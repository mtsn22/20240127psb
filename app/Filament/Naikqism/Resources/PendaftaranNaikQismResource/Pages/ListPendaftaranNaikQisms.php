<?php

namespace App\Filament\Naikqism\Resources\PendaftaranNaikQismResource\Pages;

use App\Filament\Naikqism\Resources\PendaftaranNaikQismResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendaftaranNaikQisms extends ListRecords
{
    protected static string $resource = PendaftaranNaikQismResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
