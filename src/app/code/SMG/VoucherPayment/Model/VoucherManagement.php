<?php

declare(strict_types=1);

namespace SMG\VoucherPayment\Model;

use Magento\Framework\Exception\LocalizedException;
use SMG\VoucherPayment\Api\VoucherManagementInterface;
use SMG\VoucherPayment\Api\VoucherRepositoryInterface;
use SMG\VoucherPayment\Api\Data\VoucherInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use SMG\VoucherPayment\Model\VoucherFactory;
use Magento\Framework\App\ResourceConnection;
use SMG\VoucherPayment\Model\ResourceModel\Voucher as VoucherResource;
use SMG\VoucherPayment\Model\VoucherCodeGenerator;

/**
 * Service responsible for voucher management operations.
 *
 */
class VoucherManagement implements VoucherManagementInterface
{
    /**
     * Voucher management service.
     *
     * @param VoucherRepositoryInterface $voucherRepository
     * @param VoucherFactory $voucherFactory
     * @param ResourceConnection $resourceConnection
     * @param VoucherResource $voucherResource
     * @param VoucherCodeGenerator $voucherCodeGenerator
     */
    public function __construct(
        private readonly VoucherRepositoryInterface $voucherRepository,
        private readonly VoucherFactory $voucherFactory,
        private readonly ResourceConnection $resourceConnection,
        private readonly VoucherResource $voucherResource,
        private readonly VoucherCodeGenerator $voucherCodeGenerator
    ) {
    }

    /**
     * Validate voucher number.
     *
     * @param string $voucherNumber
     * @return bool
     * @throws LocalizedException
     */
    public function validate(string $voucherNumber): bool
    {
        try {
            $voucher = $this->voucherRepository
                ->getByVoucherNumber($voucherNumber);
        } catch (NoSuchEntityException $exception) {
            throw new LocalizedException(
                __('The voucher number entered is invalid or expired.')
            );
        }

        $this->validateVoucher($voucher);

        return true;
    }

    /**
     * Validate voucher business rules.
     *
     * @param VoucherInterface $voucher
     * @return void
     * @throws LocalizedException
     */
    private function validateVoucher(
        VoucherInterface $voucher
    ): void {
        if (!$voucher->getIsActive()) {
            throw new LocalizedException(
                __('The voucher number entered is invalid or expired.')
            );
        }

        if ($voucher->getValidFrom()
            && strtotime($voucher->getValidFrom()) > time()
        ) {
            throw new LocalizedException(
                __('The voucher number entered is invalid or expired.')
            );
        }

        if ($voucher->getValidTo()
            && strtotime($voucher->getValidTo()) < time()
        ) {
            throw new LocalizedException(
                __('The voucher number entered is invalid or expired.')
            );
        }

        if ($voucher->getUsageLimit() > 0
            && $voucher->getTimesUsed() >= $voucher->getUsageLimit()
        ) {
            throw new LocalizedException(
                __('The voucher number entered is invalid or expired.')
            );
        }
    }

    /**
     * Retrieve and validate voucher.
     *
     * @param string $voucherNumber
     * @return VoucherInterface
     * @throws LocalizedException
     */
    public function getVoucher(
        string $voucherNumber
    ): VoucherInterface {
        try {
            $voucher = $this->voucherRepository
                ->getByVoucherNumber($voucherNumber);
        } catch (NoSuchEntityException $exception) {
            throw new LocalizedException(
                __('The voucher number entered is invalid or expired.')
            );
        }

        $this->validateVoucher($voucher);

        return $voucher;
    }

    /**
     * Mark voucher as used.
     *
     * @param string $voucherNumber
     * @param int $orderId
     * @return bool
     * @throws LocalizedException
     */
    public function markAsUsed(
        string $voucherNumber,
        int $orderId
    ): bool {
        $voucher = $this->getVoucher($voucherNumber);

        $timesUsed = $voucher->getTimesUsed() + 1;

        $voucher->setTimesUsed($timesUsed);

        if ($voucher->getUsageLimit() > 0
            && $timesUsed >= $voucher->getUsageLimit()
        ) {
            $voucher->setIsActive(false);
        }

        $this->voucherRepository->save($voucher);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function generate(
        VoucherInterface $request
    ): VoucherInterface {
        $voucherCode = $this->voucherCodeGenerator->generate();
        $voucher = $this->voucherFactory->create();
        $voucher->setData($request->getData());
        $voucher->setVoucherNumber($voucherCode);

        return $this->voucherRepository->save($voucher);
    }

    /**
     * @inheritdoc
     */
    public function bulkGenerate(
        VoucherInterface $request,
        int $limit
    ): array {

        if (empty($request) || $limit === 0) {
            return [];
        }
        $rows = [];
        $voucherNumbers = [];

        for ($i = 0; $i < $limit; $i++) {
            $voucherNumber = $this->voucherCodeGenerator->generate();
            $rows[] = [
                VoucherInterface::VOUCHER_NUMBER    => $voucherNumber,
                VoucherInterface::IS_ACTIVE         => $request->getIsActive(),
                VoucherInterface::IS_SINGLE_USE     => $request->getIsSingleUse(),
                VoucherInterface::USAGE_LIMIT       => $request->getUsageLimit(),
                VoucherInterface::VALID_FROM        => $request->getValidFrom(),
                VoucherInterface::VALID_TO          => $request->getValidTo()
            ];
            $voucherNumbers[] = $voucherNumber;
        }

        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->voucherResource->getMainTable();
        $connection->insertMultiple(
            $tableName,
            $rows
        );
        return $voucherNumbers;
    }
    /**
     * @inheritdoc
     */
    public function bulkDelete(
        array $vouchers
    ): int {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->voucherResource->getMainTable();
        return $connection->delete(
            $tableName,
            ['voucher_number IN (?)' => $vouchers]
        );
    }
    /**
     * @inheritdoc
     */
    public function bulkUpdate(
        array $vouchers,
        bool $isActive
    ): int {

        if (empty($vouchers)) {
            return 0;
        }
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->voucherResource->getMainTable();
        return $connection->update(
            $tableName,
            ['is_active' => $isActive],
            ['voucher_number IN (?)' => $vouchers]
        );
    }
}
