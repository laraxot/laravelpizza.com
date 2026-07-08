<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Artisan\Handlers;

use Modules\Xot\Services\Artisan\Contracts\CommandHandlerInterface;
use Modules\Xot\Services\ArtisanService;
use Webmozart\Assert\Assert;

/**
 * Handles module-related artisan commands.
 */
class ModuleCommandHandler implements CommandHandlerInterface
{
    private const MODULE_COMMANDS = [
        'module-list' => 'listModules',
        'module-disable' => 'disableModule',
        'module-enable' => 'enableModule',
    ];

    public function handle(string $moduleName = ''): string
    {
        $command = $this->getCurrentCommand();

        if (isset(self::MODULE_COMMANDS[$command])) {
            $method = self::MODULE_COMMANDS[$command];

            return $this->$method($moduleName);
        }

        return '';
    }

    public function supports(string $command): bool
    {
        return isset(self::MODULE_COMMANDS[$command]);
    }

    private function getCurrentCommand(): string
    {
        $command = request()->input('act', '');
        Assert::string($command);

        return $command;
    }

    private function listModules(string $moduleName): string
    {
        return ArtisanService::exe('module:list');
    }

    private function disableModule(string $moduleName): string
    {
        return ArtisanService::exe('module:disable '.$moduleName);
    }

    private function enableModule(string $moduleName): string
    {
        return ArtisanService::exe('module:enable '.$moduleName);
    }
}
