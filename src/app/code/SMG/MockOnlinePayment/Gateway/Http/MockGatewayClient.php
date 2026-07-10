<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Gateway\Http;

use Magento\Payment\Gateway\Http\ClientInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Psr\Log\LoggerInterface;

/**
 * Class MockGatewayClient
 *
 * Handles outbound API execution, simulating the direct communication channel
 * with the external payment gateway server.
 */
class MockGatewayClient implements ClientInterface
{
    /**
     * MockGatewayClient constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    /**
     * Sends the prepared transfer payload to the mock payment gateway API.
     *
     * @param TransferInterface $transferObject
     * @return array
     */
    public function placeRequest(TransferInterface $transferObject): array
    {
        $this->logger->info('MockOnlinePayment - Gateway Client Triggered.');

        return [
            'success' => true,
            'transaction_id' => uniqid('MOCK_')
        ];
    }
}
