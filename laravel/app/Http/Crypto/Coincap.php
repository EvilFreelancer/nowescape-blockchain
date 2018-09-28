<?php

namespace App\Http\Crypto;

class Coincap extends Crypto implements CryptoInterface
{
    /**
     * @var \CoinCapIO\API
     */
    private static $driver;

    protected static $mapping = [
        'price' => 'priceUsd',
        'change24h' => 'changePercent24Hr'
    ];

    /**
     * @return \CoinCapIO\API
     */
    private static function initDriver(): \CoinCapIO\API
    {
        if (null === self::$driver) {
            self::$driver = new \CoinCapIO\API();
        }
        return self::$driver;
    }

    protected static function parseOutput(array $ticker): array
    {
        $result = [];
        foreach (self::$mapping as $key => $value) {
            $result[$key] = $ticker[$value];
        }
        return $result;
    }

    public static function getTicker(string $name): array
    {
        self::initDriver();
        $ticker = self::$driver->assets->get($name);
        return self::parseOutput($ticker);
    }
}
