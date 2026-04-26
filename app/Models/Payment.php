<?php

namespace App\Models;

use App\Enums\PaymentNotificationStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'client_id',
        'amount',
        'payment_method',
        'due_date',
        'concept',
        'is_notification_enabled',
        'last_reminded_at',
        'payment_status',
        'notification_status',
        'paymentable_id',
        'paymentable_type',
    ];

    protected $casts = [
        'due_date' => 'date',
        'last_reminded_at' => 'datetime',
        'is_notification_enabled' => 'boolean',
        'payment_status' => PaymentStatus::class,
        'notification_status' => PaymentNotificationStatus::class,
    ];

    protected static function booted()
    {
        static::updating(function ($payment) {
            if ($payment->payment_status === PaymentStatus::Paid) {
                $payment->is_notification_enabled = false;
            }
        });
    }

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, "client_id");
    }
}
