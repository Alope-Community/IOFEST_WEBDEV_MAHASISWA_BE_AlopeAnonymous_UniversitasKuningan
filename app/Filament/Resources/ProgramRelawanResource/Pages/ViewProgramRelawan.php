<?php

namespace App\Filament\Resources\ProgramRelawanResource\Pages;

use App\Filament\Resources\ProgramRelawanResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\Concerns\HasRelationManagers;

class ViewProgramRelawan extends ViewRecord
{
    use HasRelationManagers;

    protected static string $resource = ProgramRelawanResource::class;
}
