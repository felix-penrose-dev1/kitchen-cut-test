<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\InvoiceLine;
use App\Models\InvoiceHeader;
use Illuminate\Database\Seeder;

class BaseTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Location::factory()
        //     ->count(5)
        //     ->create();

        // InvoiceHeader::factory()
        //     ->count(5)
        //     ->create();

        // with relations this will create n rows for each model above
        InvoiceLine::factory()
            ->count(5)
            ->create();
    }
}
