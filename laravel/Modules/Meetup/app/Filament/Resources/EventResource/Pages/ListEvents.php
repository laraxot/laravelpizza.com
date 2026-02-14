<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Modules\Meetup\Actions\Event\ImportEventsFromJsonAction;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Filament\Resources\EventResource;
use Modules\Meetup\Filament\Widgets\EventsStats;
use Modules\Meetup\Filament\Widgets\EventsTimelineChart;
use Modules\Meetup\Filament\Widgets\RecentEventsWidget;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListEvents extends XotBaseListRecords
{
    protected static string $resource = EventResource::class;

    /**
     * Get the table columns.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'title' => TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->limit(50),
            'start_date' => TextColumn::make('start_date')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
            'end_date' => TextColumn::make('end_date')
                ->dateTime('d/m/Y H:i')
                ->toggleable(),
            'location' => TextColumn::make('location')
                ->searchable()
                ->limit(30)
                ->toggleable(),
            'status' => TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'upcoming' => 'success',
                    'draft' => 'warning',
                    'cancelled' => 'danger',
                    'completed' => 'info',
                    default => 'gray',
                }),
            'event_status' => TextColumn::make('event_status')
                ->badge(),
            'event_attendance_mode' => TextColumn::make('event_attendance_mode')
                ->badge(),
            'attendees_count' => TextColumn::make('attendees_count')
                ->numeric()
                ->sortable(),
            'max_attendees' => TextColumn::make('max_attendees')
                ->numeric()
                ->toggleable(),
            'in_language' => TextColumn::make('in_language')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'it' => 'primary',
                    'en' => 'info',
                    default => 'gray',
                }),
            'created_at' => TextColumn::make('created_at')
                ->dateTime('d/m/Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Get the table filters.
     *
     * @return array<int, \Filament\Tables\Filters\Filter|\Filament\Tables\Filters\SelectFilter|\Filament\Tables\Filters\TernaryFilter>
     */
    #[Override]
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->label((string) __('meetup::event.event.filters.status.label'))
                ->options([
                    'upcoming' => __('meetup::event.event.filters.status.upcoming'),
                    'completed' => __('meetup::event.event.filters.status.completed'),
                    'cancelled' => __('meetup::event.event.filters.status.cancelled'),
                    'draft' => __('meetup::event.event.filters.status.draft'),
                ])
                ->multiple(),

            SelectFilter::make('event_status')
                ->label((string) __('meetup::event.event.filters.event_status.label'))
                ->options(EventStatus::class)
                ->multiple(),

            SelectFilter::make('event_attendance_mode')
                ->label((string) __('meetup::event.event.filters.attendance_mode.label'))
                ->options(EventAttendanceMode::class),

            TernaryFilter::make('has_capacity')
                ->label((string) __('meetup::event.event.filters.has_capacity.label'))
                ->trueLabel((string) __('meetup::event.event.filters.has_capacity.yes'))
                ->falseLabel((string) __('meetup::event.event.filters.has_capacity.no'))
                ->queries(
                    true: fn ($query) => $query->whereColumn('attendees_count', '<', 'max_attendees'),
                    false: fn ($query) => $query->whereColumn('attendees_count', '>=', 'max_attendees'),
                ),
        ];
    }

    /**
     * Get the header actions for the page.
     *
     * @return array<string, Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        return array_merge(parent::getHeaderActions(), [
            'import_events' => Action::make('import_events')
                ->label((string) __('meetup::event.event.actions.seed_events.label'))
                ->icon('heroicon-o-arrow-down-tray')
                ->badge(fn() => \Modules\Meetup\Models\Event::count())
                ->action(function () {
                    $count = app(ImportEventsFromJsonAction::class)->execute();

                    Notification::make()
                        ->title((string) __('meetup::event.event.actions.seed_events.notification.title'))
                        ->body(__('meetup::event.event.actions.seed_events.notification.body', ['count' => $count]))
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->color('info'),
        ]);
    }

    /**
     * Get the header widgets for the page.
     *
     * @return array<int, class-string<\Filament\Widgets\Widget>>
     */
    #[Override]
    protected function getHeaderWidgets(): array
    {
        return [
            EventStatsOverviewWidget::class,
            EventsStats::class,
            EventsTimelineChart::class,
            RecentEventsWidget::class,
        ];
    }

    /**
     * Get the default sort column and direction.
     */
    protected function getDefaultTableSortColumn(): ?string
    {
        return 'start_date';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }
}
