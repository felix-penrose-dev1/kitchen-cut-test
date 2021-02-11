<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    use HasFactory;

    public $guarded = [];


    public function header()
    {
        return $this->belongsTo(InvoiceHeader::class, 'invoice_header_id');
    }
}
