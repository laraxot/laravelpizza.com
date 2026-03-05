<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Illuminate\Support\Carbon;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;

class YearSelect extends XotBaseSelect
{
    protected int $pastYears = -2;

    protected int $futureYears = 0;

    public function past(int $years): static
    {
        $this->pastYears = $years;

        return $this;
    }

    public function future(int $years): static
    {
        $this->futureYears = $years;

        return $this;
    }

    public function range(int $past, int $future): static
    {
        $this->pastYears = $past;
        $this->futureYears = $future;

        return $this;
    }

    protected function getYearsOptions(): array
    {
        $currentYear = Carbon::now()->year;

        $start = $currentYear + $this->pastYears;
        $end = $currentYear + $this->futureYears;

        if ($start > $end) {
            [$start, $end] = [$end, $start];
        }

        $years = [];

        for ($year = $start; $year <= $end; ++$year) {
            $years[$year] = (string) $year;
        }

        return $years;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->options(fn () => $this->getYearsOptions());

        // Common setup for all XotBaseSelect components can be added here.
    }
}
