<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Observer;

use Magento\Framework\Event\Observer;
use Magento\Payment\Observer\AbstractDataAssignObserver;
use Magento\Quote\Api\Data\PaymentInterface;
use Psr\Log\LoggerInterface;

/**
 * Class DataAssignObserver
 *
 * Captures custom credit card form input data during checkout
 * and binds it securely to the payment model state.
 */
class DataAssignObserver extends AbstractDataAssignObserver
{
    /**
     * @var array
     */
    protected $additionalInformationList = [
        'cc_number',
        'cc_type',
        'cc_exp_year',
        'cc_exp_month',
        'cc_cid',
        'cc_last_4'
    ];

    /**
     * DataAssignObserver constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * Execute observer to format, bind, and log payment data safely.
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $this->logger->info('MockOnlinePayment - DataAssignObserver Triggered.');

        $dataObject = $this->readDataArgument($observer);
        $paymentModel = $this->readPaymentModelArgument($observer);
        $additionalData = $dataObject->getData(PaymentInterface::KEY_ADDITIONAL_DATA);

        if (!is_array($additionalData)) {
            $this->logger->warning('MockOnlinePayment - DataAssignObserver: No additional data found in payload.');
            return;
        }

        // 1. Assign Standard Fields if they exist
        $standardFields = ['cc_type', 'cc_exp_month', 'cc_exp_year'];
        foreach ($standardFields as $field) {
            if (isset($additionalData[$field])) {
                $paymentModel->setAdditionalInformation($field, $additionalData[$field]);
            }
        }

        // 2. Handle CC CID (Cast explicitly to an Integer)
        if (isset($additionalData['cc_cid']) && $additionalData['cc_cid'] !== '') {
            $paymentModel->setAdditionalInformation(
                'cc_cid',
                (int)$additionalData['cc_cid']
            );
        }

        // 3. Handle CC Number & Extract Last 4 Digits
        if (!empty($additionalData['cc_number'])) {
            $ccNumber = (string)$additionalData['cc_number'];

            // Clean out any spaces or hyphens from the card number input
            $cleanCcNumber = preg_replace('/\D/', '', $ccNumber);

            // Extract the last 4 characters safely
            $last4 = substr($cleanCcNumber, -4);

            $paymentModel->setAdditionalInformation('cc_last_4', $last4);
            /**
             * PCI COMPLIANCE RULE:
             * Do NOT use setAdditionalInformation() for the raw card number.
             *
             * Remove it in request builder, after reading, or in response handler, after processing response.
             * Otherwise it will be stored in database.
             */
            $paymentModel->setAdditionalInformation('cc_number', $cleanCcNumber);
        }
        $savedInformation = $paymentModel->getAdditionalInformation();
        $this->logger->info('MockOnlinePayment - Assigned Payment Information:', $savedInformation);
    }
}
