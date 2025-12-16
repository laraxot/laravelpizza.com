<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Markdown;

use Illuminate\Support\Arr;
use Spatie\QueueableAction\QueueableAction;

class GetLocalizedMarkdownPathAction
{
    use QueueableAction;

    public function execute(string $name): string
    {
        $lang = app()->getLocale();

        $paths = [
            app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('lang/'.$lang.'/'.$name),
            app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute($name),
        ];

        /** @var string|false|null $path */
        $path = Arr::first($paths, static fn (string $path): bool => file_exists($path));

        if (! \is_string($path)) {
            return '#';
        }

        return $path;
    }
}


