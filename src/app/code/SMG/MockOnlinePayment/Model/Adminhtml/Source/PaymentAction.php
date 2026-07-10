<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace SMG\MockOnlinePayment\Model\Adminhtml\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Payment\Model\MethodInterface;

class PaymentAction implements OptionSourceInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => MethodInterface::ACTION_AUTHORIZE,
                'label' => __('Authorize'),
            ],
            [
                'value' => MethodInterface::ACTION_AUTHORIZE_CAPTURE,
                'label' => __('Authorize and Capture'),
            ]
        ];
    }
}
