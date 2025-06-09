<?php

namespace App\Filament\Komunitas\Resources\ProgramDonasiResource\Pages;

use App\Filament\Komunitas\Resources\ProgramDonasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProgramDonasis extends ListRecords
{
    protected static string $resource = ProgramDonasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
