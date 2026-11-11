<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Modules\Lang\Filament\Forms\Components\NationalFlagSelect;

final class NationalFlagSelectFinalStub extends NationalFlagSelect
{
    /** @var array<int, mixed> */
    public array $forcedCountries = [];

    /** @var array<int, mixed> */
    public array $extraFilteredRows = [];

    /**
     * @return array<int, mixed>
     */
    protected function resolveCountries(): array
    {
        return $this->forcedCountries;
    }

    /**
     * @param  array<int, mixed>  $filteredCountries
     * @return array<int, mixed>
     */
    protected function finalizeFilteredCountries(array $filteredCountries): array
    {
        return array_merge(array_values($filteredCountries), $this->extraFilteredRows);
    }
}
