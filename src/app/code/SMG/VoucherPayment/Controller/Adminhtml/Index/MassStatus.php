<?php

declare(strict_types=1);

namespace SMG\VoucherPayment\Controller\Adminhtml\Index;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use SMG\VoucherPayment\Model\ResourceModel\Voucher\CollectionFactory;

/**
 * Class MassStatus
 *
 * Admin controller responsible for bulk updating the status (is_active) of selected vouchers.
 */
class MassStatus extends Action
{
    /**
     * Undocumented function
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        private Context $context,
        private Filter $filter,
        private CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute mass status update action on selected voucher collection.
     *
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $status = (bool)$this->getRequest()->getParam('is_active');

        $rowUpdated = 0;
        foreach ($collection as $post) {
            try {
                $post->setIsActive($status)
                    ->save();
                $rowUpdated++;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()->addException(
                    $e,
                    __('Something went wrong while updating status for %1.', $post->getName())
                );
            }
        }

        if ($rowUpdated) {
            $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been updated.', $rowUpdated));
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
