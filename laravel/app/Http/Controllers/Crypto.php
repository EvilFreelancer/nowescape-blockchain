<?php

namespace App\Http\Controllers;

use App\Models\Currencies;
use App\Models\Sources;
use App\Models\Histories;

class Crypto extends Controller
{
    /**
     * Get a table with list of all currencies
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getTable(): \Illuminate\Http\JsonResponse
    {

    }

    /**
     * Refresh information in database
     */
    public function refresh()
    {
        // Get all required currencies
        $currencies = Currencies::all()->toArray();
        $sources = Sources::all()->toArray();

        return array_map(
            function($currency) use ($sources) {

                // Some markets do not know what is "case insensitivity"
                $currency['name'] = strtolower($currency['name']);

                // Parse array of sources
                foreach ($sources as $source) {
                    // Driver by source name
                    $driver = '\\App\\Http\\Crypto\\' . ucfirst(strtolower($source['name']));
                    // Get default about selected currency from the server
                    $ticker = $driver::getTicker($currency['name']);
                    $default = ['id_currency' => $currency['id'], 'id_source' => $source['id']];
                    Histories::create(array_merge($ticker, $default));
                }

                return $currency['id'];
            },
            $currencies
        );

    }

}
