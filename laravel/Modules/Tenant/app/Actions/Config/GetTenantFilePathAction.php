<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Modules\Tenant\Actions\GetTenantNameAction;
use function Safe\realpath;
use Spatie\QueueableAction\QueueableAction;

class GetTenantFilePathAction
{
    use QueueableAction;

    public function execute(string $filename): string
    {
        if (isRunningTestBench()) {
            $basePath = realpath(__DIR__.'/../../Config');

            return $basePath.\DIRECTORY_SEPARATOR.$filename;
        }

        $tenantName = app(GetTenantNameAction::class)->execute();
        $path = base_path('config/'.$tenantName.'/'.$filename);

        return str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $path);
    }
}
