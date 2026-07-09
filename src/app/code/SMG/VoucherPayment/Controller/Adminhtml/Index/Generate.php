<?php

declare(strict_types=1);

namespace SMG\VoucherPayment\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Generate
 *
 * Admin controller responsible for rendering the "Generate Voucher" page.
 */
class Generate extends Action
{
    /**
     * Generate constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        private PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Render the generate voucher admin page layout.
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->setActiveMenu('SMG_VoucherPayment::voucher_payment');
        $resultPage->getConfig()->getTitle()->prepend(__('Generate Voucher'));

        return $resultPage;
    }
}
