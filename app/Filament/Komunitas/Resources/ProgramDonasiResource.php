<?php

namespace App\Filament\Komunitas\Resources;

use App\Filament\Komunitas\Resources\ProgramDonasiResource\Pages;
use App\Filament\Komunitas\Resources\ProgramDonasiResource\RelationManagers;
use App\Models\ProgramDonasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProgramDonasiResource\RelationManagers\PesertasRelationManager;

class ProgramDonasiResource extends Resource
{
    protected static ?string $model = ProgramDonasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift-top';
    protected static ?string $navigationLabel = 'Program Donasi';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_program')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('category')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Belum Mulai' => 'Belum Mulai',
                        'Berlangsung' => 'Berlangsung',
                        'Selesai' => 'Selesai',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('kontak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_selesai')
                    ->required(),
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => auth()->id()),
                Forms\Components\FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->required()
                    ->directory('image/donasi')
                    ->imagePreviewHeight('250')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular()
                    ->size(60)
                    ->disk('public')
                    ->visibility('public')
                    ->url(fn ($record) => asset('storage/' . $record->gambar)),
                Tables\Columns\TextColumn::make('nama_program')->searchable(),
                Tables\Columns\TextColumn::make('category')->searchable(),
                Tables\Columns\TextColumn::make('status')->searchable(),
                Tables\Columns\TextColumn::make('kontak')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')->date()->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')->date()->sortable(),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function getRelations(): array
    {
        return [
            PesertasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProgramDonasis::route('/'),
            'create' => Pages\CreateProgramDonasi::route('/create'),
            'edit' => Pages\EditProgramDonasi::route('/{record}/edit'),
        ];
    }
}
