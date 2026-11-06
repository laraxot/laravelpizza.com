<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Modules\Lang\Filament\Forms\Components\NationalFlagSelect;

final class NationalFlagSelectStub extends NationalFlagSelect
{
    /** @var array<int, mixed> */
    public array $forcedCountries = [];

    /**
     * @return array<int, mixed>
     */
    protected function resolveCountries(): array
    {
        return $this->forcedCountries;
    }
}
