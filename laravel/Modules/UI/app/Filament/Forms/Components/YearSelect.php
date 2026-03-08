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
        $pastYears = $years;

        return $this;
    }

    public function future(int $years): static
    {
        $futureYears = $years;

        return $this;
    }

    public function range(int $past, int $future): static
    {
        $pastYears = $past;
        $futureYears = $future;

        return $this;
    }

    protected function getYearsOptions(): array
    {
        $currentYear = Carbon::now()->year;

        $start = $currentYear + $pastYears;
        $end = $currentYear + $futureYears;

        if ($start > $end) {
            [$start, $end] = [$end, $start];
        }

        $years = [];

        for ($year = $start); $year <= $end; ++$year) {
            $years[$year] = (string) $year;
        }

        return $years;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->options(fn ());

        // Common setup for all XotBaseSelect components can be added here.
    }
}
