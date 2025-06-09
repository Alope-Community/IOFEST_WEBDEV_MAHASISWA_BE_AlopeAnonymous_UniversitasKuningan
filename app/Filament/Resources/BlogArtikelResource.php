<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogArtikelResource\Pages;
use App\Filament\Resources\BlogArtikelResource\RelationManagers;
use App\Models\BlogArtikel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;

class BlogArtikelResource extends Resource
{
    protected static ?string $model = BlogArtikel::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';
    protected static ?string $navigationLabel = 'Artikel';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
    return $form
        ->schema([
            Forms\Components\TextInput::make('judul')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('lokasi')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('konten')
                ->required()
                ->columnSpanFull(),

            Forms\Components\Select::make('user_id')
                ->label('User')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\DateTimePicker::make('tanggal_diterbitkan')
                ->required()
                ->default(now()),

            Forms\Components\FileUpload::make('gambar')
                ->image()
                ->directory('image/artikel')
                ->imagePreviewHeight('150')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public')
                    ->circular()
                    ->size(50),

                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),

                Tables\Columns\TextColumn::make('lokasi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penulis')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_diterbitkan')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogArtikels::route('/'),
            'create' => Pages\CreateBlogArtikel::route('/create'),
            'edit' => Pages\EditBlogArtikel::route('/{record}/edit'),
        ];
    }
}
