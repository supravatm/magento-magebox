<?php

namespace SMG\VoucherPayment\Model;

use Magento\Framework\Model\AbstractModel;
use SMG\VoucherPayment\Api\Data\VoucherInterface;

/**
 * Voucher Model class
 */
class Voucher extends AbstractModel implements VoucherInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            \SMG\VoucherPayment\Model\ResourceModel\Voucher::class
        );
    }

    /**
     * @inheritdoc
     */
    public function getVoucherNumber(): ?string
    {
        return $this->getData(self::VOUCHER_NUMBER);
    }
    /**
     * @inheritdoc
     */
    public function setVoucherNumber(string $voucherNumber)
    {
        return $this->setData(self::VOUCHER_NUMBER, $voucherNumber);
    }
    /**
     * @inheritdoc
     */
    public function getIsActive(): bool
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }
    /**
     * @inheritdoc
     */
    public function setIsActive(bool $isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }
    /**
     * @inheritdoc
     */
    public function getValidFrom()
    {
        return $this->getData(self::VALID_FROM);
    }
    /**
     * @inheritdoc
     */
    public function setValidFrom($validFrom)
    {
        return $this->setData(self::VALID_FROM, $validFrom);
    }
    /**
     * @inheritdoc
     */
    public function getValidTo()
    {
        return $this->getData(self::VALID_TO);
    }
    /**
     * @inheritdoc
     */
    public function setValidTo($validTo)
    {
        return $this->setData(self::VALID_TO, $validTo);
    }
    /**
     * @inheritdoc
     */
    public function getUsageLimit(): int
    {
        return (int)$this->getData(self::USAGE_LIMIT);
    }
    /**
     * @inheritdoc
     */
    public function setUsageLimit(int $limit)
    {
        return $this->setData(self::USAGE_LIMIT, $limit);
    }
    /**
     * @inheritdoc
     */
    public function getTimesUsed(): int
    {
        return (int)$this->getData(self::TIMES_USED);
    }
    /**
     * @inheritdoc
     */
    public function setTimesUsed(int $used)
    {
        return $this->setData(self::TIMES_USED, $used);
    }
    /**
     * @inheritdoc
     */
    public function getIsSingleUse(): int
    {
        return (int)$this->getData(self::IS_SINGLE_USE);
    }
    /**
     * @inheritdoc
     */
    public function setIsSingleUse(int $isSingleUse)
    {
        return $this->setData(self::IS_SINGLE_USE, $isSingleUse);
    }
}
