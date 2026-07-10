<?php

namespace SMG\VoucherPayment\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Represents a single promotional voucher in the system.
 */
class Voucher extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            'smg_voucher',
            'entity_id'
        );
    }
}
