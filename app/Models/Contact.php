<?php

namespace App\Models;

use App\Enums\ContactType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = true;

    protected $casts = [
        'contact_type' => ContactType::class,
    ];

    public function contactMethods()
    {
        return $this->hasMany(ContactMethod::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function contactServices()
    {
        return $this->hasMany(ContactService::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function referred()
    {
        return $this->belongsTo(Contact::class, 'referred_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the created info
     */
    protected function CreatedInfo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => "{$this->created_at?->format('d/m/Y H:i')}  por {$this->creator?->name}",
        );
    }

    /**
     * Get the alias
     */
    protected function alias(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->contact_type == 'P' ? $this->contact : $this->name,
        );
    }
}
