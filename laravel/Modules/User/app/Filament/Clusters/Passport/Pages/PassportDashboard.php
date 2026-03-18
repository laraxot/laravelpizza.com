<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Modules\User\Filament\Clusters\Passport;
use Modules\Xot\Actions\ExecuteArtisanCommandAction;
use Modules\Xot\Filament\Pages\XotBasePage;

class PassportDashboard extends XotBasePage
{
    protected static ?string $cluster = Passport::class;

    protected string $view = 'user::filament.pages.passport-dashboard';

    public bool $hasPublicKey = false;

    public bool $hasPrivateKey = false;

    public array $output = [];

    public string $currentCommand = '';

    public string $status = '';

    public bool $isRunning = false;

    /** @var array<string, string> */
    protected $listeners = [
        'refresh-component' => '$refresh',
        'artisan-command.started' => 'handleCommandStarted',
        'artisan-command.output' => 'handleCommandOutput',
        'artisan-command.completed' => 'handleCommandCompleted',
        'artisan-command.failed' => 'handleCommandFailed',
        'artisan-command.error' => 'handleCommandError',
    ];

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

    /**
     * @return array<int, class-string<\Filament\Widgets\Widget>>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            Passport\Widgets\PassportStatsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('passport_install')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->label(static::trans('actions.install.label'))
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->modalDescription(static::trans('actions.install.modal_description'))
                ->form([
                    Checkbox::make('force')
                        ->label(static::trans('actions.install.force_label'))
                        ->helperText(static::trans('actions.install.force_help'))
                        ->default(false),
                ])
                ->action(function (array $data) {
                    $cmd = 'passport:install --uuids';
                    if (! empty($data['force'])) {
                        $cmd .= ' --force';
                    }
                    $this->executeCommand($cmd);
                }),

            Action::make('passport_keys')
                ->icon('heroicon-o-key')
                ->color('primary')
                ->label(static::trans('actions.keys.label'))
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->form([
                    Checkbox::make('force')
                        ->label(static::trans('actions.keys.force_label'))
                        ->helperText(static::trans('actions.keys.force_help'))
                        ->default($this->hasPublicKey || $this->hasPrivateKey),
                ])
                ->action(function (array $data) {
                    $cmd = 'passport:keys';
                    if (! empty($data['force'])) {
                        $cmd .= ' --force';
                    }
                    $this->executeCommand($cmd);
                }),

            Action::make('passport_purge')
                ->icon('heroicon-o-trash')
                ->color('warning')
                ->label(static::trans('actions.purge.label'))
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->modalDescription(static::trans('actions.purge_tokens.modal_description'))
                ->form([
                    Checkbox::make('revoked')
                        ->label(static::trans('actions.purge.revoked_label'))
                        ->helperText(static::trans('actions.purge.revoked_help'))
                        ->default(true),
                    Checkbox::make('expired')
                        ->label(static::trans('actions.purge.expired_label'))
                        ->helperText(static::trans('actions.purge.expired_help'))
                        ->default(true),
                    TextInput::make('hours')
                        ->label(static::trans('actions.purge.hours_label'))
                        ->helperText(static::trans('actions.purge.hours_help'))
                        ->numeric()
                        ->default(168)
                        ->minValue(1)
                        ->maxValue(8760),
                ])
                ->action(function (array $data) {
                    $parts = [];
                    if (! empty($data['revoked'])) {
                        $parts[] = '--revoked';
                    }
                    if (! empty($data['expired'])) {
                        $parts[] = '--expired';
                        $hours = (int) ($data['hours'] ?? 168);
                        $parts[] = '--hours='.$hours;
                    }
                    $cmd = 'passport:purge'.(empty($parts) ? '' : ' '.implode(' ', $parts));
                    $this->executeCommand($cmd);
                }),

            Action::make('passport_hash')
                ->icon('heroicon-o-lock-closed')
                ->color('danger')
                ->label(static::trans('actions.hash.label'))
                ->disabled(fn () => $this->isRunning)
                ->requiresConfirmation()
                ->modalDescription(static::trans('actions.hash_secrets.modal_description'))
                ->form([
                    Checkbox::make('force')
                        ->label(static::trans('actions.hash.force_label'))
                        ->helperText(static::trans('actions.hash.force_help'))
                        ->default(false),
                ])
                ->action(function (array $data) {
                    $cmd = 'passport:hash';
                    if (! empty($data['force'])) {
                        $cmd .= ' --force';
                    }
                    $this->executeCommand($cmd);
                }),
        ];
    }
}
