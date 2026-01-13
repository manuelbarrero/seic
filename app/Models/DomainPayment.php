<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainPayment extends Model
{
    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
