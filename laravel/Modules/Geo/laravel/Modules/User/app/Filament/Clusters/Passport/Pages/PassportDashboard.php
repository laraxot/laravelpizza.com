<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Pages;

use Filament\Actions\Action;
use Filament\Clusters\Cluster;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Modules\User\Filament\Clusters\Passport;
use Modules\Xot\Actions\ExecuteArtisanCommandAction;
use Modules\Xot\Filament\Pages\XotBasePage;

class PassportDashboard extends XotBasePage
{
    public bool $hasPublicKey = false;

    public bool $hasPrivateKey = false;

    /** @var list<string> */
    public array $output = [];

    public string $status = '';

    public bool $isRunning = false;

    public string $currentCommand = '';

    /**
     * @var class-string<Cluster>
     */
    protected static ?string $cluster = Passport::class;

    protected string $view = 'user::filament.pages.passport-dashboard';

    public function executeCommand(string $command): void
    {
        $this->reset(['output', 'status']);
        $this->currentCommand = $command;
        $this->isRunning = true;

        try {
            app(ExecuteArtisanCommandAction::class)->execute($command);
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error executing command')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->isRunning = false;
        }
    }

    #[On('artisan-command.started')]
    public function handleCommandStarted(string $command): void
    {
        $this->isRunning = true;
    }

    #[On('artisan-command.output')]
    public function handleCommandOutput(string $command, string $output): void
    {
        $this->output[] = $output;
        $this->dispatch('terminal-update');
    }

    public function mount(): void
    {
        $this->checkKeys();
    }

    public function checkKeys(): void
    {
        $this->hasPublicKey = file_exists(storage_path('oauth-public.key'));
        $this->hasPrivateKey = file_exists(storage_path('oauth-private.key'));
    }

    #[On('artisan-command.completed')]
    public function onCommandCompleted(string $command): void
    {
        if ($this->currentCommand === $command) {
            $this->isRunning = false;
            $this->status = 'completed';
            $this->checkKeys();
        }

        Notification::make()
            ->title('Command completed successfully')
            ->success()
            ->send();
    }

    #[On('artisan-command.failed')]
    public function handleCommandFailed(string $command, string $error): void
    {
        $this->status = 'failed';
        $this->isRunning = false;
        $this->output[] = "[ERROR] {$error}";

        Notification::make()
            ->title('Command failed')
            ->body($error)
            ->danger()
            ->send();
    }

    #[On('artisan-command.error')]
    public function handleCommandError(string $command, string $error): void
    {
        $this->status = 'failed';
        $this->isRunning = false;
        $this->output[] = "[ERROR] {$error}";

        Notification::make()
            ->title('Command error')
            ->body($error)
            ->danger()
            ->send();
    }

    protected function getViewData(): array
    {
        return [
            'hasPublicKey' => $this->hasPublicKey,
            'hasPrivateKey' => $this->hasPrivateKey,
            'publicKeyLabel' => static::trans('status.public_key'),
            'privateKeyLabel' => static::trans('status.private_key'),
            'presentLabel' => static::trans('status.present'),
            'missingLabel' => static::trans('status.missing'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            'passport_install' => Action::make('passport_install')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->modalDescription(static::trans('actions.install.modal_description'))
                ->action(fn () => $this->executeCommand('passport:install --uuids')),

            'passport_keys' => Action::make('passport_keys')
                ->icon('heroicon-o-key')
                ->color('primary')
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->action(fn () => $this->executeCommand('passport:keys')),

            'passport_purge' => Action::make('passport_purge')
                ->icon('heroicon-o-trash')
                ->color('warning')
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->modalDescription(static::trans('actions.purge_tokens.modal_description'))
                ->action(fn () => $this->executeCommand('passport:purge')),

            'passport_hash' => Action::make('passport_hash')
                ->icon('heroicon-o-lock-closed')
                ->color('danger')
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->modalDescription(static::trans('actions.hash_secrets.modal_description'))
                ->action(fn () => $this->executeCommand('passport:hash')),
        ];
    }
}
