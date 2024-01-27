<?php

namespace App\Filament\Naikqism\Resources\PendaftaranNaikQismResource\Pages;

use App\Filament\Naikqism\Resources\PendaftaranNaikQismResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendaftaranNaikQism extends EditRecord
{
    protected static string $resource = PendaftaranNaikQismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
