<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Psr\Log\LoggerInterface;

/**
 * Class MockRefundRequestBuilder
 *
 * Builds the API request payload specifically for processing a transaction refund
 * (credit memo) through the mock payment gateway.
 */
class MockRefundRequestBuilder implements BuilderInterface
{
    /**
     * MockRefundRequestBuilder constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * Builds the refund request payload data.
     *
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject): array
    {
        $this->logger->info('MockOnlinePayment - Refund Request Builder Triggered.');

        return [
            'action' => 'refund'
        ];
    }
}
