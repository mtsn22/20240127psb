<?php

namespace App\Filament\Naikqism\Resources\PendaftaranNaikQismResource\Pages;

use App\Filament\Naikqism\Resources\PendaftaranNaikQismResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPendaftaranNaikQism extends ViewRecord
{
    protected static string $resource = PendaftaranNaikQismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
