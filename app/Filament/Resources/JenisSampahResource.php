<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisSampahResource\Pages;
use App\Filament\Resources\JenisSampahResource\RelationManagers;
use App\Models\JenisSampah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisSampahResource extends Resource
{
    protected static ?string $model = JenisSampah::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Eco Loop';
    public static function getSlug(): string
    {
        return 'jenis-sampah';
    }

    public static function getPluralLabel(): string
    {
        return 'Jenis Sampah';
    }


    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Nama Jenis Sampah'),

            TextInput::make('point_per_kg')
                ->numeric()
                ->required()
                ->label('Point per Kg'),

            Toggle::make('active')
                ->label('Aktif')
                ->hidden()
                ->default(true),

            Textarea::make('description')
                ->label('Deskripsi')
                ->rows(2),

            TextInput::make('icon')
                ->label('Icon (emoji atau nama file)')
                ->maxLength(50),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Jenis'),
                TextColumn::make('point_per_kg')->label('Point/kg'),
                // IconColumn::make('active')->boolean()->label('Aktif'),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Aktif')
                    ->sortable(),
                TextColumn::make('description')->limit(30),
                TextColumn::make('icon')->label('Icon'),
            ])
            ->filters([
                // Tambahkan filter jika perlu
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->visible(fn() => auth()->user()->can('delete jenis-sampah')),
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
            'index' => Pages\ListJenisSampahs::route('/'),
            'create' => Pages\CreateJenisSampah::route('/create'),
            'edit' => Pages\EditJenisSampah::route('/{record}/edit'),
        ];
    }
}
