<?php

namespace App\Filament\Resources\ProgramDonasiResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class PesertasRelationManager extends RelationManager
{
    protected static string $relationship = 'pesertas';

    protected static ?string $title = 'Daftar Peserta';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Donatur')
                ->relationship('user', 'name')
                ->required()
                ->searchable(),
            Forms\Components\TextInput::make('nominal')
                ->label('Nominal Donasi')
                ->numeric()
                ->required(),
            Forms\Components\Textarea::make('ucapan')
                ->label('Ucapan')
                ->rows(2)
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Donatur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->label('Nominal')
                    ->money('IDR', true),
                Tables\Columns\TextColumn::make('ucapan')
                    ->label('Ucapan')
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i'),
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
