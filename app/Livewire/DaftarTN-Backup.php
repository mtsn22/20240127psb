<?php

namespace App\Livewire;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kodepos;
use App\Models\Provinsi;
use App\Models\Pendaftar;
use App\Models\Santri;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Illuminate\Support\Str;

class DaftarTN extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    // public Pendaftar $pendaftar;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Hidden::make('ps_tahap')
                    ->default('Mendaftar'),

                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="">
                                         <p>Butuh bantuan?</p>
                                         <p>Silakan mengubungi admin di bawah ini melalui WA:</p>
                                         <p class="text-tsn-header"><a href="https://wa.me/6282210862400">> Link WA Admin Putra <</a></p>
                                         <p class="text-tsn-header"><a href="https://wa.me/628175765767">> Link WA Admin Putri <</a></p>
                                     </div>')),
                    ]),

                Wizard::make([

                    Step::make('CEK NIK')
                        ->schema([

                            TextInput::make('ps_qism_view')
                                ->label('Qism yang dituju')
                                ->default('MTW/TN')
                                ->disabled()
                                ->required()
                                ->dehydrated(),

                            Hidden::make('ps_qism')
                                ->default('6'),

                            TextInput::make('ps_kartu_keluarga')
                                ->label('Nomor KK Calon Santri')
                                ->hint('Isi sesuai KK')
                                ->hintColor('danger')
                                ->length(16)
                                ->required()
                                ->default('3295141306822004'),

                            Select::make('ps_kewarganegaraan')
                                ->label('Kewarganegaraan')
                                ->placeholder('Pilih Kewarganegaraan')
                                ->options([
                                    'WNI' => 'WNI',
                                    'WNA' => 'WNA',
                                ])
                                ->required()
                                ->live()
                                ->default('WNI'),
                            // ,


                            TextInput::make('ps_nik')
                                ->label('NIK Calon Santri')
                                ->hint('Isi sesuai dengan KK')
                                ->hintColor('danger')
                                ->length(16)
                                ->required()
                                ->live()
                                ->unique(Pendaftar::class, 'ps_nik')
                                ->unique(Santri::class, 'nik')
                                // ->exists(modifyRuleUsing: function (Exists $rule, Get $get) {
                                //     return $rule->where('tahap', 'Diterima');
                                // })
                                ->default('3295131306822002')
                                ->hidden(fn (Get $get) =>
                                $get('ps_kewarganegaraan') == 'WNA' ||
                                    $get('ps_kewarganegaraan') == ''),

                            Grid::make(2)
                                ->schema([

                                    TextInput::make('ps_kitas')
                                        ->label('KITAS')
                                        ->hint('Nomor Izin Tinggal (KITAS)')
                                        ->hintColor('danger')
                                        ->required()
                                        ->default('3295131306822002')
                                        ->unique(Pendaftar::class, 'ps_kitas')
                                        ->unique(Santri::class, 'kitas')
                                        ->hidden(fn (Get $get) =>
                                        $get('ps_kewarganegaraan') == 'WNI' ||
                                            $get('ps_kewarganegaraan') == ''),

                                    TextInput::make('ps_asal_negara')
                                        ->label('Asal Negara')
                                        ->required()
                                        ->default('asfasdad')
                                        ->hidden(fn (Get $get) =>
                                        $get('ps_kewarganegaraan') == 'WNI' ||
                                            $get('ps_kewarganegaraan') == ''),


                                ]),

                        ]),

                    Step::make('WALISANTRI')
                        ->schema([

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                                <p class="text-2xl strong"><strong>DATA WALISANTRI CALON SANTRI</strong></p>
                                            </div>')),

                            //AYAH KANDUNG


                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>A. AYAH KANDUNG</strong></p>
                                </div>')),

                                    TextInput::make('pw_ak_nama_lengkap')
                                        ->label('Nama Lengkap')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->required()
                                        ->default('sdsa'),

                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>A.01 STATUS AYAH KANDUNG</strong></p>
                                </div>')),

                                    Select::make('pw_ak_status')
                                        ->label('Status')
                                        ->placeholder('Pilih Status')
                                        ->options([
                                            'Masih Hidup' => 'Masih Hidup',
                                            'Sudah Meninggal' => 'Sudah Meninggal',
                                            'Tidak Diketahui' => 'Tidak Diketahui',
                                        ])
                                        ->required()
                                        ->live()->default('Masih Hidup'),

                                    Select::make('pw_ak_kewarganegaraan')
                                        ->label('Kewarganegaraan')
                                        ->placeholder('Pilih Kewarganegaraan')
                                        ->options([
                                            'WNI' => 'WNI',
                                            'WNA' => 'WNA',
                                        ])
                                        ->required()
                                        ->default('WNI')
                                        ->live()

                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            $get('pw_ak_status') == ''),

                                    TextInput::make('pw_ak_nik')
                                        ->label('NIK')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->length(16)
                                        ->maxLength(16)
                                        ->required()
                                        ->default('3295141306822004')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ak_kewarganegaraan') == 'WNA' ||
                                            $get('pw_ak_kewarganegaraan') == '' ||
                                            $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            $get('pw_ak_status') == ''),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_ak_asal_negara')
                                                ->label('Asal Negara')
                                                ->required()
                                                ->default('r21243')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_ak_kewarganegaraan') == '' ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            TextInput::make('pw_ak_kitas')
                                                ->label('KITAS')
                                                ->hint('Nomor Izin Tinggal (KITAS)')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_ak_kewarganegaraan') == '' ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),
                                        ]),
                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_ak_tempat_lahir')
                                                ->label('Tempat Lahir')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('afasd')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            DatePicker::make('pw_ak_tanggal_lahir')
                                                ->label('Tanggal Lahir')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('11111987')
                                                // ->format('dd/mm/yyyy')
                                                ->displayFormat('d M Y')

                                                ->closeOnDateSelection()
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),
                                        ]),

                                    Grid::make(3)
                                        ->schema([

                                            Select::make('pw_ak_pend_terakhir')
                                                ->label('Pendidikan Terakhir')
                                                ->placeholder('Pilih Pendidikan Terakhir')
                                                ->options([
                                                    'SD/Sederajat' => 'SD/Sederajat',
                                                    'SMP/Sederajat' => 'SMP/Sederajat',
                                                    'SMA/Sederajat' => 'SMA/Sederajat',
                                                    'D1' => 'D1',
                                                    'D2' => 'D2',
                                                    'D3' => 'D3',
                                                    'D4/S1' => 'D4/S1',
                                                    'S2' => 'S2',
                                                    'S3' => 'S3',
                                                    'Tidak Bersekolah' => 'Tidak Bersekolah',
                                                ])

                                                ->required()
                                                ->live()
                                                ->default('S2')

                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            Select::make('pw_ak_pekerjaan_utama')
                                                ->label('Pekerjaan Utama')
                                                ->placeholder('Pilih Pekerjaan Utama')
                                                ->options([
                                                    'Tidak Bekerja' => 'Tidak Bekerja',
                                                    'Pensiunan' => 'Pensiunan',
                                                    'PNS' => 'PNS',
                                                    'TNI/Polisi' => 'TNI/Polisi',
                                                    'Guru/Dosen' => 'Guru/Dosen',
                                                    'Pegawai Swasta' => 'Pegawai Swasta',
                                                    'Wiraswasta' => 'Wiraswasta',
                                                    'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                                    'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                                    'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                                    'Pilot/Pramugara' => 'Pilot/Pramugara',
                                                    'Pedagang' => 'Pedagang',
                                                    'Petani/Peternak' => 'Petani/Peternak',
                                                    'Nelayan' => 'Nelayan',
                                                    'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                                    'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                                    'Politikus' => 'Politikus',
                                                    'Lainnya' => 'Lainnya',
                                                ])

                                                ->required()
                                                ->live()
                                                ->default('Nelayan')

                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            Select::make('pw_ak_pghsln_rt')
                                                ->label('Penghasilan Rata-Rata')
                                                ->placeholder('Pilih Penghasilan Rata-Rata')
                                                ->options([
                                                    'Kurang dari 500.000' => 'Kurang dari 500.000',
                                                    '500.000 - 1.000.000' => '500.000 - 1.000.000',
                                                    '1.000.001 - 2.000.000' => '1.000.001 - 2.000.000',
                                                    '2.000.001 - 3.000.000' => '2.000.001 - 3.000.000',
                                                    '3.000.001 - 5.000.000' => '3.000.001 - 5.000.000',
                                                    'Lebih dari 5.000.000' => 'Lebih dari 5.000.000',
                                                    'Tidak ada' => 'Tidak ada',
                                                ])

                                                ->required()
                                                ->live()
                                                ->default('Tidak ada')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),
                                        ]),

                                    Grid::make(1)
                                        ->schema([

                                            Radio::make('pw_ak_tdk_hp')
                                                ->label('Memiliki nomer handphone?')
                                                ->live()
                                                ->default('Memiliki nomer handphone')
                                                ->options([
                                                    'Memiliki nomer handphone' => 'Memiliki nomer handphone',
                                                    'Tidak memiliki nomer handphone' => 'Tidak memiliki nomer handphone',
                                                ])
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            TextInput::make('pw_ak_nomor_handphone')
                                                ->label('No. Handphone')
                                                ->helperText('Contoh: 6282187782223')
                                                ->tel()
                                                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                                ->required()
                                                ->default('08643726383')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_tdk_hp') == 'Tidak memiliki nomer handphone' ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),
                                        ]),

                                    // KARTU KELUARGA AYAH KANDUNG
                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                            <p class="text-2xl strong"><strong>A.02 KARTU KELUARGA</strong></p>
                                            <p class="text-2xl strong"><strong>AYAH KANDUNG</strong></p>
                                        </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            $get('pw_ak_status') == ''),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_ak_no_kk')
                                                ->label('No. KK Ayah Kandung')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->length(16)
                                                ->required()
                                                ->default('3295141306822004')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            TextInput::make('pw_ak_kep_kel_kk')
                                                ->label('Nama Kepala Keluarga')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('asfasdsad')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),
                                        ]),

                                    FileUpload::make('pw_ak_file_kk')
                                        ->label('Upload KK')
                                        ->hint('File PDF')
                                        ->hintColor('danger')
                                        ->helperText('Maks. 2 Mb')
                                        ->directory('orangtua/ayahkandung/kk')
                                        ->preserveFilenames()
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->maxSize(2000)
                                        ->required()
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            $get('pw_ak_status') == ''),

                                    // ALAMAT AYAH KANDUNG
                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>A.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                    <p class="text-2xl strong"><strong>AYAH KANDUNG</strong></p>
                                </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            $get('pw_ak_status') == ''),

                                    Toggle::make('pw_al_ak_tgldi_ln')
                                        ->label('Tinggal di luar negeri')
                                        ->live()
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            $get('pw_ak_status') == ''),

                                    Textarea::make('pw_al_ak_almt_ln')
                                        ->label('Alamat Luar Negeri')
                                        ->required()
                                        ->default('sdfsadad')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_al_ak_tgldi_ln') == 0),

                                    Select::make('pw_al_ak_stts_rmh')
                                        ->label('Status Kepemilikan Rumah')
                                        ->placeholder('Pilih Status Kepemilikan Rumah')
                                        ->options([
                                            'Milik Sendiri' => 'Milik Sendiri',
                                            'Rumah Orang Tua' => 'Rumah Orang Tua',
                                            'Rumah Saudara/kerabat' => 'Rumah Saudara/kerabat',
                                            'Rumah Dinas' => 'Rumah Dinas',
                                            'Sewa/kontrak' => 'Sewa/kontrak',
                                            'Lainnya' => 'Lainnya',
                                        ])
                                        ->required()
                                        ->live()
                                        ->default('Milik Sendiri')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_al_ak_tgldi_ln') == 1 ||
                                            $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            $get('pw_ak_status') == ''),

                                    Grid::make(2)
                                        ->schema([

                                            Select::make('pw_al_ak_provinsi_id')
                                                ->label('Provinsi')
                                                ->placeholder('Pilih Provinsi')
                                                ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('11')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ak_tgldi_ln') == 1 ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == '')
                                                ->afterStateUpdated(function (Set $set) {
                                                    $set('pw_al_ak_kabupaten_id', null);
                                                    $set('pw_al_ak_kecamatan_id', null);
                                                    $set('pw_al_ak_kelurahan_id', null);
                                                    $set('pw_al_ak_kodepos', null);
                                                }),

                                            Select::make('pw_al_ak_kabupaten_id')
                                                ->label('Kabupaten')
                                                ->placeholder('Pilih Kabupaten')
                                                ->options(fn (Get $get): Collection => Kabupaten::query()
                                                    ->where('provinsi_id', $get('pw_al_ak_provinsi_id'))
                                                    ->pluck('kabupaten', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('3')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ak_tgldi_ln') == 1 ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            Select::make('pw_al_ak_kecamatan_id')
                                                ->label('Kecamatan')
                                                ->placeholder('Pilih Kecamatan')
                                                ->options(fn (Get $get): Collection => Kecamatan::query()
                                                    ->where('kabupaten_id', $get('pw_al_ak_kabupaten_id'))
                                                    ->pluck('kecamatan', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('42')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ak_tgldi_ln') == 1 ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            Select::make('pw_al_ak_kelurahan_id')
                                                ->label('Kelurahan')
                                                ->placeholder('Pilih Kelurahan')
                                                ->options(fn (Get $get): Collection => Kelurahan::query()
                                                    ->where('kecamatan_id', $get('pw_al_ak_kecamatan_id'))
                                                    ->pluck('kelurahan', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('981')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ak_tgldi_ln') == 1 ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),
                                                // ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                                //     if (($get('pw_al_ak_kodepos') ?? '') !== Str::slug($old)) {
                                                //         return;
                                                //     }

                                                //     $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                                //     $state = $kodepos;

                                                //     foreach ($state as $state) {
                                                //         $set('pw_al_ak_kodepos', Str::substr($state, 12, 5));
                                                //     }
                                                // }),


                                            TextInput::make('pw_al_ak_rt')
                                                ->label('RT')
                                                ->required()
                                                ->default('2')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ak_tgldi_ln') == 1 ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            TextInput::make('pw_al_ak_rw')
                                                ->label('RW')
                                                ->required()
                                                ->default('2')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ak_tgldi_ln') == 1 ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            Textarea::make('pw_al_ak_alamat')
                                                ->label('Alamat')
                                                ->required()
                                                ->columnSpanFull()
                                                ->default('vsdsad')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ak_tgldi_ln') == 1 ||
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                            // TextInput::make('pw_al_ak_kodepos')
                                            //     ->label('Kodepos')
                                            //     ->disabled()
                                            //     ->required()
                                            //     ->hidden(fn (Get $get) =>
                                            //     $get('pw_al_ak_tgldi_ln') == 1 ||
                                            //         $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            //         $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            //         $get('pw_ak_status') == ''),
                                        ]),








                            //IBU KANDUNG


                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>B. IBU KANDUNG</strong></p>
                                </div>')),

                                    TextInput::make('pw_ik_nama_lengkap')
                                        ->label('Nama Lengkap')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->required()
                                        ->default('gsadsad'),

                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>B.01 STATUS IBU KANDUNG</strong></p>
                                </div>')),

                                    Select::make('pw_ik_status')
                                        ->label('Status')
                                        ->placeholder('Pilih Status')
                                        ->options([
                                            'Masih Hidup' => 'Masih Hidup',
                                            'Sudah Meninggal' => 'Sudah Meninggal',
                                            'Tidak Diketahui' => 'Tidak Diketahui',
                                        ])
                                        ->required()
                                        ->default('Masih Hidup')
                                        ->live(),

                                    Select::make('pw_ik_kewarganegaraan')
                                        ->label('Kewarganegaraan')
                                        ->placeholder('Pilih Kewarganegaraan')
                                        ->options([
                                            'WNI' => 'WNI',
                                            'WNA' => 'WNA',
                                        ])
                                        ->required()
                                        ->live()
                                        ->default('WNI')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    TextInput::make('pw_ik_nik')
                                        ->label('NIK')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->length(16)
                                        ->required()
                                        ->default('3295141306822204')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ik_kewarganegaraan') == 'WNA' ||
                                            $get('pw_ik_kewarganegaraan') == '' ||
                                            $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_ik_asal_negara')
                                                ->label('Asal Negara')
                                                ->required()
                                                ->default('asfsasafd')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_ik_kewarganegaraan') == '' ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            TextInput::make('pw_ik_kitas')
                                                ->label('KITAS')
                                                ->hint('Nomor Izin Tinggal (KITAS)')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('34242423')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_ik_kewarganegaraan') == '' ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),
                                        ]),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_ik_tempat_lahir')
                                                ->label('Tempat Lahir')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('fsad')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            DatePicker::make('pw_ik_tanggal_lahir')
                                                ->label('Tanggal Lahir')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('11111987')
                                                // ->format('dd/mm/yyyy')
                                                ->displayFormat('d M Y')
                                                ->closeOnDateSelection()
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),
                                        ]),

                                    Grid::make(3)
                                        ->schema([

                                            Select::make('pw_ik_pend_terakhir')
                                                ->label('Pendidikan Terakhir')
                                                ->placeholder('Pilih Pendidikan Terakhir')
                                                ->options([
                                                    'SD/Sederajat' => 'SD/Sederajat',
                                                    'SMP/Sederajat' => 'SMP/Sederajat',
                                                    'SMA/Sederajat' => 'SMA/Sederajat',
                                                    'D1' => 'D1',
                                                    'D2' => 'D2',
                                                    'D3' => 'D3',
                                                    'D4/S1' => 'D4/S1',
                                                    'S2' => 'S2',
                                                    'S3' => 'S3',
                                                    'Tidak Bersekolah' => 'Tidak Bersekolah',
                                                ])
                                                ->required()
                                                ->live()
                                                ->default('D2')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            Select::make('pw_ik_pekerjaan_utama')
                                                ->label('Pekerjaan Utama')
                                                ->placeholder('Pilih Pekerjaan Utama')
                                                ->options([
                                                    'Tidak Bekerja' => 'Tidak Bekerja',
                                                    'Pensiunan' => 'Pensiunan',
                                                    'PNS' => 'PNS',
                                                    'TNI/Polisi' => 'TNI/Polisi',
                                                    'Guru/Dosen' => 'Guru/Dosen',
                                                    'Pegawai Swasta' => 'Pegawai Swasta',
                                                    'Wiraswasta' => 'Wiraswasta',
                                                    'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                                    'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                                    'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                                    'Pilot/Pramugara' => 'Pilot/Pramugara',
                                                    'Pedagang' => 'Pedagang',
                                                    'Petani/Peternak' => 'Petani/Peternak',
                                                    'Nelayan' => 'Nelayan',
                                                    'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                                    'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                                    'Politikus' => 'Politikus',
                                                    'Lainnya' => 'Lainnya',
                                                ])
                                                ->required()
                                                ->live()
                                                ->default('Pedagang')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            Select::make('pw_ik_pghsln_rt')
                                                ->label('Penghasilan Rata-Rata')
                                                ->placeholder('Pilih Penghasilan Rata-Rata')
                                                ->options([
                                                    'Kurang dari 500.000' => 'Kurang dari 500.000',
                                                    '500.000 - 1.000.000' => '500.000 - 1.000.000',
                                                    '1.000.001 - 2.000.000' => '1.000.001 - 2.000.000',
                                                    '2.000.001 - 3.000.000' => '2.000.001 - 3.000.000',
                                                    '3.000.001 - 5.000.000' => '3.000.001 - 5.000.000',
                                                    'Lebih dari 5.000.000' => 'Lebih dari 5.000.000',
                                                    'Tidak ada' => 'Tidak ada',
                                                ])
                                                ->required()
                                                ->live()
                                                ->default('Tidak ada')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),
                                        ]),

                                    

                                        Grid::make(1)
                                        ->schema([

                                            Radio::make('pw_ik_tdk_hp')
                                                ->label('Memiliki nomer handphone?')
                                                ->live()
                                                ->default('1')
                                                ->options([
                                                    'Memiliki nomer handphone' => 'Memiliki nomer handphone',
                                                    'Tidak memiliki nomer handphone' => 'Tidak memiliki nomer handphone',
                                                ])
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            TextInput::make('pw_ik_nomor_handphone')
                                                ->label('No. Handphone')
                                                ->helperText('Contoh: 6282187782223')
                                                ->tel()
                                                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                                ->required()
                                                ->default('08643726383')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_tdk_hp') == 'Tidak memiliki nomer handphone' ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),
                                        ]),

                                    // KARTU KELUARGA IBU KANDUNG
                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                         <p class="text-2xl strong"><strong>B.02 KARTU KELUARGA</strong></p>
                                         <p class="text-2xl strong"><strong>IBU KANDUNG</strong></p>
                                     </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    Toggle::make('pw_ik_kk_sama_ak')
                                        ->label('KK sama Dengan Ayah Kandung')
                                        ->live()
                                        ->default(1)
                                        ->afterStateUpdated(function (Get $get, Set $set) {
                                            $sama = $get('pw_ik_kk_sama_ak');
                                            $set('pw_al_ik_sama_ak', $sama);
                                        })
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    Toggle::make('pw_al_ik_sama_ak')
                                        ->label('Alamat sama dengan Ayah Kandung')
                                        ->disabled()
                                        ->live()
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_ik_no_kk')
                                                ->label('No. KK Ibu Kandung')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->length(16)
                                                ->required()
                                                ->default('3295141306822004')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            TextInput::make('pw_ik_kep_kel_kk')
                                                ->label('Nama Kepala Keluarga')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('asfadsad')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),
                                        ]),

                                    // FileUpload::make('pw_ik_file_kk')
                                    //     ->label('Upload KK')
                                    //     ->hint('File PDF')
                                    //     ->hintColor('danger')
                                    //     ->helperText('Maks. 2 Mb')
                                    //     ->directory('walisantri/ibukandung/kk')
                                    //     ->preserveFilenames()
                                    //     ->acceptedFileTypes(['application/pdf'])
                                    //     ->maxSize(2000)
                                    //     ->required()
                                    //     ->hidden(fn (Get $get) =>
                                    //     $get('pw_ik_kk_sama_ak') == 1 ||
                                    //         $get('pw_ik_status') == 'Sudah Meninggal' ||
                                    //         $get('pw_ik_status') == 'Tidak Diketahui' ||
                                    //         $get('pw_ik_status') == ''),

                                    // ALAMAT IBU KANDUNG
                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>B.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                    <p class="text-2xl strong"><strong>IBU KANDUNG</strong></p>
                                </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ik_kk_sama_ak') == 1 ||
                                            $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    Toggle::make('pw_al_ik_tgldi_ln')
                                        ->label('Tinggal di luar negeri')
                                        ->live()
                                        ->default(1)
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ik_kk_sama_ak') == 1 ||
                                            $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    Textarea::make('pw_al_ik_almt_ln')
                                        ->label('Alamat Luar Negeri')
                                        ->required()
                                        ->default('dsadsad')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_al_ik_tgldi_ln') == 0 ||
                                            $get('pw_ik_kk_sama_ak') == 1 ||
                                            $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    Select::make('pw_al_ik_stts_rmh')
                                        ->label('Status Kepemilikan Rumah')
                                        ->placeholder('Pilih Status Kepemilikan Rumah')
                                        ->options([
                                            'Milik Sendiri' => 'Milik Sendiri',
                                            'Rumah Orang Tua' => 'Rumah Orang Tua',
                                            'Rumah Saudara/kerabat' => 'Rumah Saudara/kerabat',
                                            'Rumah Dinas' => 'Rumah Dinas',
                                            'Sewa/kontrak' => 'Sewa/kontrak',
                                            'Lainnya' => 'Lainnya',
                                        ])
                                        ->required()
                                        ->live()
                                        ->default('Mili Sendiri')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_al_ik_tgldi_ln') == 1 ||
                                            $get('pw_ik_kk_sama_ak') == 1 ||
                                            $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    Grid::make(2)
                                        ->schema([

                                            Select::make('pw_al_ik_provinsi_id')
                                                ->label('Provinsi')
                                                ->placeholder('Pilih Provinsi')
                                                ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('11')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ik_tgldi_ln') == 1 ||
                                                    $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == '')
                                                ->afterStateUpdated(function (Set $set) {
                                                    $set('pw_al_ik_kabupaten_id', null);
                                                    $set('pw_al_ik_kecamatan_id', null);
                                                    $set('pw_al_ik_kelurahan_id', null);
                                                    $set('pw_al_ik_kodepos', null);
                                                }),

                                            Select::make('pw_al_ik_kabupaten_id')
                                                ->label('Kabupaten')
                                                ->placeholder('Pilih Kabupaten')
                                                ->options(fn (Get $get): Collection => Kabupaten::query()
                                                    ->where('provinsi_id', $get('pw_al_ik_provinsi_id'))
                                                    ->pluck('kabupaten', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('3')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ik_tgldi_ln') == 1 ||
                                                    $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            Select::make('pw_al_ik_kecamatan_id')
                                                ->label('Kecamatan')
                                                ->placeholder('Pilih Kecamatan')
                                                ->options(fn (Get $get): Collection => Kecamatan::query()
                                                    ->where('kabupaten_id', $get('pw_al_ik_kabupaten_id'))
                                                    ->pluck('kecamatan', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('42')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ik_tgldi_ln') == 1 ||
                                                    $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            Select::make('pw_al_ik_kelurahan_id')
                                                ->label('Kelurahan')
                                                ->placeholder('Pilih Kelurahan')
                                                ->options(fn (Get $get): Collection => Kelurahan::query()
                                                    ->where('kecamatan_id', $get('pw_al_ik_kecamatan_id'))
                                                    ->pluck('kelurahan', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('981')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ik_tgldi_ln') == 1 ||
                                                    $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),
                                                // ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                                //     if (($get('pw_al_ik_kodepos') ?? '') !== Str::slug($old)) {
                                                //         return;
                                                //     }

                                                //     $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                                //     $state = $kodepos;

                                                //     foreach ($state as $state) {
                                                //         $set('pw_al_ik_kodepos', Str::substr($state, 12, 5));
                                                //     }
                                                // }),


                                            TextInput::make('pw_al_ik_rt')
                                                ->label('RT')
                                                ->required()
                                                ->default('3')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ik_tgldi_ln') == 1 ||
                                                    $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            TextInput::make('pw_al_ik_rw')
                                                ->label('RW')
                                                ->required()
                                                ->default('4')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ik_tgldi_ln') == 1 ||
                                                    $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            Textarea::make('pw_al_ik_alamat')
                                                ->label('Alamat')
                                                ->required()
                                                ->columnSpanFull()
                                                ->default('asdsafasd')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_ik_tgldi_ln') == 1 ||
                                                    $get('pw_ik_kk_sama_ak') == 1 ||
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                            // TextInput::make('pw_al_ik_kodepos')
                                            //     ->label('Kodepos')
                                            //     ->disabled()
                                            //     ->required()
                                            //     ->hidden(fn (Get $get) =>
                                            //     $get('pw_al_ik_tgldi_ln') == 1 ||
                                            //         $get('pw_ik_kk_sama_ak') == 1 ||
                                            //         $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            //         $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            //         $get('pw_ik_status') == ''),
                                        ]),





                            //WALI


                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>C. WALI</strong></p>
                                </div>')),

                                    Select::make('pw_w_status')
                                        ->label('Status')
                                        ->placeholder('Pilih Status')
                                        ->options(function (Get $get) {

                                            if (($get('pw_ak_status') == "Masih Hidup" && $get('pw_ik_status') == "Masih Hidup")) {
                                                return ([
                                                    'Sama dengan ayah kandung' => 'Sama dengan ayah kandung',
                                                    'Sama dengan ibu kandung' => 'Sama dengan ibu kandung',
                                                    'Lainnya' => 'Lainnya'
                                                ]);
                                            } elseif (($get('pw_ak_status') == "Masih Hidup" && $get('pw_ik_status') !== "Masih Hidup")) {
                                                return ([
                                                    'Sama dengan ayah kandung' => 'Sama dengan ayah kandung',
                                                    'Lainnya' => 'Lainnya'
                                                ]);
                                            } elseif (($get('pw_ak_status') !== "Masih Hidup" && $get('pw_ik_status') == "Masih Hidup")) {
                                                return ([
                                                    'Sama dengan ibu kandung' => 'Sama dengan ibu kandung',
                                                    'Lainnya' => 'Lainnya'
                                                ]);
                                            } elseif (($get('pw_ak_status') !== "Masih Hidup" && $get('pw_ik_status') !== "Masih Hidup")) {
                                                return ([
                                                    'Lainnya' => 'Lainnya'
                                                ]);
                                            }
                                        })
                                        ->required()
                                        ->default('Lainnya')
                                        ->live(),

                                    TextInput::make('pw_w_nama_lengkap')
                                        ->label('Nama Lengkap')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->required()
                                        ->default('asasd')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_status') !== 'Lainnya'),

                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>C.01 STATUS WALI</strong></p>
                                </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_status') !== 'Lainnya'),

                                    Select::make('pw_w_kewarganegaraan')
                                        ->label('Kewarganegaraan')
                                        ->placeholder('Pilih Kewarganegaraan')
                                        ->options([
                                            'WNI' => 'WNI',
                                            'WNA' => 'WNA',
                                        ])
                                        ->required()
                                        ->live()
                                        ->default('WNA')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_status') !== 'Lainnya'),

                                    TextInput::make('pw_w_nik')
                                        ->label('NIK')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->length(16)
                                        ->required()
                                        ->default('asdasd')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_kewarganegaraan') == 'WNA' ||
                                            $get('pw_w_kewarganegaraan') == '' ||
                                            $get('pw_w_status') !== 'Lainnya'),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_w_asal_negara')
                                                ->label('Asal Negara')
                                                ->required()
                                                ->default('asfsada')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_w_kewarganegaraan') == '' ||
                                                    $get('pw_w_status') !== 'Lainnya'),

                                            TextInput::make('pw_w_kitas')
                                                ->label('KITAS')
                                                ->hint('Nomor Izin Tinggal (KITAS)')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('14123213')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_w_kewarganegaraan') == '' ||
                                                    $get('pw_w_status') !== 'Lainnya'),
                                        ]),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_w_tempat_lahir')
                                                ->label('Tempat Lahir')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('asdasd')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') !== 'Lainnya'),

                                            DatePicker::make('pw_w_tanggal_lahir')
                                                ->label('Tanggal Lahir')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('11111878')
                                                // ->format('dd/mm/yyyy')
                                                ->displayFormat('d M Y')

                                                ->closeOnDateSelection()
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') !== 'Lainnya'),
                                        ]),

                                    Grid::make(3)
                                        ->schema([

                                            Select::make('pw_w_pend_terakhir')
                                                ->label('Pendidikan Terakhir')
                                                ->placeholder('Pilih Pendidikan Terakhir')
                                                ->options([
                                                    'SD/Sederajat' => 'SD/Sederajat',
                                                    'SMP/Sederajat' => 'SMP/Sederajat',
                                                    'SMA/Sederajat' => 'SMA/Sederajat',
                                                    'D1' => 'D1',
                                                    'D2' => 'D2',
                                                    'D3' => 'D3',
                                                    'D4/S1' => 'D4/S1',
                                                    'S2' => 'S2',
                                                    'S3' => 'S3',
                                                    'Tidak Bersekolah' => 'Tidak Bersekolah',
                                                ])

                                                ->required()
                                                ->live()
                                                ->default('S3')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') !== 'Lainnya'),

                                            Select::make('pw_w_pekerjaan_utama')
                                                ->label('Pekerjaan Utama')
                                                ->placeholder('Pilih Pekerjaan Utama')
                                                ->options([
                                                    'Tidak Bekerja' => 'Tidak Bekerja',
                                                    'Pensiunan' => 'Pensiunan',
                                                    'PNS' => 'PNS',
                                                    'TNI/Polisi' => 'TNI/Polisi',
                                                    'Guru/Dosen' => 'Guru/Dosen',
                                                    'Pegawai Swasta' => 'Pegawai Swasta',
                                                    'Wiraswasta' => 'Wiraswasta',
                                                    'Pengacara/Jaksa/Hakim/Notaris' => 'Pengacara/Jaksa/Hakim/Notaris',
                                                    'Seniman/Pelukis/Artis/Sejenis' => 'Seniman/Pelukis/Artis/Sejenis',
                                                    'Dokter/Bidan/Perawat' => 'Dokter/Bidan/Perawat',
                                                    'Pilot/Pramugara' => 'Pilot/Pramugara',
                                                    'Pedagang' => 'Pedagang',
                                                    'Petani/Peternak' => 'Petani/Peternak',
                                                    'Nelayan' => 'Nelayan',
                                                    'Buruh (Tani/Pabrik/Bangunan)' => 'Buruh (Tani/Pabrik/Bangunan)',
                                                    'Sopir/Masinis/Kondektur' => 'Sopir/Masinis/Kondektur',
                                                    'Politikus' => 'Politikus',
                                                    'Lainnya' => 'Lainnya',
                                                ])

                                                ->required()
                                                ->live()
                                                ->default('PNS')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') !== 'Lainnya'),

                                            Select::make('pw_w_pghsln_rt')
                                                ->label('Penghasilan Rata-Rata')
                                                ->placeholder('Pilih Penghasilan Rata-Rata')
                                                ->options([
                                                    'Kurang dari 500.000' => 'Kurang dari 500.000',
                                                    '500.000 - 1.000.000' => '500.000 - 1.000.000',
                                                    '1.000.001 - 2.000.000' => '1.000.001 - 2.000.000',
                                                    '2.000.001 - 3.000.000' => '2.000.001 - 3.000.000',
                                                    '3.000.001 - 5.000.000' => '3.000.001 - 5.000.000',
                                                    'Lebih dari 5.000.000' => 'Lebih dari 5.000.000',
                                                    'Tidak ada' => 'Tidak ada',
                                                ])

                                                ->required()
                                                ->live()
                                                ->default('Lebih dari 5.000.000')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') !== 'Lainnya'),
                                        ]),


                                        Grid::make(1)
                                        ->schema([

                                            Radio::make('pw_w_tdk_hp')
                                                ->label('Memiliki nomer handphone?')
                                                ->live()
                                                ->default('Memiliki nomer handphone')
                                                ->options([
                                                    'Memiliki nomer handphone' => 'Memiliki nomer handphone',
                                                    'Tidak memiliki nomer handphone' => 'Tidak memiliki nomer handphone',
                                                ])
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') == 'Sudah Meninggal' ||
                                                    $get('pw_w_status') == 'Tidak Diketahui' ||
                                                    $get('pw_w_status') == ''),

                                            TextInput::make('pw_w_nomor_handphone')
                                                ->label('No. Handphone')
                                                ->helperText('Contoh: 6282187782223')
                                                ->tel()
                                                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                                ->required()
                                                ->default('08643726383')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_tdk_hp') == 'Tidak memiliki nomer handphone' ||
                                                    $get('pw_w_status') == 'Sudah Meninggal' ||
                                                    $get('pw_w_status') == 'Tidak Diketahui' ||
                                                    $get('pw_w_status') == ''),
                                        ]),

                                    // KARTU KELUARGA WALI
                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                         <p class="text-2xl strong"><strong>C.02 KARTU KELUARGA</strong></p>
                                         <p class="text-2xl strong"><strong>WALI</strong></p>
                                     </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_status') !== 'Lainnya'),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_w_no_kk')
                                                ->label('No. KK Wali')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->length(16)
                                                ->required()
                                                ->default('3295133306822004')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') !== 'Lainnya'),

                                            TextInput::make('pw_w_kep_kel_kk')
                                                ->label('Nama Kepala Keluarga')
                                                ->hint('Isi sesuai dengan KK')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('sfdsadsad')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') !== 'Lainnya'),

                                            // FileUpload::make('pw_w_file_kk')
                                            //     ->label('Upload KK')
                                            //     ->hint('File PDF')
                                            //     ->hintColor('danger')
                                            //     ->helperText('Maks. 2 Mb')
                                            //     ->directory('walisantri/wali/kk')
                                            //     ->preserveFilenames()
                                            //     ->acceptedFileTypes(['application/pdf'])
                                            //     ->maxSize(2000)
                                            //     ->required()
                                            //     ->hidden(fn (Get $get) =>
                                            //     $get('pw_w_status') !== 'Lainnya'),
                                        ]),

                                    // ALAMAT WALI
                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                    <p class="text-2xl strong"><strong>C.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                    <p class="text-2xl strong"><strong>WALI</strong></p>
                                </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_status') !== 'Lainnya'),

                                    Toggle::make('pw_al_w_tgldi_ln')
                                        ->label('Tinggal di luar negeri')
                                        ->live()
                                        ->default(1)
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_status') !== 'Lainnya'),

                                    Textarea::make('pw_al_w_almt_ln')
                                        ->label('Alamat Luar Negeri')
                                        ->required()
                                        ->default('asgasdsad')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_al_w_tgldi_ln') == 0 ||
                                            $get('pw_w_status') !== 'Lainnya'),

                                    Select::make('pw_al_w_stts_rmh')
                                        ->label('Status Kepemilikan Rumah')
                                        ->placeholder('Pilih Status Kepemilikan Rumah')
                                        ->options([
                                            'Milik Sendiri' => 'Milik Sendiri',
                                            'Rumah Orang Tua' => 'Rumah Orang Tua',
                                            'Rumah Saudara/kerabat' => 'Rumah Saudara/kerabat',
                                            'Rumah Dinas' => 'Rumah Dinas',
                                            'Sewa/kontrak' => 'Sewa/kontrak',
                                            'Lainnya' => 'Lainnya',
                                        ])
                                        ->required()
                                        ->live()
                                        ->default('Rumah Orang Tua')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_al_w_tgldi_ln') == 1 ||
                                            $get('pw_w_status') !== 'Lainnya'),

                                    Grid::make(2)
                                        ->schema([

                                            Select::make('pw_al_w_provinsi_id')
                                                ->label('Provinsi')
                                                ->placeholder('Pilih Provinsi')
                                                ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('11')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_w_tgldi_ln') == 1 ||
                                                    $get('pw_w_status') !== 'Lainnya')
                                                ->afterStateUpdated(function (Set $set) {
                                                    $set('pw_al_w_kabupaten_id', null);
                                                    $set('pw_al_w_kecamatan_id', null);
                                                    $set('pw_al_w_kelurahan_id', null);
                                                    $set('pw_al_w_kodepos', null);
                                                }),

                                            Select::make('pw_al_w_kabupaten_id')
                                                ->label('Kabupaten')
                                                ->placeholder('Pilih Kabupaten')
                                                ->options(fn (Get $get): Collection => Kabupaten::query()
                                                    ->where('provinsi_id', $get('pw_al_w_provinsi_id'))
                                                    ->pluck('kabupaten', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('3')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_w_tgldi_ln') == 1 ||
                                                    $get('pw_w_status') !== 'Lainnya'),

                                            Select::make('pw_al_w_kecamatan_id')
                                                ->label('Kecamatan')
                                                ->placeholder('Pilih Kecamatan')
                                                ->options(fn (Get $get): Collection => Kecamatan::query()
                                                    ->where('kabupaten_id', $get('pw_al_w_kabupaten_id'))
                                                    ->pluck('kecamatan', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('42')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_w_tgldi_ln') == 1 ||
                                                    $get('pw_w_status') !== 'Lainnya'),

                                            Select::make('pw_al_w_kelurahan_id')
                                                ->label('Kelurahan')
                                                ->placeholder('Pilih Kelurahan')
                                                ->options(fn (Get $get): Collection => Kelurahan::query()
                                                    ->where('kecamatan_id', $get('pw_al_w_kecamatan_id'))
                                                    ->pluck('kelurahan', 'id'))
                                                ->required()
                                                ->live()
                                                ->default('981')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_w_tgldi_ln') == 1 ||
                                                    $get('pw_w_status') !== 'Lainnya'),
                                                // ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                                //     if (($get('pw_al_w_kodepos') ?? '') !== Str::slug($old)) {
                                                //         return;
                                                //     }

                                                //     $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                                //     $state = $kodepos;

                                                //     foreach ($state as $state) {
                                                //         $set('pw_al_w_kodepos', Str::substr($state, 12, 5));
                                                //     }
                                                // }),


                                            TextInput::make('pw_al_w_rt')
                                                ->label('RT')
                                                ->required()
                                                ->default('2')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_w_tgldi_ln') == 1 ||
                                                    $get('pw_w_status') !== 'Lainnya'),

                                            TextInput::make('pw_al_w_rw')
                                                ->label('RW')
                                                ->required()
                                                ->default('4')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_w_tgldi_ln') == 1 ||
                                                    $get('pw_w_status') !== 'Lainnya'),

                                            Textarea::make('pw_al_w_alamat')
                                                ->label('Alamat')
                                                ->required()
                                                ->columnSpanFull()
                                                ->default('sadasd')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_al_w_tgldi_ln') == 1 ||
                                                    $get('pw_w_status') !== 'Lainnya'),

                                            // TextInput::make('pw_al_w_kodepos')
                                            //     ->label('Kodepos')
                                            //     ->disabled()
                                            //     ->required()
                                            //     ->hidden(fn (Get $get) =>
                                            //     $get('pw_al_w_tgldi_ln') == 1 ||
                                            //         $get('pw_w_status') !== 'Lainnya'),
                                        ]),






                        ]),

                    Step::make('CALON SANTRI')
                        ->schema([

                            //SANTRI
                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                                <p class="text-2xl strong"><strong>DATA CALON SANTRI</strong></p>
                                            </div>')),

                            TextInput::make('ps_nama_lengkap')
                                ->label('Nama Lengkap')
                                ->hint('Isi sesuai dengan KK')
                                ->hintColor('danger')
                                ->default('sfsadasd')
                                ->default('3295141306811104')
                                ->required(),

                            TextInput::make('ps_nama_panggilan')
                                ->label('Nama Hijroh')
                                ->required()
                                ->default('asdafafs')
                                ->default('ummu'),

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                            </div>')),


                            TextInput::make('ps_peng_pend_formal')
                                ->label('Pengalaman Pendidikan Formal')
                                ->required()
                                ->default('f'),

                            TextInput::make('ps_peng_pend_agama')
                                ->label('Pengalaman Pendidikan Agama (mondok)')
                                ->required()
                                ->default('a'),

                            TextInput::make('ps_hafalan')
                                ->label('Hafalan')
                                ->length('2')
                                ->suffix('juz')
                                ->required()
                                ->default('10'),

                            Select::make('ps_mendaftar_keinginan')
                                ->label('Mendaftar atas kenginginan')
                                ->options([
                                    'Orangtua' => 'Orangtua',
                                    'Ananda' => 'Ananda',
                                    'Lainnya' => 'Lainnya',
                                ])
                                ->required()
                                ->live()
                                ->default('Orangtua'),

                            TextInput::make('ps_mendaftar_keinginan_lainnya')
                                ->label('Lainnya')
                                ->required()
                                ->default('asdasf')
                                ->hidden(fn (Get $get) =>
                                $get('ps_mendaftar_keinginan') !== 'Lainnya' ||
                                    $get('ps_mendaftar_keinginan') == ''),



                            Hidden::make('ps_aktivitaspend')
                                ->default('Mahad Aly'),

                            Grid::make(3)
                                ->schema([

                                    Radio::make('ps_jeniskelamin')
                                        ->label('Jenis Kelamin')
                                        ->options([
                                            'Laki-laki' => 'Laki-laki',
                                            'Perempuan' => 'Perempuan',
                                        ])
                                        ->required()
                                        ->default('Laki-laki')
                                        ->inline(),

                                    TextInput::make('ps_tempat_lahir')
                                        ->label('Tempat Lahir')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->default('sdfsada')
                                        ->required(),


                                    DatePicker::make('ps_tanggal_lahir')
                                        ->label('Tanggal Lahir')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->required()
                                        ->default('11111987')
                                        ->closeOnDateSelection()
                                        ->afterStateUpdated(function (Set $set, $state) {
                                            $set('ps_umur', Carbon::parse($state)->age);
                                        }),


                                    TextInput::make('ps_umur')
                                        ->label('Umur')
                                        ->default('12')
                                        ->required(),

                                ]),

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                            </div>')),

                            Grid::make(2)
                                ->schema([

                                    TextInput::make('ps_anak_ke')
                                        ->label('Anak ke-')
                                        ->required()
                                        ->default('3')
                                        ->rules([
                                                fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                                    // dd($attribute, $value);

                                                    $anakke = $get('ps_anak_ke');
                                                    $psjumlahsaudara = $get('ps_jumlah_saudara');
                                                    $jumlahsaudara = $psjumlahsaudara + 1;

                                                    // dd($anakke + 1);



                                                    if ( $anakke > $jumlahsaudara ){
                                                        $fail("Anak ke tidak bisa lebih dari jumlah saudara + 1");

                                                    }
                                                },
                                            ]),

                                        TextInput::make('ps_jumlah_saudara')
                                        ->label('Jumlah saudara')
                                        ->default('5')
                                        ->required(),




                                ]),

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                            </div>')),

                            Grid::make(1)
                                ->schema([

                                    TextInput::make('ps_agama')
                                        ->label('Agama')
                                        ->default('Islam')
                                        ->disabled()
                                        ->required(),

                                ]),

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                            </div>')),

                            Grid::make(2)
                                ->schema([

                                    Select::make('ps_cita_cita')
                                        ->label('Cita-cita')
                                        ->placeholder('Pilih Cita-cita')
                                        ->options([
                                            'PNS' => 'PNS',
                                            'TNI/Polri' => 'TNI/Polri',
                                            'Guru/Dosen' => 'Guru/Dosen',
                                            'Dokter' => 'Dokter',
                                            'Politikus' => 'Politikus',
                                            'Wiraswasta' => 'Wiraswasta',
                                            'Seniman/Artis' => 'Seniman/Artis',
                                            'Ilmuwan' => 'Ilmuwan',
                                            'Agamawan' => 'Agamawan',
                                            'Lainnya' => 'Lainnya',
                                        ])
                                        ->required()
                                        ->default('Dokter')
                                        ->live(),

                                    TextInput::make('ps_cita_cita_lainnya')
                                        ->label('Cita-cita Lainnya')
                                        ->required()
                                        ->default('sfdsad')
                                        ->hidden(fn (Get $get) =>
                                        $get('ps_cita_cita') !== 'Lainnya'),
                                ]),

                            Grid::make(2)
                                ->schema([
                                    Select::make('ps_hobi')
                                        ->label('Hobi')
                                        ->placeholder('Pilih Hobi')
                                        ->options([
                                            'Olahraga' => 'Olahraga',
                                            'Kesetuan' => 'Kesetuan',
                                            'Membaca' => 'Membaca',
                                            'Menulis' => 'Menulis',
                                            'Jalan-jalan' => 'Jalan-jalan',
                                            'Lainnya' => 'Lainnya',
                                        ])
                                        ->required()
                                        ->default('Lainnya')
                                        ->live(),

                                    TextInput::make('ps_hobi_lainnya')
                                        ->label('Hobi Lainnya')
                                        ->required()
                                        ->default('asdads')
                                        ->hidden(fn (Get $get) =>
                                        $get('ps_hobi') !== 'Lainnya'),

                                ]),


                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                            </div>')),

                            Grid::make(2)
                                ->schema([
                                    Select::make('ps_keb_khus')
                                        ->label('Kebutuhan Khusus')
                                        ->placeholder('Pilih Kebutuhan Khusus')
                                        ->options([
                                            'Tidak Ada' => 'Tidak Ada',
                                            'Lamban belajar' => 'Lamban belajar',
                                            'Kesulitan belajar spesifik' => 'Kesulitan belajar spesifik',
                                            'Gangguan komunikasi' => 'Gangguan komunikasi',
                                            'Berbakat/memiliki kemampuan dan kecerdasan luar biasa' => 'Berbakat/memiliki kemampuan dan kecerdasan luar biasa',
                                            'Lainnya' => 'Lainnya',
                                        ])
                                        ->required()
                                        ->default('Tidak Ada')
                                        ->live(),

                                    TextInput::make('ps_keb_khus_lainnya')
                                        ->label('Kebutuhan Khusus Lainnya')
                                        ->required()
                                        ->default('asdads')
                                        ->hidden(fn (Get $get) =>
                                        $get('ps_keb_khus') !== 'Lainnya'),

                                ]),

                            Grid::make(2)
                                ->schema([
                                    Select::make('ps_keb_dis')
                                        ->label('Kebutuhan Disabilitas')
                                        ->placeholder('Pilih Kebutuhan Disabilitas')
                                        ->options([
                                            'Tidak Ada' => 'Tidak Ada',
                                            'Tuna Netra' => 'Tuna Netra',
                                            'Tuna Rungu' => 'Tuna Rungu',
                                            'Tuna Daksa' => 'Tuna Daksa',
                                            'Tuna Grahita' => 'Tuna Grahita',
                                            'Tuna Laras' => 'Tuna Laras',
                                            'Tuna Wicara' => 'Tuna Wicara',
                                            'Lainnya' => 'Lainnya',
                                        ])
                                        ->required()
                                        ->default('Tidak Ada')
                                        ->live(),

                                    TextInput::make('ps_keb_dis_lainnya')
                                        ->label('Kebutuhan Disabilitas Lainnya')
                                        ->required()
                                        ->default('asfsadad')
                                        ->hidden(fn (Get $get) =>
                                        $get('ps_keb_dis') !== 'Lainnya'),

                                ]),

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                            </div>')),


                                Grid::make(1)
                                        ->schema([

                                            Radio::make('ps_tdk_hp')
                                                ->label('Memiliki nomer handphone?')
                                                ->live()
                                                ->default('Memiliki nomer handphone')
                                                ->options([
                                                    'Memiliki nomer handphone' => 'Memiliki nomer handphone',
                                                    'Tidak memiliki nomer handphone' => 'Tidak memiliki nomer handphone',
                                                ])
                                                ->hidden(fn (Get $get) =>
                                                $get('ps_status') == 'Sudah Meninggal' ||
                                                    $get('ps_status') == 'Tidak Diketahui' ||
                                                    $get('ps_status') == ''),

                                            TextInput::make('ps_nomor_handphone')
                                                ->label('No. Handphone')
                                                ->helperText('Contoh: 6282187782223')
                                                ->tel()
                                                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                                ->required()
                                                ->default('08643726383')
                                                ->hidden(fn (Get $get) =>
                                                $get('ps_tdk_hp') == 'Tidak memiliki nomer handphone' ||
                                                    $get('ps_status') == 'Sudah Meninggal' ||
                                                    $get('ps_status') == 'Tidak Diketahui' ||
                                                    $get('ps_status') == ''),

                                                TextInput::make('ps_email')
                                        ->label('Email')
                                        ->email(),
                                        ]),

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                            </div>')),

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                                                        <p class="text-2xl strong"><strong>TEMPAT TINGGAL DOMISILI</strong></p>
                                                                        <p class="text-2xl strong"><strong>SANTRI</strong></p>
                                                                    </div>')),

                            Select::make('ps_al_s_status_mukim')
                                ->label('Status Mukim')
                                ->placeholder('Pilih Status Mukim')
                                ->default('Mukim')
                                ->live()
                                ->options([
                                    'Mukim' => 'Mukim',
                                    'Tidak Mukim' => 'Tidak Mukim',
                                ])
                                ->required(),


                            Select::make('ps_al_s_stts_tptgl')
                                ->label('Status Tempat Tinggal')
                                ->placeholder('Pilih Status Tempat Tinggal')
                                ->options([
                                    'Tinggal dengan Ayah Kandung' => 'Tinggal dengan Ayah Kandung',
                                    'Tinggal dengan Ibu Kandung' => 'Tinggal dengan Ibu Kandung',
                                    'Tinggal dengan Wali' => 'Tinggal dengan Wali',
                                    'Ikut Saudara/Kerabat' => 'Ikut Saudara/Kerabat',
                                    'Kontrak/Kost' => 'Kontrak/Kost',
                                    'Tinggal di Asrama Bukan Milik Pesantren' => 'Tinggal di Asrama Bukan Milik Pesantren',
                                    'Panti Asuhan' => 'Panti Asuhan',
                                    'Rumah Singgah' => 'Rumah Singgah',
                                    'Lainnya' => 'Lainnya',
                                ])
                                ->required()
                                ->live()
                                ->default('Kontrak/Kos')
                                ->hidden(
                                    fn (Get $get) =>
                                    $get('ps_al_s_status_mukim') !== 'Tidak Mukim'
                                ),

                            Grid::make(2)
                                ->schema([

                                    Select::make('ps_al_s_provinsi_id')
                                        ->label('Provinsi')
                                        ->placeholder('Pilih Provinsi')
                                        ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                        ->required()
                                        ->default('11')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Wali'
                                        )
                                        ->afterStateUpdated(function (Set $set) {
                                            $set('ps_al_s_kabupaten_id', null);
                                            $set('ps_al_s_kecamatan_id', null);
                                            $set('ps_al_s_kelurahan_id', null);
                                            $set('ps_al_s_kodepos', null);
                                        }),

                                    Select::make('ps_al_s_kabupaten_id')
                                        ->label('Kabupaten')
                                        ->placeholder('Pilih Kabupaten')
                                        ->options(fn (Get $get): Collection => Kabupaten::query()
                                            ->where('provinsi_id', $get('ps_al_s_provinsi_id'))
                                            ->pluck('kabupaten', 'id'))
                                        ->required()
                                        ->default('3')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Wali'
                                        ),

                                    Select::make('ps_al_s_kecamatan_id')
                                        ->label('Kecamatan')
                                        ->placeholder('Pilih Kecamatan')
                                        ->options(fn (Get $get): Collection => Kecamatan::query()
                                            ->where('kabupaten_id', $get('ps_al_s_kabupaten_id'))
                                            ->pluck('kecamatan', 'id'))
                                        ->required()
                                        ->default('42')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Wali'
                                        ),

                                    Select::make('ps_al_s_kelurahan_id')
                                        ->label('Kelurahan')
                                        ->placeholder('Pilih Kelurahan')
                                        ->options(fn (Get $get): Collection => Kelurahan::query()
                                            ->where('kecamatan_id', $get('ps_al_s_kecamatan_id'))
                                            ->pluck('kelurahan', 'id'))
                                        ->required()
                                        ->default('981')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Wali'
                                        ),
                                        // ->afterStateUpdated(function (Get $get, ?string $state, Set $set) {

                                        //     $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                        //     $state = $kodepos;

                                        //     foreach ($state as $states) {
                                        //         // dd($states);
                                        //         $set('ps_al_s_kodepos', Str::substr($states, 12, 5));
                                        //     }
                                        // }),


                                    TextInput::make('ps_al_s_rt')
                                        ->label('RT')
                                        ->required()
                                        ->default('3')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Wali'
                                        ),

                                    TextInput::make('ps_al_s_rw')
                                        ->label('RW')
                                        ->required()
                                        ->default('5')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Wali'
                                        ),

                                    Textarea::make('ps_al_s_alamat')
                                        ->label('Alamat')
                                        ->required()
                                        ->columnSpanFull()
                                        ->default('asdsafsad')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Wali'
                                        ),

                                    // Select::make('ps_al_s_kodepos')
                                    //     ->label('Kodepos')
                                    //     ->required()
                                    //     ->preload()
                                    //     ->options(function (Get $get) {

                                    //         $kelurahan = $get('ps_al_s_kelurahan_id');
                                    //         $kodepos = Kodepos::where('kelurahan_id', $kelurahan)->get('kodepos');

                                    //         // dd($kelurahan, $kodepos);

                                    //         if ($kelurahan !== null) {


                                    //             return ([
                                    //                 $kodepos => 'a',
                                    //             ]);
                                    //         }
                                        
                                    //     })
                                        
                                    //     ->hidden(
                                    //         fn (Get $get) =>
                                    //         $get('ps_al_s_status_mukim') !== 'Tidak Mukim' ||
                                    //         $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                    //         $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                    //         $get('ps_al_s_stts_tptgl') === 'Tinggal dengan Wali'
                                    //     ),

                                    TextInput::make('ps_al_s_jarak')
                                        ->label('Jarak Tempat Tinggal ke Pondok')
                                        ->required()
                                        ->default('3 Km')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim'
                                        ),

                                    TextInput::make('ps_al_s_transportasi')
                                        ->label('Transportasi ke Pondok')
                                        ->required()
                                        ->default('Jalan kaki')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim'
                                        ),

                                    TextInput::make('ps_al_s_waktu_tempuh')
                                        ->label('Waktu ke Pondok')
                                        ->required()
                                        ->default('10 menit')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim'
                                        ),

                                    Textarea::make('ps_al_s_koordinat')
                                        ->label('Koordinat')
                                        ->required()
                                        ->default('[1.3223,43322322]')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_al_s_status_mukim') !== 'Tidak Mukim'
                                        ),
                                ]),
                        ]),





                    Step::make('KUESIONER KEGIATAN HARIAN')
                        ->schema([

                    Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                                                        <p><strong>Di isi oleh wali calon santri/santriwati, baik yang berada di Mahad atau berada dirumah</strong></p>
                                                                        <p><strong>Harap diisi dengan kejujuran</strong></p>
                                                                    </div>')),

                                Select::make('ps_kkh_keberadaan')
                                        ->label('1. Di mana saat ini ananda berada?')
                                        ->placeholder('Pilih')
                                        ->options([
                                            'Di rumah orangtua' => 'Di rumah orangtua',
                                            'Di mahad' => 'Di mahad',
                                        ])

                                        ->required()
                                        ->default('Di rumah orangtua')
                                        ->live(),

                                        TextArea::make('ps_kkh_keberadaan_nama_mhd')
                                        ->label('Nama Mahad')
                                        ->required()
                                        ->default('sadads')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkh_keberadaan') !== 'Di mahad'),

                                        TextArea::make('ps_kkh_keberadaan_lokasi_mhd')
                                        ->label('Lokasi Mahad')
                                        ->required()
                                        ->default('sadads')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkh_keberadaan') !== 'Di mahad'),

                                        TextArea::make('ps_kkh_keberadaan_rumah_keg')
                                        ->label('2. Jika dirumah, apa kegiatan ananda selama waktu tersebut?')
                                        ->required()
                                        ->default('asfsadsa'),

                                        Radio::make('ps_kkh_fasilitas_gawai')
                                        ->label('3. Apakah selama di rumah (baik bagi yg dirumah, atau bagi yang di Mahad ketika liburan), ananda difasilitasi HP atau laptop (baik dengan memiliki sendiri HP/ laptop dan yang sejenis atau dipinjami orang tua)?')
                                        ->required()
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live()
                                        ->default('Ya'),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos')
                                        ->label('Apakah ananda memiliki akun medsos (media sosial)?')
                                        ->required()
                                        ->default('Ya')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkh_fasilitas_gawai') !== 'Ya'),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos_daftar')
                                        ->label('Akun medsos apa saja yang ananda miliki?')
                                        ->required()
                                        ->default('asfdads')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkh_fasilitas_gawai') !== 'Ya'),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos_aktif')
                                        ->label('Apakah akun tersebut masih aktif hingga sekarang?')
                                        ->required()
                                        ->default('asdafs')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkh_fasilitas_gawai') !== 'Ya'),

                                        Radio::make('ps_kkh_fasilitas_gawai_medsos_menutup')
                                        ->label('Apakah bersedia menutup akun tersebut selama menjadi santri/santriwati?')
                                        ->required()
                                        ->default('Bersedia')
                                        ->options([
                                                    'Bersedia' => 'Bersedia',
                                                    'Tidak Bersedia' => 'Tidak Bersedia',
                                                ])
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkh_fasilitas_gawai') !== 'Ya'),

                                        CheckboxList::make('ps_kkh_medsos_sering')
                                        ->label('4. Dari medsos berikut, manakah yang sering digunakan ananda?')
                                        ->required()
                                        ->default('Whatsapp')
                                        ->options([
                                                    'Whatsapp' => 'Whatsapp',
                                                    'Twitter/X' => 'Twitter/X',
                                                    'Instagram' => 'Instagram',
                                                    'Lainnya' => 'Lainnya',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkh_medsos_sering_lainnya')
                                        ->label('Akun medsos lainnya')
                                        ->required()
                                        ->default('asdadsads')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkh_medsos_sering') !== 'Lainnya'),

                                        Radio::make('ps_kkh_medsos_group')
                                        ->label('5. Apakah ananda tergabung dalam grup yang ada pada medsos tersebut?')
                                        ->required()
                                        ->default('Ya')
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkh_medsos_group_nama')
                                        ->label('Mohon dijelaskan nama grup dan bidang kegiatannya')
                                        ->required()
                                        ->default('asdadasdads')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkh_medsos_group') !== 'Ya'),

                                        TextArea::make('ps_kkh_bacaan')
                                        ->label('6. Apa saja buku bacaan yang disukai atau sering dibaca ananda?')
                                        ->helperText('Mohon dijelaskan jenis bacaannya')
                                        ->default('asdads')
                                        ->required(),

                                        TextArea::make('ps_kkh_bacaan_cara_dapat')
                                        ->label('Bagaimana cara mendapatkan bacaan tersebut? (Via online atau membeli sendiri)')
                                        ->default('assad')
                                        ->required(),

                        ]),

                    Step::make('KUESIONER KESEHATAN')
                        ->schema([

                                Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                                                        <p><strong>Mohon dijawab dgn kejujuran</strong></p>
                                                                    </div>')),

                                
                                Radio::make('ps_kkes_sakit_serius')
                                        ->label('1. Apakah ananda pernah mengalami sakit yang cukup serius?')
                                        ->required()
                                        ->default('Ya')
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkes_sakit_serius_nama_penyakit')
                                        ->label('Jika iya, kapan dan penyakit apa?')
                                        ->required()
                                        ->default('asdad')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkes_sakit_serius') !== 'Ya'),


                                Radio::make('ps_kkes_terapi')
                                        ->label('2. Apakah ananda pernah atau sedang menjalani terapi kesehatan?')
                                        ->required()
                                        ->default('Ya')
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkes_terapi_nama_terapi')
                                        ->label('Jika iya, kapan dan terapi apa?')
                                        ->required()
                                        ->default('asdasd')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkes_terapi') !== 'Ya'),

                                        Radio::make('ps_kkes_kambuh')
                                        ->label('3. Apakah ananda memiliki penyakit yang dapat/sering kambuh?')
                                        ->required()
                                        ->default('Ya')
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkes_kambuh_nama_penyakit')
                                        ->label('Jika iya, penyakit apa?')
                                        ->required()
                                        ->default('asdad')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkes_kambuh') !== 'Ya'),

                                        Radio::make('ps_kkes_alergi')
                                        ->label('4. Apakah ananda memiliki alergi terhadap perkara-perkara tertentu?')
                                        ->required()
                                        ->default('Ya')
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkes_alergi_nama_alergi')
                                        ->label('Jika iya, sebutkan!')
                                        ->required()
                                        ->default('asdadsd')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkes_alergi') !== 'Ya'),

                                        Radio::make('ps_kkes_pantangan')
                                        ->label('5. Apakah ananda mempunyai pantangan yang berkaitan dengan kesehatan?')
                                        ->required()
                                        ->default('Ya')
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkes_pantangan_nama')
                                        ->label('Jika iya, sebutkan dan jelaskan alasannya!')
                                        ->required()
                                        ->default('asdadssad')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkes_pantangan') !== 'Ya'),

                                        Radio::make('ps_kkes_psikologis')
                                        ->label('6. Apakah ananda pernah mengalami gangguan psikologis (depresi dan gejala-gejalanya)?')
                                        ->required()
                                        ->default('Ya')
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkes_psikologis_kapan')
                                        ->label('Jika iya, kapan?')
                                        ->required()
                                        ->default('asdad')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkes_psikologis') !== 'Ya'),

                                        Radio::make('ps_kkes_gangguan')
                                        ->label('7. Apakah ananda pernah mengalami gangguan jin?')
                                        ->required()
                                        ->default('Ya')
                                        ->options([
                                                    'Ya' => 'Ya',
                                                    'Tidak' => 'Tidak',
                                                ])
                                        ->live(),

                                        TextArea::make('ps_kkes_gangguan_kapan')
                                        ->label('Jika iya, kapan?')
                                        ->required()
                                        ->default('asdadsad')
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kkes_gangguan') !== 'Ya'),

                        ]),

                    Step::make('KUESIONER KEMAMPUAN PEMBAYARAN ADMINISTRASI')
                        ->schema([

                            Placeholder::make('')
                                ->content(new HtmlString('<div>
                                    <table class="table">
                                        <!-- head -->
                                        <thead>
                                            <tr class="border-tsn-header">
                                                <th class="text-lg text-tsn-header" colspan="2">RINCIAN BIAYA AWAL DAN SPP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th>Uang Pendaftaran</th>
                                                <td class="text-end">Rp. 100.000</td>
                                            </tr>
                                            <!-- row 2 -->
                                            <tr>
                                                <th>Uang Gedung</th>
                                                <td class="text-end">Rp. 600.000</td>
                                            </tr>
                                            <!-- row 3 -->
                                            <tr>
                                                <th>Uang Sarpras</th>
                                                <td class="text-end">Rp. 400.000</td>
                                            </tr>
                                            <!-- row 4 -->
                                            <tr class="border-tsn-header">
                                                <th>SPP Awal</th>
                                                <td class="text-end">Rp. 550.000</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="text-end"><strong>Rp. 1.650.000</strong></td>
                                            </tr>
                                            </tbody>
                                    </table>
                                </div>')),

                                Radio::make('ps_kadm_status')
                                        ->label('Status anak didik terkait dengan administrasi')
                                        ->required()
                                        ->default('Santri/Santriwati tidak mampu')
                                        ->options([
                                                    'Santri/Santriwati mampu (tidak ada permasalahan biaya)' => 'Santri/Santriwati mampu (tidak ada permasalahan biaya)',
                                                    'Santri/Santriwati tidak mampu' => 'Santri/Santriwati tidak mampu',
                                                ])
                                        ->live(),

                                        Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                                                        <p><strong>Bersedia memenuhi persyaratan sebagai berikut:</strong></p>
                                                                    </div>'))
                                ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'),

                                Radio::make('ps_kadm_surat_subsidi')
                                        ->label('1. Wali harus membuat surat permohonan subsidi/ keringanan biaya administrasi')
                                        ->required()
                                        ->default('Bersedia')
                                        ->options([
                                                    'Bersedia' => 'Bersedia',
                                                    'Tidak bersedia' => 'Tidak bersedia',
                                                ])
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'),

                                        Radio::make('ps_kadm_surat_kurang_mampu')
                                        ->label('2. Wali harus menyertakan surat keterangan kurang mampu dari ustadz salafy setempat SERTA dari aparat desa setempat, yang isinya menyatakan bhw mmg kluarga tersebut "perlu dibantu"')
                                        ->required()
                                        ->default('Bersedia')
                                        ->options([
                                                    'Bersedia' => 'Bersedia',
                                                    'Tidak bersedia' => 'Tidak bersedia',
                                                ])
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'),

                                        Radio::make('ps_kadm_atur_keuangan')
                                        ->label('3. Keuangan ananda akan dipegang dan diatur oleh Mahad')
                                        ->required()
                                        ->default('Bersedia')
                                        ->options([
                                                    'Bersedia' => 'Bersedia',
                                                    'Tidak bersedia' => 'Tidak bersedia',
                                                ])
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'),

                                        Radio::make('ps_kadm_penentuan_subsidi')
                                        ->label('4. Yang menentukan bentuk keringanan yang diberikan adalah Mahad')
                                        ->required()
                                        ->default('Bersedia')
                                        ->options([
                                                    'Bersedia' => 'Bersedia',
                                                    'Tidak bersedia' => 'Tidak bersedia',
                                                ])
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'),

                                        Radio::make('ps_kadm_hidup_sederhana')
                                        ->label('5. Ananda harus berpola hidup sederhana agar tidak menimbulkan pertanyaan pihak luar')
                                        ->required()
                                        ->default('Bersedia')
                                        ->options([
                                                    'Bersedia' => 'Bersedia',
                                                    'Tidak bersedia' => 'Tidak bersedia',
                                                ])
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'),

                                        Radio::make('ps_kadm_kebijakan_subsidi')
                                        ->label('6. Kebijakan subsidi bisa berubah sewaktu waktu')
                                        ->required()
                                        ->default('Bersedia')
                                        ->options([
                                                    'Bersedia' => 'Bersedia',
                                                    'Tidak bersedia' => 'Tidak bersedia',
                                                ])
                                        ->hidden(
                                            fn (Get $get) =>
                                            $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'),

                        ]),
                ])
                    ->nextAction(
                        fn (Action $action) => $action->label('Lanjut')
                            ->extraAttributes([
                                "class" => "btn bg-tsn-accent text-black focus:bg-tsn-bg",
                            ]),
                    )
                    ->submitAction(new HtmlString('<button class="submit btn bg-tsn-accent">Submit</button>')),

                // Placeholder::make('')
                //     ->content(new HtmlString('<div>
                //                                     </div>')),


            ])
            ->statePath('data')
            ->model(Pendaftar::class);
    }

    public function create(): void
    {
        Pendaftar::create($this->form->getState());

        // $Pendaftar = Pendaftar::create($this->form->getState());

        // $this->form->model($Pendaftar)->saveRelationships();

        session()->flash('status', 'Alhamdulillah, ananda telah terdaftar sebagai calon santri');

        $this->redirect('/tn');
    }



    public function render(): View
    {
        return view('livewire.formdaftartn');
    }
}
