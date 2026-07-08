<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Theme;

use Illuminate\Support\Facades\Config;
use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ThemeService::setTheme() (archived to .bak).
 *
 * Persists the active theme into config('theme.active') so GetThemeAction,
 * IsThemeAction and GetThemePathAction read it back consistently across
 * the request lifecycle.
 */
class SetThemeAction
{
    use QueueableAction;

    public function execute(string $theme): void
    {
        Config::set('theme.active', $theme);
    }
}
