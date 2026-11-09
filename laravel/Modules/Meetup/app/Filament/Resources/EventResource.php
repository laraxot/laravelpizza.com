<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Meetup\Actions\Event\DeleteEventAction;
use Modules\Meetup\Filament\TableFilters\EventStartDateFilter;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    // Le proprietà navigationIcon, navigationLabel, modelLabel, pluralModelLabel
    // sono gestite automaticamente da XotBaseResource tramite traduzioni

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
                EventStartDateFilter::make(),
                Tables\Filters\SelectFilter::make('event_attendance_mode')
                    ->options([
                        'OfflineEventAttendanceMode' => 'In Presence',
                        'OnlineEventAttendanceMode' => 'Online',
                        'MixedEventAttendanceMode' => 'Mixed',
                    ]),
            ])
            ->recordActions([
                'edit' => EditAction::make(),
                'delete' => self::configureDeleteAction(DeleteAction::make()),
            ])
            ->toolbarActions([
                'bulk_delete' => ActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * PRD FR-1: l'eliminazione di un evento con iscrizioni chiede una conferma esplicita
     * che dichiara quante iscrizioni andranno perse, e passa da DeleteEventAction.
     */
    public static function configureDeleteAction(DeleteAction $action): DeleteAction
    {
        return $action
            ->requiresConfirmation()
            ->modalDescription(static function (Event $record): string {
                // Conta sulla pivot: attendees() fa join con users su un altro database e restituiva 0.
                $count = EventUser::query()->where('event_id', $record->getKey())->count();
                $key = $count > 0 ? 'with_attendees' : 'without_attendees';

                return (string) __('meetup::event.delete_confirmation.'.$key, ['count' => $count]);
            })
            ->using(static fn (Event $record): bool => app(DeleteEventAction::class)->execute($record));
    }

    // getPages() gestito automaticamente da XotBaseResource
}
