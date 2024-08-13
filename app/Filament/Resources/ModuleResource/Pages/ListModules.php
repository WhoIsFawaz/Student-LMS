<?php

namespace App\Filament\Resources\ModuleResource\Pages;

use Filament\Actions;
use App\Imports\ModulesImport;
use Filament\Pages\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ModuleResource;

class ListModules extends ListRecords
{
    protected static string $resource = ModuleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('importModules')
                ->label('Import Modules')
                ->color('danger')
                ->icon('heroicon-o-document-arrow-down')
                ->form([
                    FileUpload::make('attachment'),
                    
                ])
                ->action(function(array $data){
                    $file = public_path('storage/'.$data['attachment']);

                    Excel::import(new ModulesImport, $file);

                    Notification::make()
                        ->title('Modules Imported')
                        ->success()
                        ->send();
                })

        ];
    }
}
