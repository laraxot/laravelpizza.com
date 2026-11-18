<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Meetup\Actions\Event\ImportEventsFromJsonAction;

class ImportEventsAction extends Action
{
    public static function make(?string $name = 'import_events'): static
    {
        return parent::make($name)
            ->label((string) __('meetup::event.event.actions.seed_events.label'))
            ->icon('heroicon-o-arrow-down-tray')
            // Strumento di sviluppo: importa gli eventi di esempio di Modules/Meetup/database/json. In produzione
            // un organizzatore che lo clicca riempirebbe il sito di eventi finti: visibile solo in locale.
            ->visible(static fn (): bool => app()->environment('local'))
            ->action(function (): void {
                $count = app(ImportEventsFromJsonAction::class)->execute();

                Notification::make()
                    ->title((string) __('meetup::event.event.actions.seed_events.notification.title'))
                    ->body(__('meetup::event.event.actions.seed_events.notification.body', ['count' => $count]))
                    ->success()
                    ->send();
            })
            ->requiresConfirmation()
            ->color('info');
    }
}
