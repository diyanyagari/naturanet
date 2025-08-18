<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokumenResource\Pages;
use App\Models\Dokumen;
use Cloudinary\Cloudinary;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;

class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';
    protected static ?string $navigationGroup = 'Berkas';
    protected static ?string $navigationLabel = 'Dokumen';
    protected static ?string $pluralLabel = 'Dokumen';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->label('Nama Dokumen')
                ->required()
                ->maxLength(150),

            FileUpload::make('pdf')
                ->label('Upload PDF')
                ->acceptedFileTypes(['application/pdf'])
                ->maxSize(10240)
                ->disk('public')
                ->directory('tmp/docs')
                ->preserveFilenames()
                ->required(fn (string $context) => $context === 'create'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('format')
                    ->label('Tipe')
                    ->default('pdf'),

                Tables\Columns\TextColumn::make('ukuran')
                    ->label('Ukuran')
                    ->formatStateUsing(function ($state) {
                        return $state ? number_format($state / 1024 / 1024, 2) . ' MB' : '-';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Dibuat'),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('primary')
                    ->url(fn (Dokumen $record) => $record->secure_url)
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make()
                    ->before(function (Dokumen $record) {
                        if ($record->public_id) {
                            $cloud = new Cloudinary();
                            $cloud->uploadApi()->destroy($record->public_id, ['resource_type' => 'raw']);
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDokumens::route('/'),
            'create' => Pages\CreateDokumen::route('/create'),
            'edit'   => Pages\EditDokumen::route('/{record}/edit'),
        ];
    }
}
