<?php

namespace SMG\VoucherPayment\Model\ResourceModel\Voucher;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Provides utility methods for filtering, mapping, and sorting items
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \SMG\VoucherPayment\Model\Voucher::class,
            \SMG\VoucherPayment\Model\ResourceModel\Voucher::class
        );
    }
}
