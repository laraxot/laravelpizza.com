<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Artisan\Handlers;

use Modules\Xot\Services\Artisan\Contracts\CommandHandlerInterface;
use Modules\Xot\Services\ArtisanService;
use Webmozart\Assert\Assert;

/**
 * Handles cache-related artisan commands.
 */
class CacheCommandHandler implements CommandHandlerInterface
{
    private const CACHE_COMMANDS = [
        'clear' => 'clearAll',
        'clearcache' => 'clearCache',
        'configcache' => 'cacheConfig',
    ];

    public function handle(string $moduleName = ''): string
    {
        $command = $this->getCurrentCommand();

        if (isset(self::CACHE_COMMANDS[$command])) {
            $method = self::CACHE_COMMANDS[$command];

            return $this->$method();
        }

        return '';
    }

    public function supports(string $command): bool
    {
        return isset(self::CACHE_COMMANDS[$command]);
    }

    private function getCurrentCommand(): string
    {
        $command = request()->input('act', '');
        Assert::string($command);

        return $command;
    }

    private function clearAll(): string
    {
        $output = '';
        $output .= ArtisanService::exe('cache:clear').PHP_EOL;
        $output .= ArtisanService::exe('config:clear').PHP_EOL;
        $output .= ArtisanService::exe('event:clear').PHP_EOL;
        $output .= ArtisanService::exe('route:clear').PHP_EOL;
        $output .= ArtisanService::exe('view:clear').PHP_EOL;
        $output .= ArtisanService::exe('debugbar:clear').PHP_EOL;
        $output .= ArtisanService::exe('opcache:clear').PHP_EOL;
        $output .= ArtisanService::exe('optimize:clear').PHP_EOL;
        $output .= ArtisanService::exe('key:generate').PHP_EOL;
        $output .= ArtisanService::sessionClear().PHP_EOL;
        $output .= ArtisanService::errorClear().PHP_EOL;
        $output .= ArtisanService::debugbarClear().PHP_EOL;
        $output .= PHP_EOL.'DONE'.PHP_EOL;

        return $output;
    }

    private function clearCache(): string
    {
        return ArtisanService::exe('cache:clear');
    }

    private function cacheConfig(): string
    {
        return ArtisanService::exe('config:cache');
    }
}
