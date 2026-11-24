<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Theme;

use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ThemeService::isTheme() (archived to .bak).
 *
 * @see docs/contracts/is-theme-action.md
<<<<<<< .merge_file_FWKQ0D
 *
=======
>>>>>>> .merge_file_26hhau
 * @contract docs/contracts/is-theme-action.md
 */
class IsThemeAction
{
    use QueueableAction;

    public function execute(string $theme): bool
    {
        return app(GetThemeAction::class)->execute() === $theme;
    }
}
