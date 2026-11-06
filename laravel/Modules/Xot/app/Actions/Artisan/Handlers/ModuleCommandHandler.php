<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Artisan\Handlers;

use Modules\Xot\Actions\Artisan\RunArtisanCommandAction;
use Webmozart\Assert\Assert;

/**
 * Handles module-related artisan commands.
 *
 * @deprecated Residuo: l'interfaccia dei handler e il registry sono stati rimossi, i comandi `module-*`
 *             li serve `HandleArtisanActRequestAction` tramite `ArtisanActEnum`. Nessun chiamante.
 */
class ModuleCommandHandler
{
    /** @var list<string> */
    private const array MODULE_COMMANDS = ['module-list', 'module-disable', 'module-enable'];

    public function handle(string $moduleName = ''): string
    {
        return match ($this->getCurrentCommand()) {
            'module-list' => $this->listModules(),
            'module-disable' => $this->disableModule($moduleName),
            'module-enable' => $this->enableModule($moduleName),
            default => '',
        };
    }

    public function supports(string $command): bool
    {
        return in_array($command, self::MODULE_COMMANDS, true);
    }

    private function getCurrentCommand(): string
    {
        $command = request()->input('act', '');
        Assert::string($command);

        return $command;
    }

    private function listModules(): string
    {
        return app(RunArtisanCommandAction::class)->execute('module:list');
    }

    private function disableModule(string $moduleName): string
    {
        return app(RunArtisanCommandAction::class)->execute('module:disable '.$moduleName);
    }

    private function enableModule(string $moduleName): string
    {
        return app(RunArtisanCommandAction::class)->execute('module:enable '.$moduleName);
    }
}
