<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Xot\Actions\ExecuteArtisanCommandAction;

class ArtisanCommandsManager extends XotBasePage
{
    public array $output = [];
    public string $currentCommand = '';
    public string $status = '';
    public bool $isRunning = false;

    protected string $view = 'xot::filament.pages.artisan-commands-manager';

    public function executeCommand(string $command): void
    {
        $this->currentCommand = $command;
        $this->isRunning = true;
        try {
            app(ExecuteArtisanCommandAction::class)->execute($command);
            Notification::make()->title('Success')->success()->send();
        } catch (\Exception $e) {
            Notification::make()->title('Error')->body($e->getMessage())->danger()->send();
        }
        $this->isRunning = false;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('migrate')->action(fn () => $this->executeCommand('migrate')),
            Action::make('filament_upgrade')->action(fn () => $this->executeCommand('filament:upgrade')),
            Action::make('optimize')->action(fn () => $this->executeCommand('optimize')),
        ];
    }
}
