<?php

namespace App\Filament\Naikqism\Resources;

use App\Filament\Naikqism\Resources\PendaftaranNaikQismResource\Pages;
use App\Filament\Naikqism\Resources\PendaftaranNaikQismResource\RelationManagers;
use App\Filament\Resources\PendaftaranResource;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kodepos;
use App\Models\PendaftaranNaikQism;
use App\Models\Provinsi;
use App\Models\Walisantri;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class PendaftaranNaikQismResource extends Resource
{
    protected static ?string $model = Walisantri::class;

    protected static bool $isLazy = false;

    protected static bool $shouldRegisterNavigation = false;

    // protected static ?string $recordTitleAttribute = 'Formulir Pendaftaran Santri Baru';

    protected static ?string $modelLabel = 'Formulir Pendaftaran Naik Qism';

    protected static ?string $pluralModelLabel = 'Formulir Pendaftaran Naik Qism';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('is_collapse')
                ->hidden()
                ->live(),

                Section::make('')
                    ->schema([


                        Placeholder::make('')
                            ->content(new HtmlString('<div class="">
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

                                     </div>')),


                    ])->compact(),

                Section::make('Informasi Pendaftar')
                    ->schema([
                        Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('kartu_keluarga_santri')
                                    ->label('Nomor Kartu Keluarga')
                                    ->disabled()
                                    ->live(),

                                Forms\Components\TextInput::make('nama_kpl_kel_santri')
                                    ->label('Nama Kepala Keluarga')
                                    ->disabled()
                                    ->live(),

                                TextInput::make('hp_komunikasi')
                                    ->label('No Handphone walisantri untuk komunikasi')
                                    ->helperText('Contoh: 82187782223')
                                    // ->mask('82187782223')
                                    ->prefix('62')
                                    ->tel()
                                    ->live()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->required()

                            ]),



                    ])->compact()
                    ->collapsed(fn (Get $get): bool => $get('is_collapse')),

                //AYAH KANDUNG
                Section::make('Walisantri')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>A. AYAH KANDUNG</strong></p>
                                                </div>')),

                        Radio::make('ak_nama_lengkap_sama')
                            ->label('Apakah Nama sama dengan Nama Kepala Keluarga?')
                            ->live()
                            ->options([
                                'Ya' => 'Ya',
                                'Tidak' => 'Tidak',
                            ])
                            // ->hidden(fn (Get $get) =>
                            // $get('ak_status') !== 'Masih Hidup')
                            ->afterStateUpdated(function (Get $get, Set $set) {

                                if ($get('ak_nama_lengkap_sama') === 'Ya') {
                                    $set('ak_nama_lengkap', $get('nama_kpl_kel_santri'));
                                    $set('ik_nama_lengkap_sama', 'Tidak');
                                    $set('ik_nama_lengkap', null);
                                    $set('w_nama_lengkap_sama', 'Tidak');
                                    $set('w_nama_lengkap', null);
                                } else {
                                    $set('ak_nama_lengkap', null);
                                }
                            })->columnSpanFull(),

                        Forms\Components\TextInput::make('ak_nama_lengkap')
                            ->label('Nama Lengkap')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required()
                            ->disabled(fn (Get $get) =>
                            $get('ak_nama_lengkap_sama') === 'Ya')
                            ->dehydrated(),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>A.01 STATUS AYAH KANDUNG</strong></p>
                                                </div>')),

                        Forms\Components\Select::make('ak_status')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options([
                                'Masih Hidup' => 'Masih Hidup',
                                'Sudah Meninggal' => 'Sudah Meninggal',
                                'Tidak Diketahui' => 'Tidak Diketahui',
                            ])
                            ->required()
                            ->live()
                            ->native(false),

                        TextInput::make('ak_nama_kunyah')
                            ->label('Nama Hijroh/Islami')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') !== 'Masih Hidup'),

                        Forms\Components\Select::make('ak_kewarganegaraan')
                            ->label('Kewarganegaraan')
                            ->placeholder('Pilih Kewarganegaraan')
                            ->options([
                                'WNI' => 'WNI',
                                'WNA' => 'WNA',
                            ])
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') !== 'Masih Hidup'),

                        Forms\Components\TextInput::make('ak_nik')
                            ->label('NIK')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ak_kewarganegaraan') !== 'WNI' ||
                                $get('ak_status') !== 'Masih Hidup'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ak_asal_negara')
                                    ->label('Asal Negara')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_kewarganegaraan') !== 'WNA' ||
                                        $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\TextInput::make('ak_kitas')
                                    ->label('KITAS')
                                    ->hint('Nomor Izin Tinggal (KITAS)')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_kewarganegaraan') !== 'WNA' ||
                                        $get('ak_status') !== 'Masih Hidup'),
                            ]),
                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ak_tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\DatePicker::make('ak_tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    // ->format('dd/mm/yyyy')
                                    ->displayFormat('d M Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup'),
                            ]),

                        Grid::make(3)
                            ->schema([

                                Forms\Components\Select::make('ak_pend_terakhir')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\Select::make('ak_pekerjaan_utama')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\Select::make('ak_pghsln_rt')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup'),
                            ]),

                        Grid::make(1)
                            ->schema([

                                Radio::make('ak_tdk_hp')
                                    ->label('Memiliki nomor handphone?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup'),

                                Radio::make('ak_nomor_handphone_sama')
                                    ->label('Apakah nomor handphone sama dengan Pendaftar?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_tdk_hp') !== 'Ya' ||
                                        $get('ak_status') !== 'Masih Hidup')
                                    ->afterStateUpdated(function (Get $get, Set $set) {

                                        if ($get('ak_nomor_handphone_sama') === 'Ya') {
                                            $set('ak_nomor_handphone', $get('hp_komunikasi'));
                                            $set('ik_nomor_handphone_sama', 'Tidak');
                                            $set('ik_nomor_handphone', null);
                                            $set('w_nomor_handphone_sama', 'Tidak');
                                            $set('w_nomor_handphone', null);
                                        } else {
                                            $set('ak_nomor_handphone', null);
                                        }
                                    })->columnSpanFull(),

                                Forms\Components\TextInput::make('ak_nomor_handphone')
                                    ->label('No. Handphone')
                                    ->helperText('Contoh: 82187782223')
                                    // ->mask('82187782223')
                                    ->prefix('62')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('ak_nomor_handphone_sama') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_tdk_hp') !== 'Ya' ||
                                        $get('ak_status') !== 'Masih Hidup'),
                            ]),

                        // KARTU KELUARGA AYAH KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                        <p class="text-lg strong"><strong>A.02 KARTU KELUARGA</strong></p>
                        <p class="text-lg strong"><strong>AYAH KANDUNG</strong></p>
                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') !== 'Masih Hidup'),

                        Grid::make(2)
                            ->schema([

                                Radio::make('ak_kk_sama_pendaftar')
                                    ->label('Apakah KK dan Nama Kepala Keluarga sama dengan Pendaftar?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup')
                                    ->afterStateUpdated(function (Get $get, Set $set) {

                                        if ($get('ak_kk_sama_pendaftar') === 'Ya') {
                                            $set('ak_no_kk', $get('kartu_keluarga_santri'));
                                            $set('ak_kep_kel_kk', $get('nama_kpl_kel_santri'));
                                            $set('ik_kk_sama_pendaftar', 'Tidak');
                                            $set('ik_no_kk', null);
                                            $set('ik_kep_kel_kk', null);
                                            $set('w_kk_sama_pendaftar', 'Tidak');
                                            $set('w_no_kk', null);
                                            $set('w_kep_kel_kk', null);
                                        } else {
                                            $set('ak_no_kk', null);
                                            $set('ak_kep_kel_kk', null);
                                        }
                                    })->columnSpanFull(),

                                Forms\Components\TextInput::make('ak_no_kk')
                                    ->label('No. KK Ayah Kandung')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->length(16)
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('ak_kk_sama_pendaftar') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\TextInput::make('ak_kep_kel_kk')
                                    ->label('Nama Kepala Keluarga')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('ak_kk_sama_pendaftar') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_status') !== 'Masih Hidup'),
                            ]),


                        // ALAMAT AYAH KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>A.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                                    <p class="text-lg strong"><strong>AYAH KANDUNG</strong></p>
                                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') !== 'Masih Hidup'),

                        Radio::make('al_ak_tgldi_ln')
                            ->label('Apakah tinggal di luar negeri?')
                            ->live()
                            ->options([
                                'Ya' => 'Ya',
                                'Tidak' => 'Tidak',
                            ])
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') !== 'Masih Hidup'),

                        Forms\Components\Textarea::make('al_ak_almt_ln')
                            ->label('Alamat Luar Negeri')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('al_ak_tgldi_ln') !== 'Ya'),

                        Forms\Components\Select::make('al_ak_stts_rmh')
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
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                $get('ak_status') !== 'Masih Hidup'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\Select::make('al_ak_provinsi_id')
                                    ->label('Provinsi')
                                    ->placeholder('Pilih Provinsi')
                                    ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                        $get('ak_status') !== 'Masih Hidup')
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('al_ak_kabupaten_id', null);
                                        $set('al_ak_kecamatan_id', null);
                                        $set('al_ak_kelurahan_id', null);
                                        $set('al_ak_kodepos', null);
                                    }),

                                Forms\Components\Select::make('al_ak_kabupaten_id')
                                    ->label('Kabupaten')
                                    ->placeholder('Pilih Kabupaten')
                                    ->options(fn (Get $get): Collection => Kabupaten::query()
                                        ->where('provinsi_id', $get('al_ak_provinsi_id'))
                                        ->pluck('kabupaten', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                        $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\Select::make('al_ak_kecamatan_id')
                                    ->label('Kecamatan')
                                    ->placeholder('Pilih Kecamatan')
                                    ->options(fn (Get $get): Collection => Kecamatan::query()
                                        ->where('kabupaten_id', $get('al_ak_kabupaten_id'))
                                        ->pluck('kecamatan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                        $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\Select::make('al_ak_kelurahan_id')
                                    ->label('Kelurahan')
                                    ->placeholder('Pilih Kelurahan')
                                    ->options(fn (Get $get): Collection => Kelurahan::query()
                                        ->where('kecamatan_id', $get('al_ak_kecamatan_id'))
                                        ->pluck('kelurahan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                        $get('ak_status') !== 'Masih Hidup')
                                    ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                        if (($get('al_ak_kodepos') ?? '') !== Str::slug($old)) {
                                            return;
                                        }

                                        $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                        $state = $kodepos;

                                        foreach ($state as $state) {
                                            $set('al_ak_kodepos', Str::substr($state, 12, 5));
                                        }
                                    }),


                                Forms\Components\TextInput::make('al_ak_rt')
                                    ->label('RT')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                        $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\TextInput::make('al_ak_rw')
                                    ->label('RW')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                        $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\Textarea::make('al_ak_alamat')
                                    ->label('Alamat')
                                    ->required()
                                    ->columnSpanFull()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                        $get('ak_status') !== 'Masih Hidup'),

                                Forms\Components\TextInput::make('al_ak_kodepos')
                                    ->label('Kodepos')
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_ak_tgldi_ln') !== 'Tidak' ||
                                        $get('ak_status') !== 'Masih Hidup'),
                            ]),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                         <p class="text-lg strong"><strong>Kajian yang diikuti</strong></p>
                                     </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') !== 'Masih Hidup'),

                        Textarea::make('ak_ustadz_kajian')
                            ->label('Ustadz yang mengisi kajian')
                            ->required()
                            ->default('4232')
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') !== 'Masih Hidup'),

                        TextArea::make('ak_tempat_kajian')
                            ->label('Tempat kajian yang diikuti')
                            ->required()
                            ->default('4232')
                            ->hidden(fn (Get $get) =>
                            $get('ak_status') !== 'Masih Hidup'),





                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                </div>')),


                        // //IBU KANDUNG
                        // Section::make('')
                        //     ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div>
                                                </div>')),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>B. IBU KANDUNG</strong></p>
                                                </div>')),

                        Radio::make('ik_nama_lengkap_sama')
                            ->label('Apakah Nama sama dengan Nama Kepala Keluarga?')
                            ->live()
                            ->options([
                                'Ya' => 'Ya',
                                'Tidak' => 'Tidak',
                            ])
                            ->hidden(fn (Get $get) =>
                            $get('ak_nama_lengkap_sama') !== 'Tidak')
                            ->afterStateUpdated(function (Get $get, Set $set) {

                                if ($get('ik_nama_lengkap_sama') === 'Ya') {
                                    $set('ik_nama_lengkap', $get('nama_kpl_kel_santri'));
                                    $set('w_nama_lengkap_sama', 'Tidak');
                                    $set('w_nama_lengkap', null);
                                } else {
                                    $set('ik_nama_lengkap', null);
                                }
                            })->columnSpanFull(),

                        Forms\Components\TextInput::make('ik_nama_lengkap')
                            ->label('Nama Lengkap')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required()
                            ->disabled(fn (Get $get) =>
                            $get('ik_nama_lengkap_sama') === 'Ya')
                            ->dehydrated(),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>B.01 STATUS IBU KANDUNG</strong></p>
                                                </div>')),

                        Forms\Components\Select::make('ik_status')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options([
                                'Masih Hidup' => 'Masih Hidup',
                                'Sudah Meninggal' => 'Sudah Meninggal',
                                'Tidak Diketahui' => 'Tidak Diketahui',
                            ])
                            ->required()
                            ->live()
                            ->native(false),

                        TextInput::make('ik_nama_kunyah')
                            ->label('Nama Hijroh/Islami')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') !== 'Masih Hidup'),

                        Forms\Components\Select::make('ik_kewarganegaraan')
                            ->label('Kewarganegaraan')
                            ->placeholder('Pilih Kewarganegaraan')
                            ->options([
                                'WNI' => 'WNI',
                                'WNA' => 'WNA',
                            ])
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') !== 'Masih Hidup'),

                        Forms\Components\TextInput::make('ik_nik')
                            ->label('NIK')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ik_kewarganegaraan') !== 'WNI' ||
                                $get('ik_status') !== 'Masih Hidup'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ik_asal_negara')
                                    ->label('Asal Negara')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kewarganegaraan') !== 'WNA' ||
                                        $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\TextInput::make('ik_kitas')
                                    ->label('KITAS')
                                    ->hint('Nomor Izin Tinggal (KITAS)')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kewarganegaraan') !== 'WNA' ||
                                        $get('ik_status') !== 'Masih Hidup'),
                            ]),
                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('ik_tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\DatePicker::make('ik_tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    // ->format('dd/mm/yyyy')
                                    ->displayFormat('d M Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') !== 'Masih Hidup'),
                            ]),

                        Grid::make(3)
                            ->schema([

                                Forms\Components\Select::make('ik_pend_terakhir')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\Select::make('ik_pekerjaan_utama')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\Select::make('ik_pghsln_rt')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') !== 'Masih Hidup'),
                            ]),

                        Grid::make(1)
                            ->schema([

                                Radio::make('ik_tdk_hp')
                                    ->label('Memiliki nomor handphone?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_status') !== 'Masih Hidup'),

                                Radio::make('ik_nomor_handphone_sama')
                                    ->label('Apakah nomor handphone sama dengan Pendaftar?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_tdk_hp') !== 'Ya' ||
                                        $get('ak_nomor_handphone_sama') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup')
                                    ->afterStateUpdated(function (Get $get, Set $set) {

                                        if ($get('ik_nomor_handphone_sama') === 'Ya') {
                                            $set('ik_nomor_handphone', $get('hp_komunikasi'));
                                            $set('w_nomor_handphone_sama', 'Tidak');
                                            $set('w_nomor_handphone', null);
                                        } else {
                                            $set('ik_nomor_handphone', null);
                                        }
                                    })->columnSpanFull(),

                                Forms\Components\TextInput::make('ik_nomor_handphone')
                                    ->label('No. Handphone')
                                    ->helperText('Contoh: 82187782223')
                                    // ->mask('82187782223')
                                    ->prefix('62')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('ik_nomor_handphone_sama') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_tdk_hp') !== 'Ya' ||
                                        $get('ik_status') !== 'Masih Hidup'),
                            ]),

                        // KARTU KELUARGA IBU KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                        <p class="text-lg strong"><strong>B.02 KARTU KELUARGA</strong></p>
                        <p class="text-lg strong"><strong>IBU KANDUNG</strong></p>
                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') !== 'Masih Hidup'),

                        Radio::make('ik_kk_sama_ak')
                            ->label('Apakah KK Ibu Kandung sama dengan KK Ayah Kandung?')
                            ->live()
                            ->options(function (Get $get) {

                                if ($get('ak_status') !== 'Masih Hidup') {

                                    return ([
                                        'Tidak' => 'Tidak',
                                    ]);
                                } else {
                                    return ([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ]);
                                }
                            })
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $sama = $get('ik_kk_sama_ak');
                                $set('al_ik_sama_ak', $sama);

                                if ($get('ik_kk_sama_ak') === 'Ya') {
                                    $set('ik_kk_sama_pendaftar', 'Tidak');
                                }
                            })
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') !== 'Masih Hidup'),

                        Radio::make('al_ik_sama_ak')
                            ->label('Alamat sama dengan Ayah Kandung')
                            ->helperText('Untuk mengubah alamat, silakan mengubah status KK Ibu kandung')
                            ->disabled()
                            ->live()
                            ->options([
                                'Ya' => 'Ya',
                                'Tidak' => 'Tidak',
                            ])
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') !== 'Masih Hidup'),

                        Grid::make(2)
                            ->schema([

                                Radio::make('ik_kk_sama_pendaftar')
                                    ->label('Apakah KK dan Nama Kepala Keluarga sama dengan Pendaftar?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('ak_kk_sama_pendaftar') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup')
                                    ->afterStateUpdated(function (Get $get, Set $set) {

                                        if ($get('ik_kk_sama_pendaftar') === 'Ya') {
                                            $set('ik_no_kk', $get('kartu_keluarga_santri'));
                                            $set('ik_kep_kel_kk', $get('nama_kpl_kel_santri'));
                                            $set('w_kk_sama_pendaftar', 'Tidak');
                                            $set('w_no_kk', null);
                                            $set('w_kep_kel_kk', null);
                                        } else {
                                            $set('ik_no_kk', null);
                                            $set('ik_kep_kel_kk', null);
                                        }
                                    })->columnSpanFull(),

                                Forms\Components\TextInput::make('ik_no_kk')
                                    ->label('No. KK Ibu Kandung')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->length(16)
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('ik_kk_sama_pendaftar') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\TextInput::make('ik_kep_kel_kk')
                                    ->label('Nama Kepala Keluarga')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('ik_kk_sama_pendaftar') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup'),
                            ]),


                        // ALAMAT AYAH KANDUNG
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>B.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                                    <p class="text-lg strong"><strong>IBU KANDUNG</strong></p>
                                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ik_kk_sama_ak') !== 'Tidak' ||
                                $get('ik_status') !== 'Masih Hidup'),

                        Radio::make('al_ik_tgldi_ln')
                            ->label('Apakah tinggal di luar negeri?')
                            ->live()
                            ->options([
                                'Ya' => 'Ya',
                                'Tidak' => 'Tidak',
                            ])
                            ->hidden(fn (Get $get) =>
                            $get('ik_kk_sama_ak') !== 'Tidak' ||
                                $get('ik_status') !== 'Masih Hidup'),

                        Forms\Components\Textarea::make('al_ik_almt_ln')
                            ->label('Alamat Luar Negeri')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('ik_kk_sama_ak') !== 'Tidak' ||
                                $get('al_ik_tgldi_ln') !== 'Ya' ||
                                $get('ik_status') !== 'Masih Hidup'),

                        Forms\Components\Select::make('al_ik_stts_rmh')
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
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('ik_kk_sama_ak') !== 'Tidak' ||
                                $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                $get('ik_status') !== 'Masih Hidup'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\Select::make('al_ik_provinsi_id')
                                    ->label('Provinsi')
                                    ->placeholder('Pilih Provinsi')
                                    ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup')
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('al_ik_kabupaten_id', null);
                                        $set('al_ik_kecamatan_id', null);
                                        $set('al_ik_kelurahan_id', null);
                                        $set('al_ik_kodepos', null);
                                    }),

                                Forms\Components\Select::make('al_ik_kabupaten_id')
                                    ->label('Kabupaten')
                                    ->placeholder('Pilih Kabupaten')
                                    ->options(fn (Get $get): Collection => Kabupaten::query()
                                        ->where('provinsi_id', $get('al_ik_provinsi_id'))
                                        ->pluck('kabupaten', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\Select::make('al_ik_kecamatan_id')
                                    ->label('Kecamatan')
                                    ->placeholder('Pilih Kecamatan')
                                    ->options(fn (Get $get): Collection => Kecamatan::query()
                                        ->where('kabupaten_id', $get('al_ik_kabupaten_id'))
                                        ->pluck('kecamatan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\Select::make('al_ik_kelurahan_id')
                                    ->label('Kelurahan')
                                    ->placeholder('Pilih Kelurahan')
                                    ->options(fn (Get $get): Collection => Kelurahan::query()
                                        ->where('kecamatan_id', $get('al_ik_kecamatan_id'))
                                        ->pluck('kelurahan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup')
                                    ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                        if (($get('al_ik_kodepos') ?? '') !== Str::slug($old)) {
                                            return;
                                        }

                                        $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                        $state = $kodepos;

                                        foreach ($state as $state) {
                                            $set('al_ik_kodepos', Str::substr($state, 12, 5));
                                        }
                                    }),


                                Forms\Components\TextInput::make('al_ik_rt')
                                    ->label('RT')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\TextInput::make('al_ik_rw')
                                    ->label('RW')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\Textarea::make('al_ik_alamat')
                                    ->label('Alamat')
                                    ->required()
                                    ->columnSpanFull()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup'),

                                Forms\Components\TextInput::make('al_ik_kodepos')
                                    ->label('Kodepos')
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('ik_kk_sama_ak') !== 'Tidak' ||
                                        $get('al_ik_tgldi_ln') !== 'Tidak' ||
                                        $get('ik_status') !== 'Masih Hidup'),
                            ]),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                         <p class="text-lg strong"><strong>Kajian yang diikuti</strong></p>
                                     </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') !== 'Masih Hidup'),

                        Textarea::make('ik_ustadz_kajian')
                            ->label('Ustadz yang mengisi kajian')
                            ->required()
                            ->default('4232')
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') !== 'Masih Hidup'),

                        TextArea::make('ik_tempat_kajian')
                            ->label('Tempat kajian yang diikuti')
                            ->required()
                            ->default('4232')
                            ->hidden(fn (Get $get) =>
                            $get('ik_status') !== 'Masih Hidup'),



                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b border-tsn-accent">
                                                </div>')),


                        // //IBU KANDUNG
                        // Section::make('')
                        //     ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div>
                                                </div>')),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>C. WALI</strong></p>
                                                </div>')),

                        Forms\Components\Select::make('w_status')
                            ->label('Status')
                            ->placeholder('Pilih Status')
                            ->options(function (Get $get) {

                                if (($get('ak_status') == "Masih Hidup" && $get('ik_status') == "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ayah kandung' => 'Sama dengan ayah kandung',
                                        'Sama dengan ibu kandung' => 'Sama dengan ibu kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status') == "Masih Hidup" && $get('ik_status') !== "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ayah kandung' => 'Sama dengan ayah kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status') !== "Masih Hidup" && $get('ik_status') == "Masih Hidup")) {
                                    return ([
                                        'Sama dengan ibu kandung' => 'Sama dengan ibu kandung',
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                } elseif (($get('ak_status') !== "Masih Hidup" && $get('ik_status') !== "Masih Hidup")) {
                                    return ([
                                        'Lainnya' => 'Lainnya'
                                    ]);
                                }
                            })
                            ->required()
                            ->live()
                            ->native(false),

                        Forms\Components\Select::make('w_hubungan')
                            ->label('Hubungan wali dengan calon santri')
                            ->placeholder('Pilih Hubungan')
                            ->options([
                                'Kakek/Nenek' => 'Kakek/Nenek',
                                'Paman/Bibi' => 'Paman/Bibi',
                                'Kakak' => 'Kakak',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Radio::make('w_nama_lengkap_sama')
                            ->label('Apakah Nama sama dengan Nama Kepala Keluarga?')
                            ->live()
                            ->options([
                                'Ya' => 'Ya',
                                'Tidak' => 'Tidak',
                            ])
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya' ||
                                $get('ak_nama_lengkap_sama') !== 'Tidak' ||
                                $get('ik_nama_lengkap_sama') !== 'Tidak')
                            ->afterStateUpdated(function (Get $get, Set $set) {

                                if ($get('w_nama_lengkap_sama') === 'Ya') {
                                    $set('w_nama_lengkap', $get('nama_kpl_kel_santri'));
                                } else {
                                    $set('w_nama_lengkap', null);
                                }
                            })->columnSpanFull(),

                        Forms\Components\TextInput::make('w_nama_lengkap')
                            ->label('Nama Lengkap')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->required()
                            ->disabled(fn (Get $get) =>
                            $get('w_nama_lengkap_sama') === 'Ya')
                            ->dehydrated()
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>C.01 STATUS WALI</strong></p>
                                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        TextInput::make('w_nama_kunyah')
                            ->label('Nama Hijroh/Islami')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Forms\Components\Select::make('w_kewarganegaraan')
                            ->label('Kewarganegaraan')
                            ->placeholder('Pilih Kewarganegaraan')
                            ->options([
                                'WNI' => 'WNI',
                                'WNA' => 'WNA',
                            ])
                            ->required()
                            ->live()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Forms\Components\TextInput::make('w_nik')
                            ->label('NIK')
                            ->hint('Isi sesuai dengan KK')
                            ->hintColor('danger')
                            ->length(16)
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('w_kewarganegaraan') !== 'WNI' ||
                                $get('w_status') !== 'Lainnya'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('w_asal_negara')
                                    ->label('Asal Negara')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_kewarganegaraan') !== 'WNA' ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('w_kitas')
                                    ->label('KITAS')
                                    ->hint('Nomor Izin Tinggal (KITAS)')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_kewarganegaraan') !== 'WNA' ||
                                        $get('w_status') !== 'Lainnya'),
                            ]),
                        Grid::make(2)
                            ->schema([

                                Forms\Components\TextInput::make('w_tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\DatePicker::make('w_tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    // ->format('dd/mm/yyyy')
                                    ->displayFormat('d M Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),
                            ]),

                        Grid::make(3)
                            ->schema([

                                Forms\Components\Select::make('w_pend_terakhir')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\Select::make('w_pekerjaan_utama')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\Select::make('w_pghsln_rt')
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
                                    ->searchable()
                                    ->required()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),
                            ]),

                        Grid::make(1)
                            ->schema([

                                Radio::make('w_tdk_hp')
                                    ->label('Memiliki nomor handphone?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Radio::make('w_nomor_handphone_sama')
                                    ->label('Apakah nomor handphone sama dengan Pendaftar?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('w_tdk_hp') !== 'Ya' ||
                                        $get('ak_nomor_handphone_sama') !== 'Tidak' ||
                                        $get('ik_nomor_handphone_sama') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya')
                                    ->afterStateUpdated(function (Get $get, Set $set) {

                                        if ($get('w_nomor_handphone_sama') === 'Ya') {
                                            $set('w_nomor_handphone', $get('hp_komunikasi'));
                                        } else {
                                            $set('w_nomor_handphone', null);
                                        }
                                    })->columnSpanFull(),

                                Forms\Components\TextInput::make('w_nomor_handphone')
                                    ->label('No. Handphone')
                                    ->helperText('Contoh: 82187782223')
                                    // ->mask('82187782223')
                                    ->prefix('62')
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('w_nomor_handphone_sama') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_tdk_hp') !== 'Ya' ||
                                        $get('w_status') !== 'Lainnya'),
                            ]),

                        // KARTU KELUARGA WALI
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                        <p class="text-lg strong"><strong>C.02 KARTU KELUARGA</strong></p>
                        <p class="text-lg strong"><strong>WALI</strong></p>
                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Grid::make(2)
                            ->schema([

                                Radio::make('w_kk_sama_pendaftar')
                                    ->label('Apakah KK dan Nama Kepala Keluarga sama dengan Pendaftar?')
                                    ->live()
                                    ->options([
                                        'Ya' => 'Ya',
                                        'Tidak' => 'Tidak',
                                    ])
                                    ->hidden(fn (Get $get) =>
                                    $get('ak_kk_sama_pendaftar') !== 'Tidak' ||
                                        $get('ik_kk_sama_pendaftar') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya')
                                    ->afterStateUpdated(function (Get $get, Set $set) {

                                        if ($get('w_kk_sama_pendaftar') === 'Ya') {
                                            $set('w_no_kk', $get('kartu_keluarga_santri'));
                                            $set('w_kep_kel_kk', $get('nama_kpl_kel_santri'));
                                        } else {
                                            $set('w_no_kk', null);
                                            $set('w_kep_kel_kk', null);
                                        }
                                    })->columnSpanFull(),

                                Forms\Components\TextInput::make('w_no_kk')
                                    ->label('No. KK Wali')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->length(16)
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('w_kk_sama_pendaftar') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('w_kep_kel_kk')
                                    ->label('Nama Kepala Keluarga')
                                    ->hint('Isi sesuai dengan KK')
                                    ->hintColor('danger')
                                    ->required()
                                    ->disabled(fn (Get $get) =>
                                    $get('w_kk_sama_pendaftar') === 'Ya')
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('w_status') !== 'Lainnya'),
                            ]),


                        // ALAMAT WALI
                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                                    <p class="text-lg strong"><strong>C.03 TEMPAT TINGGAL DOMISILI</strong></p>
                                                    <p class="text-lg strong"><strong>WALI</strong></p>
                                                </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Radio::make('al_w_tgldi_ln')
                            ->label('Apakah tinggal di luar negeri?')
                            ->live()
                            ->options([
                                'Ya' => 'Ya',
                                'Tidak' => 'Tidak',
                            ])
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Forms\Components\Textarea::make('al_w_almt_ln')
                            ->label('Alamat Luar Negeri')
                            ->required()
                            ->hidden(fn (Get $get) =>
                            $get('al_w_tgldi_ln') !== 'Ya'),

                        Forms\Components\Select::make('al_w_stts_rmh')
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
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->hidden(fn (Get $get) =>
                            $get('al_w_tgldi_ln') !== 'Tidak' ||
                                $get('w_status') !== 'Lainnya'),

                        Grid::make(2)
                            ->schema([

                                Forms\Components\Select::make('al_w_provinsi_id')
                                    ->label('Provinsi')
                                    ->placeholder('Pilih Provinsi')
                                    ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya')
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('al_w_kabupaten_id', null);
                                        $set('al_w_kecamatan_id', null);
                                        $set('al_w_kelurahan_id', null);
                                        $set('al_w_kodepos', null);
                                    }),

                                Forms\Components\Select::make('al_w_kabupaten_id')
                                    ->label('Kabupaten')
                                    ->placeholder('Pilih Kabupaten')
                                    ->options(fn (Get $get): Collection => Kabupaten::query()
                                        ->where('provinsi_id', $get('al_w_provinsi_id'))
                                        ->pluck('kabupaten', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\Select::make('al_w_kecamatan_id')
                                    ->label('Kecamatan')
                                    ->placeholder('Pilih Kecamatan')
                                    ->options(fn (Get $get): Collection => Kecamatan::query()
                                        ->where('kabupaten_id', $get('al_w_kabupaten_id'))
                                        ->pluck('kecamatan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\Select::make('al_w_kelurahan_id')
                                    ->label('Kelurahan')
                                    ->placeholder('Pilih Kelurahan')
                                    ->options(fn (Get $get): Collection => Kelurahan::query()
                                        ->where('kecamatan_id', $get('al_w_kecamatan_id'))
                                        ->pluck('kelurahan', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->live()
                                    ->native(false)
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya')
                                    ->afterStateUpdated(function (Get $get, ?string $state, Set $set, ?string $old) {

                                        if (($get('al_w_kodepos') ?? '') !== Str::slug($old)) {
                                            return;
                                        }

                                        $kodepos = Kodepos::where('kelurahan_id', $state)->get('kodepos');

                                        $state = $kodepos;

                                        foreach ($state as $state) {
                                            $set('al_w_kodepos', Str::substr($state, 12, 5));
                                        }
                                    }),


                                Forms\Components\TextInput::make('al_w_rt')
                                    ->label('RT')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('al_w_rw')
                                    ->label('RW')
                                    ->required()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\Textarea::make('al_w_alamat')
                                    ->label('Alamat')
                                    ->required()
                                    ->columnSpanFull()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya'),

                                Forms\Components\TextInput::make('al_w_kodepos')
                                    ->label('Kodepos')
                                    ->disabled()
                                    ->required()
                                    ->dehydrated()
                                    ->hidden(fn (Get $get) =>
                                    $get('al_w_tgldi_ln') !== 'Tidak' ||
                                        $get('w_status') !== 'Lainnya'),
                            ]),

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="border-b">
                                         <p class="text-lg strong"><strong>Kajian yang diikuti</strong></p>
                                     </div>'))
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        Textarea::make('w_ustadz_kajian')
                            ->label('Ustadz yang mengisi kajian')
                            ->required()
                            ->default('4232')
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),

                        TextArea::make('w_tempat_kajian')
                            ->label('Tempat kajian yang diikuti')
                            ->required()
                            ->default('4232')
                            ->hidden(fn (Get $get) =>
                            $get('w_status') !== 'Lainnya'),


                    ])->compact()
                    ->collapsed(fn (Get $get): bool => $get('is_collapse')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendaftaranNaikQisms::route('/'),
            'create' => Pages\CreatePendaftaranNaikQism::route('/create'),
            'view' => Pages\ViewPendaftaranNaikQism::route('/{record}'),
            'edit' => Pages\EditPendaftaranNaikQism::route('/{record}/edit'),
        ];
    }
}
