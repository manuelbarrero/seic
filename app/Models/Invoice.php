<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;

    protected $casts = [
        'date' => 'date',
    ];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'invoice_payment')
            ->withPivot('amount_applied');
    }

    public function calculateTotals()
    {
        $this->sub_total = $this->invoiceItems()->sum('total');
        $this->total = $this->invoiceItems()->sum('total');
        $this->tax_amount = 0;
        // $this->tax_amount = $this->sub_total * $this->tax_rate / 100;
        // $this->total = $this->sub_total + $this->tax_amount;
        $this->save();
    }
}
