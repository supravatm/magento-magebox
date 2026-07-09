<?php

namespace SMG\VoucherPayment\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use SMG\VoucherPayment\Api\Data\VoucherInterface;

/**
 * Voucher management Service contract of promotional vouchers.
 *
 * @api
 *
 */
interface VoucherManagementInterface
{
    /**
     * Assesses whether a given coupon code meets current checkout eligibility rules.
     *
     * @param string $voucherNumber
     * @return bool
     */
    public function validate(string $voucherNumber): bool;

    /**
     * Resolves the complete domain entity representing a specific voucher.
     *
     * @param string $voucherNumber
     * @return VoucherInterface
     */
    public function getVoucher(string $voucherNumber): VoucherInterface;

    /**
     * Locks and increments the usage telemetry of a coupon code against a specific purchase.
     *
     * @param string $voucherNumber
     * @param int $orderId
     * @return bool
     */
    public function markAsUsed(
        string $voucherNumber,
        int $orderId
    ): bool;

    /**
     * Generate a single voucher.
     *
     * @param VoucherInterface $request
     * @return VoucherInterface
     */
    public function generate(
        VoucherInterface $request
    ): VoucherInterface;

    /**
     * Generate multiple vouchers.
     *
     * @param VoucherInterface $request
     * @param int $limit
     * @return string[]
     */
    public function bulkGenerate(
        VoucherInterface $request,
        int $limit
    ): array;

    /**
     * Delete vouchers.
     *
     * @param string[] $vouchers
     * @return int
     */
    public function bulkDelete(array $vouchers);

    /**
     * Update status.
     *
     * @param string[] $vouchers
     * @param bool $isActive
     * @return int
     */
    public function bulkUpdate(
        array $vouchers,
        bool $isActive
    );
}
