<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function getInvoices(array $dateRange = null, string $status = null, string $location = null)
    {
        $invoices = DB::table('invoice_headers')
            ->join('locations', 'invoice_headers.location_id', '=', 'locations.id')
            ->select('invoice_headers.id', 'date', 'status', 'locations.name as location');

        if ($dateRange) {
            $invoices->whereBetween('date', [$dateRange[0], $dateRange[1]]);
        }

        if ($status) {
            $invoices->where('status', $status);
        }

        if ($location) {
            $invoices->where('location', $location);
        }

        return $invoices->get();
    }
}
