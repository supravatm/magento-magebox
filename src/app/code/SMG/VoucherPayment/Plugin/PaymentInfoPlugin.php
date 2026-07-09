<?php

namespace SMG\VoucherPayment\Plugin;

/**
 * Payment information block rendering.
 *
 * This plugin hooks into the payment info block to append 'Voucher Number'.
 * It extracts stored voucher information from the payment instance
 * and formats it for display in administrative views and customer order summaries.
 */
class PaymentInfoPlugin
{
    /**
     * Appends the applied voucher number to the visible payment details array.
     *
     * Executed after the core payment block compiles its specific information list.
     * It checks for an active payment object, extracts the custom 'voucher_number'
     * attribute, and adds a localized text label to the output array.
     *
     * @param \Magento\Payment\Block\Info $subject
     * @param array $result
     *
     * @return array
     */
    public function afterGetSpecificInformation(
        \Magento\Payment\Block\Info $subject,
        array $result
    ) {
        $payment = $subject->getInfo();

        if (!$payment) {
            return $result;
        }

        $voucherNumber = $payment->getData('voucher_number');

        if ($voucherNumber) {
            $result[(string)__('Voucher Number')] = $voucherNumber;
        }

        return $result;
    }
}
