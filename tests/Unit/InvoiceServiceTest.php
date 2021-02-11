<?php

namespace Tests\Unit;

use App\Models\InvoiceHeader;
use App\Models\InvoiceLine;
use App\Models\Location;
use Tests\TestCase;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceServiceTest extends TestCase
{
    use RefreshDatabase;

    public $invoiceService;


    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestData();

        $this->invoiceService = new InvoiceService();
    }


    public function test_invoices_return_correct_data()
    {
        $invoices = $this->invoiceService->getInvoices();

        $this->assertIsObject($invoices);

        foreach ($invoices as $invoice) {
            $this->assertNotEmpty($invoice->id);
            $this->assertNotEmpty($invoice->date);
            $this->assertNotEmpty($invoice->status);
            $this->assertNotEmpty($invoice->location);
        }
    }


    public function test_filtered_invoices_return_correct_data()
    {
        $invoices = $this->invoiceService->getInvoices([
            '2000-01-01',
            '2021-01-01'
        ], InvoiceHeader::STATUS_OPEN, 'London');

        $this->assertCount(2);

        foreach ($invoices as $invoice) {
            $this->assertNotEmpty($invoice->id);
            $this->assertNotEmpty($invoice->date);
            $this->assertNotEmpty($invoice->status);
            $this->assertNotEmpty($invoice->location);
        }
    }


    public function seedTestData()
    {
        Location::create([['name' => 'London'],['name' => 'Bejing']]);

        InvoiceHeader::create([[
            'location_id' => 1,
            'date' => '2002-02-24',
            'status' => InvoiceHeader::STATUS_OPEN,
        ],[
            'location_id' => 1,
            'date' => '2004-01-29',
            'status' => InvoiceHeader::STATUS_PROCESSED,
        ],[
            'location_id' => 2,
            'date' => '1996-02-20',
            'status' => InvoiceHeader::STATUS_OPEN,
        ]]);

        InvoiceLine::create([[
            'invoice_header_id' => 1,
            'description' => 'foo bar',
            'value' => 12.50,
        ],[
            'invoice_header_id' => 1,
            'description' => 'foo bar',
            'value' => 12.50,
        ],[
            'invoice_header_id' => 1,
            'description' => 'foo bar',
            'value' => 12.50,
        ],[
            'invoice_header_id' => 2,
            'description' => 'foo bar',
            'value' => 12.50,
        ],[
            'invoice_header_id' => 3,
            'description' => 'foo bar',
            'value' => 12.50,
        ]]);
    }
}
