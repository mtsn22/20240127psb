<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CekNIK extends Component implements HasForms
{
    use InteractsWithForms;

    // public ?string $NIK = null;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([

                        TextInput::make('kk_pendaftar')
                            ->required(),
                            TextInput::make('nik_pendaftar')
                            ->required(),
                            TextInput::make('nama_pendaftar')
                            ->required(),
                            DatePicker::make('tgl_lhr_pendaftar')
                            ->required(),

                    ]),

            ])
            ->statePath('data');
    }

    public function create(): void
    {
        Pendaftar::create($this->form->getState());
    }



    public function render(): View
    {
        return view('livewire.ceknik');
    }
}
