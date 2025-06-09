<?php

namespace App\Filament\Resources\ForumDiskusiResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class KomentarsRelationManager extends RelationManager
{
    protected static string $relationship = 'komentars';
    protected static ?string $title = 'Komentar';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Nama Peserta')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
            Forms\Components\Textarea::make('komentar')
                ->required()
                ->columnSpanFull(),
            Forms\Components\DateTimePicker::make('tanggal_komentar')
                    ->required()
                    ->default(now()),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('komentar')
                    ->label('Komentar'),
                Tables\Columns\TextColumn::make('tanggal_komentar')
                    ->dateTime()
                    ->label('Tanggal Komentar'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
