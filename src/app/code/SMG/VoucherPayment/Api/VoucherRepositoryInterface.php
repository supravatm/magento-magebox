<?php

namespace SMG\VoucherPayment\Api;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use SMG\VoucherPayment\Api\Data\VoucherInterface;

interface VoucherRepositoryInterface
{
    /**
     * Save voucher.
     *
     * @param VoucherInterface $voucher
     * @return VoucherInterface
     * @throws LocalizedException
     */
    public function save(
        VoucherInterface $voucher
    );

    /**
     * Retrieve voucher by entity ID.
     *
     * @param int $id
     * @return VoucherInterface
     * @throws NoSuchEntityException
     */
    public function getById(
        int $id
    );

    /**
     * Retrieve voucher by voucher number.
     *
     * @param string $voucherNumber
     * @return VoucherInterface
     * @throws NoSuchEntityException
     */
    public function getByVoucherNumber(
        string $voucherNumber
    );

    /**
     * Delete voucher.
     *
     * @param VoucherInterface $voucher
     * @return bool
     * @throws LocalizedException
     */
    public function delete(
        VoucherInterface $voucher
    );

    /**
     * Delete voucher by ID.
     *
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(
        int $id
    );
}
