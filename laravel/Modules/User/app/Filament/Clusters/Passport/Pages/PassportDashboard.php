<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
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

    public function mount(): void
    {
        $this->checkKeys();
    }

    public function checkKeys(): void
    {
        $this->hasPublicKey = file_exists(storage_path('oauth-public.key'));
        $this->hasPrivateKey = file_exists(storage_path('oauth-private.key'));
    }

    public function executeCommand(string $command): void
    {
        $this->currentCommand = $command;
        $this->isRunning = true;
        try {
            app(ExecuteArtisanCommandAction::class)->execute($command);
            Notification::make()->title('Command success')->success()->send();
        } catch (\Exception $e) {
            Notification::make()->title('Error')->body($e->getMessage())->danger()->send();
        }
        $this->isRunning = false;
        $this->checkKeys();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('passport_install')->action(fn () => $this->executeCommand('passport:install')),
            Action::make('passport_keys')->action(fn () => $this->executeCommand('passport:keys')),
        ];
    }
}
