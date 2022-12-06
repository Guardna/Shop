<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    use HasFactory;
    public  $timestamps = false;
    protected $table = "invoiceline";
    protected  $primaryKey = "InvoiceLineId";

    public  function invoice() {
        return $this->belongsTo(Invoice::class, "InvoiceId", "InvoiceId");
    }
    public function post() {
        return $this->belongsTo(PostEloquentModel::class, "PostId", "id");
    }
}
