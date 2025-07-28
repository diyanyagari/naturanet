<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Traits\HasFilamentPermissions;

class CustomerResource extends Resource
{
    use HasFilamentPermissions;
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Customers';
    protected static ?string $navigationGroup = 'Public Services';

    protected static function getResourceName(): string
    {
        return 'customers';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('username')
                ->label('Username')
                ->required()
                ->autocomplete('new-username')
                ->extraAttributes(['aria-autocomplete' => 'none'])
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('jenis_customer')
                ->label('Jenis Customer')
                ->required(),

            Forms\Components\TextInput::make('nik')
                ->label('NIK')
                ->maxLength(20)
                ->nullable(),

            Forms\Components\TextInput::make('name')
                ->label('Nama')
                ->required(),

            Forms\Components\TextInput::make('no_kk')
                ->label('No KK')
                ->nullable(),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->autocomplete('new-password')
                ->extraAttributes(['aria-autocomplete' => 'none'])
                ->dehydrateStateUsing(fn($state) => bcrypt($state))
                ->required(fn(string $context): bool => $context === 'create')
                ->dehydrated(fn($state) => filled($state))
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('jenis_customer'),
                Tables\Columns\TextColumn::make('nik'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('no_kk'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->visible(fn () => auth()->user()->can('delete customers')),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
