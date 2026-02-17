<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Meetup\Actions\Event\ImportEventsFromJsonAction;
use Modules\Meetup\Models\Event;

class ImportEventsAction extends Action
{
    public static function make(string $name = 'import_events'): static
    {
        return parent::make($name)
            ->label((string) __('meetup::event.event.actions.seed_events.label'))
            ->icon('heroicon-o-arrow-down-tray')
            ->badge(fn () => Event::count())
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
