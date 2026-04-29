<?php

namespace App\Models;

use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory;

    protected $fillable = [
        'full_name',
        'person_type',
        'client_type',
        'phone_number',
        'email',
        'curp',
        'rfc',
        'address',
        'occupation',
        'date_of_birth',
    ];

    public function appointments()
    {
        return $this->morphMany(Appointments::class, 'appointmentable');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function allPayments()
    {
        return Payment::query()
            ->where('client_id', $this->id);
    }
}
