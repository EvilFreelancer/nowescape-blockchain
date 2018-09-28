<?php

namespace App\Http\Crypto;

interface CryptoInterface
{
    public static function getTicker(string $name): array;
}
