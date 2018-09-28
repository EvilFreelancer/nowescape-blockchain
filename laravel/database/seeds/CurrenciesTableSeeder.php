<?php

use App\Models\Currencies;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Currencies::truncate();

        // Create few columns
        Currencies::create(['name' => 'Bitcoin']);
        Currencies::create(['name' => 'Ethereum']);
        Currencies::create(['name' => 'Ripple']);
        Currencies::create(['name' => 'Litecoin']);
        Currencies::create(['name' => 'NEO']);
    }
}
