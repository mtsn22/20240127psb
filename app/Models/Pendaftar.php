<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $casts = [
        'ps_kkh_medsos_sering' => 'array',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
