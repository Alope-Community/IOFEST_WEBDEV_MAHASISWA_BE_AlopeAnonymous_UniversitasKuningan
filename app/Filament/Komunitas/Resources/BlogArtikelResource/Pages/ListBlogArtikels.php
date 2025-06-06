<?php

namespace App\Filament\Komunitas\Resources\BlogArtikelResource\Pages;

use App\Filament\Komunitas\Resources\BlogArtikelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlogArtikels extends ListRecords
{
    protected static string $resource = BlogArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
