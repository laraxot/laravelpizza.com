<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Meetup\Enums\EventAttendanceMode;
use Modules\Meetup\Enums\EventStatus;
use Modules\Meetup\Filament\Resources\EventResource;
use Modules\Meetup\Filament\TableFilters\EventStartDateFilter;
use Modules\Meetup\Models\Event;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Override;

class EventsTable extends XotBaseResourceTable
{
    /**
     * Get the table columns.
     *
     * @return array<string, Column>
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
                ->toggleable(isToggledHiddenByDefault: true),
            'location' => TextColumn::make('location')
                ->searchable()
                ->limit(30)
                ->toggleable(),
            'venue.name' => TextColumn::make('venue.name')
                ->searchable()
                ->toggleable(),
            'status' => TextColumn::make('status')
                ->badge()
                ->formatStateUsing(static fn (string $state): string => (string) __('meetup::event_form.fields.status.options.'.$state))
                ->color(static fn (string $state): string => match ($state) {
                    'published' => 'success',
                    'draft', 'pending' => 'warning',
                    'cancelled' => 'danger',
                    default => 'gray',
                }),
            'event_status' => TextColumn::make('event_status')
                ->badge()
                ->toggleable(isToggledHiddenByDefault: true),
            'event_attendance_mode' => TextColumn::make('event_attendance_mode')
                ->badge()
                ->toggleable(isToggledHiddenByDefault: true),
            // "12 / 40": iscritti sui posti disponibili, a colpo d'occhio.
            'attendees_count' => TextColumn::make('attendees_count')
                ->formatStateUsing(static fn (int $state, Event $record): string => $state.' / '.$record->max_attendees)
                ->sortable(),
            'in_language' => TextColumn::make('in_language')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'it' => 'primary',
                    'en' => 'info',
                    default => 'gray',
                })
                ->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')
                ->dateTime('d/m/Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Get the table filters.
     *
     * @return array<string, Filter|SelectFilter|TernaryFilter>
     */
    #[Override]
    public function getTableFilters(): array
    {
        return [
            // I valori reali di `status` sono draft/pending/published/cancelled: il vecchio filtro offriva
            // "upcoming" e "completed", che non corrispondevano a nessun evento.
            'status' => SelectFilter::make('status')
                ->label((string) __('meetup::event.event.filters.status.label'))
                ->options([
                    'draft' => __('meetup::event_form.fields.status.options.draft'),
                    'pending' => __('meetup::event_form.fields.status.options.pending'),
                    'published' => __('meetup::event_form.fields.status.options.published'),
                    'cancelled' => __('meetup::event_form.fields.status.options.cancelled'),
                ])
                ->multiple(),

            'timing' => SelectFilter::make('timing')
                ->label((string) __('meetup::event.event.filters.timing.label'))
                ->options([
                    'upcoming' => __('meetup::event.event.filters.timing.upcoming'),
                    'past' => __('meetup::event.event.filters.timing.past'),
                ])
                ->query(static fn (Builder $query, array $data): Builder => match ($data['value'] ?? null) {
                    'upcoming' => $query->where('start_date', '>=', now()),
                    'past' => $query->where('start_date', '<', now()),
                    default => $query,
                }),

            'start_date' => EventStartDateFilter::make(),

            'event_status' => SelectFilter::make('event_status')
                ->label((string) __('meetup::event.event.filters.event_status.label'))
                ->options(EventStatus::class)
                ->multiple(),

            'event_attendance_mode' => SelectFilter::make('event_attendance_mode')
                ->label((string) __('meetup::event.event.filters.attendance_mode.label'))
                ->options(EventAttendanceMode::class),

            'has_capacity' => TernaryFilter::make('has_capacity')
                ->label((string) __('meetup::event.event.filters.has_capacity.label'))
                ->trueLabel((string) __('meetup::event.event.filters.has_capacity.yes'))
                ->falseLabel((string) __('meetup::event.event.filters.has_capacity.no'))
                ->queries(
                    true: static fn (Builder $query): Builder => $query->whereColumn('attendees_count', '<', 'max_attendees'),
                    false: static fn (Builder $query): Builder => $query->whereColumn('attendees_count', '>=', 'max_attendees'),
                ),
        ];
    }

    /**
     * Modifica ed eliminazione dalla riga: l'eliminazione passa da DeleteEventAction (conferma con il numero di iscritti).
     *
     * @return array<string, Action>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make()->iconButton(),
            'delete' => EventResource::configureDeleteAction(DeleteAction::make())->iconButton(),
        ];
    }

    /**
     * @return array<string, DeleteBulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [
            'delete' => EventResource::configureDeleteBulkAction(DeleteBulkAction::make()),
        ];
    }

    /**
     * Get the default sort column and direction.
     */
    public function getDefaultTableSortColumn(): ?string
    {
        return 'start_date';
    }

    public function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    /**
     * Il pulsante "Nuovo" e' gia' nell'intestazione della pagina: qui resta solo il cambio vista (tabella o schede).
     *
     * @return array<string, TableLayoutToggleTableAction>
     */
    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
            'layout' => TableLayoutToggleTableAction::make('layout'),
        ];
    }
}
