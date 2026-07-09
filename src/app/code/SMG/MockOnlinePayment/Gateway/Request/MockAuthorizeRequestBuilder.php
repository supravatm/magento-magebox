<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Psr\Log\LoggerInterface;

/**
 * Class MockAuthorizeRequestBuilder
 *
 * Extracts order and payment details from Magento's checkout state and compiles
 * them into a structured array payload for the payment gateway authorization request.
 */
class MockAuthorizeRequestBuilder implements BuilderInterface
{
    /**
     * MockAuthorizeRequestBuilder constructor.
     *
     * @param LoggerInterface $logger
     * @param SubjectReader $subjectReader
     */
    public function __construct(
        private LoggerInterface $logger,
        private SubjectReader $subjectReader
    ) {
    }

    /**
     * Builds the authorization request payload data.
     *
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject): array
    {
        $paymentDO = $this->subjectReader->readPayment($buildSubject);
        $order = $paymentDO->getOrder();
        $payment = $paymentDO->getPayment();
        
        // payload
        $requestData = [
            'amount' => $this->subjectReader->readAmount($buildSubject),
            'currency' => $order->getCurrencyCode(),
            'order_id' => $order->getOrderIncrementId(),
            'card_number' => $payment->getAdditionalInformation('cc_number'),
            'card_last_four' => $payment->getAdditionalInformation('cc_last_4')
        ];

        $this->logger->info('MockOnlinePayment - Authorize Request Builder Triggered.');
        $this->logger->info('MockOnlinePayment - Request Payload:', $requestData);

        return $requestData;
    }
}
