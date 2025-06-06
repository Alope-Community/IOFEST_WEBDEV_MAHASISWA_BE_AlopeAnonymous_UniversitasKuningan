<?php

namespace App\Filament\Resources\ForumDiskusiResource\Pages;

use App\Filament\Resources\ForumDiskusiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListForumDiskusis extends ListRecords
{
    protected static string $resource = ForumDiskusiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
