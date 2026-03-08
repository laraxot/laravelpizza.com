<?php

namespace Modules\EventOrganizer\App\Filament\Resources;

use Modules\EventOrganizer\App\Models\EventOrganizer;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;

class EventOrganizerResource extends Resource
{
    protected static ?string $model = EventOrganizer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Event Management';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('organization')
                    ->searchable(),
                TextColumn::make('event.name')
                    ->label('Event')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteAction::make(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->maxLength(20),
                TextInput::make('organization')
                    ->maxLength(255),
                TextInput::make('website')
                    ->url()
                    ->maxLength(255),
                Textarea::make('description')
                    ->maxLength(65535),
                Select::make('event_id')
                    ->relationship('event', 'name')
                    ->nullable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \Modules\EventOrganizer\App\Filament\Resources\Pages\ListEventOrganizers::route('/'),
            'create' => \Modules\EventOrganizer\App\Filament\Resources\Pages\CreateEventOrganizer::route('/create'),
            'edit' => \Modules\EventOrganizer\App\Filament\Resources\Pages\EditEventOrganizer::route('/{record}/edit'),
        ];
    }
}