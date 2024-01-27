<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use App\Models\Santri;
use App\Models\Shop\Product;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\Attributes\On;
use PhpParser\Node\Stmt\Label;

class DaftarNaikQism extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public $kk = '';

    public function cek()
    {
        Santri::where('kartu_keluarga', $this->kk);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Santri::where('kartu_keluarga', $this->kk))
            ->heading('Status Pendaftaran')
            ->columns([
                // Split::make([
                TextColumn::make('nama_lengkap')
                ->description(fn ($record): string => "Nama:", position: 'above'),
                
                

            // ])->from('lg')
            ])
            ->actions([
                EditAction::make('Daftar')
                ->model(Santri::class)
                ->form([
        TextInput::make('nama_lengkap')
            ->required()
            ->maxLength(255),
        // ...
    ])
                ->button()
                ->openUrlInNewTab()
                // ->hidden(fn ($record) => $record->ps_tahap !== 'Diterima')
                ->extraAttributes([
                    'class' => 'bg-tsn-accent text-black focus:bg-tsn-bg',
                ])
            ])
            ->paginated(false)
            ->emptyStateHeading('Masukkan nomor KK');
    }
    // public function table(Table $table): Table
    // {
    //     // return $table
    //     //     ->query(Product::query())
    //     //     ->columns([
    //     //         TextColumn::make('name'),
    //     //     ])
    //     //     ->filters([
    //     //         // ...
    //     //     ])
    //     //     ->actions([
    //     //         // ...
    //     //     ])
    //     //     ->bulkActions([
    //     //         // ...
    //     //     ]);
    // }

    public function render(): View
    {
        return view('livewire.formnaikqism');
    }
}
