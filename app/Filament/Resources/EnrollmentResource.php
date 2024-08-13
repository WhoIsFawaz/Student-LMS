<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Student;
use App\Models\User;
use App\Models\Module;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('user_id')
            ->label('User')
            ->options(User::where('user_type', 'student')
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
            DatePicker::make('enrollment_date')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Student Name')->searchable(),
                TextColumn::make('module.module_name')->label('Module Name')->searchable(),
                TextColumn::make('enrollment_date')->label('Enrollment Date')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('module_id')
                    ->relationship('module', 'module_name')
                    ->label('Module')
            ])
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
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
