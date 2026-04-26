<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AppointmentStatus;


class Appointments extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentsFactory> */
    use HasFactory;

    protected $fillable = [
        "appointmentable_id",
        "appointmentable_type",
        "date_time",
        "reason",
        "status",
        "modality",
        "notes",
        "reminder_sent_at",
        "confirmed_by_reminder_at",
        "reschedule_proposed_at",
    ];

    protected $casts = [
        'status' => AppointmentStatus::class,
        'date_time' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'confirmed_by_reminder_at' => 'datetime',
        'reschedule_proposed_at' => 'datetime',
    ];

    public function appointmentable(){
        return $this->morphTo();
    }
}
