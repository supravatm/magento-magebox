<?php

declare(strict_types=1);

namespace SMG\VoucherPayment\Plugin;

use Psr\Log\LoggerInterface;
use Magento\Quote\Model\Quote\Payment as QuotePayment;
use Magento\Sales\Model\Order\Payment as OrderPayment;
use Magento\Quote\Model\Quote\Payment\ToOrderPayment;

/**
 * Intercepts the quote-to-order payment conversion process.
 *
 * This plugin ensures that any coupon or promotional voucher code attached
 * to the customer's shopping cart session is successfully transferred to the
 * final processed order record for auditing and discount tracking.
 */
class ToOrderPaymentPlugin
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Injects system dependencies for operational monitoring.
     *
     * Provides the class with a standardized mechanism to record runtime
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Copies the voucher number from the quote payment to the order payment.
     *
     * Executed automatically after the core conversion method. It checks for the
     *
     * @param ToOrderPayment $subject
     * @param OrderPayment $result
     * @param QuotePayment $quotePayment
     * @param array $data
     * @return OrderPayment
     */
    public function afterConvert(
        ToOrderPayment $subject,
        OrderPayment $result,
        QuotePayment $quotePayment,
        array $data = []
    ): OrderPayment {
        $voucherNumber = $quotePayment->getData('voucher_number');

        if ($voucherNumber) {
            $result->setData('voucher_number', $voucherNumber);
        }

        return $result;
    }
}
