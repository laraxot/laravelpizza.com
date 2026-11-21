<?php

declare(strict_types=1);

namespace Modules\UI\Services;

use Modules\Xot\Actions\File\AssetAction;

final class UIService
{
    public static function asset(string $asset): string
    {
        return app(AssetAction::class)->execute($asset);
    }
}
