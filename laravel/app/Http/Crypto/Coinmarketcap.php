<?php

namespace App\Http\Crypto;

class Coinmarketcap extends Crypto implements CryptoInterface
{
    /**
     * @var \Rentberry\Coinmarketcap\Coinmarketcap
     */
    private static $driver;

    protected static $mapping = [
        'price' => 'price_usd',
        'change24h' => 'percent_change_24h'
    ];

    /**
     * @return \Rentberry\Coinmarketcap\Coinmarketcap
     */
    private static function initDriver(): \Rentberry\Coinmarketcap\Coinmarketcap
    {
        if (null === self::$driver) {
            self::$driver = new \Rentberry\Coinmarketcap\Coinmarketcap();
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
        $ticker = self::$driver->getTicker($name);
        return self::parseOutput($ticker);
    }
}
