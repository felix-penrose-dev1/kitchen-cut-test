<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHeader extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';
    const STATUS_OPEN = 'open';
    const STATUS_PROCESSED = 'processed';


    public function location()
    {
        return $this->belongsTo(Location::class);
    }


    public function lines()
    {
        return $this->hasMany(InvoiceLine::class, 'invoice_header_id');
    }
}
