<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankSampahResource\Pages;
use App\Filament\Resources\BankSampahResource\RelationManagers;
use App\Models\BankSampah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankSampahResource extends Resource
{
    protected static ?string $model = BankSampah::class;
    protected static ?string $navigationGroup = 'Eco Loop';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    public static function getNavigationLabel(): string
    {
        return 'Bank Sampah';
    }

    public static function getSlug(): string
    {
        return 'bank-sampah';
    }

    public static function getPluralLabel(): string
    {
        return 'Bank Sampah';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama Bank Sampah')
                ->required(),

            Textarea::make('alamat')
                ->label('Alamat')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->copyable()
                    ->copyMessage('ID disalin!')
                    ->tooltip('Copy')
                    ->icon('heroicon-o-clipboard')
                    ->copyMessageDuration(1500)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nama')->label('Nama Bank Sampah')->searchable(),
                TextColumn::make('alamat')->label('Alamat'),
            ])
            ->filters([
                //
            ])
            ->recordUrl(null)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn() => auth()->user()->can('delete customers')),
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
            'index' => Pages\ListBankSampahs::route('/'),
            'create' => Pages\CreateBankSampah::route('/create'),
            'edit' => Pages\EditBankSampah::route('/{record}/edit'),
        ];
    }
}
