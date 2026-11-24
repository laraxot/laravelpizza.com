<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Markdown;

use Illuminate\Support\Arr;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-localized-markdown-path-action.md
 *
 * @contract docs/contracts/get-localized-markdown-path-action.md
 */
class GetLocalizedMarkdownPathAction
{
    use QueueableAction;

    public function execute(string $name): string
    {
        $lang = app()->getLocale();

        $paths = [
            app(GetTenantFilePathAction::class)->execute('lang/'.$lang.'/'.$name),
            app(GetTenantFilePathAction::class)->execute($name),
        ];

        /** @var string|false|null $path */
        $path = Arr::first($paths, static fn (string $path): bool => file_exists($path));

        if (! \is_string($path)) {
            return '#';
        }

        return $path;
    }
}
