<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSantri extends Model
{
    use HasFactory;

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
