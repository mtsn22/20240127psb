<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Resources\PendaftaranResource;
use App\Models\Walisantri;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPendaftaran extends EditRecord
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Action::make('save')
                ->label('Simpan')
                ->action('save')
                ->extraAttributes([
                    'class' => 'text-black',
                ]),
            Action::make('Dashboard')
                ->label('Dashboard')
                ->icon('heroicon-m-home')
                ->url('/psb'),

            // Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Simpan'),
            // ->successRedirectUrl('/psb'),
            $this->getCancelFormAction()
                ->label('Batal'),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Data Walisantri telah tersimpan')
            ->body('Lanjutkan dengan menambah data calon santri')
            ->persistent()
            ->color('warning')
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // $this->data['is_collapse'] = '1';
        $walisantri = Walisantri::find($this->data['id']);
                $walisantri->is_collapse = '1';
                $walisantri->save();
    }

    //     protected function mutateFormDataBeforeSave(array $data): array
    // {
    //     $this->data['is_collapse'] = '1';

    //     return $data;
    // }
}
