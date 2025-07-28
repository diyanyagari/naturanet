<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Traits\HasFilamentPermissions;

class PermissionResource extends Resource
{
    use HasFilamentPermissions;
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Permissions';
    protected static ?string $navigationGroup = 'User Management';

    protected static function getResourceName(): string
    {
        return 'permissions';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Permission Name')
                    ->required()
                    ->unique(Permission::class, 'name', ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->columns([
            //     Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            //     Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Created')->sortable(),
            // ])
            // ->filters([
            //     //
            // ])
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            // ])
            // ->bulkActions([
            //     Tables\Actions\DeleteBulkAction::make()->visible(fn () => auth()->user()->can('delete permissions')),
            // ]);
            ->query(
                fn(Builder $query) => $query->selectRaw("*, SUBSTRING_INDEX(name, '-', -1) as group_key")
            )
            ->groups([
                Tables\Grouping\Group::make('group_key')
                    ->label('Group')
                    ->getTitleFromRecordUsing(fn($record) => ucfirst($record->group_key)),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Permission Name'),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime(),
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
