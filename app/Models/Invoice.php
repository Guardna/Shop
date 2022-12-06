<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public  $timestamps = false;
    protected $table = "invoice";
    protected  $primaryKey = "InvoiceId";

    public function invoiceLines() {
        return $this->hasMany(InvoiceLine::class, "InvoiceId", "InvoiceId");
    }
}
