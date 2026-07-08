<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Theme;

use Illuminate\Support\Facades\Config;
use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ThemeService::getTheme() (archived to .bak).
 */
class GetThemeAction
{
    use QueueableAction;

    public function execute(): string
    {
        $theme = Config::get('theme.active', 'default');

        return is_string($theme) ? $theme : 'default';
    }
}
