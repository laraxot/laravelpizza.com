<?php

declare(strict_types=1);

namespace Modules\Xot\Services\Artisan\Contracts;

/**
 * Interface for Artisan command handlers.
 */
interface CommandHandlerInterface
{
    /**
     * Handle the artisan command.
     */
    public function handle(string $moduleName = ''): string;

    /**
     * Check if this handler supports the given command.
     */
    public function supports(string $command): bool;
}
