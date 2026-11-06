<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class UiCoverageThrowingTransitionState extends UiCoverageStateContract
{
    /**
     * @param  Model|array<string, mixed>|string|null  $record
     */
    public function __construct(Model|array|string|null $record = null)
    {
        parent::__construct($record);
    }

    public function transitionableStates(): array
    {
        throw new \RuntimeException('forced for coverage');
    }

    /**
     * @return Collection<string, string>
     */
    public static function getStateMapping(): Collection
    {
        return collect([
            'pending' => self::class,
            'done' => UiCoverageDoneState::class,
        ]);
    }
}
