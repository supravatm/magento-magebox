<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Psr\Log\LoggerInterface;

/**
 * Class MockVoidRequestBuilder
 *
 * Builds the API request payload specifically for canceling (voiding)
 * an authorized payment transaction before it is captured.
 */
class MockVoidRequestBuilder implements BuilderInterface
{
    /**
     * MockVoidRequestBuilder constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * Builds the void request payload data.
     *
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject): array
    {
        $this->logger->info('MockOnlinePayment - Void Request Builder Triggered.');

        return [
            'action' => 'void'
        ];
    }
}
