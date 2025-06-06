<?php

namespace App\Filament\Resources\ForumDiskusiResource\Pages;

use App\Filament\Resources\ForumDiskusiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForumDiskusi extends EditRecord
{
    protected static string $resource = ForumDiskusiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
