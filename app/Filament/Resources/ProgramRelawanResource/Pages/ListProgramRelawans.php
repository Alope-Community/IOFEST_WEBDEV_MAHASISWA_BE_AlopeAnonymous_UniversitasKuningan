<?php

namespace App\Filament\Resources\ProgramRelawanResource\Pages;

use App\Filament\Resources\ProgramRelawanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramRelawans extends ListRecords
{
    protected static string $resource = ProgramRelawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
