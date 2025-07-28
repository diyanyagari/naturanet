<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;
use App\Traits\HasFilamentPermissions;


class UserResource extends Resource
{
    use HasFilamentPermissions;
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'User Management';

    protected static function getResourceName(): string
    {
        return 'users';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255)
                    ->unique(User::class, 'username')
                    ->autocomplete('new-username')
                    ->extraAttributes(['aria-autocomplete' => 'none']),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn(string $context) => $context === 'create')
                    ->dehydrated(fn($state) => filled($state))
                    ->dehydrateStateUsing(fn($state) => \Hash::make($state))
                    ->maxLength(255)
                    ->autocomplete('new-password')
                    ->extraAttributes(['aria-autocomplete' => 'none']),

                // 👉 Place the role dropdown here
                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->options(Role::where('name', '!=', 'superadmin')->pluck('name', 'name'))
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('username')->label('Username')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->getStateUsing(fn($record) => $record->roles
                        ->where('name', '!=', 'superadmin')
                        ->pluck('name')->join(', '))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime()->sortable(),
            ])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->beforeFormFilled(function ($record, $action) {
                        if ($record->hasRole('superadmin')) {
                            \Filament\Notifications\Notification::make()
                                ->title('Tidak bisa edit.')
                                ->danger()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('delete users')),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'superadmin');
            });
    }
}
