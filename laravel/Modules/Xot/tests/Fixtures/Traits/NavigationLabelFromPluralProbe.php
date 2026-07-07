<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Traits;

final class NavigationLabelFromPluralProbe extends HasCustomModelLabelProbeBase
{
    public static function getPluralModelLabel(): string
    {
        return 'Plurals';
    }
}
