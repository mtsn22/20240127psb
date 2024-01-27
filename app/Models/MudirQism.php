<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MudirQism extends Model
{
    use HasFactory;

    public function pengajar()
    {
        return $this->belongsTo(Pengajar::class);
    }

    public function qism()
    {
        return $this->belongsTo(Qism::class);
    }
}
