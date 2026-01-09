<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Config;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

class GetTenantConfigArrayAction
{
    use QueueableAction;

    public function execute(string $name): array
    {
        $path = app(GetTenantConfigPathAction::class)->execute($name);

        if (! File::exists($path)) {
            return [];
        }

        $content = File::getRequire($path);

        if (! is_array($content)) {
            return [];
        }

        return $content;
    }
}
