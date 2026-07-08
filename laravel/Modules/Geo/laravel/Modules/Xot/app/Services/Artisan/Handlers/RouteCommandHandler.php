<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Artisan\Handlers;

use Modules\Xot\Services\Artisan\Contracts\CommandHandlerInterface;
use Modules\Xot\Services\ArtisanService;
use Webmozart\Assert\Assert;

/**
 * Handles route-related artisan commands.
 */
class RouteCommandHandler implements CommandHandlerInterface
{
    private const ROUTE_COMMANDS = [
        'routelist' => 'listRoutes',
        'routelist1' => 'showRouteList',
        'routecache' => 'cacheRoutes',
        'routeclear' => 'clearRoutes',
    ];

    public function handle(string $moduleName = ''): string
    {
        $command = $this->getCurrentCommand();

        if (isset(self::ROUTE_COMMANDS[$command])) {
            $method = self::ROUTE_COMMANDS[$command];

            return $this->$method();
        }

        return '';
    }

    public function supports(string $command): bool
    {
        return isset(self::ROUTE_COMMANDS[$command]);
    }

    private function getCurrentCommand(): string
    {
        Assert::string($currentCommand = request()->input('act', ''));

        return $currentCommand;
    }

    private function listRoutes(): string
    {
        return ArtisanService::exe('route:list');
    }

    private function showRouteList(): string
    {
        return ArtisanService::showRouteList();
    }

    private function cacheRoutes(): string
    {
        return ArtisanService::exe('route:cache');
    }

    private function clearRoutes(): string
    {
        return ArtisanService::exe('route:clear');
    }
}
