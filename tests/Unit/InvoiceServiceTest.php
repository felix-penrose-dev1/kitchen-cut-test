<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\InvoiceHeader;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvoiceServiceTest extends TestCase
{
    use RefreshDatabase;

    public invoiceService $invoiceService;
    public $testData = [
        'invoice_headers' => [[
            'location_id' => 1,
            'date' => '2002-02-24',
            'status' => InvoiceHeader::STATUS_OPEN,
        ],[
            'location_id' => 1,
            'date' => '2004-01-29',
            'status' => InvoiceHeader::STATUS_OPEN,
        ],[
            'location_id' => 1,
            'date' => '1996-03-02',
            'status' => InvoiceHeader::STATUS_PROCESSED,
        ],[
            'location_id' => 2,
            'date' => '1996-02-20',
            'status' => InvoiceHeader::STATUS_PROCESSED,
        ]],

        'invoice_lines' => [[
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
        ]],

        'locations' => [['name' => 'London'], ['name' => 'Bejing']],
    ];


    protected function setUp(): void
    {
        parent::setUp();
        $this->seedTestData();

        $this->invoiceService = new InvoiceService();
    }


    public function seedTestData()
    {
        DB::table('locations')->insert($this->testData['locations']);
        DB::table('invoice_headers')->insert($this->testData['invoice_headers']);
        DB::table('invoice_lines')->insert($this->testData['invoice_lines']);
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
        $dateRange = ['from' => '2000-01-01', 'to' => '2021-01-01'];
        $invoices = $this->invoiceService->getInvoices(null, InvoiceHeader::STATUS_OPEN, 1);

        $this->assertCount(2, $invoices);

        $i = 0;
        foreach ($invoices as $invoice) {
            $this->assertSame('1', $invoice->location_id);
            $this->assertTrue($invoice->date > $dateRange['from']);
            $this->assertTrue($invoice->date < $dateRange['to']);
            $this->assertSame(InvoiceHeader::STATUS_OPEN, $invoice->status);
            $this->assertSame('London', $invoice->location);
            $i++;
        }
    }


    public function test_location_id_will_return_sum_of_invoices()
    {
        $locationId = 1;
        $locationByStatusValue = $this->invoiceService->getTotalForLocation($locationId);

        $this->assertCount(2, $locationByStatusValue);
        $this->assertSame('50.0', $locationByStatusValue['open']->total);
        $this->assertSame('12.5', $locationByStatusValue['processed']->total);
    }
}
