<?php

use App\Models\Sources;
use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Sources::truncate();

        // Create few columns
        Sources::create(['name' => 'CoinMarketCap', 'url' => 'https://coinmarketcap.com/']);
        Sources::create(['name' => 'CoinCap', 'url' => 'https://coincap.io/']);
    }
}
