<?php

namespace App\Http\Controllers;

use App\Models\Currencies;

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

    public function refresh()
    {
        // Get all required currencies
        $currencies = Currencies::all();

        // Enable sources
        $sources['cmc'] = new \Rentberry\Coinmarketcap\Coinmarketcap();

        array_map(
            function($currency) use ($sources) {
            },
            $currencies
        );

        $source_cmc->getTicker('bitcoin');

    }

}
