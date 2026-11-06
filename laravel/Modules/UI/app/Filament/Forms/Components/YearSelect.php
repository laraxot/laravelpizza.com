<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Illuminate\Support\Carbon;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;

class YearSelect extends XotBaseSelect
{
    protected int $pastYears = -2;

    protected int $futureYears = 0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->options(fn (): array => $this->withCurrentYear($this->getYearsOptions()));

        // Common setup for all XotBaseSelect components can be added here.
    }

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

    /**
     * L'anno gia' salvato resta tra le opzioni anche se e' fuori dall'intervallo: senza, un record
     * di un anno vecchio mostra la select vuota e il salvataggio fallisce la validazione `in`.
     *
     * @param  array<int, string>  $years
     * @return array<int, string>
     */
    protected function withCurrentYear(array $years): array
    {
        $state = $this->getState();
        if (is_numeric($state) && ! isset($years[(int) $state])) {
            $years[(int) $state] = (string) (int) $state;
            ksort($years);
        }

        return $years;
    }

    /**
     * @return array<int, string>
     */
    protected function getYearsOptions(): array
    {
        $currentYear = Carbon::now()->year;

        $start = $currentYear + $this->pastYears;
        $end = $currentYear + $this->futureYears;

        if ($start > $end) {
            [$start, $end] = [$end, $start];
        }

        $years = [];

        for ($year = $start; $year <= $end; $year++) {
            $years[$year] = (string) $year;
        }

        return $years;
    }
}
