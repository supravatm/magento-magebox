<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Gateway\Response;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Psr\Log\LoggerInterface;

/**
 * Class MockResponseHandler
 *
 * Processes and persists transaction results from the payment gateway response
 * into Magento's order and payment records.
 */
class MockResponseHandler implements HandlerInterface
{
    /**
     * MockResponseHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    ) {
    }
    
    /**
     * Handles payment gateway response data to update Magento transaction state.
     *
     * @param array $handlingSubject
     * @param array $response
     * @return void
     */
    public function handle(
        array $handlingSubject,
        array $response
    ): void {

        $this->logger->info('MockOnlinePayment - Response Handler Triggered.');

        $paymentDO = SubjectReader::readPayment($handlingSubject);
        $payment = $paymentDO->getPayment();

        // Fallback or validation mapping to prevent undefined index notices
        $transactionId = $response['transaction_id'] ?? 'MOCK_TXN_' . time();

        $payment->setTransactionId($transactionId);

        // Setting to false leaves the transaction open for future actions like capturing or refunding
        $payment->setIsTransactionClosed(false);
    }
}
