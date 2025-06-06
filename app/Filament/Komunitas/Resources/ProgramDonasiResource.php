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
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('program_id')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('metode_pembayaran')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('tanggal')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProgramDonasis::route('/'),
            'create' => Pages\CreateProgramDonasi::route('/create'),
            'edit' => Pages\EditProgramDonasi::route('/{record}/edit'),
        ];
    }
}
