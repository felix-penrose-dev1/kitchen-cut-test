<?php

namespace App\Services;

use App\Models\InvoiceHeader;

class InvoiceService
{
    public function getInvoices(array $dateRange = null, string $status = null, string $location = null)
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

        if ($location) {
            $invoices->where('location_id', $location);
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
}
