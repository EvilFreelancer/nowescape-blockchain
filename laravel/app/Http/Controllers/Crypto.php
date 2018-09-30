<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Currencies;
use App\Models\Sources;
use App\Models\Histories;

class Crypto extends Controller
{
    private function avg(array $array)
    {
        return array_sum($array) / \count($array);
    }

    /**
     * Get a table with list of all currencies
     *
     * @return  array
     */
    public function table(): array
    {
        // Much more better write this in ORM style, but I do not like limitations of nesting
        // of elouqent in simple SQL queries
//        $current = DB::select('
//            SELECT h.*, s.name as source_name, c.name as currency_name
//            FROM histories AS h
//            LEFT JOIN sources AS s ON (h.id_source = s.id)
//            LEFT JOIN currencies AS c ON (h.id_currency = c.id)
//            WHERE h.added_at = (SELECT max(added_at) FROM histories);
//        ');

        $current = Histories::select('histories.*', 'sources.name as source_name', 'currencies.name as currency_name')
            ->leftJoin('sources', function($join) {
                $join->on('histories.id_source', '=', 'sources.id');
            })
            ->leftJoin('currencies', function($join) {
                $join->on('histories.id_currency', '=', 'currencies.id');
            })
            ->whereRaw('added_at = (
                select max(`added_at`) from histories
                where added_at = (select max(`added_at`) from histories)
            )')
            ->get()->toArray();

        $previous = Histories::whereRaw('added_at = (
                select max(`added_at`) from histories
                where added_at < (select max(`added_at`) from histories)
            )')
            ->get()->toArray();

        $result = [];
        array_map(
            function($item, $prev) use (&$result) {
                $cur = $item['id_currency'];
                $pre = $prev['id_currency'];
                $result[$cur]['name'] = $item['currency_name'];
                $result[$cur]['avg'][] = $item['price'];
                $result[$cur]['change24h'][] = $item['change24h'];

                $result[$pre]['avg_prev'][] = $prev['price'];
                $result[$pre]['change24h_prev'][] = $prev['change24h'];
            },
            $current,
            $previous
        );

        $result = array_map(
            function($item) {
                $item['avg'] = $this->avg($item['avg']);
                $item['avg_prev'] = $this->avg($item['avg_prev']);
                $item['change24h'] = $this->avg($item['change24h']);
                $item['change24h_prev'] = $this->avg($item['change24h_prev']);
                return $item;
            },
            $result
        );

        // Reindex array
        $result = array_values($result);

        return $result;
    }

    /**
     * Refresh information in database
     */
    public function refresh()
    {
        // Get all required currencies
        $currencies = Currencies::all()->toArray();
        $sources = Sources::all()->toArray();

        // Time of script execution (for easy selects)
        $added_at = date('Y-m-d H:i:s');

        return array_map(
            function($currency) use ($sources, $added_at) {

                // Some markets do not know what is "case insensitivity"
                $currency['name'] = strtolower($currency['name']);

                // Parse array of sources
                foreach ($sources as $source) {
                    // Driver by source name
                    $driver = '\\App\\Http\\Crypto\\' . ucfirst(strtolower($source['name']));
                    // Get default about selected currency from the server
                    $ticker = $driver::getTicker($currency['name']);
                    $default = [
                        'id_currency' => $currency['id'],
                        'id_source' => $source['id'],
                        'added_at' => $added_at
                    ];
                    Histories::create(array_merge($ticker, $default));
                }

                return $currency['id'];
            },
            $currencies
        );

    }

}
