<?php

namespace App\Filament\Resources\ProgramRelawanResource\RelationManagers;

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
                ->label('Nama Peserta')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Peserta'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Bergabung'),
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
