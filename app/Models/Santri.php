<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;

    public function walisantri()
    {
        return $this->belongsTo(Walisantri::class);
    }

    public function kelasSantris()
    {
        return $this->hasMany(KelasSantri::class);
    }

    public function kelassantri()
    {
        return $this->hasOne(KelasSantri::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function kodepos()
    {
        return $this->belongsTo(Kodepos::class);
    }

    public function statusSantris()
    {
        return $this->hasMany(StatusSantri::class);
    }
    public function statussantri()
    {
        return $this->hasOne(StatusSantri::class);
    }

    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class);
    }

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class);
    }
}
