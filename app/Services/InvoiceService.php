<?php

namespace App\Services;

use App\Models\InvoiceHeader;
use Illuminate\Support\Facades\DB;

class InvoiceService
{

    /**
     * Get a list of all invoices - with the option to filter
     *
     * @param array $dateRange - from/to date range
     * @param string $status
     * @param string $locationId
     *
     * @return Object
     */
    public function getInvoices(array $dateRange = null, string $status = null, string $locationId = null): Object
    {
        $invoices = InvoiceHeader::with('lines')
            ->select('invoice_headers.id', 'date', 'status', 'invoice_headers.location_id', 'locations.name as location')
            ->join('locations', 'invoice_headers.location_id', '=', 'locations.id');

        if (!empty($dateRange['from']) || !empty($dateRange['to'])) {
            $invoices->whereBetween('date', [
                $dateRange['from'] ?? '1900-01-01',
                $dateRange['to'] ?? '5000-01-01',
            ]);
        }

        if ($status) {
            $invoices->where('status', $status);
        }

        if ($locationId) {
            $invoices->where('location_id', $locationId);
        }

        // loop through and add up the invoice total
        $invoices = $invoices->get()->map(function ($invoice) {

            $total = 0;

            foreach ($invoice->lines as $line) {
                $total += $line->value;
            }

            $invoice->total = $total;

            return $invoice;
        });


        return $invoices;
    }


    /**
     * Return a K/V pair of the status with it's total invoice value for a specific location
     *
     * @param integer $locationId
     *
     * @return Object
     */
    public function getTotalForLocation(int $locationId): Object
    {
        $query = DB::table('invoice_headers AS ih')
            ->select('l.id', 'l.name', 'ih.status', DB::raw('SUM(il.value) as total'))
            ->join('locations AS l', 'ih.location_id', 'l.id')
            ->join('invoice_lines AS il', 'ih.id', 'il.invoice_header_id')
            ->where('l.id', $locationId)
            ->groupBy('ih.status');

        return $query->get()->keyBy('status');
    }
}
