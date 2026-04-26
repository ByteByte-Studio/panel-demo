<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = [
        "full_name",
        "person_type",
        "client_type",
        "phone_number",
        "email",
        "curp",
        "rfc",
        "address",
        "occupation",
        "date_of_birth",
    ];

    public function appointments(){
        return $this->morphMany(Appointments::class, "appointmentable");
    }

    public function payments(){
        return $this->morphMany(Payment::class, "paymentable");
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function allPayments()
    {
        return \App\Models\Payment::query()
            ->where('client_id', $this->id);
    }

}
