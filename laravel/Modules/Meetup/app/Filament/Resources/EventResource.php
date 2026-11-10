<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Collection;
use Modules\Meetup\Actions\Event\DeleteEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    // Navigazione ed etichette: lang/{it,en}/event.php. Tabella in Pages\ListEvents, form in Schemas\EventForm,
    // iscritti in RelationManagers\RegistrationsRelationManager.

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

    /**
     * Anche l'eliminazione multipla passa da DeleteEventAction: senza, restavano iscrizioni e collegamenti orfani.
     */
    public static function configureDeleteBulkAction(DeleteBulkAction $action): DeleteBulkAction
    {
        return $action
            ->requiresConfirmation()
            ->using(static function (Collection $records): void {
                $delete = app(DeleteEventAction::class);
                foreach ($records as $record) {
                    if ($record instanceof Event) {
                        $delete->execute($record);
                    }
                }
            });
    }

    // getPages() gestito automaticamente da XotBaseResource
}
