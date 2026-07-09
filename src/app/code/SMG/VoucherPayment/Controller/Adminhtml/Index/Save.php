<?php

declare(strict_types=1);

namespace SMG\VoucherPayment\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use SMG\VoucherPayment\Api\VoucherRepositoryInterface;
use SMG\VoucherPayment\Api\Data\VoucherInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Math\Random;

/**
 * Class Save
 *
 * Controller handling form data persistence and automatic voucher generation logic.
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Save constructor.
     *
     * @param Context $context
     * @param VoucherRepositoryInterface $voucherRepository
     * @param VoucherInterfaceFactory $voucherFactory
     * @param Random $mathRandom
     */
    public function __construct(
        Context $context,
        private VoucherRepositoryInterface $voucherRepository,
        private VoucherInterfaceFactory $voucherFactory,
        private Random $mathRandom
    ) {
        parent::__construct($context);
    }

    /**
     * Process POST form submission, generate code, and persist item.
     *
     * @return Redirect
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();
        try {
            if ($data) {
                if (!isset($data['times_used']) || $data['times_used'] === '') {
                    $data['times_used'] = 0;
                }
                // Perform backend date validations
                $fromDateStr = $data['from_date'] ?? null;
                $toDateStr = $data['to_date'] ?? null;
                $currentDateStr = date('Y-m-d');
                if ($fromDateStr) {
                    // Ensure from_date is not older than today
                    if (strtotime($fromDateStr) < strtotime($currentDateStr)) {
                        throw new LocalizedException(__('The "From Date" cannot be older than the current date.'));
                    }

                    // Ensure to_date is not older than from_date
                    if ($toDateStr && strtotime($toDateStr) < strtotime($fromDateStr)) {
                        throw new LocalizedException(__('The "To Date" cannot be older than the "From Date".'));
                    }
                }

                $data['voucher_number'] = $this->generateVoucherCode();
                $model = $this->voucherFactory->create();
                $model->setData($data);
                $this->voucherRepository->save($model);
                $this->messageManager->addSuccessMessage(__('Voucher code generated'));
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while generating the code.'));
        }
        return $resultRedirect->setPath('*/*/index');
    }

    /**
     * Generates a secure, 12-character alphanumeric voucher code string.
     *
     * @return string
     * @throws LocalizedException
     */
    public function generateVoucherCode(): string
    {
        // Allowed characters: standard uppercase alphanumeric
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        // Generates a random string of length 12 using the defined character pool
        $code = $this->mathRandom->getRandomString(12, $chars);

        return $code;
    }
}
