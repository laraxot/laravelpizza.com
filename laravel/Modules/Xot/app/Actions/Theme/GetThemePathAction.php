<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Theme;

use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\ThemeService::getThemePath() (archived to .bak).
 */
class GetThemePathAction
{
    use QueueableAction;

    public function execute(): string
    {
        return resource_path('themes/'.app(GetThemeAction::class)->execute());
    }
}
