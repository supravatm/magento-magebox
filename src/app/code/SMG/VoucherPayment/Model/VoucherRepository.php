<?php

namespace SMG\VoucherPayment\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use SMG\VoucherPayment\Api\Data\VoucherInterface;
use SMG\VoucherPayment\Api\VoucherRepositoryInterface;
use SMG\VoucherPayment\Model\ResourceModel\Voucher as VoucherResource;
use SMG\VoucherPayment\Model\ResourceModel\Voucher\CollectionFactory;

/**
 * Manages database operations for user discount vouchers.
 * This repository handles queries for fetching active coupon codes
 */
class VoucherRepository implements VoucherRepositoryInterface
{
    /**
     * @param VoucherFactory $voucherFactory
     * @param VoucherResource $resource
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        private VoucherFactory $voucherFactory,
        private VoucherResource $resource,
        private CollectionFactory $collectionFactory
    ) {
        //
    }

    /**
     * Save
     *
     * @param VoucherInterface $voucher
     * @return void
     */
    public function save(VoucherInterface $voucher)
    {
        /** @var \SMG\VoucherPayment\Model\Voucher $voucher */
        $this->resource->save($voucher);
        return $voucher;
    }
    /**
     * @inheritDoc
     */
    public function getById(int $id)
    {
        $voucher = $this->voucherFactory->create();

        $this->resource->load($voucher, $id);

        if (!$voucher->getId()) {
            throw new NoSuchEntityException(
                __('Voucher not found.')
            );
        }

        return $voucher;
    }
    /**
     * @inheritDoc
     */
    public function getByVoucherNumber(
        string $voucherNumber
    ) {
        $collection = $this->collectionFactory->create();

        $voucher = $collection
            ->addFieldToFilter(
                'voucher_number',
                $voucherNumber
            )
            ->getFirstItem();
        return $voucher;
    }
    /**
     * @inheritDoc
     */
    public function delete(
        VoucherInterface $voucher
    ) {
        /** @var \SMG\VoucherPayment\Model\Voucher $voucher */
        $this->resource->delete($voucher);
        return true;
    }
    /**
     * @inheritDoc
     */
    public function deleteById(
        int $id
    ) {
        return $this->delete(
            $this->getById($id)
        );
    }
    /**
     * @inheritDoc
     */
    public function valid(
        string $voucherNumber
    ) {
        return $this->resource->valid($voucherNumber);
    }
}
