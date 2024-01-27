<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel as FilamentPanel;
use Filament\Tables\Columns\Layout\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

// use BezhanSalleh\FilamentShield\Traits\HasPanelShield;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function canAccessPanel(FilamentPanel $panel): bool
    {

        // return $this->can('view-admin', User::class);
        // return $this->isAdmin() || $this->isPengajar() || $this->isWalisantri();
        if (auth()->user()->panelrole === 'psb' && $panel->getId() === 'psb') {
            return true;
        } elseif (auth()->user()->panelrole === 'walisantri' && $panel->getId() === 'psb') {
            return true;
        } elseif (auth()->user()->panelrole === 'walisantri' && $panel->getId() === 'naikqism') {
            return true;
        } else {

            return false;
        }
    }

    public function getRedirectRoute()
    {
        $naikqism = Session::get('channel');

        if ($naikqism === 'psb') {
            return match ((string)$this->panelrole) {
                'psb' => 'psb',
                'walisantri' => 'psb',
            };
        } elseif ($naikqism === 'naikqism') {
            return match ((string)$this->panelrole) {
                'psb' => 'naikqism',
                'walisantri' => 'naikqism',
            };
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
