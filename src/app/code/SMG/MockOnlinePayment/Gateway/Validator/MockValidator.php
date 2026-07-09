<?php

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Gateway\Validator;

use Magento\Payment\Gateway\Validator\ResultInterface;
use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;
use Magento\Payment\Gateway\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;

/**
 * Class MockValidator
 *
 * Validates the transaction response coming back from the mock payment gateway.
 */
class MockValidator implements ValidatorInterface
{
    /**
     * @var ResultInterfaceFactory
     */
    private ResultInterfaceFactory $resultFactory;

    /**
     * MockValidator constructor.
     *
     * @param ResultInterfaceFactory $resultFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResultInterfaceFactory $resultFactory,
        private LoggerInterface $logger
    ) {
        $this->resultFactory = $resultFactory;
    }

    /**
     * Validates the gateway response data.
     *
     * @param array $validationSubject
     * @return ResultInterface
     */
    public function validate(array $validationSubject)
    {
        $this->logger->info('MockOnlinePayment - MockValidator Triggered.');
        return $this->resultFactory->create([
            'isValid' => true
        ]);
    }
}
