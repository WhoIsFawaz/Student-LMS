<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\University;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UniversityResource\Pages;
use App\Filament\Resources\UniversityResource\RelationManagers;

class UniversityResource extends Resource
{
    protected static ?string $model = University::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'University';
    protected static ?string $pluralLabel = 'University';
    protected static ?string $label = 'University';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('University Details')
                    ->schema([
                        Forms\Components\TextInput::make('university_name')
                            ->required()
                            ->label('University Name'),
                        Forms\Components\TextInput::make('domain')
                            ->required()
                            ->label('Domain')
                            ->url(),
                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('logos')
                            ->disk('public'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('university_name')->label('University Name'),
                Tables\Columns\TextColumn::make('domain')
                    ->label('Domain')
                    ->url(fn($record) => $record->domain), // Provide the URL here
                Tables\Columns\ImageColumn::make('logo')->label('Logo'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUniversities::route('/'),            
        ];
    }
}