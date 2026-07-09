<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Psr\Log\LoggerInterface;

/**
 * Class MockCaptureRequestBuilder
 *
 * Builds the API request payload specifically for capturing a previously
 * authorized payment transaction through the mock payment gateway.
 */
class MockCaptureRequestBuilder implements BuilderInterface
{
    /**
     * MockCaptureRequestBuilder constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * Builds the capture request payload data.
     *
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject): array
    {
        $this->logger->info('MockOnlinePayment - Capture Request Builder Triggered.');

        return [
            'action' => 'capture'
        ];
    }
}
