<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForumDiskusiResource\Pages;
use App\Filament\Resources\ForumDiskusiResource\RelationManagers;
use App\Models\ForumDiskusi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ForumDiskusiResource\RelationManagers\KomentarsRelationManager;

class ForumDiskusiResource extends Resource
{
    protected static ?string $model = ForumDiskusi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
        protected static ?string $navigationLabel = 'Forum Diskusi';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('judul')
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
                Forms\Components\DateTimePicker::make('tanggal_dibuat')
                    ->required()
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penulis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_dibuat')
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
            KomentarsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForumDiskusis::route('/'),
            'create' => Pages\CreateForumDiskusi::route('/create'),
            'edit' => Pages\EditForumDiskusi::route('/{record}/edit'),
        ];
    }
}
