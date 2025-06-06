<?php

namespace App\Filament\Komunitas\Resources\ProgramRelawanResource\Pages;

use App\Filament\Komunitas\Resources\ProgramRelawanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProgramRelawan extends EditRecord
{
    protected static string $resource = ProgramRelawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
