<?php

namespace App\Filament\Resources\PendaftaranResource\RelationManagers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kodepos;
use App\Models\Pendaftar;
use App\Models\Provinsi;
use App\Models\Qism;
use App\Models\QismDetail;
use App\Models\QismDetailHasKelas;
use App\Models\Santri;
use App\Models\Semester;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\StatusSantri;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class SantrisRelationManager extends RelationManager
{
    protected static string $relationship = 'santris';

    protected static bool $isLazy = false;

    protected static ?string $title = 'Daftar Calon Santri';

    use ExposesTableToWidgets;

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                         Section::make('1. CEK NIK')
                            ->schema([
                                Hidden::make('tahap')
                                    ->default('Tahap 1'),

                                Hidden::make('jenispendaftar')
                                    ->default('Baru'),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>1. CEK NIK CALON SANTRI</strong></p>
                                                </div>')),

                                Group::make()
                                    ->relationship('statussantri')
                                    ->schema([
                                        Hidden::make('status')
                                            ->default('Calon'),
                                    ]),

                                Group::make()
                                    ->relationship('kelassantri')
                                    ->schema([
                                        Hidden::make('mahad_id')
                                            ->default(1),

                                        Select::make('qism_id')
                                            ->label('Qism yang dituju')
                                            ->placeholder('Pilih Qism yang dituju')
                                            ->options(Qism::all()->pluck('qism', 'id'))
                                            ->live()
                                            ->required()
                                            ->native(false)
                                            ->afterStateUpdated(function (Get $get, ?string $state, Set $set) {
                                                // dd($get('qism_id'));
                                                if ($get('qism_id') === '5' || $get('qism_id') === '6') {
                                                    $set('tahun_ajaran_id', 6);
                                                    $set('semester_id', 3);
                                                } else {
                                                    $set('tahun_ajaran_id', 7);
                                                    $set('semester_id', 1);
                                                }
                                            }),

                                        Radio::make('qism_detail_id')
                                            ->label('')
                                            ->options(function (Get $get) {

                                                return (QismDetail::where('qism_id', $get('qism_id'))->pluck('qism_detail', 'id'));
                                            })
                                            ->required()
                                            // ->native(false)
                                            ->live(),

                                        Select::make('tahun_ajaran_id')
                                            ->label('Tahun Ajaran')
                                            ->disabled()
                                            ->dehydrated()
                                            ->required()
                                            ->options(TahunAjaran::all()->pluck('ta', 'id'))
                                            ->native(false),

                                        Select::make('semester_id')
                                            ->label('Semester')
                                            ->disabled()
                                            ->dehydrated()
                                            ->required()
                                            ->options(Semester::all()->pluck('semester', 'id'))
                                            ->native(false),

                                        Select::make('kelas_id')
                                            ->label('Kelas yang dituju')
                                            ->placeholder('Pilih Kelas')
                                            ->native(false)
                                            ->options(function (Get $get) {

                                                return (QismDetailHasKelas::where('qism_detail_id', $get('qism_detail_id'))->pluck('kelas', 'id'));
                                            })
                                            ->required(),

                                    ]),


                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                    </div>')),

                                Grid::make()
                                    ->schema([

                                        Select::make('kartu_keluarga_sama')
                                            ->label('Kartu Keluarga sama dengan')
                                            ->required()
                                            ->live()
                                            ->native(false)
                                            ->options(function (RelationManager $livewire) {

                                                $statusayah = $livewire->getOwnerRecord()->ak_status;
                                                $statusibusamaayah = $livewire->getOwnerRecord()->ik_kk_sama_ak;
                                                $statuswali = $livewire->getOwnerRecord()->w_status;

                                                if ($statusayah === 'Masih Hidup' && $statusibusamaayah === 'Ya' && $statuswali === 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ayah Kandung' => 'KK sama dengan Ayah Kandung',
                                                        'KK sama dengan Wali' => 'KK sama dengan Wali',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah !== 'Masih Hidup' && $statusibusamaayah === 'Tidak' && $statuswali === 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ibu Kandung' => 'KK sama dengan Ibu Kandung',
                                                        'KK sama dengan Wali' => 'KK sama dengan Wali',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah !== 'Masih Hidup' && $statusibusamaayah === null && $statuswali === 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Wali' => 'KK sama dengan Wali',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah === 'Masih Hidup' && $statusibusamaayah === 'Tidak' && $statuswali === 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ayah Kandung' => 'KK sama dengan Ayah Kandung',
                                                        'KK sama dengan Ibu Kandung' => 'KK sama dengan Ibu Kandung',
                                                        'KK sama dengan Wali' => 'KK sama dengan Wali',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah === 'Masih Hidup' && $statusibusamaayah === 'Ya' && $statuswali !== 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ayah Kandung' => 'KK sama dengan Ayah Kandung',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah !== 'Masih Hidup' && $statusibusamaayah === 'Tidak' && $statuswali !== 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ibu Kandung' => 'KK sama dengan Ibu Kandung',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah === 'Masih Hidup' && $statusibusamaayah === 'Tidak' && $statuswali !== 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ayah Kandung' => 'KK sama dengan Ayah Kandung',
                                                        'KK sama dengan Ibu Kandung' => 'KK sama dengan Ibu Kandung',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                }
                                            })
                                            ->afterStateUpdated(function (Get $get, RelationManager $livewire, Set $set) {
                                                $akkk = $livewire->getOwnerRecord()->ak_no_kk;

                                                if ($get('kartu_keluarga_sama') === 'KK sama dengan Ayah Kandung') {

                                                    $set('kartu_keluarga', $livewire->getOwnerRecord()->ak_no_kk);
                                                    $set('nama_kpl_kel', $livewire->getOwnerRecord()->ak_kep_kel_kk);
                                                } elseif ($get('kartu_keluarga_sama') === 'KK sama dengan Ibu Kandung') {

                                                    $set('kartu_keluarga', $livewire->getOwnerRecord()->ik_no_kk);
                                                    $set('nama_kpl_kel', $livewire->getOwnerRecord()->ik_kep_kel_kk);
                                                } elseif ($get('kartu_keluarga_sama') === 'KK sama dengan Wali') {

                                                    $set('kartu_keluarga', $livewire->getOwnerRecord()->w_no_kk);
                                                    $set('nama_kpl_kel', $livewire->getOwnerRecord()->w_kep_kel_kk);
                                                } elseif ($get('kartu_keluarga_sama') === 'KK sendiri') {

                                                    $set('kartu_keluarga', null);
                                                    $set('nama_kpl_kel', null);
                                                }
                                            })->columnSpanFull(),

                                        TextInput::make('kartu_keluarga')
                                            ->label('Nomor KK Calon Santri')
                                            ->length(16)
                                            ->required()
                                            // ->disabled(fn (Get $get) =>
                                            // $get('kartu_keluarga_sama') !== 'KK Sendiri')
                                            ->dehydrated(),

                                        TextInput::make('nama_kpl_kel')
                                            ->label('Nama Kepala Keluarga')
                                            ->required()
                                            // ->disabled(fn (Get $get) =>
                                            // $get('kartu_keluarga_sama') !== 'KK Sendiri')
                                            ->dehydrated(),
                                    ]),

                                Select::make('kewarganegaraan')
                                    ->label('Kewarganegaraan Calon Santri')
                                    ->placeholder('Pilih Kewarganegaraan')
                                    ->options([
                                        'WNI' => 'WNI',
                                        'WNA' => 'WNA',
                                    ])
                                    ->required()
                                    ->live()
                                    ->native(false),
                                    // ->default('WNI'),

                                TextInput::make('nik')
                                    ->label('NIK Calon Santri')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->length(16)
                                    ->required()
                                    ->unique(Santri::class, 'nik')
                                    // ->default('3295131306822002')
                                    ->hidden(fn (Get $get) =>
                                    $get('kewarganegaraan') !== 'WNI'),

                                Grid::make(2)
                                    ->schema([

                                        TextInput::make('kitas')
                                            ->label('KITAS Calon Santri')
                                            ->hint('Nomor Izin Tinggal (KITAS)')
                                            ->hintColor('danger')
                                            ->required()
                                            // ->default('3295131306822002')
                                            ->unique(Santri::class, 'kitas')
                                            ->hidden(fn (Get $get) =>
                                            $get('kewarganegaraan') !== 'WNA'),

                                        TextInput::make('asal_negara')
                                            ->label('Asal Negara Calon Santri')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('kewarganegaraan') !== 'WNA'),
                                    ]),

                            ])->collapsible(),
                        // end of step 1

                        Section::make('2. DATA SANTRI')
                            ->schema([
                                //SANTRI
                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                <p class="text-2xl strong"><strong>SANTRI</strong></p>
                                            </div>')),

                                TextInput::make('nama_lengkap')
                                    ->label('Nama Lengkap')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    // ->default('asfasdad')
                                    ->required(),

                                TextInput::make('nama_panggilan')
                                    ->label('Nama Hijroh/Islami')
                                    // ->default('asfasdad')
                                    ->required(),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                            </div>')),

                                Grid::make(4)
                                    ->schema([

                                        Radio::make('jeniskelamin')
                                            ->label('Jenis Kelamin')
                                            ->options([
                                                'Laki-laki' => 'Laki-laki',
                                                'Perempuan' => 'Perempuan',
                                            ])
                                            ->required()
                                            // ->default('Laki-laki')
                                            ->inline(),

                                        TextInput::make('tempat_lahir')
                                            ->label('Tempat Lahir')
                                            ->hint('Isi sesuai dengan KK')
                                            ->hintColor('danger')
                                            // ->default('asfasdad')
                                            ->required(),

                                        DatePicker::make('tanggal_lahir')
                                            ->label('Tanggal Lahir')
                                            ->hint('Isi sesuai dengan KK')
                                            ->hintColor('danger')
                                            // ->default('20010101')
                                            ->required()
                                            ->displayFormat('d M Y')
                                            ->native(false)
                                            ->live()
                                            ->closeOnDateSelection()
                                            ->afterStateUpdated(function (Set $set, $state) {
                                                $set('umur', Carbon::parse($state)->age);
                                            }),

                                        TextInput::make('umur')
                                            ->label('Umur')
                                            ->disabled()
                                            ->dehydrated()
                                            ->required(),

                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(2)
                                    ->schema([

                                        TextInput::make('anak_ke')
                                            ->label('Anak ke-')
                                            ->required()
                                            // ->default('3')
                                            ->rules([
                                                fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {

                                                    $anakke = $get('anak_ke');
                                                    $psjumlahsaudara = $get('jumlah_saudara');
                                                    $jumlahsaudara = $psjumlahsaudara + 1;

                                                    if ($anakke > $jumlahsaudara) {
                                                        $fail("Anak ke tidak bisa lebih dari jumlah saudara + 1");
                                                    }
                                                },
                                            ]),

                                        TextInput::make('jumlah_saudara')
                                            ->label('Jumlah saudara')
                                            // ->default('5')
                                            ->required(),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(1)
                                    ->schema([

                                        TextInput::make('agama')
                                            ->label('Agama')
                                            ->default('Islam')
                                            ->disabled()
                                            ->required()
                                            ->dehydrated(),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(2)
                                    ->schema([

                                        Select::make('cita_cita')
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
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('cita_cita_lainnya')
                                            ->label('Cita-cita Lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('cita_cita') !== 'Lainnya'),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('hobi')
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
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('hobi_lainnya')
                                            ->label('Hobi Lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('hobi') !== 'Lainnya'),

                                    ]),


                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('keb_khus')
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
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('keb_khus_lainnya')
                                            ->label('Kebutuhan Khusus Lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('keb_khus') !== 'Lainnya'),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('keb_dis')
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
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('keb_dis_lainnya')
                                            ->label('Kebutuhan Disabilitas Lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('keb_dis') !== 'Lainnya'),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(1)
                                    ->schema([

                                        Radio::make('tdk_hp')
                                            ->label('Memiliki nomor handphone?')
                                            ->live()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ]),

                                        TextInput::make('nomor_handphone')
                                            ->label('No. Handphone')
                                            ->helperText('Contoh: 82187782223')
                                            // ->mask('82187782223')
                                            ->prefix('62')
                                            ->tel()
                                            // ->default('82187782223')
                                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                            ->required()
                                            ->hidden(fn (Get $get) =>
                                            $get('tdk_hp') !== 'Ya'),

                                        TextInput::make('email')
                                            ->label('Email')
                                            // ->default('mail@mail.com')
                                            ->email(),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('bya_sklh')
                                            ->label('Yang membiayai sekolah')
                                            ->placeholder('Pilih Yang membiayai sekolah')
                                            ->options([
                                                'Orang Tua' => 'Orang Tua',
                                                'Wali/Orang Tua Asuh' => 'Wali/Orang Tua Asuh',
                                                'Tanggungan Sendiri' => 'Tanggungan Sendiri',
                                                'Lainnya' => 'Lainnya',
                                            ])
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('bya_sklh_lainnya')
                                            ->label('Yang membiayai sekolah lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('bya_sklh') !== 'Lainnya'),
                                    ]),

                                Grid::make(2)
                                    ->schema([

                                        Radio::make('belum_nisn')
                                            ->label('Apakah memiliki NISN?')
                                            ->helperText(new HtmlString('<strong>NISN</strong> adalah Nomor Induk Siswa Nasional'))
                                            ->live()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ]),

                                        TextInput::make('nisn')
                                            ->label('Nomor NISN')
                                            ->required()
                                            // ->default('2421324')
                                            ->hidden(fn (Get $get) =>
                                            $get('belum_nisn') !== 'Ya'),
                                    ]),

                                Grid::make(2)
                                    ->schema([

                                        Radio::make('nomor_kip_memiliki')
                                            ->label('Apakah memiliki KIP?')
                                            ->helperText(new HtmlString('<strong>KIP</strong> adalah Kartu Indonesia Pintar'))
                                            ->live()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ]),

                                        TextInput::make('nomor_kip')
                                            ->label('Nomor KIP')
                                            ->required()
                                            // ->default('32524324')
                                            ->hidden(fn (Get $get) =>
                                            $get('nomor_kip_memiliki') !== 'Ya'),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                TextInput::make('aktivitaspend')
                                    ->label('Aktivitas Pendidikan yang Diikuti')
                                    ->placeholder('Pilih Aktivitas Pendidikan yang Diikuti')
                                    // ->default('PKPPS')
                                    ->hidden()
                                    ->dehydrated(),

                                Group::make()
                                    ->relationship('pendaftar')
                                    ->schema([

                                        Grid::make(2)
                                            ->schema([

                                                Select::make('ps_mendaftar_keinginan')
                                                    ->label('Mendaftar atas kenginginan')
                                                    ->options([
                                                        'Orangtua' => 'Orangtua',
                                                        'Ananda' => 'Ananda',
                                                        'Lainnya' => 'Lainnya',
                                                    ])
                                                    ->required()
                                                    ->live()
                                                    // ->default('Lainnya')
                                                    ->native(false),

                                                TextInput::make('ps_mendaftar_keinginan_lainnya')
                                                    ->label('Lainnya')
                                                    ->required()
                                                    // ->default('asdasf')
                                                    ->hidden(fn (Get $get) =>
                                                    $get('ps_mendaftar_keinginan') !== 'Lainnya'),
                                            ]),

                                        Placeholder::make('')
                                            ->content(new HtmlString('<div class="border-b"></div>')),

                                        Textarea::make('ps_peng_pend_agama')
                                            ->label('Pengalaman pendidikan agama')
                                            ->required(),
                                            // ->default('asdasf'),

                                        Textarea::make('ps_peng_pend_formal')
                                            ->label('Pengalaman pendidikan formal')
                                            ->required(),
                                            // ->default('asdasf'),

                                        TextInput::make('ps_hafalan')
                                            ->label('Hafalan')
                                            ->length('2')
                                            ->suffix('juz')
                                            ->required(),
                                            // ->default('10'),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                // ALAMAT SANTRI
                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                <p class="text-lg strong"><strong>TEMPAT TINGGAL DOMISILI</strong></p>
                                                <p class="text-lg strong"><strong>SANTRI</strong></p>
                                            </div>')),

                                Radio::make('al_s_status_mukim')
                                    ->label('Apakah mukim di Pondok?')
                                    ->helperText(new HtmlString('Pilih <strong>Tidak Mukim</strong> khusus bagi pendaftar <strong>Tarbiyatul Aulaad</strong> dan <strong>Pra Tahfidz kelas 1-4</strong>'))
                                    ->live()
                                    // ->default('Tidak Mukim')
                                    ->options([
                                        'Mukim' => 'Mukim',
                                        'Tidak Mukim' => 'Tidak Mukim',
                                    ])
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        if ($get('al_s_status_mukim') === 'Mukim') {

                                            $set('al_s_stts_tptgl', 'Tinggal di Asrama Pesantren');
                                        } elseif ($get('al_s_status_mukim') === 'Tidak Mukim') {

                                            $set('al_s_stts_tptgl', null);
                                        }
                                    }),

                                Select::make('al_s_stts_tptgl')
                                    ->label('Status tempat tinggal')
                                    ->placeholder('Status tempat tinggal')
                                    ->options(function (Get $get) {
                                        if ($get('al_s_status_mukim') === 'Tidak Mukim') {
                                            return ([
                                                'Tinggal dengan Ayah Kandung' => 'Tinggal dengan Ayah Kandung',
                                                'Tinggal dengan Ibu Kandung' => 'Tinggal dengan Ibu Kandung',
                                                'Tinggal dengan Wali' => 'Tinggal dengan Wali',
                                                'Ikut Saudara/Kerabat' => 'Ikut Saudara/Kerabat',
                                                'Kontrak/Kost' => 'Kontrak/Kost',
                                                'Tinggal di Asrama Bukan Milik Pesantren' => 'Tinggal di Asrama Bukan Milik Pesantren',
                                                'Panti Asuhan' => 'Panti Asuhan',
                                                'Rumah Singgah' => 'Rumah Singgah',
                                                'Lainnya' => 'Lainnya',
                                            ]);
                                        } elseif ($get('al_s_status_mukim') === 'Mukim') {
                                            return ([
                                                'Tinggal di Asrama Pesantren' => 'Tinggal di Asrama Pesantren'
                                            ]);
                                        }
                                    })
                                    // ->searchable()
                                    ->required()
                                    // ->default('Kontrak/Kost')
                                    ->disabled(fn (Get $get) =>
                                    $get('al_s_status_mukim') === 'Mukim')
                                    ->live()
                                    ->native(false)
                                    ->dehydrated(),

                                Grid::make(2)
                                    ->schema([

                                        Select::make('al_s_provinsi_id')
                                            ->label('Provinsi')
                                            ->placeholder('Pilih Provinsi')
                                            ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                            ->searchable()
                                            // ->default('35')
                                            ->required()
                                            ->live()
                                            ->native(false)
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            )
                                            ->afterStateUpdated(function (Set $set) {
                                                $set('al_s_kabupaten_id', null);
                                                $set('al_s_kecamatan_id', null);
                                                $set('al_s_kelurahan_id', null);
                                                $set('al_s_kodepos', null);
                                            }),

                                        Select::make('al_s_kabupaten_id')
                                            ->label('Kabupaten')
                                            ->placeholder('Pilih Kabupaten')
                                            ->options(fn (Get $get): Collection => Kabupaten::query()
                                                ->where('provinsi_id', $get('al_s_provinsi_id'))
                                                ->pluck('kabupaten', 'id'))
                                            ->searchable()
                                            ->required()
                                            // ->default('232')
                                            ->live()
                                            ->native(false)
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        Select::make('al_s_kecamatan_id')
                                            ->label('Kecamatan')
                                            ->placeholder('Pilih Kecamatan')
                                            ->options(fn (Get $get): Collection => Kecamatan::query()
                                                ->where('kabupaten_id', $get('al_s_kabupaten_id'))
                                                ->pluck('kecamatan', 'id'))
                                            ->searchable()
                                            ->required()
                                            // ->default('3617')
                                            ->live()
                                            ->native(false)
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        Select::make('al_s_kelurahan_id')
                                            ->label('Kelurahan')
                                            ->placeholder('Pilih Kelurahan')
                                            ->options(fn (Get $get): Collection => Kelurahan::query()
                                                ->where('kecamatan_id', $get('al_s_kecamatan_id'))
                                                ->pluck('kelurahan', 'id'))
                                            ->searchable()
                                            ->required()
                                            // ->default('45322')
                                            ->live()
                                            ->native(false)
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            )
                                            ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                                $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                                $state = $kodepos;

                                                foreach ($state as $state) {
                                                    $set('al_s_kodepos', Str::substr($state, 12, 5));
                                                }
                                            }),


                                        TextInput::make('al_s_rt')
                                            ->label('RT')
                                            ->required()
                                            // ->default('2')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        TextInput::make('al_s_rw')
                                            ->label('RW')
                                            ->required()
                                            // ->default('2')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        Textarea::make('al_s_alamat')
                                            ->label('Alamat')
                                            ->required()
                                            ->columnSpanFull()
                                            // ->default('sdfsdasdada')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        TextInput::make('al_s_kodepos')
                                            ->label('Kodepos')
                                            ->disabled()
                                            ->required()
                                            ->dehydrated()
                                            // ->default('63264')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),


                                        Grid::make(3)
                                            ->schema([
                                                Select::make('al_s_jarak')
                                                    ->label('Jarak tempat tinggal ke Pondok Pesantren')
                                                    ->options([
                                                        'Kurang dari 5 km' => 'Kurang dari 5 km',
                                                        'Antara 5 - 10 Km' => 'Antara 5 - 10 Km',
                                                        'Antara 11 - 20 Km' => 'Antara 11 - 20 Km',
                                                        'Antara 21 - 30 Km' => 'Antara 21 - 30 Km',
                                                        'Lebih dari 30 Km' => 'Lebih dari 30 Km',
                                                    ])
                                                    // ->searchable()
                                                    ->required()
                                                    // ->default('Kurang dari 5 km')
                                                    ->live()
                                                    ->native(false)
                                                    ->hidden(
                                                        fn (Get $get) =>
                                                        $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                            $get('al_s_stts_tptgl') === null
                                                    ),

                                                Select::make('al_s_transportasi')
                                                    ->label('Transportasi ke Pondok Pesantren')
                                                    ->options([
                                                        'Jalan kaki' => 'Jalan kaki',
                                                        'Sepeda' => 'Sepeda',
                                                        'Sepeda Motor' => 'Sepeda Motor',
                                                        'Mobil Pribadi' => 'Mobil Pribadi',
                                                        'Antar Jemput Sekolah' => 'Antar Jemput Sekolah',
                                                        'Angkutan Umum' => 'Angkutan Umum',
                                                        'Perahu/Sampan' => 'Perahu/Sampan',
                                                        'Lainnya' => 'Lainnya',
                                                        'Kendaraan Pribadi' => 'Kendaraan Pribadi',
                                                        'Kereta Api' => 'Kereta Api',
                                                        'Ojek' => 'Ojek',
                                                        'Andong/Bendi/Sado/Dokar/Delman/Becak' => 'Andong/Bendi/Sado/Dokar/Delman/Becak',
                                                    ])
                                                    // ->searchable()
                                                    ->required()
                                                    // ->default('Ojek')
                                                    ->live()
                                                    ->native(false)
                                                    ->hidden(
                                                        fn (Get $get) =>
                                                        $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                            $get('al_s_stts_tptgl') === null
                                                    ),

                                                Select::make('al_s_waktu_tempuh')
                                                    ->label('Waktu tempuh ke Pondok Pesantren')
                                                    ->options([
                                                        '1 - 10 menit' => '1 - 10 menit',
                                                        '10 - 19 menit' => '10 - 19 menit',
                                                        '20 - 29 menit' => '20 - 29 menit',
                                                        '30 - 39 menit' => '30 - 39 menit',
                                                        '1 - 2 jam' => '1 - 2 jam',
                                                        '> 2 jam' => '> 2 jam',
                                                    ])
                                                    // ->searchable()
                                                    ->required()
                                                    // ->default('10 - 19 menit')
                                                    ->live()
                                                    ->native(false)
                                                    ->hidden(
                                                        fn (Get $get) =>
                                                        $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                            $get('al_s_stts_tptgl') === null
                                                    ),

                                                TextInput::make('al_s_koordinat')
                                                    ->label('Titik koordinat tempat tinggal')
                                                    // ->default('sfasdadasdads')
                                                    ->hidden(
                                                        fn (Get $get) =>
                                                        $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                            $get('al_s_stts_tptgl') === null
                                                    )->columnSpanFull(),
                                            ]),
                                    ]),
                            ])->collapsible(),
                        // end of step 2

                        Section::make('3. KUESIONER KEGIATAN HARIAN')
                            ->schema([

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>KUESIONER KEGIATAN HARIAN</strong></p>
                                                </div>')),
                                Group::make()
                                    ->relationship('pendaftar')
                                    ->schema([
                                        Radio::make('ps_kkh_keberadaan')
                                            ->label('1. Di mana saat ini ananda berada?')
                                            ->options([
                                                'Di rumah orangtua' => 'Di rumah orangtua',
                                                'Di mahad' => 'Di mahad',
                                            ])
                                            ->required()
                                            // ->default('Di rumah orangtua')
                                            ->live(),

                                        TextArea::make('ps_kkh_keberadaan_nama_mhd')
                                            ->label('Nama Mahad')
                                            ->required()
                                            // ->default('sadads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_keberadaan') !== 'Di mahad'
                                            ),

                                        TextArea::make('ps_kkh_keberadaan_lokasi_mhd')
                                            ->label('Lokasi Mahad')
                                            ->required()
                                            // ->default('sadads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_keberadaan') !== 'Di mahad'
                                            ),

                                        TextArea::make('ps_kkh_keberadaan_rumah_keg')
                                            ->label('2. Jika dirumah, apa kegiatan ananda selama waktu tersebut?')
                                            ->required(),
                                            // ->default('asfsadsa'),

                                        Radio::make('ps_kkh_fasilitas_gawai')
                                            ->label('3. Apakah selama di rumah (baik bagi yg dirumah, atau bagi yang di Mahad ketika liburan), ananda difasilitasi HP atau laptop (baik dengan memiliki sendiri HP/ laptop dan yang sejenis atau dipinjami orang tua)?')
                                            ->required()
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),
                                            // ->default('Ya'),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos')
                                            ->label('Apakah ananda memiliki akun medsos (media sosial)?')
                                            ->required()
                                            // ->default('Ya')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_fasilitas_gawai') !== 'Ya'
                                            ),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos_daftar')
                                            ->label('Akun medsos apa saja yang ananda miliki?')
                                            ->required()
                                            // ->default('asfdads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_fasilitas_gawai') !== 'Ya'
                                            ),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos_aktif')
                                            ->label('Apakah akun tersebut masih aktif hingga sekarang?')
                                            ->required()
                                            // ->default('asdafs')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_fasilitas_gawai') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkh_fasilitas_gawai_medsos_menutup')
                                            ->label('Apakah bersedia menutup akun tersebut selama menjadi santri/santriwati?')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak Bersedia' => 'Tidak Bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_fasilitas_gawai') !== 'Ya'
                                            ),

                                        CheckboxList::make('ps_kkh_medsos_sering')
                                            ->label('4. Dari medsos berikut, manakah yang sering digunakan ananda?')
                                            ->required()
                                            // ->default('Whatsapp')
                                            ->options([
                                                'Whatsapp' => 'Whatsapp',
                                                'Twitter/X' => 'Twitter/X',
                                                'Instagram' => 'Instagram',
                                                'Lainnya' => 'Lainnya',
                                            ]),

                                        TextArea::make('ps_kkh_medsos_sering_lainnya')
                                            ->label('Akun medsos lainnya')
                                            ->required()
                                            // ->default('asdadsads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_medsos_sering') !== 'Lainnya'
                                            ),

                                        Radio::make('ps_kkh_medsos_group')
                                            ->label('5. Apakah ananda tergabung dalam grup yang ada pada medsos tersebut?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkh_medsos_group_nama')
                                            ->label('Mohon dijelaskan nama grup dan bidang kegiatannya')
                                            ->required()
                                            // ->default('asdadasdads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_medsos_group') !== 'Ya'
                                            ),

                                        TextArea::make('ps_kkh_bacaan')
                                            ->label('6. Apa saja buku bacaan yang disukai atau sering dibaca ananda?')
                                            ->helperText('Mohon dijelaskan jenis bacaannya')
                                            // ->default('asdads')
                                            ->required(),

                                        TextArea::make('ps_kkh_bacaan_cara_dapat')
                                            ->label('Bagaimana cara mendapatkan bacaan tersebut? (Via online atau membeli sendiri)')
                                            // ->default('assad')
                                            ->required(),

                                    ]),
                            ])->collapsible(),
                        // end of step 3

                        Section::make('4. KUESIONER KESEHATAN')
                            ->schema([

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>KUESIONER KESEHATAN</strong></p>
                                                </div>')),
                                Group::make()
                                    ->relationship('pendaftar')
                                    ->schema([
                                        Radio::make('ps_kkes_sakit_serius')
                                            ->label('1. Apakah ananda pernah mengalami sakit yang cukup serius?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_sakit_serius_nama_penyakit')
                                            ->label('Jika iya, kapan dan penyakit apa?')
                                            ->required()
                                            // ->default('asdad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_sakit_serius') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_terapi')
                                            ->label('2. Apakah ananda pernah atau sedang menjalani terapi kesehatan?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_terapi_nama_terapi')
                                            ->label('Jika iya, kapan dan terapi apa?')
                                            ->required()
                                            // ->default('asdasd')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_terapi') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_kambuh')
                                            ->label('3. Apakah ananda memiliki penyakit yang dapat/sering kambuh?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_kambuh_nama_penyakit')
                                            ->label('Jika iya, penyakit apa?')
                                            ->required()
                                            // ->default('asdad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_kambuh') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_alergi')
                                            ->label('4. Apakah ananda memiliki alergi terhadap perkara-perkara tertentu?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_alergi_nama_alergi')
                                            ->label('Jika iya, sebutkan!')
                                            ->required()
                                            // ->default('asdadsd')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_alergi') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_pantangan')
                                            ->label('5. Apakah ananda mempunyai pantangan yang berkaitan dengan kesehatan?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_pantangan_nama')
                                            ->label('Jika iya, sebutkan dan jelaskan alasannya!')
                                            ->required()
                                            // ->default('asdadssad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_pantangan') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_psikologis')
                                            ->label('6. Apakah ananda pernah mengalami gangguan psikologis (depresi dan gejala-gejalanya)?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_psikologis_kapan')
                                            ->label('Jika iya, kapan?')
                                            ->required()
                                            // ->default('asdad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_psikologis') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_gangguan')
                                            ->label('7. Apakah ananda pernah mengalami gangguan jin?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_gangguan_kapan')
                                            ->label('Jika iya, kapan?')
                                            ->required()
                                            // ->default('asdadsad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_gangguan') !== 'Ya'
                                            ),

                                    ]),
                            ])->collapsible(),
                        // end of step 4

                        Section::make('5. KUESIONER KEMAMPUAN PEMBAYARAN ADMINISTRASI')
                            ->schema([

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>KUESIONER KEMAMPUAN PEMBAYARAN ADMINISTRASI</strong></p>
                                                </div>')),
                                Group::make()
                                    ->relationship('pendaftar')
                                    ->schema([
                                        Placeholder::make('')
                                            ->content(new HtmlString('<div class="grid grid-cols-1 justify-center">
                                            <div class="border rounded-xl p-4">
                                            <table>
                                                <!-- head -->
                                                <thead>
                                                    <tr class="border-b">
                                                        <th class="text-lg text-tsn-header" colspan="4">RINCIAN BIAYA AWAL DAN SPP (menginap)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th class="text-start">Uang Pendaftaran     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">100.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 2 -->
                                            <tr>
                                                <th class="text-start">Uang Gedung      </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">300.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 3 -->
                                            <tr>
                                                <th class="text-start">Uang Sarpras     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">200.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 4 -->
                                            <tr class="border-tsn-header">
                                                <th class="text-start">SPP*     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">550.000</td>
                                                <td class="text-end">(per bulan)</td>
                                            </tr>
                                            <tr class="border-t">
                                                <th>Total       </th>
                                                <td class="text-end"><strong>Rp.</strong></td>
                                                <td class="text-end"><strong>1.150.000</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-sm" colspan="4">*Pembayaran administrasi awal termasuk SPP bulan pertama</td>
                                            </tr>
                                            </tbody>
                                                </table>
                                            </div>

                                            <br>

                                            <div class="border rounded-xl p-4">
                                            <table>
                                                <!-- head -->
                                                <thead>
                                                    <tr class="border-b">
                                                        <th class="text-lg text-tsn-header" colspan="4">RINCIAN BIAYA AWAL DAN SPP (fullday tanpa makan)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th class="text-start">Uang Pendaftaran     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">100.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 2 -->
                                            <tr>
                                                <th class="text-start">Uang Gedung      </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">300.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 3 -->
                                            <tr>
                                                <th class="text-start">Uang Sarpras     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">200.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 4 -->
                                            <tr class="border-tsn-header">
                                                <th class="text-start">SPP*     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">200.000</td>
                                                <td class="text-end">(per bulan)</td>
                                            </tr>
                                            <tr class="border-t">
                                                <th>Total       </th>
                                                <td class="text-end"><strong>Rp.</strong></td>
                                                <td class="text-end"><strong>800.000</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-sm" colspan="4">*Pembayaran administrasi awal termasuk SPP bulan pertama</td>
                                            </tr>
                                            </tbody>
                                                </table>
                                            </div>

                                            <br>

                                            <div class="border rounded-xl p-4">
                                            <table>
                                                <!-- head -->
                                                <thead>
                                                    <tr class="border-b">
                                                        <th class="text-lg text-tsn-header" colspan="4">RINCIAN BIAYA AWAL DAN SPP (fullday dengan makan)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th class="text-start">Uang Pendaftaran     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">100.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 2 -->
                                            <tr>
                                                <th class="text-start">Uang Gedung      </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">300.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 3 -->
                                            <tr>
                                                <th class="text-start">Uang Sarpras     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">200.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 4 -->
                                            <tr class="border-tsn-header">
                                                <th class="text-start">SPP*     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">300.000</td>
                                                <td class="text-end">(per bulan)</td>
                                            </tr>
                                            <tr class="border-t">
                                                <th>Total       </th>
                                                <td class="text-end"><strong>Rp.</strong></td>
                                                <td class="text-end"><strong>900.000</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-sm" colspan="4">*Pembayaran administrasi awal termasuk SPP bulan pertama</td>
                                            </tr>
                                            </tbody>
                                                </table>
                                            </div>
                                            </div>')),

                                        Radio::make('ps_kadm_status')
                                            ->label('Status anak didik terkait dengan administrasi')
                                            ->required()
                                            // ->default('Santri/Santriwati tidak mampu')
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
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_surat_subsidi')
                                            ->label('1. Wali harus membuat surat permohonan subsidi/ keringanan biaya administrasi')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_surat_kurang_mampu')
                                            ->label('2. Wali harus menyertakan surat keterangan kurang mampu dari ustadz salafy setempat SERTA dari aparat pemerintah setempat, yang isinya menyatakan bhw mmg kluarga tersebut "perlu dibantu"')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_atur_keuangan')
                                            ->label('3. Keuangan ananda akan dipegang dan diatur oleh Mahad')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_penentuan_subsidi')
                                            ->label('4. Yang menentukan bentuk keringanan yang diberikan adalah Mahad')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_hidup_sederhana')
                                            ->label('5. Ananda harus berpola hidup sederhana agar tidak menimbulkan pertanyaan pihak luar')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_kebijakan_subsidi')
                                            ->label('6. Kebijakan subsidi bisa berubah sewaktu waktu')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),
                                    ]),
                            ])->collapsible(),
                        // end of step 5

                ]);
                // end of schema
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Daftar Calon Santri')
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('statussantri', function ($query) {
                $query->where('status', 'calon');
            }))
            ->recordTitleAttribute('Calon Santri')
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah calon santri')
                    ->modalHeading('Tambah calon santri')
                    ->modalDescription(new HtmlString('<div class="">
                                                            <p>Butuh bantuan?</p>
                                                            <p>Silakan mengubungi admin di bawah ini:</p>

                                                            <table class="table w-fit">
                                        <!-- head -->
                                        <thead>
                                            <tr class="border-tsn-header">
                                                <th class="text-tsn-header text-xs" colspan="2"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th><a href="https://wa.me/6282210862400"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                                </svg>
                                                </a></th>
                                                <td class="text-xs"><a href="https://wa.me/6282210862400">WA Admin Putra (Abu Hammaam)</a></td>
                                            </tr>
                                            <tr>
                                                <th><a href="https://wa.me/6285236459012"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                                </svg>
                                                </a></th>
                                                <td class="text-xs"><a href="https://wa.me/6285236459012">WA Admin Putra (Abu Fathimah Hendi)</a></td>
                                            </tr>
                                            <tr>
                                                <th><a href="https://wa.me/6281333838691"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                                </svg>
                                                </a></th>
                                                <td class="text-xs"><a href="https://wa.me/6281333838691">WA Admin Putra (Akh Irfan)</a></td>
                                            </tr>
                                            <tr>
                                                <th><a href="https://wa.me/628175765767"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                                                </svg>
                                                </a></th>
                                                <td class="text-xs"><a href="https://wa.me/628175765767">WA Admin Putri</a></td>
                                            </tr>


                                        </tbody>
                                        </table>

                                                        </div>'))
                    ->modalWidth('full')
                    ->stickyModalHeader()
                    ->steps([

                        Step::make('1. CEK NIK')
                            ->schema([
                                Hidden::make('tahap')
                                    ->default('Tahap 1'),

                                Hidden::make('jenispendaftar')
                                    ->default('Baru'),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>1. CEK NIK CALON SANTRI</strong></p>
                                                </div>')),

                                Group::make()
                                    ->relationship('statussantri')
                                    ->schema([
                                        Hidden::make('status')
                                            ->default('Calon'),
                                    ]),

                                Group::make()
                                    ->relationship('kelassantri')
                                    ->schema([
                                        Hidden::make('mahad_id')
                                            ->default(1),

                                        Select::make('qism_id')
                                            ->label('Qism yang dituju')
                                            ->placeholder('Pilih Qism yang dituju')
                                            ->options(Qism::all()->pluck('qism', 'id'))
                                            ->live()
                                            ->required()
                                            ->native(false)
                                            ->afterStateUpdated(function (Get $get, ?string $state, Set $set) {
                                                // dd($get('qism_id'));
                                                if ($get('qism_id') === '5' || $get('qism_id') === '6') {
                                                    $set('tahun_ajaran_id', 6);
                                                    $set('semester_id', 3);
                                                } else {
                                                    $set('tahun_ajaran_id', 7);
                                                    $set('semester_id', 1);
                                                }
                                            }),

                                        Radio::make('qism_detail_id')
                                            ->label('')
                                            ->options(function (Get $get) {

                                                return (QismDetail::where('qism_id', $get('qism_id'))->pluck('qism_detail', 'id'));
                                            })
                                            ->required()
                                            // ->native(false)
                                            ->live(),

                                        Select::make('tahun_ajaran_id')
                                            ->label('Tahun Ajaran')
                                            ->disabled()
                                            ->dehydrated()
                                            ->required()
                                            ->options(TahunAjaran::all()->pluck('ta', 'id'))
                                            ->native(false),

                                        Select::make('semester_id')
                                            ->label('Semester')
                                            ->disabled()
                                            ->dehydrated()
                                            ->required()
                                            ->options(Semester::all()->pluck('semester', 'id'))
                                            ->native(false),

                                        Select::make('kelas_id')
                                            ->label('Kelas yang dituju')
                                            ->placeholder('Pilih Kelas')
                                            ->native(false)
                                            ->options(function (Get $get) {

                                                return (QismDetailHasKelas::where('qism_detail_id', $get('qism_detail_id'))->pluck('kelas', 'id'));
                                            })
                                            ->required(),

                                    ]),


                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                    </div>')),

                                Grid::make()
                                    ->schema([

                                        Select::make('kartu_keluarga_sama')
                                            ->label('Kartu Keluarga sama dengan')
                                            ->required()
                                            ->live()
                                            ->native(false)
                                            ->options(function (RelationManager $livewire) {

                                                $statusayah = $livewire->getOwnerRecord()->ak_status;
                                                $statusibusamaayah = $livewire->getOwnerRecord()->ik_kk_sama_ak;
                                                $statuswali = $livewire->getOwnerRecord()->w_status;

                                                if ($statusayah === 'Masih Hidup' && $statusibusamaayah === 'Ya' && $statuswali === 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ayah Kandung' => 'KK sama dengan Ayah Kandung',
                                                        'KK sama dengan Wali' => 'KK sama dengan Wali',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah !== 'Masih Hidup' && $statusibusamaayah === 'Tidak' && $statuswali === 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ibu Kandung' => 'KK sama dengan Ibu Kandung',
                                                        'KK sama dengan Wali' => 'KK sama dengan Wali',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah !== 'Masih Hidup' && $statusibusamaayah === null && $statuswali === 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Wali' => 'KK sama dengan Wali',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah === 'Masih Hidup' && $statusibusamaayah === 'Tidak' && $statuswali === 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ayah Kandung' => 'KK sama dengan Ayah Kandung',
                                                        'KK sama dengan Ibu Kandung' => 'KK sama dengan Ibu Kandung',
                                                        'KK sama dengan Wali' => 'KK sama dengan Wali',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah === 'Masih Hidup' && $statusibusamaayah === 'Ya' && $statuswali !== 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ayah Kandung' => 'KK sama dengan Ayah Kandung',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah !== 'Masih Hidup' && $statusibusamaayah === 'Tidak' && $statuswali !== 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ibu Kandung' => 'KK sama dengan Ibu Kandung',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                } elseif ($statusayah === 'Masih Hidup' && $statusibusamaayah === 'Tidak' && $statuswali !== 'Lainnya') {

                                                    return ([
                                                        'KK sama dengan Ayah Kandung' => 'KK sama dengan Ayah Kandung',
                                                        'KK sama dengan Ibu Kandung' => 'KK sama dengan Ibu Kandung',
                                                        'KK sendiri' => 'KK sendiri',
                                                    ]);
                                                }
                                            })
                                            ->afterStateUpdated(function (Get $get, RelationManager $livewire, Set $set) {
                                                $akkk = $livewire->getOwnerRecord()->ak_no_kk;

                                                if ($get('kartu_keluarga_sama') === 'KK sama dengan Ayah Kandung') {

                                                    $set('kartu_keluarga', $livewire->getOwnerRecord()->ak_no_kk);
                                                    $set('nama_kpl_kel', $livewire->getOwnerRecord()->ak_kep_kel_kk);
                                                } elseif ($get('kartu_keluarga_sama') === 'KK sama dengan Ibu Kandung') {

                                                    $set('kartu_keluarga', $livewire->getOwnerRecord()->ik_no_kk);
                                                    $set('nama_kpl_kel', $livewire->getOwnerRecord()->ik_kep_kel_kk);
                                                } elseif ($get('kartu_keluarga_sama') === 'KK sama dengan Wali') {

                                                    $set('kartu_keluarga', $livewire->getOwnerRecord()->w_no_kk);
                                                    $set('nama_kpl_kel', $livewire->getOwnerRecord()->w_kep_kel_kk);
                                                } elseif ($get('kartu_keluarga_sama') === 'KK sendiri') {

                                                    $set('kartu_keluarga', null);
                                                    $set('nama_kpl_kel', null);
                                                }
                                            })->columnSpanFull(),

                                        TextInput::make('kartu_keluarga')
                                            ->label('Nomor KK Calon Santri')
                                            ->length(16)
                                            ->required()
                                            // ->disabled(fn (Get $get) =>
                                            // $get('kartu_keluarga_sama') !== 'KK Sendiri')
                                            ->dehydrated(),

                                        TextInput::make('nama_kpl_kel')
                                            ->label('Nama Kepala Keluarga')
                                            ->required()
                                            // ->disabled(fn (Get $get) =>
                                            // $get('kartu_keluarga_sama') !== 'KK Sendiri')
                                            ->dehydrated(),
                                    ]),

                                Select::make('kewarganegaraan')
                                    ->label('Kewarganegaraan Calon Santri')
                                    ->placeholder('Pilih Kewarganegaraan')
                                    ->options([
                                        'WNI' => 'WNI',
                                        'WNA' => 'WNA',
                                    ])
                                    ->required()
                                    ->live()
                                    ->native(false),
                                    // ->default('WNI'),

                                TextInput::make('nik')
                                    ->label('NIK Calon Santri')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->length(16)
                                    ->required()
                                    ->unique(Santri::class, 'nik')
                                    // ->default('3295131306822002')
                                    ->hidden(fn (Get $get) =>
                                    $get('kewarganegaraan') !== 'WNI'),

                                Grid::make(2)
                                    ->schema([

                                        TextInput::make('kitas')
                                            ->label('KITAS Calon Santri')
                                            ->hint('Nomor Izin Tinggal (KITAS)')
                                            ->hintColor('danger')
                                            ->required()
                                            // ->default('3295131306822002')
                                            ->unique(Santri::class, 'kitas')
                                            ->hidden(fn (Get $get) =>
                                            $get('kewarganegaraan') !== 'WNA'),

                                        TextInput::make('asal_negara')
                                            ->label('Asal Negara Calon Santri')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('kewarganegaraan') !== 'WNA'),
                                    ]),

                            ]),
                        // end of step 1

                        Step::make('2. DATA SANTRI')
                            ->schema([
                                //SANTRI
                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                <p class="text-2xl strong"><strong>SANTRI</strong></p>
                                            </div>')),

                                TextInput::make('nama_lengkap')
                                    ->label('Nama Lengkap')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    // ->default('asfasdad')
                                    ->required(),

                                TextInput::make('nama_panggilan')
                                    ->label('Nama Hijroh/Islami')
                                    // ->default('asfasdad')
                                    ->required(),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                            </div>')),

                                Grid::make(4)
                                    ->schema([

                                        Radio::make('jeniskelamin')
                                            ->label('Jenis Kelamin')
                                            ->options([
                                                'Laki-laki' => 'Laki-laki',
                                                'Perempuan' => 'Perempuan',
                                            ])
                                            ->required()
                                            // ->default('Laki-laki')
                                            ->inline(),

                                        TextInput::make('tempat_lahir')
                                            ->label('Tempat Lahir')
                                            ->hint('Isi sesuai dengan KK')
                                            ->hintColor('danger')
                                            // ->default('asfasdad')
                                            ->required(),

                                        DatePicker::make('tanggal_lahir')
                                            ->label('Tanggal Lahir')
                                            ->hint('Isi sesuai dengan KK')
                                            ->hintColor('danger')
                                            // ->default('20010101')
                                            ->required()
                                            ->displayFormat('d M Y')
                                            ->native(false)
                                            ->live()
                                            ->closeOnDateSelection()
                                            ->afterStateUpdated(function (Set $set, $state) {
                                                $set('umur', Carbon::parse($state)->age);
                                            }),

                                        TextInput::make('umur')
                                            ->label('Umur')
                                            ->disabled()
                                            ->dehydrated()
                                            ->required(),

                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(2)
                                    ->schema([

                                        TextInput::make('anak_ke')
                                            ->label('Anak ke-')
                                            ->required()
                                            // ->default('3')
                                            ->rules([
                                                fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {

                                                    $anakke = $get('anak_ke');
                                                    $psjumlahsaudara = $get('jumlah_saudara');
                                                    $jumlahsaudara = $psjumlahsaudara + 1;

                                                    if ($anakke > $jumlahsaudara) {
                                                        $fail("Anak ke tidak bisa lebih dari jumlah saudara + 1");
                                                    }
                                                },
                                            ]),

                                        TextInput::make('jumlah_saudara')
                                            ->label('Jumlah saudara')
                                            // ->default('5')
                                            ->required(),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(1)
                                    ->schema([

                                        TextInput::make('agama')
                                            ->label('Agama')
                                            ->default('Islam')
                                            ->disabled()
                                            ->required()
                                            ->dehydrated(),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(2)
                                    ->schema([

                                        Select::make('cita_cita')
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
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('cita_cita_lainnya')
                                            ->label('Cita-cita Lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('cita_cita') !== 'Lainnya'),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('hobi')
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
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('hobi_lainnya')
                                            ->label('Hobi Lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('hobi') !== 'Lainnya'),

                                    ]),


                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('keb_khus')
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
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('keb_khus_lainnya')
                                            ->label('Kebutuhan Khusus Lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('keb_khus') !== 'Lainnya'),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('keb_dis')
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
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('keb_dis_lainnya')
                                            ->label('Kebutuhan Disabilitas Lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('keb_dis') !== 'Lainnya'),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(1)
                                    ->schema([

                                        Radio::make('tdk_hp')
                                            ->label('Memiliki nomor handphone?')
                                            ->live()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ]),

                                        TextInput::make('nomor_handphone')
                                            ->label('No. Handphone')
                                            ->helperText('Contoh: 82187782223')
                                            // ->mask('82187782223')
                                            ->prefix('62')
                                            ->tel()
                                            // ->default('82187782223')
                                            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                            ->required()
                                            ->hidden(fn (Get $get) =>
                                            $get('tdk_hp') !== 'Ya'),

                                        TextInput::make('email')
                                            ->label('Email')
                                            // ->default('mail@mail.com')
                                            ->email(),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                Grid::make(2)
                                    ->schema([
                                        Select::make('bya_sklh')
                                            ->label('Yang membiayai sekolah')
                                            ->placeholder('Pilih Yang membiayai sekolah')
                                            ->options([
                                                'Orang Tua' => 'Orang Tua',
                                                'Wali/Orang Tua Asuh' => 'Wali/Orang Tua Asuh',
                                                'Tanggungan Sendiri' => 'Tanggungan Sendiri',
                                                'Lainnya' => 'Lainnya',
                                            ])
                                            // ->searchable()
                                            ->required()
                                            // ->default('Lainnya')
                                            ->live()
                                            ->native(false),

                                        TextInput::make('bya_sklh_lainnya')
                                            ->label('Yang membiayai sekolah lainnya')
                                            ->required()
                                            // ->default('asfasdad')
                                            ->hidden(fn (Get $get) =>
                                            $get('bya_sklh') !== 'Lainnya'),
                                    ]),

                                Grid::make(2)
                                    ->schema([

                                        Radio::make('belum_nisn')
                                            ->label('Apakah memiliki NISN?')
                                            ->helperText(new HtmlString('<strong>NISN</strong> adalah Nomor Induk Siswa Nasional'))
                                            ->live()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ]),

                                        TextInput::make('nisn')
                                            ->label('Nomor NISN')
                                            ->required()
                                            // ->default('2421324')
                                            ->hidden(fn (Get $get) =>
                                            $get('belum_nisn') !== 'Ya'),
                                    ]),

                                Grid::make(2)
                                    ->schema([

                                        Radio::make('nomor_kip_memiliki')
                                            ->label('Apakah memiliki KIP?')
                                            ->helperText(new HtmlString('<strong>KIP</strong> adalah Kartu Indonesia Pintar'))
                                            ->live()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ]),

                                        TextInput::make('nomor_kip')
                                            ->label('Nomor KIP')
                                            ->required()
                                            // ->default('32524324')
                                            ->hidden(fn (Get $get) =>
                                            $get('nomor_kip_memiliki') !== 'Ya'),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                TextInput::make('aktivitaspend')
                                    ->label('Aktivitas Pendidikan yang Diikuti')
                                    ->placeholder('Pilih Aktivitas Pendidikan yang Diikuti')
                                    // ->default('PKPPS')
                                    ->hidden()
                                    ->dehydrated(),

                                Group::make()
                                    ->relationship('pendaftar')
                                    ->schema([

                                        Grid::make(2)
                                            ->schema([

                                                Select::make('ps_mendaftar_keinginan')
                                                    ->label('Mendaftar atas kenginginan')
                                                    ->options([
                                                        'Orangtua' => 'Orangtua',
                                                        'Ananda' => 'Ananda',
                                                        'Lainnya' => 'Lainnya',
                                                    ])
                                                    ->required()
                                                    ->live()
                                                    // ->default('Lainnya')
                                                    ->native(false),

                                                TextInput::make('ps_mendaftar_keinginan_lainnya')
                                                    ->label('Lainnya')
                                                    ->required()
                                                    // ->default('asdasf')
                                                    ->hidden(fn (Get $get) =>
                                                    $get('ps_mendaftar_keinginan') !== 'Lainnya'),
                                            ]),

                                        Placeholder::make('')
                                            ->content(new HtmlString('<div class="border-b"></div>')),

                                        Textarea::make('ps_peng_pend_agama')
                                            ->label('Pengalaman pendidikan agama')
                                            ->required(),
                                            // ->default('asdasf'),

                                        Textarea::make('ps_peng_pend_formal')
                                            ->label('Pengalaman pendidikan formal')
                                            ->required(),
                                            // ->default('asdasf'),

                                        TextInput::make('ps_hafalan')
                                            ->label('Hafalan')
                                            ->length('2')
                                            ->suffix('juz')
                                            ->required(),
                                            // ->default('10'),
                                    ]),

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b"></div>')),

                                // ALAMAT SANTRI
                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                <p class="text-lg strong"><strong>TEMPAT TINGGAL DOMISILI</strong></p>
                                                <p class="text-lg strong"><strong>SANTRI</strong></p>
                                            </div>')),

                                Radio::make('al_s_status_mukim')
                                    ->label('Apakah mukim di Pondok?')
                                    ->helperText(new HtmlString('Pilih <strong>Tidak Mukim</strong> khusus bagi pendaftar <strong>Tarbiyatul Aulaad</strong> dan <strong>Pra Tahfidz kelas 1-4</strong>'))
                                    ->live()
                                    // ->default('Tidak Mukim')
                                    ->options([
                                        'Mukim' => 'Mukim',
                                        'Tidak Mukim' => 'Tidak Mukim',
                                    ])
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        if ($get('al_s_status_mukim') === 'Mukim') {

                                            $set('al_s_stts_tptgl', 'Tinggal di Asrama Pesantren');
                                        } elseif ($get('al_s_status_mukim') === 'Tidak Mukim') {

                                            $set('al_s_stts_tptgl', null);
                                        }
                                    }),

                                Select::make('al_s_stts_tptgl')
                                    ->label('Status tempat tinggal')
                                    ->placeholder('Status tempat tinggal')
                                    ->options(function (Get $get) {
                                        if ($get('al_s_status_mukim') === 'Tidak Mukim') {
                                            return ([
                                                'Tinggal dengan Ayah Kandung' => 'Tinggal dengan Ayah Kandung',
                                                'Tinggal dengan Ibu Kandung' => 'Tinggal dengan Ibu Kandung',
                                                'Tinggal dengan Wali' => 'Tinggal dengan Wali',
                                                'Ikut Saudara/Kerabat' => 'Ikut Saudara/Kerabat',
                                                'Kontrak/Kost' => 'Kontrak/Kost',
                                                'Tinggal di Asrama Bukan Milik Pesantren' => 'Tinggal di Asrama Bukan Milik Pesantren',
                                                'Panti Asuhan' => 'Panti Asuhan',
                                                'Rumah Singgah' => 'Rumah Singgah',
                                                'Lainnya' => 'Lainnya',
                                            ]);
                                        } elseif ($get('al_s_status_mukim') === 'Mukim') {
                                            return ([
                                                'Tinggal di Asrama Pesantren' => 'Tinggal di Asrama Pesantren'
                                            ]);
                                        }
                                    })
                                    // ->searchable()
                                    ->required()
                                    // ->default('Kontrak/Kost')
                                    ->disabled(fn (Get $get) =>
                                    $get('al_s_status_mukim') === 'Mukim')
                                    ->live()
                                    ->native(false)
                                    ->dehydrated(),

                                Grid::make(2)
                                    ->schema([

                                        Select::make('al_s_provinsi_id')
                                            ->label('Provinsi')
                                            ->placeholder('Pilih Provinsi')
                                            ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                            ->searchable()
                                            // ->default('35')
                                            ->required()
                                            ->live()
                                            ->native(false)
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            )
                                            ->afterStateUpdated(function (Set $set) {
                                                $set('al_s_kabupaten_id', null);
                                                $set('al_s_kecamatan_id', null);
                                                $set('al_s_kelurahan_id', null);
                                                $set('al_s_kodepos', null);
                                            }),

                                        Select::make('al_s_kabupaten_id')
                                            ->label('Kabupaten')
                                            ->placeholder('Pilih Kabupaten')
                                            ->options(fn (Get $get): Collection => Kabupaten::query()
                                                ->where('provinsi_id', $get('al_s_provinsi_id'))
                                                ->pluck('kabupaten', 'id'))
                                            ->searchable()
                                            ->required()
                                            // ->default('232')
                                            ->live()
                                            ->native(false)
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        Select::make('al_s_kecamatan_id')
                                            ->label('Kecamatan')
                                            ->placeholder('Pilih Kecamatan')
                                            ->options(fn (Get $get): Collection => Kecamatan::query()
                                                ->where('kabupaten_id', $get('al_s_kabupaten_id'))
                                                ->pluck('kecamatan', 'id'))
                                            ->searchable()
                                            ->required()
                                            // ->default('3617')
                                            ->live()
                                            ->native(false)
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        Select::make('al_s_kelurahan_id')
                                            ->label('Kelurahan')
                                            ->placeholder('Pilih Kelurahan')
                                            ->options(fn (Get $get): Collection => Kelurahan::query()
                                                ->where('kecamatan_id', $get('al_s_kecamatan_id'))
                                                ->pluck('kelurahan', 'id'))
                                            ->searchable()
                                            ->required()
                                            // ->default('45322')
                                            ->live()
                                            ->native(false)
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            )
                                            ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                                $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                                $state = $kodepos;

                                                foreach ($state as $state) {
                                                    $set('al_s_kodepos', Str::substr($state, 12, 5));
                                                }
                                            }),


                                        TextInput::make('al_s_rt')
                                            ->label('RT')
                                            ->required()
                                            // ->default('2')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        TextInput::make('al_s_rw')
                                            ->label('RW')
                                            ->required()
                                            // ->default('2')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        Textarea::make('al_s_alamat')
                                            ->label('Alamat')
                                            ->required()
                                            ->columnSpanFull()
                                            // ->default('sdfsdasdada')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),

                                        TextInput::make('al_s_kodepos')
                                            ->label('Kodepos')
                                            ->disabled()
                                            ->required()
                                            ->dehydrated()
                                            // ->default('63264')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ayah Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Ibu Kandung' ||
                                                    $get('al_s_stts_tptgl') === 'Tinggal dengan Wali' ||
                                                    $get('al_s_stts_tptgl') === null
                                            ),


                                        Grid::make(3)
                                            ->schema([
                                                Select::make('al_s_jarak')
                                                    ->label('Jarak tempat tinggal ke Pondok Pesantren')
                                                    ->options([
                                                        'Kurang dari 5 km' => 'Kurang dari 5 km',
                                                        'Antara 5 - 10 Km' => 'Antara 5 - 10 Km',
                                                        'Antara 11 - 20 Km' => 'Antara 11 - 20 Km',
                                                        'Antara 21 - 30 Km' => 'Antara 21 - 30 Km',
                                                        'Lebih dari 30 Km' => 'Lebih dari 30 Km',
                                                    ])
                                                    // ->searchable()
                                                    ->required()
                                                    // ->default('Kurang dari 5 km')
                                                    ->live()
                                                    ->native(false)
                                                    ->hidden(
                                                        fn (Get $get) =>
                                                        $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                            $get('al_s_stts_tptgl') === null
                                                    ),

                                                Select::make('al_s_transportasi')
                                                    ->label('Transportasi ke Pondok Pesantren')
                                                    ->options([
                                                        'Jalan kaki' => 'Jalan kaki',
                                                        'Sepeda' => 'Sepeda',
                                                        'Sepeda Motor' => 'Sepeda Motor',
                                                        'Mobil Pribadi' => 'Mobil Pribadi',
                                                        'Antar Jemput Sekolah' => 'Antar Jemput Sekolah',
                                                        'Angkutan Umum' => 'Angkutan Umum',
                                                        'Perahu/Sampan' => 'Perahu/Sampan',
                                                        'Lainnya' => 'Lainnya',
                                                        'Kendaraan Pribadi' => 'Kendaraan Pribadi',
                                                        'Kereta Api' => 'Kereta Api',
                                                        'Ojek' => 'Ojek',
                                                        'Andong/Bendi/Sado/Dokar/Delman/Becak' => 'Andong/Bendi/Sado/Dokar/Delman/Becak',
                                                    ])
                                                    // ->searchable()
                                                    ->required()
                                                    // ->default('Ojek')
                                                    ->live()
                                                    ->native(false)
                                                    ->hidden(
                                                        fn (Get $get) =>
                                                        $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                            $get('al_s_stts_tptgl') === null
                                                    ),

                                                Select::make('al_s_waktu_tempuh')
                                                    ->label('Waktu tempuh ke Pondok Pesantren')
                                                    ->options([
                                                        '1 - 10 menit' => '1 - 10 menit',
                                                        '10 - 19 menit' => '10 - 19 menit',
                                                        '20 - 29 menit' => '20 - 29 menit',
                                                        '30 - 39 menit' => '30 - 39 menit',
                                                        '1 - 2 jam' => '1 - 2 jam',
                                                        '> 2 jam' => '> 2 jam',
                                                    ])
                                                    // ->searchable()
                                                    ->required()
                                                    // ->default('10 - 19 menit')
                                                    ->live()
                                                    ->native(false)
                                                    ->hidden(
                                                        fn (Get $get) =>
                                                        $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                            $get('al_s_stts_tptgl') === null
                                                    ),

                                                TextInput::make('al_s_koordinat')
                                                    ->label('Titik koordinat tempat tinggal')
                                                    // ->default('sfasdadasdads')
                                                    ->hidden(
                                                        fn (Get $get) =>
                                                        $get('al_s_status_mukim') !== 'Tidak Mukim' ||
                                                            $get('al_s_stts_tptgl') === null
                                                    )->columnSpanFull(),
                                            ]),
                                    ]),
                            ]),
                        // end of step 2

                        Step::make('3. KUESIONER KEGIATAN HARIAN')
                            ->schema([

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>KUESIONER KEGIATAN HARIAN</strong></p>
                                                </div>')),
                                Group::make()
                                    ->relationship('pendaftar')
                                    ->schema([
                                        Radio::make('ps_kkh_keberadaan')
                                            ->label('1. Di mana saat ini ananda berada?')
                                            ->options([
                                                'Di rumah orangtua' => 'Di rumah orangtua',
                                                'Di mahad' => 'Di mahad',
                                            ])
                                            ->required()
                                            // ->default('Di rumah orangtua')
                                            ->live(),

                                        TextArea::make('ps_kkh_keberadaan_nama_mhd')
                                            ->label('Nama Mahad')
                                            ->required()
                                            // ->default('sadads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_keberadaan') !== 'Di mahad'
                                            ),

                                        TextArea::make('ps_kkh_keberadaan_lokasi_mhd')
                                            ->label('Lokasi Mahad')
                                            ->required()
                                            // ->default('sadads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_keberadaan') !== 'Di mahad'
                                            ),

                                        TextArea::make('ps_kkh_keberadaan_rumah_keg')
                                            ->label('2. Jika dirumah, apa kegiatan ananda selama waktu tersebut?')
                                            ->required(),
                                            // ->default('asfsadsa'),

                                        Radio::make('ps_kkh_fasilitas_gawai')
                                            ->label('3. Apakah selama di rumah (baik bagi yg dirumah, atau bagi yang di Mahad ketika liburan), ananda difasilitasi HP atau laptop (baik dengan memiliki sendiri HP/ laptop dan yang sejenis atau dipinjami orang tua)?')
                                            ->required()
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),
                                            // ->default('Ya'),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos')
                                            ->label('Apakah ananda memiliki akun medsos (media sosial)?')
                                            ->required()
                                            // ->default('Ya')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_fasilitas_gawai') !== 'Ya'
                                            ),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos_daftar')
                                            ->label('Akun medsos apa saja yang ananda miliki?')
                                            ->required()
                                            // ->default('asfdads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_fasilitas_gawai') !== 'Ya'
                                            ),

                                        TextArea::make('ps_kkh_fasilitas_gawai_medsos_aktif')
                                            ->label('Apakah akun tersebut masih aktif hingga sekarang?')
                                            ->required()
                                            // ->default('asdafs')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_fasilitas_gawai') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkh_fasilitas_gawai_medsos_menutup')
                                            ->label('Apakah bersedia menutup akun tersebut selama menjadi santri/santriwati?')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak Bersedia' => 'Tidak Bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_fasilitas_gawai') !== 'Ya'
                                            ),

                                        CheckboxList::make('ps_kkh_medsos_sering')
                                            ->label('4. Dari medsos berikut, manakah yang sering digunakan ananda?')
                                            ->required()
                                            // ->default('Whatsapp')
                                            ->options([
                                                'Whatsapp' => 'Whatsapp',
                                                'Twitter/X' => 'Twitter/X',
                                                'Instagram' => 'Instagram',
                                                'Lainnya' => 'Lainnya',
                                            ]),

                                        TextArea::make('ps_kkh_medsos_sering_lainnya')
                                            ->label('Akun medsos lainnya')
                                            ->required()
                                            // ->default('asdadsads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_medsos_sering') !== 'Lainnya'
                                            ),

                                        Radio::make('ps_kkh_medsos_group')
                                            ->label('5. Apakah ananda tergabung dalam grup yang ada pada medsos tersebut?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkh_medsos_group_nama')
                                            ->label('Mohon dijelaskan nama grup dan bidang kegiatannya')
                                            ->required()
                                            // ->default('asdadasdads')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkh_medsos_group') !== 'Ya'
                                            ),

                                        TextArea::make('ps_kkh_bacaan')
                                            ->label('6. Apa saja buku bacaan yang disukai atau sering dibaca ananda?')
                                            ->helperText('Mohon dijelaskan jenis bacaannya')
                                            // ->default('asdads')
                                            ->required(),

                                        TextArea::make('ps_kkh_bacaan_cara_dapat')
                                            ->label('Bagaimana cara mendapatkan bacaan tersebut? (Via online atau membeli sendiri)')
                                            // ->default('assad')
                                            ->required(),

                                    ]),
                            ]),
                        // end of step 3

                        Step::make('4. KUESIONER KESEHATAN')
                            ->schema([

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>KUESIONER KESEHATAN</strong></p>
                                                </div>')),
                                Group::make()
                                    ->relationship('pendaftar')
                                    ->schema([
                                        Radio::make('ps_kkes_sakit_serius')
                                            ->label('1. Apakah ananda pernah mengalami sakit yang cukup serius?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_sakit_serius_nama_penyakit')
                                            ->label('Jika iya, kapan dan penyakit apa?')
                                            ->required()
                                            // ->default('asdad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_sakit_serius') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_terapi')
                                            ->label('2. Apakah ananda pernah atau sedang menjalani terapi kesehatan?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_terapi_nama_terapi')
                                            ->label('Jika iya, kapan dan terapi apa?')
                                            ->required()
                                            // ->default('asdasd')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_terapi') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_kambuh')
                                            ->label('3. Apakah ananda memiliki penyakit yang dapat/sering kambuh?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_kambuh_nama_penyakit')
                                            ->label('Jika iya, penyakit apa?')
                                            ->required()
                                            // ->default('asdad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_kambuh') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_alergi')
                                            ->label('4. Apakah ananda memiliki alergi terhadap perkara-perkara tertentu?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_alergi_nama_alergi')
                                            ->label('Jika iya, sebutkan!')
                                            ->required()
                                            // ->default('asdadsd')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_alergi') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_pantangan')
                                            ->label('5. Apakah ananda mempunyai pantangan yang berkaitan dengan kesehatan?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_pantangan_nama')
                                            ->label('Jika iya, sebutkan dan jelaskan alasannya!')
                                            ->required()
                                            // ->default('asdadssad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_pantangan') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_psikologis')
                                            ->label('6. Apakah ananda pernah mengalami gangguan psikologis (depresi dan gejala-gejalanya)?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_psikologis_kapan')
                                            ->label('Jika iya, kapan?')
                                            ->required()
                                            // ->default('asdad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_psikologis') !== 'Ya'
                                            ),

                                        Radio::make('ps_kkes_gangguan')
                                            ->label('7. Apakah ananda pernah mengalami gangguan jin?')
                                            ->required()
                                            // ->default('Ya')
                                            ->options([
                                                'Ya' => 'Ya',
                                                'Tidak' => 'Tidak',
                                            ])
                                            ->live(),

                                        TextArea::make('ps_kkes_gangguan_kapan')
                                            ->label('Jika iya, kapan?')
                                            ->required()
                                            // ->default('asdadsad')
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kkes_gangguan') !== 'Ya'
                                            ),

                                    ]),
                            ]),
                        // end of step 4

                        Step::make('5. KUESIONER KEMAMPUAN PEMBAYARAN ADMINISTRASI')
                            ->schema([

                                Placeholder::make('')
                                    ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>KUESIONER KEMAMPUAN PEMBAYARAN ADMINISTRASI</strong></p>
                                                </div>')),
                                Group::make()
                                    ->relationship('pendaftar')
                                    ->schema([
                                        Placeholder::make('')
                                            ->content(new HtmlString('<div class="grid grid-cols-1 justify-center">
                                            <div class="border rounded-xl p-4">
                                            <table>
                                                <!-- head -->
                                                <thead>
                                                    <tr class="border-b">
                                                        <th class="text-lg text-tsn-header" colspan="4">RINCIAN BIAYA AWAL DAN SPP (menginap)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th class="text-start">Uang Pendaftaran     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">100.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 2 -->
                                            <tr>
                                                <th class="text-start">Uang Gedung      </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">300.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 3 -->
                                            <tr>
                                                <th class="text-start">Uang Sarpras     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">200.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 4 -->
                                            <tr class="border-tsn-header">
                                                <th class="text-start">SPP*     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">550.000</td>
                                                <td class="text-end">(per bulan)</td>
                                            </tr>
                                            <tr class="border-t">
                                                <th>Total       </th>
                                                <td class="text-end"><strong>Rp.</strong></td>
                                                <td class="text-end"><strong>1.150.000</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-sm" colspan="4">*Pembayaran administrasi awal termasuk SPP bulan pertama</td>
                                            </tr>
                                            </tbody>
                                                </table>
                                            </div>

                                            <br>

                                            <div class="border rounded-xl p-4">
                                            <table>
                                                <!-- head -->
                                                <thead>
                                                    <tr class="border-b">
                                                        <th class="text-lg text-tsn-header" colspan="4">RINCIAN BIAYA AWAL DAN SPP (fullday tanpa makan)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th class="text-start">Uang Pendaftaran     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">100.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 2 -->
                                            <tr>
                                                <th class="text-start">Uang Gedung      </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">300.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 3 -->
                                            <tr>
                                                <th class="text-start">Uang Sarpras     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">200.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 4 -->
                                            <tr class="border-tsn-header">
                                                <th class="text-start">SPP*     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">200.000</td>
                                                <td class="text-end">(per bulan)</td>
                                            </tr>
                                            <tr class="border-t">
                                                <th>Total       </th>
                                                <td class="text-end"><strong>Rp.</strong></td>
                                                <td class="text-end"><strong>800.000</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-sm" colspan="4">*Pembayaran administrasi awal termasuk SPP bulan pertama</td>
                                            </tr>
                                            </tbody>
                                                </table>
                                            </div>

                                            <br>

                                            <div class="border rounded-xl p-4">
                                            <table>
                                                <!-- head -->
                                                <thead>
                                                    <tr class="border-b">
                                                        <th class="text-lg text-tsn-header" colspan="4">RINCIAN BIAYA AWAL DAN SPP (fullday dengan makan)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            <!-- row 1 -->
                                            <tr>
                                                <th class="text-start">Uang Pendaftaran     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">100.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 2 -->
                                            <tr>
                                                <th class="text-start">Uang Gedung      </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">300.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 3 -->
                                            <tr>
                                                <th class="text-start">Uang Sarpras     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">200.000</td>
                                                <td class="text-end">(per tahun)</td>
                                            </tr>
                                            <!-- row 4 -->
                                            <tr class="border-tsn-header">
                                                <th class="text-start">SPP*     </th>
                                                <td class="text-end">Rp.</td>
                                                <td class="text-end">300.000</td>
                                                <td class="text-end">(per bulan)</td>
                                            </tr>
                                            <tr class="border-t">
                                                <th>Total       </th>
                                                <td class="text-end"><strong>Rp.</strong></td>
                                                <td class="text-end"><strong>900.000</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="text-sm" colspan="4">*Pembayaran administrasi awal termasuk SPP bulan pertama</td>
                                            </tr>
                                            </tbody>
                                                </table>
                                            </div>
                                            </div>')),

                                        Radio::make('ps_kadm_status')
                                            ->label('Status anak didik terkait dengan administrasi')
                                            ->required()
                                            // ->default('Santri/Santriwati tidak mampu')
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
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_surat_subsidi')
                                            ->label('1. Wali harus membuat surat permohonan subsidi/ keringanan biaya administrasi')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_surat_kurang_mampu')
                                            ->label('2. Wali harus menyertakan surat keterangan kurang mampu dari ustadz salafy setempat SERTA dari aparat pemerintah setempat, yang isinya menyatakan bhw mmg kluarga tersebut "perlu dibantu"')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_atur_keuangan')
                                            ->label('3. Keuangan ananda akan dipegang dan diatur oleh Mahad')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_penentuan_subsidi')
                                            ->label('4. Yang menentukan bentuk keringanan yang diberikan adalah Mahad')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_hidup_sederhana')
                                            ->label('5. Ananda harus berpola hidup sederhana agar tidak menimbulkan pertanyaan pihak luar')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),

                                        Radio::make('ps_kadm_kebijakan_subsidi')
                                            ->label('6. Kebijakan subsidi bisa berubah sewaktu waktu')
                                            ->required()
                                            // ->default('Bersedia')
                                            ->options([
                                                'Bersedia' => 'Bersedia',
                                                'Tidak bersedia' => 'Tidak bersedia',
                                            ])
                                            ->hidden(
                                                fn (Get $get) =>
                                                $get('ps_kadm_status') !== 'Santri/Santriwati tidak mampu'
                                            ),
                                    ]),
                            ]),
                        // end of step 5
                    ])
                // end of action steps
            ])



            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Ubah'),
                    Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
