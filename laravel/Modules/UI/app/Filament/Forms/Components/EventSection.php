<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

/** Reusable editor for the common schema.org/Event properties. */
final class EventSection extends XotBaseSection
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            TextInput::make('name')->required(),
            Textarea::make('description'),
            Grid::make(2)->schema([
                DateTimePicker::make('start_date'),
                DateTimePicker::make('end_date'),
                Select::make('event_status')->options([
                    'EventScheduled' => 'Scheduled',
                    'EventCancelled' => 'Cancelled',
                    'EventPostponed' => 'Postponed',
                    'EventRescheduled' => 'Rescheduled',
                    'EventMovedOnline' => 'Moved online',
                ]),
                Select::make('event_attendance_mode')->options([
                    'OfflineEventAttendanceMode' => 'Offline',
                    'OnlineEventAttendanceMode' => 'Online',
                    'MixedEventAttendanceMode' => 'Mixed',
                ]),
            ]),
            Grid::make(2)->schema([
                TextInput::make('location'),
                TextInput::make('organizer'),
                TextInput::make('performer'),
                TextInput::make('image')->url(),
                TextInput::make('url')->url(),
            ]),
        ]);
    }

    public static function getDefaultName(): string
    {
        return 'event';
    }
}
