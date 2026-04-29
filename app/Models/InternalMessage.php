<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'body',
        'sender_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipients()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('attended_at')
            ->withTimestamps();
    }
}
