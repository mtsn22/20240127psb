<?php

namespace App\Livewire;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kodepos;
use App\Models\Provinsi;
use App\Models\Pendaftar;
use App\Models\Santri;
use App\Models\QismDetailHasKelas;
use App\Models\PesanDaftar;
use App\Models\QismDetail;
use App\Models\Qism;
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
                    ->default('Tahap 1'),

                    Hidden::make('jenispendaftar')
                    ->default('Baru'),

                     Hidden::make('ta')
                                ->default('2425'),

                Section::make('')
                    ->schema([

                        Placeholder::make('')
                            ->content(new HtmlString('<div class="">
                                         <p>Butuh bantuan?</p>
                                         <p>Silakan mengubungi admin di bawah ini melalui WA:</p>

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
                    ]),

                Wizard::make([

                    Step::make('1. CEK NIK')
                        ->schema([

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                                <p class="text-2xl strong"><strong>1. CEK NIK CALON SANTRI</strong></p>
                                            </div>')),

                            

                            // TextInput::make('ps_qism_view')
                            //     ->label('Qism yang dituju')
                            //     ->default('Tarbiyatunnisaa')
                            //     ->disabled()
                            //     ->required()
                            //     ->dehydrated(),

                            // Hidden::make('ps_qism')
                            //     ->default('6'),

                                 Select::make('ps_qism')
                                                ->label('Qism yang dituju')
                                                ->placeholder('Pilih Qism yang dituju')
                                                ->options(Qism::all()->pluck('qism', 'id'))
                                                ->live()
                                                ->required(),

                                                Radio::make('ps_jeniskelamin')
                                        ->label('Jenis Kelamin')
                                        ->options(function (Get $get) {
                                                    
                                            if ($get('ps_qism') === null) {
                                                
                                                return ([
                                            'Laki-laki' => 'Laki-laki',
                                            'Perempuan' => 'Perempuan',
                                                    ]);

                                            }elseif ($get('ps_qism') === '1') {
                                                
                                                return ([
                                            'Laki-laki' => 'Laki-laki',
                                            'Perempuan' => 'Perempuan',
                                                    ]);

                                            }elseif ($get('ps_qism') === '2') {
                                                
                                                return ([
                                            'Laki-laki' => 'Laki-laki',
                                            'Perempuan' => 'Perempuan',
                                                    ]);

                                            }elseif ($get('ps_qism') === '3') {
                                                
                                                return ([
                                            'Laki-laki' => 'Laki-laki',
                                            'Perempuan' => 'Perempuan',
                                                    ]);

                                            }elseif ($get('ps_qism') === '4') {
                                                
                                                return ([
                                            'Laki-laki' => 'Laki-laki'
                                                    ]);

                                            }elseif ($get('ps_qism') === '5') {
                                                
                                                return ([
                                            'Perempuan' => 'Perempuan'
                                                    ]);

                                            }elseif ($get('ps_qism') === '6') {
                                                
                                                return ([
                                            'Perempuan' => 'Perempuan'
                                                    ]);

                                            }


                                            })
                                        ->required()
                                        ->live()
                                        ->inline(),

                                Select::make('ps_kelas')
                                                ->label('Kelas yang dituju')
                                                ->placeholder('Pilih Kelas')
                                                
                                                ->options(function (Get $get) {
                                                    
                                            if ($get('ps_qism') === '1' && $get('ps_jeniskelamin') === 'Laki-laki') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 1)->pluck('kelas', 'id'));

                                            }elseif ($get('ps_qism') === '1' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 2)->pluck('kelas', 'id'));

                                            }elseif ($get('ps_qism') === '2' && $get('ps_jeniskelamin') === 'Laki-laki') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 3)->pluck('kelas', 'id'));

                                            }elseif ($get('ps_qism') === '2' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 4)->pluck('kelas', 'id'));

                                            }elseif ($get('ps_qism') === '3' && $get('ps_jeniskelamin') === 'Laki-laki') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 5)->pluck('kelas', 'id'));

                                            }elseif ($get('ps_qism') === '3' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 6)->pluck('kelas', 'id'));

                                            }elseif ($get('ps_qism') === '4' && $get('ps_jeniskelamin') === 'Laki-laki') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 7)->pluck('kelas', 'id'));

                                            }elseif ($get('ps_qism') === '5' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 8)->pluck('kelas', 'id'));

                                            }elseif ($get('ps_qism') === '6' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                                return (QismDetailHasKelas::where('qism_detail_id', 9)->pluck('kelas', 'id'));

                                            }
                                        }
                                    )
                                                ->required(),

                               

                            TextInput::make('ps_kartu_keluarga')
                                ->label('Nomor KK Calon Santri')
                                ->hint('Isi sesuai KK')
                                ->hintColor('danger')
                                ->length(16)
                                ->required()
                                ->default('3295141306822004'),

                            Select::make('ps_kewarganegaraan')
                                ->label('Kewarganegaraan Calon Santri')
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
                                // ->notin(function (Get $get) {

                                //     $qismdetail = $get('ps_qism_detail');
                                    
                                //     $nik =  PesanDaftar::all()->pluck('nik', 'id')->toArray();
                                                    
                                //             if ($get('ps_qism') === '1' && $get('ps_jeniskelamin') === 'Laki-laki') {
                                //                 dd('a');
                                //                 return (PesanDaftar::all()->pluck('nik', 'id')->toArray());

                                //             }
                                               
                                //         })
                                // ->in(function (Get $get) {

                                //     $qismdetail = $get('ps_qism_detail');
                                    
                                //     $nik =  PesanDaftar::where('qism_detail_id', $qismdetail)->pluck('nik', 'id')->toArray();
                                   

                                //             if ($get('ps_qism') === '2' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                //                 return (PesanDaftar::where('qism_detail_id', 4)->pluck('nik', 'id')->toArray());

                                //             }elseif ($get('ps_qism') === '3' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                //                 return (PesanDaftar::where('qism_detail_id', 6)->pluck('nik', 'id')->toArray());

                                //             }elseif ($get('ps_qism') === '5' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                //                 return (PesanDaftar::where('qism_detail_id', 8)->pluck('nik', 'id')->toArray());

                                //             }elseif ($get('ps_qism') === '6' && $get('ps_jeniskelamin') === 'Perempuan') {
                                                
                                //                 return (PesanDaftar::where('qism_detail_id', 9)->pluck('nik', 'id')->toArray());

                                //             }else{
                                //                 return;
                                //             }
                                //         })
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
                                        ->label('KITAS Calon Santri')
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
                                        ->label('Asal Negara Calon Santri')
                                        ->required()
                                        ->default('asfasdad')
                                        ->hidden(fn (Get $get) =>
                                        $get('ps_kewarganegaraan') == 'WNI' ||
                                            $get('ps_kewarganegaraan') == ''),


                                ]),

                                TextInput::make('hp_komunikasi')
                                                ->label('No Handphone untuk menerima pengumuman melalui WA')
                                                ->helperText('Contoh: 82187782223')
                                                ->mask('82187782223')
                                                ->prefix('62')
                                                ->tel()
                                                ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                                ->required(),
                                                // ->default('08643726383'),

                        ]),

                    Step::make('2. WALISANTRI')
                        ->schema([

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                                <p class="text-2xl strong"><strong>2. DATA WALISANTRI</strong></p>
                                            </div>')),

                            
                                Section::make('AYAH KANDUNG')
                            
                                    ->schema([
                            //AYAH KANDUNG


                                    TextInput::make('pw_ak_nama_lengkap')
                                        ->label('Nama Lengkap')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->required()
                                        ->default('sdsa'),

                                        

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

                                    TextInput::make('pw_ak_nama_kunyah')
                                ->label('Nama Hijroh/Islami')
                                ->required()
                                ->default('asdafafs')
                                ->hidden(fn (Get $get) =>
                                                $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

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
                                    

                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                         <p class="text-lg strong"><strong>Kajian yang diikuti</strong></p>
                                     </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ak_status') == 'Sudah Meninggal' ||
                                            $get('pw_ak_status') == 'Tidak Diketahui' ||
                                            $get('pw_ak_status') == ''),
                                    
                                    TextArea::make('pw_ak_ustadz_kajian')
                                                ->label('Ustadz yang mengisi kajian')
                                                ->required()
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),

                                                TextArea::make('pw_ak_tempat_kajian')
                                                ->label('Tempat kajian yang diikuti')
                                                ->required()
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                    $get('pw_ak_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ak_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ak_status') == ''),


                                            ]),





                             Section::make('IBU KANDUNG')
                            
                                    ->schema([
                            //IBU KANDUNG


                                    TextInput::make('pw_ik_nama_lengkap')
                                        ->label('Nama Lengkap')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->required()
                                        ->default('sdsa'),

                                        

                                    Select::make('pw_ik_status')
                                        ->label('Status')
                                        ->placeholder('Pilih Status')
                                        ->options([
                                            'Masih Hidup' => 'Masih Hidup',
                                            'Sudah Meninggal' => 'Sudah Meninggal',
                                            'Tidak Diketahui' => 'Tidak Diketahui',
                                        ])
                                        ->required()
                                        ->live()->default('Masih Hidup'),

                                    TextInput::make('pw_ik_nama_kunyah')
                                ->label('Nama Hijroh/Islami')
                                ->required()
                                ->default('asdafafs')
                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                    Select::make('pw_ik_kewarganegaraan')
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
                                        $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),

                                    TextInput::make('pw_ik_nik')
                                        ->label('NIK')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->length(16)
                                        ->maxLength(16)
                                        ->required()
                                        ->default('3295141306822004')
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
                                                ->default('r21243')
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
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_ik_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_ik_kewarganegaraan') == '' ||
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
                                                ->default('S2')

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
                                                ->default('Nelayan')

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
                                    

                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                         <p class="text-lg strong"><strong>Kajian yang diikuti</strong></p>
                                     </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_ik_status') == 'Sudah Meninggal' ||
                                            $get('pw_ik_status') == 'Tidak Diketahui' ||
                                            $get('pw_ik_status') == ''),
                                    
                                    TextArea::make('pw_ik_ustadz_kajian')
                                                ->label('Ustadz yang mengisi kajian')
                                                ->required()
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),

                                                TextArea::make('pw_ik_tempat_kajian')
                                                ->label('Tempat kajian yang diikuti')
                                                ->required()
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                    $get('pw_ik_status') == 'Sudah Meninggal' ||
                                                    $get('pw_ik_status') == 'Tidak Diketahui' ||
                                                    $get('pw_ik_status') == ''),


                                            ]),
                                   


                        Section::make('WALI')
                        ->description('Jika ada wali, pilih "Lainnya"')
                            
                                    ->schema([
                            // WALI


                                    TextInput::make('pw_w_nama_lengkap')
                                        ->label('Nama Lengkap')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->required()
                                        ->default('sdsa'),

                                        

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

                                    TextInput::make('pw_w_nama_kunyah')
                                ->label('Nama Hijroh/Islami')
                                ->required()
                                ->default('asdafafs')
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
                                        ->default('WNI')
                                        ->live()
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_status') !== 'Lainnya'),

                                    TextInput::make('pw_w_nik')
                                        ->label('NIK')
                                        ->hint('Isi sesuai dengan KK')
                                        ->hintColor('danger')
                                        ->length(16)
                                        ->maxLength(16)
                                        ->required()
                                        ->default('3295141306822004')
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_kewarganegaraan') == 'WNA' ||
                                            $get('pw_w_kewarganegaraan') == '' ||
                                            $get('pw_w_status') !== 'Lainnya'),

                                    Grid::make(2)
                                        ->schema([

                                            TextInput::make('pw_w_asal_negara')
                                                ->label('Asal Negara')
                                                ->required()
                                                ->default('r21243')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_w_kewarganegaraan') == '' ||
                                                    $get('pw_w_status') !== 'Lainnya'),

                                            TextInput::make('pw_w_kitas')
                                                ->label('KITAS')
                                                ->hint('Nomor Izin Tinggal (KITAS)')
                                                ->hintColor('danger')
                                                ->required()
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_kewarganegaraan') == 'WNI' ||
                                                    $get('pw_w_kewarganegaraan') == '' ||
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
                                                ->default('S2')

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
                                                ->default('Nelayan')

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
                                                ->default('Tidak ada')
                                                ->hidden(fn (Get $get) =>
                                                $get('pw_w_status') !== 'Lainnya'),
                                        ]),
                                    

                                    Placeholder::make('')
                                        ->content(new HtmlString('<div class="border-b">
                                         <p class="text-lg strong"><strong>Kajian yang diikuti</strong></p>
                                     </div>'))
                                        ->hidden(fn (Get $get) =>
                                        $get('pw_w_status') !== 'Lainnya'),
                                    
                                    TextArea::make('pw_w_ustadz_kajian')
                                                ->label('Ustadz yang mengisi kajian')
                                                ->required()
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                    $get('pw_w_status') !== 'Lainnya'),

                                                TextArea::make('pw_w_tempat_kajian')
                                                ->label('Tempat kajian yang diikuti')
                                                ->required()
                                                ->default('4232')
                                                ->hidden(fn (Get $get) =>
                                                    $get('pw_w_status') !== 'Lainnya'),


                                            ]),
                            



                           


                                        






                        ]),

                    Step::make('3. CALON SANTRI')
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
                                ->label('Nama Hijroh/Islami')
                                ->required()
                                ->default('asdafafs')
                                ->default('ummu'),

                            Placeholder::make('')
                                ->content(new HtmlString('<div class="border-b">
                                            </div>')),


                            TextArea::make('ps_peng_pend_formal')
                                ->label('Pengalaman Pendidikan Formal')
                                ->required()
                                ->default('f'),

                            TextArea::make('ps_peng_pend_agama')
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



                           Grid::make(3)
                                ->schema([

                                    

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

                                    Select::make('ps_al_s_provinsi_id')
                                                ->label('Provinsi')
                                                ->placeholder('Pilih Provinsi')
                                                ->options(Provinsi::all()->pluck('provinsi', 'id'))
                                                ->required()
                                                ->live(),
                                                // ->default('11'),
                                                

                                            Select::make('ps_al_s_kabupaten_id')
                                                ->label('Kabupaten')
                                                ->placeholder('Pilih Kabupaten')
                                                ->options(fn (Get $get): Collection => Kabupaten::query()
                                                    ->where('provinsi_id', $get('ps_al_s_provinsi_id'))
                                                    ->pluck('kabupaten', 'id'))
                                                ->required()
                                                ->live(),
                                                // ->default('3'),

                                            Select::make('ps_al_s_kecamatan_id')
                                                ->label('Kecamatan')
                                                ->placeholder('Pilih Kecamatan')
                                                ->options(fn (Get $get): Collection => Kecamatan::query()
                                                    ->where('kabupaten_id', $get('ps_al_s_kabupaten_id'))
                                                    ->pluck('kecamatan', 'id'))
                                                ->required()
                                                ->live(),
                                                // ->default('42'),

                                            Select::make('ps_al_s_kelurahan_id')
                                                ->label('Kelurahan')
                                                ->placeholder('Pilih Kelurahan')
                                                ->options(fn (Get $get): Collection => Kelurahan::query()
                                                    ->where('kecamatan_id', $get('ps_al_s_kecamatan_id'))
                                                    ->pluck('kelurahan', 'id'))
                                                ->required()
                                                ->live(),
                                                // ->default('981'),

                                                TextInput::make('ps_al_s_rt')
                                        ->label('RT')
                                        ->required()
                                        ->default('3'),
                                        

                                    TextInput::make('ps_al_s_rw')
                                        ->label('RW')
                                        ->required()
                                        ->default('5'),

                                    Textarea::make('ps_al_s_alamat')
                                        ->label('Alamat')
                                        ->required()
                                        ->columnSpanFull()
                                        ->default('asdsafsad'),


                                            Select::make('ps_al_s_kodepos')
                                                ->label('Kodepos')
                                                ->disabled()
                                                ->dehydrated()
                                                ->disablePlaceholderSelection()
                                                // ->required()
                                                ->options(fn (Get $get): Collection => Kodepos::query()
                                                    ->where('kelurahan_id', $get('ps_al_s_kelurahan_id'))
                                                    ->pluck('kodepos', 'id')),

                                ]),



                            
                        ]),





                    Step::make('4. KUESIONER KEGIATAN HARIAN')
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
                                                ]),

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

                    Step::make('5. KUESIONER KESEHATAN')
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

                    Step::make('6. KUESIONER KEMAMPUAN PEMBAYARAN ADMINISTRASI')
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
                                        ->label('2. Wali harus menyertakan surat keterangan kurang mampu dari ustadz salafy setempat SERTA dari aparat pemerintah setempat, yang isinya menyatakan bhw mmg kluarga tersebut "perlu dibantu"')
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

        session()->flash('message', 'Alhamdulillah, ananda telah terdaftar sebagai calon santri');

        $this->redirect('/tn');
    }



    public function render(): View
    {
        return view('livewire.formdaftartn');
    }
}
