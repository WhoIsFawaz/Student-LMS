<?php

namespace App\Filament\Resources\TeachesResource\Pages;

use App\Filament\Resources\TeachesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeaches extends ListRecords
{
    protected static string $resource = TeachesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
