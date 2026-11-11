<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Modules\Meetup\Filament\Resources\EventResource;
use Modules\Meetup\Models\Event;
use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class RecentEventsWidget extends XotBaseTableWidget
{
    protected int|string|array $columnSpan = 'full';

    /**
     * PRD FR-3: i prossimi eventi con le iscrizioni rispetto ai posti, per capire subito dove serve promozione.
     */
    #[\Override]
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Event::query()
                    ->with(['venue'])
                    ->where('start_date', '>=', now())
                    ->orderBy('start_date')
                    ->limit(8)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->url(static fn (Event $record): string => EventResource::getUrl('edit', ['record' => $record])),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('location')
                    ->state(static fn (Event $record): string => $record->venue !== null ? $record->venue->name : $record->location),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(static fn (string $state): string => (string) __('meetup::event_form.fields.status.options.'.$state))
                    ->color(static fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft', 'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('attendees_count')
                    ->formatStateUsing(static fn (int $state, Event $record): string => $state.' / '.$record->max_attendees)
                    ->badge()
                    ->color(static fn (int $state, Event $record): string => match (true) {
                        $record->max_attendees > 0 && $state >= $record->max_attendees => 'danger',
                        $record->max_attendees > 0 && $state / $record->max_attendees >= 0.8 => 'warning',
                        default => 'gray',
                    }),
            ])
            ->paginated(false)
            ->emptyStateHeading((string) __('meetup::recent_events.empty'))
            ->heading((string) __('meetup::recent_events.label'));
    }

    /**
     * Riepilogo in sola lettura: niente "Nuovo", cambio vista o selezione multipla (si agisce dalla pagina Eventi).
     *
     * @return array<string, never>
     */
    #[\Override]
    public function getTableHeaderActions(): array
    {
        return [];
    }

    /**
     * @return array<string, never>
     */
    #[\Override]
    public function getTableBulkActions(): array
    {
        return [];
    }

    /**
     * @return array<string, never>
     */
    #[\Override]
    public function getTableActions(): array
    {
        return [];
    }
}
