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
        Location::factory()
            ->count(15)
            ->create();

            InvoiceHeader::factory()
            ->count(15)
            ->create();

        InvoiceLine::factory()
            ->count(50)
            ->create();
    }
}
