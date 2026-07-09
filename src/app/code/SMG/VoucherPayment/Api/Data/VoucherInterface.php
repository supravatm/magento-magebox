<?php

namespace SMG\VoucherPayment\Api\Data;

/**
 * Voucher data interface.
 *
 * @api
 */
interface VoucherInterface
{
    public const ENTITY_ID = 'entity_id';
    public const VOUCHER_NUMBER = 'voucher_number';
    public const IS_ACTIVE = 'is_active';
    public const VALID_FROM = 'valid_from';
    public const VALID_TO = 'valid_to';
    public const USAGE_LIMIT = 'usage_limit';
    public const TIMES_USED = 'times_used';
    public const IS_SINGLE_USE = 'is_single_use';

    /**
     * Get entity ID.
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set entity ID.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get voucher number.
     *
     * @return string|null
     */
    public function getVoucherNumber(): ?string;

    /**
     * Set voucher number.
     *
     * @param string $voucherNumber
     * @return $this
     */
    public function setVoucherNumber(string $voucherNumber);

    /**
     * Get active status.
     *
     * @return bool
     */
    public function getIsActive(): bool;

    /**
     * Set active status.
     *
     * @param bool $isActive
     * @return $this
     */
    public function setIsActive(bool $isActive);

    /**
     * Get valid from date.
     *
     * @return string|null
     */
    public function getValidFrom();

    /**
     * Set valid from date.
     *
     * @param string|null $validFrom
     * @return $this
     */
    public function setValidFrom($validFrom);

    /**
     * Get valid to date.
     *
     * @return string|null
     */
    public function getValidTo();

    /**
     * Set valid to date.
     *
     * @param string|null $validTo
     * @return $this
     */
    public function setValidTo($validTo);

    /**
     * Get usage limit.
     *
     * @return int
     */
    public function getUsageLimit(): int;

    /**
     * Set usage limit.
     *
     * @param int $limit
     * @return $this
     */
    public function setUsageLimit(int $limit);

    /**
     * Get times used.
     *
     * @return int
     */
    public function getTimesUsed(): int;

    /**
     * Set times used.
     *
     * @param int $used
     * @return $this
     */
    public function setTimesUsed(int $used);

    /**
     * Get single use used.
     *
     * @return int
     */
    public function getIsSingleUse(): int;

    /**
     * Set single use used.
     *
     * @param int $used
     * @return $this
     */
    public function setIsSingleUse(int $used);
}
