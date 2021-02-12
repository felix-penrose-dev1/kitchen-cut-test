<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\InvoiceHeader;
use App\Services\InvoiceService;

class InvoiceController extends Controller
{
    public function index(Request $request, InvoiceService $invoiceService)
    {
        $dateRange = [
            'from' => $request->get('dateFrom'),
            'to' => $request->get('dateTo')
        ];

        $invoices = $invoiceService->getInvoices($dateRange, $request->get('status'), $request->get('location'));
        $statuses = InvoiceHeader::ALL_STATUSES;
        $locations = Location::all();

        $locationByStatusValue = null;
        if ($locationId = $request->get('location')) {
            $locationByStatusValue = $invoiceService->getTotalForLocation($locationId);
        }

        return view('index', compact('invoices', 'statuses', 'locations', 'locationByStatusValue'));
    }
}
