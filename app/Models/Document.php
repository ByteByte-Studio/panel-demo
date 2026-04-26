<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'file_path',
    ];

    /**
     * Obtiene el modelo padre al que pertenece este documento (Client, Procedure, Case, etc.)
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}