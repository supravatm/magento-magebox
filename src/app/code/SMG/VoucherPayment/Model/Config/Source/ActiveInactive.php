<?php

declare(strict_types=1);

namespace SMG\VoucherPayment\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Provide Active and Inactive options for UI components.
 */
class ActiveInactive implements OptionSourceInterface
{

    public const ACTIVE = '0';
    public const INACTIVE = '1';

    /**
     * Return options array for grid/form dropdowns.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->toArray() as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $options;
    }

    /**
     * Get options in "key-value" format.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::ACTIVE => __('Active'),
            self::INACTIVE => __('Inactive')
        ];
    }
}
