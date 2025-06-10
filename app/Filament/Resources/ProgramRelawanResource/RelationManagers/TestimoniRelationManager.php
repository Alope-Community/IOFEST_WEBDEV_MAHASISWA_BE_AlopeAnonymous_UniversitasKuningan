<?php

namespace App\Filament\Resources\ProgramRelawanResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class TestimoniRelationManager extends RelationManager
{
    protected static string $relationship = 'testimoniRatings';
    protected static ?string $title = 'Daftar Testimoni';
    protected static ?string $recordTitleAttribute = 'user.name';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Nama Peserta')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Textarea::make('pesan')
                ->label('Pesan Testimoni')
                ->required()
                ->maxLength(500),

            Forms\Components\TextInput::make('rating')
                ->label('Rating')
                ->numeric()
                ->minValue(1)
                ->maxValue(5)
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Peserta')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('pesan')
                    ->label('Pesan')
                    ->limit(50),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Testimoni'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
