<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Config;

use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Spatie\QueueableAction\QueueableAction;

class GetTenantConfigPathAction
{
    use QueueableAction;

    public function execute(string $name): string
    {
        $filename = $name . '.php';
        return app(GetTenantFilePathAction::class)->execute($filename);
    }
}