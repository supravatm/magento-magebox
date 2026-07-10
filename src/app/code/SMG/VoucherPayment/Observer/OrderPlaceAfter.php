<?php

namespace SMG\VoucherPayment\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use SMG\VoucherPayment\Api\VoucherRepositoryInterface;
use SMG\VoucherPayment\Model\Config as VoucherPayment;
use SMG\VoucherPayment\Api\VoucherManagementInterface;

/**
 * After place order business logic for voucher payments.
 *
 * Update voucherNumber after an order completes successfully. Its
 * changes state of voucherNumber, updates usage history, and invalidates
 */
class OrderPlaceAfter implements ObserverInterface
{
    /**
     * Injects the required data services and reporting utilities.
     *
     * @param VoucherRepositoryInterface $voucherRepository
     * @param LoggerInterface $logger
     * @param VoucherManagementInterface $voucherManagement
     */
    public function __construct(
        private readonly VoucherRepositoryInterface $voucherRepository,
        private readonly LoggerInterface $logger,
        private readonly VoucherManagementInterface $voucherManagement
    ) {
    }

    /**
     * Executes the business rules attached to the order placement event.
     *
     * Inspects the newly created order payload, identifies the payment type,
     * and performs state updates on associated voucher codes.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $order = $observer->getEvent()->getOrder();
        $payment = $order->getPayment();
        if (!$payment) {
            return;
        }

        if ($payment->getMethod() !== VoucherPayment::PAYMENT_METHOD_CODE) {
            return;
        }

        $voucherNumber = $order->getPayment()->getData('voucher_number');

        if (!$voucherNumber) {
            return;
        }

        try {
            $this->voucherManagement->markAsUsed(
                $voucherNumber,
                (int)$order->getEntityId()
            );
        } catch (\Throwable $exception) {
            $this->logger->error(
                $exception->getMessage()
            );
        }
    }
}
