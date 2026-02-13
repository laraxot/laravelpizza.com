<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Tables;
use Filament\Tables\Table;
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
            'event_details' => Section::make('Event Details')
                ->schema([
                    'title' => TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    'description' => Textarea::make('description')
                        ->maxLength(65535)
                        ->columnSpanFull(),
                    'start_date' => DateTimePicker::make('start_date')
                        ->required(),
                    'end_date' => DateTimePicker::make('end_date')
                        ->required(),
                    'location' => TextInput::make('location')
                        ->required()
                        ->maxLength(255),
                    'status' => Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'cancelled' => 'Cancelled',
                        ])
                        ->default('draft')
                        ->required(),
                    'attendees_count' => TextInput::make('attendees_count')
                        ->numeric()
                        ->default(0),
                    'max_attendees' => TextInput::make('max_attendees')
                        ->numeric()
                        ->default(100),
                    'cover_image' => FileUpload::make('cover_image')
                        ->image(),
                ])
                ->columns(2),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('attendees_count')
                    ->numeric(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                        'upcoming' => 'Upcoming',
                        'past' => 'Past',
                    ]),
                Tables\Filters\Filter::make('start_date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from'),
                        \Filament\Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when($data['from'], fn ($q, $date) => $q->whereDate('start_date', '>=', $date))
                        ->when($data['until'], fn ($q, $date) => $q->whereDate('start_date', '<=', $date))),
                Tables\Filters\SelectFilter::make('event_attendance_mode')
                    ->options([
                        'OfflineEventAttendanceMode' => 'In Presence',
                        'OnlineEventAttendanceMode' => 'Online',
                        'MixedEventAttendanceMode' => 'Mixed',
                    ]),
            ])
            ->actions([
                'edit' => EditAction::make(),
                'delete' => DeleteAction::make(),
            ])
            ->bulkActions([
                'bulk_delete' => ActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    // getPages() gestito automaticamente da XotBaseResource
}
