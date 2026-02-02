<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Enums\RepeatFrequency;
use Modules\Meetup\Models\Event;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    // Le proprietà navigationIcon, navigationLabel, modelLabel, pluralModelLabel
    // sono gestite automaticamente da XotBaseResource tramite traduzioni

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'main_tabs' => Tabs::make('Event Configuration')
                ->tabs([
                    'general' => Tab::make('General Info')
                        ->schema([
                            'title' => TextInput::make('title')
                                ->required()
                                ->maxLength(255),
                            'description' => Textarea::make('description')
                                ->maxLength(65535)
                                ->columnSpanFull(),
                            'url' => TextInput::make('url')
                                ->url()
                                ->maxLength(255),
                            'cover_image' => FileUpload::make('cover_image')
                                ->image()
                                ->directory('events/covers'),
                            'keywords' => Select::make('keywords')
                                ->multiple()
                                ->searchable()
                                ->placeholder('Add keywords...')
                                ->options([
                                    'Laravel' => 'Laravel',
                                    'Pizza' => 'Pizza',
                                    'Gourmet' => 'Gourmet',
                                    'Tech' => 'Tech',
                                    'Social' => 'Social',
                                ]),
                        ]),
                    'datetime' => Tab::make('Date & Time')
                        ->schema([
                            'grid' => Grid::make(2)
                                ->schema([
                                    'start_date' => DateTimePicker::make('start_date')
                                        ->required(),
                                    'end_date' => DateTimePicker::make('end_date')
                                        ->required(),
                                    'door_time' => DateTimePicker::make('door_time'),
                                    'duration' => TextInput::make('duration')
                                        ->placeholder('PT2H (ISO 8601)'),
                                    'in_language' => TextInput::make('in_language')
                                        ->default('it')
                                        ->maxLength(5),
                                ]),
                        ]),
                    'location' => Tab::make('Location')
                        ->schema([
                            'event_attendance_mode' => Select::make('event_attendance_mode')
                                ->options(EventAttendanceMode::class)
                                ->required(),
                            'location' => TextInput::make('location')
                                ->required()
                                ->maxLength(255),
                            'location_id' => Select::make('location_id')
                                ->relationship('venue', 'formatted_address')
                                ->searchable()
                                ->preload(),
                        ]),
                    'schedule' => Tab::make('Recurring')
                        ->schema([
                            'repeat_frequency' => Select::make('repeat_frequency')
                                ->options(RepeatFrequency::class)
                                ->nullable(),
                            'repeat_days' => CheckboxList::make('repeat_days')
                                ->options([
                                    'Monday' => 'Monday',
                                    'Tuesday' => 'Tuesday',
                                    'Wednesday' => 'Wednesday',
                                    'Thursday' => 'Thursday',
                                    'Friday' => 'Friday',
                                    'Saturday' => 'Saturday',
                                    'Sunday' => 'Sunday',
                                ])
                                ->columns(4),
                            'repeat_count' => TextInput::make('repeat_count')
                                ->numeric(),
                            'schedule_end_date' => DateTimePicker::make('schedule_end_date'),
                            'schedule_timezone' => TextInput::make('schedule_timezone')
                                ->default('Europe/Rome'),
                        ]),
                    'status' => Tab::make('Status & Organizer')
                        ->schema([
                            'status' => Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                    'cancelled' => 'Cancelled',
                                ])
                                ->default('draft')
                                ->required(),
                            'event_status' => Select::make('event_status')
                                ->options(EventStatus::class)
                                ->required(),
                            'organizer_id' => Select::make('organizer_id')
                                ->relationship('organizer', 'name')
                                ->searchable()
                                ->preload(),
                        ]),
                    'capacity' => Tab::make('Capacity & Pricing')
                        ->schema([
                            'is_accessible_for_free' => Toggle::make('is_accessible_for_free')
                                ->default(true),
                            'attendees_count' => TextInput::make('attendees_count')
                                ->numeric()
                                ->default(0),
                            'max_attendees' => TextInput::make('max_attendees')
                                ->numeric()
                                ->default(100),
                            'offers' => Repeater::make('offers')
                                ->schema([
                                    'type' => Select::make('@type')->default('Offer')->options(['Offer' => 'Offer']),
                                    'price' => TextInput::make('price')->numeric()->required(),
                                    'priceCurrency' => TextInput::make('priceCurrency')->default('EUR')->required(),
                                    'availability' => Select::make('availability')
                                        ->options([
                                            'https://schema.org/InStock' => 'In Stock',
                                            'https://schema.org/SoldOut' => 'Sold Out',
                                        ])
                                        ->default('https://schema.org/InStock'),
                                ])
                                ->columnSpanFull(),
                        ]),
                ])
                ->columnSpanFull(),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('event_status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_attendance_mode')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('attendees_count')
                    ->label('Att.')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_attendees')
                    ->label('Max')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_accessible_for_free')
                    ->label('Free')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event_status')
                    ->options(EventStatus::class),
                Tables\Filters\SelectFilter::make('event_attendance_mode')
                    ->options(EventAttendanceMode::class),
                Tables\Filters\TernaryFilter::make('is_accessible_for_free'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    // getPages() gestito automaticamente da XotBaseResource
}
