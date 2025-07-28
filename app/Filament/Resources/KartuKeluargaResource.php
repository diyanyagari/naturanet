<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KartuKeluargaResource\Pages;
use App\Models\KartuKeluarga;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class KartuKeluargaResource extends Resource
{
    protected static ?string $model = KartuKeluarga::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Kartu Keluarga';
    protected static ?string $navigationGroup = 'Eco Loop';

    public static function getNavigationLabel(): string
    {
        return 'Kartu Keluarga';
    }

    public static function getModelLabel(): string
    {
        return 'Kartu Keluarga';
    }

    public static function getSlug(): string
    {
        return 'kartu-keluarga';
    }

    public static function getPluralLabel(): string
    {
        return 'Kartu Keluarga';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('no_kk')->required()->unique(ignoreRecord: true),

            Select::make('kepala_keluarga_id')
                ->label('Kepala Keluarga')
                ->options(function () {
                    $sudahJadiKepala = KartuKeluarga::query()->pluck('kepala_keluarga_id')->toArray();

                    $sudahJadiAnggota = \DB::table('kartu_keluarga_anggota')->pluck('customer_id')->toArray();

                    $excludedIds = array_unique(array_merge(
                        $sudahJadiKepala,
                        $sudahJadiAnggota,
                    ));

                    return Customer::query()
                        ->where('jenis_customer', 'warga')
                        ->whereNotIn('uuid', $excludedIds)
                        ->pluck('name', 'uuid');
                })
                ->getOptionLabelUsing(function ($value) {
                    return Customer::find($value)?->name ?? $value;
                })
                ->searchable()
                ->nullable(),

            Repeater::make('anggota')
                ->label('Anggota Keluarga')
                ->live()
                ->afterStateHydrated(function (\Filament\Forms\Set $set, $state, $record) {
                    if ($record && $record->anggota) {
                        $set('anggota', $record->anggota->map(fn($item) => [
                            'customer_id' => $item->uuid,
                            'hubungan' => $item->pivot->hubungan,
                        ])->toArray());
                    }
                })
                ->schema([
                    Select::make('customer_id')
                        ->label('Anggota')
                        ->options(function (callable $get) {
                            $kepalaKeluargaId = $get('../../kepala_keluarga_id');
                            $anggota = collect($get('../../anggota') ?? []);
                            $selectedIdsInForm = $anggota->pluck('customer_id')->filter()->all();

                            $sudahJadiKepala = KartuKeluarga::query()->pluck('kepala_keluarga_id')->toArray();

                            $sudahJadiAnggota = \DB::table('kartu_keluarga_anggota')->pluck('customer_id')->toArray();

                            $excludedIds = array_unique(array_merge(
                                $sudahJadiKepala,
                                $sudahJadiAnggota,
                                $selectedIdsInForm,
                                [$kepalaKeluargaId]
                            ));

                            return Customer::query()
                                ->where('jenis_customer', 'warga')
                                ->whereNotIn('uuid', $excludedIds)
                                ->pluck('name', 'uuid');
                        })
                        ->getOptionLabelUsing(function ($value) {
                            return Customer::find($value)?->name ?? $value;
                        })
                        ->searchable()
                        ->required()
                        ->preload(),

                    Select::make('hubungan')
                        ->options([
                            'ayah' => 'Ayah',
                            'ibu' => 'Ibu',
                            'anak' => 'Anak',
                            'saudara' => 'Saudara',
                            'lainnya' => 'Lainnya',
                        ])
                        ->required(),
                ])
                ->createItemButtonLabel('Tambah Anggota')
                ->minItems(1)
                ->columnSpan('full'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_kk')
                    ->label('No. KK')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kepalaKeluarga.name')
                    ->label('Kepala Keluarga')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('anggota_count')
                    ->label('Jumlah Anggota')
                    ->counts('anggota'), // fitur bawaan Filament
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn() => auth()->user()->can('delete kartu-keluarga')),
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
            'index' => Pages\ListKartuKeluargas::route('/'),
            'create' => Pages\CreateKartuKeluarga::route('/create'),
            'edit' => Pages\EditKartuKeluarga::route('/{record}/edit'),
        ];
    }
}
