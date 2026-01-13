<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;

    public function invoice()
    {
        return $this->belongsToMany(Invoice::class);
    }

    // pivot table invoice_payment
    public function invoicePayments()
    {
        return $this->hasMany(InvoicePayment::class);
    }
}
