<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;
use Modules\Meetup\Models\Event;
use Modules\Xot\Datas\XotData;

class EventCalendarWidget extends Widget
{
    protected string $view = 'meetup::filament.widgets.event-calendar';

    public string $type = 'event';

    public function getActionName(string $function): string
    {
        $action_suffix = Str::of($function)->studly()->append('Action')->toString();
        $resource = XotData::make()->getUserResourceClassByType($this->type);
        $model = $resource::getModel();
        $modelString = is_string($model) ? $model : (string) $model;
        $action = Str::of($modelString)
            ->replace('\\Models\\', '\\Actions\\')
            ->append('\\Calendar\\'.$action_suffix)
            ->toString();

        return $action;
    }

    /**
     * @param  array<string, mixed>  $fetchInfo
     * @return array<int, array<string, mixed>>
     */
    public function fetchEvents(array $fetchInfo): array
    {
        // Fetch events for the calendar view
        /** @var array<int, array<string, mixed>> $events */
        $events = Event::whereBetween('start_date', [$fetchInfo['start'], $fetchInfo['end']])
            ->where('status', 'published')
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date->toISOString(),
                    'end' => $event->end_date->toISOString(),
                    'backgroundColor' => '#DC2626', // Pizza red
                    'borderColor' => '#DC2626',
                    'textColor' => '#FFFFFF',
                ];
            })
            ->values()
            ->toArray();

        return $events;
    }

    /**
     * Get the form schema for the widget.
     *
     * @return array<string, \Filament\Forms\Components\TextInput|\Filament\Forms\Components\Select|\Filament\Forms\Components\DateTimePicker|\Filament\Schemas\Components\Grid>
     */
    public function getFormSchema(): array
    {
        // Default schema for event creation/editing in calendar
        return [
            'title' => TextInput::make('title')
                ->required()
                ->maxLength(255),

            'dates' => Grid::make()
                ->schema([
                    'start_date' => DateTimePicker::make('start_date')
                        ->required(),
                    'end_date' => DateTimePicker::make('end_date')
                        ->required(),
                ]),

            'location' => TextInput::make('location')
                ->maxLength(255),

            'status' => Select::make('status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'cancelled' => 'Cancelled',
                ])
                ->default('draft')
                ->required(),
        ];
    }

    public function onDateSelect(string $start, ?string $end, bool $allDay, ?array $view, ?array $resource): void
    {
        // Handle date selection for creating new events
        // This would open a form modal to create a new event
    }
}
