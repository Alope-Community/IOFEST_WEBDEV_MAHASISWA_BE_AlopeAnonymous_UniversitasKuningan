<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramRelawanResource\Pages;
use App\Filament\Resources\ProgramRelawanResource\RelationManagers;
use App\Models\ProgramRelawan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use App\Filament\Resources\ProgramRelawanResource\RelationManagers\PesertasRelationManager;
use App\Filament\Resources\ProgramRelawanResource\RelationManagers\TestimoniRelationManager;

class ProgramRelawanResource extends Resource
{
    protected static ?string $model = ProgramRelawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationLabel = 'Program Relawan';
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
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_selesai')
                    ->required(),
                Forms\Components\TextInput::make('kontak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->required()
                    ->directory('image/relawan')
                    ->imagePreviewHeight('250')
                    ->maxSize(1024),
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
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Dibuat Oleh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')->date()->sortable(),
                Tables\Columns\TextColumn::make('tanggal_selesai')->date()->sortable(),
                Tables\Columns\TextColumn::make('kontak')->searchable(),
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

    public static function getRelations(): array
    {
        return [
            PesertasRelationManager::class,
            TestimoniRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProgramRelawans::route('/'),
            'create' => Pages\CreateProgramRelawan::route('/create'),
            'edit' => Pages\EditProgramRelawan::route('/{record}/edit'),
            'view' => Pages\ViewProgramRelawan::route('/{record}'),
        ];
    }
}
