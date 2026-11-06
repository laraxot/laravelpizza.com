<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Enums\IconPosition;
use Modules\Xot\Actions\ExecuteArtisanCommandAction;
use Modules\Xot\Actions\ExecuteComposerDumpAutoloadAction;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;

/**
 * Esegue migrate, passport:*, config:cache, composer dump-autoload: solo super-admin.
 */
class ArtisanCommandsManager extends XotBasePage
{
    use SuperAdminOnlyTrait;

    /** @var list<string> */
    public array $output = [];

    public string $currentCommand = '';

    public string $status = '';

    public bool $isRunning = false;

    /**
     * Livewire event listeners for this component.
     *
     * @var array<string, string>
     *
     * @phpstan-var array<string, string>
     */
    protected $listeners = [
        'refresh-component' => '$refresh',
    ];

    /**
     * `ExecuteArtisanCommandAction::execute()` è sincrona e bloccante: al suo
     * ritorno il comando è già completato per davvero. Prima leggevamo lo
     * stato finale da un giro di eventi Laravel (`Event::dispatch(...)`) che
     * questa pagina intercettava via `#[On(...)]`/`$listeners` — ma
     * `Illuminate\Support\Facades\Event` e il bus di eventi di Livewire sono
     * due sistemi distinti che non si parlano: nessun listener li riceveva
     * mai, quindi sul percorso di successo `isRunning`/`status`/`output`
     * restavano bloccati ai valori impostati qui sopra (mai "completato" né
     * mai un output popolato, a prescindere da quanto il comando reale fosse
     * andato a buon fine). Fix: leggere direttamente il valore di ritorno.
     */
    public function executeCommand(string $command): void
    {
        abort_unless(static::canAccess(), 403);

        $this->reset(['output', 'status']);
        $this->currentCommand = $command;
        $this->isRunning = true;

        try {
            $result = app(ExecuteArtisanCommandAction::class)->execute($command);

            $this->output = $result['output'];
            $this->status = $result['status'];
            $this->isRunning = false;

            $this->notifyCommandResult($command, $result['status']);
        } catch (\Exception $e) {
            $this->status = 'failed';
            $this->isRunning = false;

            Notification::make()
                ->title((string) __('xot::artisan-commands-manager.messages.command_failed'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Story xot-artisan-commands-manager-layout-and-composer-dump-autoload.md:
     * `composer dump-autoload` non è un comando artisan, non può passare da
     * `ExecuteArtisanCommandAction` (limitato a `php artisan ...`) — serve a
     * chi non ha accesso SSH e deve rigenerare l'autoloader dopo un deploy
     * che ha aggiunto classi nuove (sintomo: job in coda falliti con "Job is
     * incomplete class").
     */
    public function executeComposerDumpAutoload(): void
    {
        abort_unless(static::canAccess(), 403);

        $this->reset(['output', 'status']);
        $this->currentCommand = 'composer dump-autoload';
        $this->isRunning = true;

        try {
            $result = app(ExecuteComposerDumpAutoloadAction::class)->execute();

            $this->output = $result['output'];
            $this->status = $result['status'];
            $this->isRunning = false;

            $this->notifyCommandResult($this->currentCommand, $result['status']);
        } catch (\Throwable $e) {
            $this->status = 'failed';
            $this->isRunning = false;

            Notification::make()
                ->title((string) __('xot::artisan-commands-manager.messages.command_failed'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * @param  'completed'|'failed'  $status
     */
    private function notifyCommandResult(string $command, string $status): void
    {
        if ($status === 'completed') {
            Notification::make()
                ->title((string) __('xot::artisan-commands-manager.messages.command_completed'))
                ->body((string) __('xot::artisan-commands-manager.messages.command_completed_desc', ['command' => $command]))
                ->success()
                ->send();

            return;
        }

        Notification::make()
            ->title((string) __('xot::artisan-commands-manager.messages.command_failed'))
            ->body((string) __('xot::artisan-commands-manager.messages.command_failed_desc', ['command' => $command]))
            ->danger()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('migrate')
                ->label((string) __('xot::artisan-commands-manager.commands.migrate.label'))
                ->icon('heroicon-o-circle-stack')
                ->color('primary')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->action(fn () => $this->executeCommand('migrate')),
            Action::make('filament_upgrade')
                ->label((string) __('xot::artisan-commands-manager.commands.filament_upgrade.label'))
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->action(fn () => $this->executeCommand('filament:upgrade')),
            Action::make('filament_optimize')
                ->label((string) __('xot::artisan-commands-manager.commands.filament_optimize.label'))
                ->icon('heroicon-o-sparkles')
                ->color('success')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->action(fn () => $this->executeCommand('filament:optimize')),
            Action::make('view_cache')
                ->label((string) __('xot::artisan-commands-manager.commands.view_cache.label'))
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->action(fn () => $this->executeCommand('view:cache')),
            Action::make('config_cache')
                ->label((string) __('xot::artisan-commands-manager.commands.config_cache.label'))
                ->icon('heroicon-o-cog-6-tooth')
                ->color('gray')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->action(fn () => $this->executeCommand('config:cache')),
            Action::make('route_cache')
                ->label((string) __('xot::artisan-commands-manager.commands.route_cache.label'))
                ->icon('heroicon-o-map')
                ->color('gray')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->action(fn () => $this->executeCommand('route:cache')),
            Action::make('event_cache')
                ->label((string) __('xot::artisan-commands-manager.commands.event_cache.label'))
                ->icon('heroicon-o-bell')
                ->color('gray')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->action(fn () => $this->executeCommand('event:cache')),
            Action::make('queue_restart')
                ->label((string) __('xot::artisan-commands-manager.commands.queue_restart.label'))
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->action(fn () => $this->executeCommand('queue:restart')),
            Action::make('composer_dump_autoload')
                ->label((string) __('xot::artisan-commands-manager.commands.composer_dump_autoload.label'))
                ->icon('heroicon-o-cube')
                ->color('gray')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->action(fn () => $this->executeComposerDumpAutoload()),
            Action::make('notify_migrate_themes_to_mail_templates')
                ->label((string) __('xot::artisan-commands-manager.commands.notify_migrate_themes_to_mail_templates.label'))
                ->icon('heroicon-o-envelope')
                ->color('gray')
                ->size('lg')
                ->iconPosition(IconPosition::Before)
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->modalDescription((string) __('xot::artisan-commands-manager.commands.notify_migrate_themes_to_mail_templates.modal_description'))
                ->action(fn () => $this->executeCommand('notify:migrate-themes-to-mail-templates')),
        ];
    }
}
