<?php

namespace App\Filament\Resources\PendaftaranResource\Widgets;

use App\Models\KelasSantri;
use App\Models\Santri;
use App\Models\StatusSantri;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PendaftaranNaikQism extends BaseWidget
{

    public function table(Table $table): Table
    {
        // $aktif = StatusSantri::where('status', 'aktif')->pluck('santri_id');

        return $table
            ->query(
                Santri::where('naikqism', 'naik')->whereHas('walisantri.user', function ($query) {
                    $query->where('id', Auth::user()->id);
                })
            )
            ->columns([
                TextColumn::make('nama_lengkap'),
            ]);
    }
}
