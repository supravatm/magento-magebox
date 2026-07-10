<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;
use Magento\Payment\Gateway\Http\TransferInterface;
use Magento\Payment\Gateway\Config\Config;
use Psr\Log\LoggerInterface;

/**
 * Class MockTransfer
 *
 * Configures and builds the transmission payload container used for
 * communication between Magento and the payment gateway.
 */
class MockTransfer implements TransferFactoryInterface
{
    /**
     * @var TransferBuilder
     */
    private TransferBuilder $transferBuilder;

    /**
     * MockTransfer constructor.
     *
     * @param TransferBuilder $transferBuilder
     * @param LoggerInterface $logger
     * @param Config $config
     */
    public function __construct(
        TransferBuilder $transferBuilder,
        private LoggerInterface $logger,
        private Config $config
    ) {
        $this->transferBuilder = $transferBuilder;
    }

    /**
     * Builds the payment gateway transfer object from request array data.
     *
     * @param array $request
     * @return TransferInterface
     */
    public function create(array $request): TransferInterface
    {
        $this->logger->info('MockOnlinePayment - Transfer Triggered.', ['keys' => array_keys($request)]);

        $storeId = $request['store_id'] ?? null;

        // Read your settings using the injected config object
        $merchantId = $this->config->getValue('marchent_id', $storeId);
        $gatewayUrl = $this->config->getValue('getway_url', $storeId);

        return $this->transferBuilder
            ->setBody($request)
            ->setUri($gatewayUrl)
            ->setHeaders(['X-Merchant-ID' => $merchantId])
            ->build();
    }
}
