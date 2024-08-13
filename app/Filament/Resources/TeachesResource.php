<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Module;
use App\Models\Teaches;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TeachesResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TeachesResource\RelationManagers;

class TeachesResource extends Resource
{
    protected static ?string $model = Teaches::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::where('user_type', 'professor')
                        ->get()
                        ->mapWithKeys(function ($user) {
                            return [$user->user_id => $user->first_name . ' ' . $user->last_name];
                        })
                        ->toArray())
                    ->searchable()
                    ->required(),
                Select::make('module_id')
                    ->label('Module')
                    ->options(Module::all()->pluck('module_name', 'module_id')->toArray())
                    ->searchable()
                    ->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Professor Name')->searchable(),
                TextColumn::make('module.module_name')->label('Module Name')->searchable(),
            ])
            ->filters([Tables\Filters\SelectFilter::make('module_id')->relationship('module', 'module_name')->label('Module')])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTeaches::route('/'),
            'create' => Pages\CreateTeaches::route('/create'),
            'edit' => Pages\EditTeaches::route('/{record}/edit'),
        ];
    }
}
