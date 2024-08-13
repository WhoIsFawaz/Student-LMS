<?php

namespace App\Filament\Resources\TeachesResource\Pages;

use App\Filament\Resources\TeachesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeaches extends EditRecord
{
    protected static string $resource = TeachesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
