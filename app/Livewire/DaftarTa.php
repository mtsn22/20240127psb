<?php

namespace App\Livewire;

use App\Models\Pendaftar;
use App\Models\Santri;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class DaftarTa extends Component implements HasForms
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


                        Placeholder::make('')
                            ->content(new HtmlString('<div class="sticky top-0">
                                         <p>Butuh bantuan?</p>
                                         <p>Silakan mengubungi admin di bawah ini melalui WA:</p>
                                         <p class="text-tsn-header"><a href="https://wa.me/6282210862400">> Link WA Admin Putra <</a></p>
                                         <p class="text-tsn-header"><a href="https://wa.me/6281232171109">> Link WA Admin Putri <</a></p>
                                     </div>')),

                        TextInput::make('qism_calon_view')
                            ->label('Qism yang dituju')
                            ->default('Tarbiyatul Aulaad')
                            ->disabled()
                            ->required()
                            ->dehydrated(),

                        Hidden::make('qism_calon')
                            ->default('1'),

                        TextInput::make('kk_calon')
                            ->label('Nomor KK Calon Santri')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required(),

                        TextInput::make('nama_kep_kel_calon')
                            ->label('Nama Kepala Keluarga')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required(),

                        TextInput::make('nik_calon')
                            ->label('Nomor NIK Calon Santri')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required()
                            ->unique(Pendaftar::class, 'nik_calon')
                            ->unique(Santri::class, 'nik'),

                        TextInput::make('nama_calon')
                            ->label('Nama Calon Santri')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required(),

                        DatePicker::make('tanggal_lahir_calon')
                            ->label('Tanggal Lahir Calon Santri')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required()
                            // ->native(false)
                            ->closeOnDateSelection(),

                        Radio::make('jeniskelamin_calon')
                            ->label('Jenis Kelamin Calon Santri')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required()
                            ->inline(),

                        Hidden::make('tahap')
                            ->default('Mendaftar'),
                    ]),

            ])
            ->statePath('data');
    }

    public function create(): void
    {
        Pendaftar::create($this->form->getState());

        session()->flash('status', 'Alhamdulillah, ananda telah terdaftar sebagai calon santri');

        $this->redirect('/');
    }



    public function render(): View
    {
        return view('livewire.daftarta');
    }
}
