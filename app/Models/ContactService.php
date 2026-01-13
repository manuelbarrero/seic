<?php

namespace App\Models;

use App\Enums\ServiceStatus;
use App\Enums\ServiceType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ContactService extends Model
{
    protected $table = 'contact_service';

    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;

    protected $casts = [
        'status' => ServiceStatus::class,
        'type' => ServiceType::class,
        'date_from' => 'date',
        'due_date' => 'date',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class)->withDefault();
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the due month
     */
    protected function due_month(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->due_date->format('m'),
        );
    }
}
