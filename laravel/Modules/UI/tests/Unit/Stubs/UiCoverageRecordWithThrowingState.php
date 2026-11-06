<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Illuminate\Support\Collection;

final class UiCoverageRecordWithThrowingState extends UiCoverageRecord
{
    /**
     * @return Collection<string, string>
     */
    public function getStatesFor(string $name): Collection
    {
        return collect([
            'pending' => UiCoverageThrowingTransitionState::class,
            'done' => UiCoverageDoneState::class,
        ]);
    }
}
