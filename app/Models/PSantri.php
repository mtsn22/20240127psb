<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PSantri extends Model
{
    use HasFactory;

    public function pwalisantri()
    {
        return $this->belongsTo(PWalisantri::class, 'p_walisantri_id', 'id');
    }
}
