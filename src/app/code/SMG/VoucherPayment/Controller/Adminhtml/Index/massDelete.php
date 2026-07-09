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
 * Class MassDelete
 *
 * Admin controller responsible for bulk deleting selected vouchers via grid mass action.
 */
class MassDelete extends Action
{
    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        private Filter $filter,
        private CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute mass delete action on selected voucher collection.
     *
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute()
    {
        /** @var \SMG\VoucherPayment\Model\ResourceModel\Voucher\Collection $collection */
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        try {
            $collection->walk('delete');
            $this->messageManager->addSuccessMessage(__('Voucher has been deleted.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Something wrong when delete Posts.'));
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
