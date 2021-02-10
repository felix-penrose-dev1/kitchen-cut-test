<?php

namespace Tests\Unit;

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

        $this->invoiceService = new InvoiceService();
    }


    public function test_filtered_invoices_return_correct_data()
    {
        $this->seed();

        $invoices = $this->invoiceService->getInvoices();

        $this->assertIsObject($invoices);

        foreach ($invoices as $invoice) {
            $this->assertNotEmpty($invoice->id);
            $this->assertNotEmpty($invoice->date);
            $this->assertNotEmpty($invoice->status);
            $this->assertNotEmpty($invoice->location);
        }
    }
}
