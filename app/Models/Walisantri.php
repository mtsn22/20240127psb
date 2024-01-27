<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walisantri extends Model
{
    use HasFactory;

    protected $casts = [
        'is_collapse' => 'boolean',
    ];

    public function santris()
    {
        return $this->hasMany(Santri::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function al_ak_provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'al_ak_provinsi_id');
    }

    public function al_ak_kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'al_ak_kabupaten_id');
    }

    public function al_ak_kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'al_ak_kecamatan_id');
    }

    public function al_ak_kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'al_ak_kelurahan_id');
    }

    public function al_ak_kodepos()
    {
        return $this->belongsTo(Kodepos::class, 'al_ak_kodepos_id');
    }

    public function al_ik_provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'al_ik_provinsi_id');
    }

    public function al_ik_kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'al_ik_kabupaten_id');
    }

    public function al_ik_kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'al_ik_kecamatan_id');
    }

    public function al_ik_kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'al_ik_kelurahan_id');
    }

    public function al_ik_kodepos()
    {
        return $this->belongsTo(Kodepos::class, 'al_ik_kodepos_id');
    }

    public function al_w_provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'al_w_provinsi_id');
    }

    public function al_w_kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'al_w_kabupaten_id');
    }

    public function al_w_kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'al_w_kecamatan_id');
    }

    public function al_w_kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'al_w_kelurahan_id');
    }

    public function al_w_kodepos()
    {
        return $this->belongsTo(Kodepos::class, 'al_w_kodepos_id');
    }

    public function kelasSantris()
    {
        return $this->hasManyThrough(KelasSantri::class, Santri::class);
    }

    public function statussantris()
    {
        return $this->hasOneThrough(StatusSantri::class, Santri::class);
    }
}
