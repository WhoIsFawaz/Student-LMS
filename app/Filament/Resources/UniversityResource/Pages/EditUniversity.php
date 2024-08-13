<?php

namespace App\Filament\Resources\UniversityResource\Pages;

use Filament\Actions;
use App\Models\University;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\UniversityResource;

class EditUniversity extends EditRecord
{
    protected static string $resource = UniversityResource::class;

    protected static ?string $title = 'Edit University';

    public function mount($record = null): void
    {
        $university = University::first();
        
        if ($university) {
            $record = $university->getKey();
        } else {
            $record = $this->newRecord();
        }

        parent::mount($record);
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record instanceof University) {
            return $data;
        }

        if (University::exists()) {
            abort(403, 'University record already exists.');
        }

        return $data;
    }
}