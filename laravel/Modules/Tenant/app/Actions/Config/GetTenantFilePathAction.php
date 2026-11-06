<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use InvalidArgumentException;
use Modules\Tenant\Actions\GetTenantNameAction;
use Spatie\QueueableAction\QueueableAction;

class GetTenantFilePathAction
{
    use QueueableAction;

    public function execute(string $filename): string
    {
        $normalizedFilename = str_replace('\\', '/', $filename);
        if (str_starts_with($normalizedFilename, '/') || str_contains($filename, "\0") || in_array('..', explode('/', $normalizedFilename), true)) {
            throw new InvalidArgumentException('Tenant filename must be a relative path without traversal segments.');
        }

        $tenantName = app(GetTenantNameAction::class)->execute();
        $path = base_path('config/'.$tenantName.'/'.$filename);

        return str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $path);
    }
}
