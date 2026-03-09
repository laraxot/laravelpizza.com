<?php

declare(strict_types=1);

namespace Modules\Xot\Enums;

use Carbon\Carbon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Collection;
use Modules\Xot\Traits\EnumTrait;

/**
 * Enum per la gestione dei giorni della settimana.
 *
 * Questo enum fornisce funzionalità per:
 * - Rappresentare i giorni della settimana
 * - Ottenere etichette localizzate
 * - Gestire giorni lavorativi e weekend
 * - Calcolare giorni successivi
 * - Integrazione con Filament UI
 */
enum DayOfWeek: int implements HasColor, HasDescription, HasIcon, HasLabel
{
    use EnumTrait;

    case MONDAY = 1;
    case TUESDAY = 2;
    case WEDNESDAY = 3;
    case THURSDAY = 4;
    case FRIDAY = 5;
    case SATURDAY = 6;
    case SUNDAY = 7;

    /**
     * Restituisce l'etichetta abbreviata per questo giorno della settimana.
     */
    public function shortLabel(): string
    {
        $carbon = Carbon::now()->startOfWeek()->addDays($this->value - 1);
        $carbon->locale('it');

        return (string) $carbon->isoFormat('ddd');
    }

    /**
     * Restituisce una collezione dei giorni lavorativi (lunedì-venerdì).
     *
     * @return Collection<int, self>
     */
    public static function workingDays(): Collection
    {
        /** @var Collection<int, self> $result */
        $result = collect(self::cases())->filter(static fn (self $day): bool => $day->value <= 5);

        return $result;
    }

    /**
     * Restituisce una collezione dei giorni del weekend (sabato-domenica).
     *
     * @return Collection<int, self>
     */
    public static function weekendDays(): Collection
    {
        /** @var Collection<int, self> $result */
        $result = collect(self::cases())->filter(static fn (self $day): bool => $day->value > 5);

        return $result;
    }

    /**
     * Determina se questo giorno è un giorno del weekend.
     */
    public function isWeekend(): bool
    {
        return $this->value > 5;
    }

    /**
     * Ottiene il giorno successivo della settimana.
     */
    public function next(): self
    {
        return match ($this) {
            self::MONDAY => self::TUESDAY,
            self::TUESDAY => self::WEDNESDAY,
            self::WEDNESDAY => self::THURSDAY,
            self::THURSDAY => self::FRIDAY,
            self::FRIDAY => self::SATURDAY,
            self::SATURDAY => self::SUNDAY,
            self::SUNDAY => self::MONDAY,
        };
    }
}
