<?php

namespace App\Filament\Resources\BlogArtikelResource\Pages;

use App\Filament\Resources\BlogArtikelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlogArtikel extends EditRecord
{
    protected static string $resource = BlogArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
