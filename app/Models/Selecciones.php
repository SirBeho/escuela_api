<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Selecciones extends Model
{
    use HasFactory;

    public function alumnos(): BelongsTo
    {
        return $this->belongsTo(Alumnos::class);
    }
}
