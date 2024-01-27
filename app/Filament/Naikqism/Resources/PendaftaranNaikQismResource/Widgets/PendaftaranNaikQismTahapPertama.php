<?php

namespace App\Filament\Naikqism\Resources\PendaftaranNaikQismResource\Widgets;

use App\Filament\Naikqism\Resources\PendaftaranNaikQismResource;
use App\Models\Walisantri;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PendaftaranNaikQismTahapPertama extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;

    public function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->query(
                Walisantri::where('user_id',Auth::user()->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('')
                ->label('Mulai Pendaftaran Tahap 1'),
            ])
            ->actions([
                Action::make('Mulai Proses Pendaftaran')
                    ->url(fn (Walisantri $record): string => PendaftaranNaikQismResource::getUrl('edit', ['record' => $record]))
                    ->hidden(function (Walisantri $record) {
                        // dd($record->is_collapse);
                        if($record->is_collapse === true){
                            return true;
                        }elseif($record->is_collapse === false){
                            return false;
                        }
                    })
                    ->button(),

                    Action::make('Tambah Calon Santri')
                    ->url(fn (Walisantri $record): string => PendaftaranNaikQismResource::getUrl('edit', ['record' => $record]))
                    ->hidden(function (Walisantri $record) {
                        // dd($record->is_collapse);
                        if($record->is_collapse === false){
                            return true;
                        }elseif($record->is_collapse === true){
                            return false;
                        }
                    })
                    ->button()

            ], position: ActionsPosition::BeforeColumns);
    }
}
