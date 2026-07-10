<?php

declare(strict_types=1);

namespace SMG\VoucherPayment\Model;

class VoucherCodeGenerator
{
    private const CHARACTERS = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * Generate voucher code.
     *
     * Example:
     * ABCD-EFGH-IJKL
     *
     * @return string
     * @throws \Exception
     */
    public function generate(): string
    {
        $code = '';

        for ($i = 0; $i < 12; $i++) {
            $code .= self::CHARACTERS[random_int(0, strlen(self::CHARACTERS) - 1)];
        }

        return implode('-', str_split($code, 4));
    }
}
