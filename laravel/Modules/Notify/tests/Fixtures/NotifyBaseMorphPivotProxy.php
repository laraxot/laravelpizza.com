<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Fixtures;

use Modules\Notify\Models\BaseMorphPivot;

final class NotifyBaseMorphPivotProxy extends BaseMorphPivot
{
    protected $table = 'notify_base_morph_pivot_proxy';

    /** @return array<string, string> */
    public function exposedCasts(): array
    {
        /** @var array<string, string> $casts */
        $casts = $this->getCasts();

        return $casts;
    }
}
