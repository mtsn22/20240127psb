<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SantriResource\Pages;
use App\Filament\Resources\SantriResource\RelationManagers;
use App\Models\Santri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SantriResource extends Resource
{
    protected static ?string $model = Santri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('walisantri_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nism')
                    ->maxLength(255),
                Forms\Components\TextInput::make('belum_nism')
                    ->maxLength(10),
                Forms\Components\TextInput::make('nama_lengkap')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahap')
                    ->maxLength(20),
                Forms\Components\TextInput::make('jenispendaftar')
                    ->maxLength(20),
                Forms\Components\TextInput::make('kartu_keluarga_sama')
                    ->maxLength(50),
                Forms\Components\TextInput::make('nama_panggilan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nisn')
                    ->maxLength(255),
                Forms\Components\TextInput::make('belum_nisn')
                    ->maxLength(50),
                Forms\Components\TextInput::make('kewarganegaraan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('asal_negara')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kitas')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(255),
                Forms\Components\TextInput::make('belum_punya_nik')
                    ->maxLength(10),
                Forms\Components\TextInput::make('jeniskelamin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tanggal_lahir')
                    ->maxLength(50),
                Forms\Components\TextInput::make('umur')
                    ->maxLength(50),
                Forms\Components\TextInput::make('agama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cita_cita')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cita_cita_lainnya')
                    ->maxLength(255),
                Forms\Components\TextInput::make('anak_ke')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_saudara')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tdk_hp')
                    ->maxLength(10),
                Forms\Components\TextInput::make('nomor_handphone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('akun_medsos')
                    ->maxLength(255),
                Forms\Components\TextInput::make('akun_medsos_aktif')
                    ->maxLength(10),
                Forms\Components\TextInput::make('hobi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('hobi_lainnya')
                    ->maxLength(255),
                Forms\Components\TextInput::make('aktivitaspend')
                    ->maxLength(255),
                Forms\Components\TextInput::make('peng_pend_agama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('peng_pend_formal')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bya_sklh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bya_sklh_lainnya')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_mampu')
                    ->maxLength(255),
                Forms\Components\TextInput::make('rincian_status_mampu')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mendaftar_keinginan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('keb_khus')
                    ->maxLength(255),
                Forms\Components\TextInput::make('keb_khus_lainnya')
                    ->maxLength(255),
                Forms\Components\TextInput::make('keb_dis')
                    ->maxLength(255),
                Forms\Components\TextInput::make('keb_dis_lainnya')
                    ->maxLength(255),
                Forms\Components\TextInput::make('peny_fisik')
                    ->maxLength(255),
                Forms\Components\TextInput::make('peny_non_fisik')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_kip')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_kip_memiliki')
                    ->maxLength(10),
                Forms\Components\TextInput::make('kartu_keluarga')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_kpl_kel')
                    ->maxLength(255),
                Forms\Components\TextInput::make('file_kip')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_status_mukim')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_stts_tptgl')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_provinsi_id')
                    ->numeric(),
                Forms\Components\TextInput::make('al_s_kabupaten_id')
                    ->numeric(),
                Forms\Components\TextInput::make('al_s_kecamatan_id')
                    ->numeric(),
                Forms\Components\TextInput::make('al_s_kelurahan_id')
                    ->numeric(),
                Forms\Components\TextInput::make('al_s_rt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_rw')
                    ->maxLength(255),
                Forms\Components\Textarea::make('al_s_alamat')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('al_s_kodepos')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_jarak')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_transportasi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_waktu_tempuh')
                    ->maxLength(255),
                Forms\Components\TextInput::make('al_s_koordinat')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('walisantri_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nism')
                    ->searchable(),
                Tables\Columns\TextColumn::make('belum_nism')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenispendaftar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kartu_keluarga_sama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_panggilan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('belum_nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kewarganegaraan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asal_negara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('belum_punya_nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jeniskelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('umur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cita_cita')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cita_cita_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anak_ke')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_saudara')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tdk_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_handphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('akun_medsos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('akun_medsos_aktif')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hobi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hobi_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('aktivitaspend')
                    ->searchable(),
                Tables\Columns\TextColumn::make('peng_pend_agama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('peng_pend_formal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bya_sklh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bya_sklh_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_mampu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rincian_status_mampu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mendaftar_keinginan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keb_khus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keb_khus_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keb_dis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('keb_dis_lainnya')
                    ->searchable(),
                Tables\Columns\TextColumn::make('peny_fisik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('peny_non_fisik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_kip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_kip_memiliki')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kartu_keluarga')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_kpl_kel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_kip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_status_mukim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_stts_tptgl')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_provinsi_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_s_kabupaten_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_s_kecamatan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_s_kelurahan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('al_s_rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_kodepos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_jarak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_transportasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_waktu_tempuh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('al_s_koordinat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSantris::route('/'),
            'create' => Pages\CreateSantri::route('/create'),
            'view' => Pages\ViewSantri::route('/{record}'),
            'edit' => Pages\EditSantri::route('/{record}/edit'),
        ];
    }
}
