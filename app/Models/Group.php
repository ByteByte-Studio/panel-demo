<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $appends = ['current_members_count'];

    protected $fillable = [
        'name',
        "message",
        'capacity',
        'date_time',
        "location",
        "location_link",
        'is_active'
    ];


    protected function casts(): array
    {
        return [
            'date_time' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function getCurrentMembersCountAttribute(): int
    {
        return $this->clients()->count();
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
