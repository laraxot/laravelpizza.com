<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Theme;

use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ThemeService::isTheme() (archived to .bak).
 */
class IsThemeAction
{
    use QueueableAction;

    public function execute(string $theme): bool
    {
        return app(GetThemeAction::class)->execute() === $theme;
    }
}
