<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Modules\Xot\Filament\Forms\Components\XotBaseDatePicker;

use function Safe\preg_match;

/**
 * InlineDatePicker - Calendario inline minimalista e multilingua.
 *
 * Principi:
 * - DRY: Don't Repeat Yourself - Codice senza duplicazioni
 * - KISS: Keep It Simple, Stupid - Semplicità sopra tutto
 * - Carbon First: Localizzazione automatica tramite Carbon
 * - Design One Theme: UI/UX conforme al tema standard
 */
class InlineDatePicker extends XotBaseDatePicker
{
    /**
     * Mese attualmente visualizzato (formato Y-m).
     */
    public string $currentViewMonth;

    /**
     * Date abilitate per la selezione.
     *
     * @var array<string>|\Closure|null
     */
    protected array|\Closure|null $enabledDates = null;

    /**
     * Vista Blade per il rendering.
     */
    protected string $view = 'ui::filament.forms.components.inline-date-picker';

    /**
     * Setup iniziale del componente.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Inizializzazione con localizzazione Carbon
        Carbon::setLocale(App::getLocale());
        $this->currentViewMonth = now()->format('Y-m');

        // Hydration/Dehydration del valore
        $this->afterStateHydrated(static function (self $component, mixed $state): void {
            if ($state !== null && \is_string($state) && $state !== '') {
                try {
                    $date = Carbon::parse($state);
                    $component->currentViewMonth = $date->format('Y-m');
                } catch (\Exception $e) {
                    // Handle invalid date
                    $component->currentViewMonth = now()->format('Y-m');
                }
            }
        });

        $this->dehydrateStateUsing(static function (self $_component, mixed $state): ?string {
            if ($state !== null && \is_string($state) && $state !== '') {
                try {
                    return Carbon::parse($state)->format('Y-m-d');
                } catch (\Exception $e) {
                    return null;
                }
            }

            return null;
        });
    }

    /**
     * Naviga al mese precedente.
     */
    public function previousMonth(): void
    {
        $currentMonth = Carbon::createFromFormat('Y-m', $this->currentViewMonth);
        if (! $currentMonth) {
            return;
        }
        $this->currentViewMonth = $currentMonth->subMonthNoOverflow()->format('Y-m');
    }

    /**
     * Naviga al mese successivo.
     */
    public function nextMonth(): void
    {
        $currentMonth = Carbon::createFromFormat('Y-m', $this->currentViewMonth);
        if (! $currentMonth) {
            return;
        }
        $this->currentViewMonth = $currentMonth->addMonthNoOverflow()->format('Y-m');
    }

    /**
     * Imposta le date abilitate.
     *
     * @param  array<string>|\Closure  $dates
     */
    public function enabledDates(array|\Closure $dates): static
    {
        $this->enabledDates = $dates;

        return $this;
    }

    /**
     * Imposta il mese corrente di visualizzazione.
     *
     * @param  string  $month  Formato Y-m (es. '2025-06')
     */
    public function currentViewMonth(string $month): static
    {
        // ✅ Validazione robusta - fallback se vuoto o invalido
        if (empty($month) || ! preg_match('/^\d{4}-\d{2}$/', $month)) {
            $this->currentViewMonth = now()->format('Y-m');
        } else {
            // Verifica che sia una data valida
            try {
                Carbon::createFromFormat('Y-m', $month);
                $this->currentViewMonth = $month;
            } catch (\Exception $e) {
                $this->currentViewMonth = now()->format('Y-m');
            }
        }

        return $this;
    }

    /**
     * Ottiene le date abilitate risolte.
     *
     * @return Collection<int, string>
     */
    public function getEnabledDates(): Collection
    {
        $datesRaw = $this->evaluate($this->enabledDates) ?? [];

        if (! is_iterable($datesRaw)) {
            $datesRaw = [];
        }

        /** @var iterable<int|string, mixed> $datesRaw */
        $dates = \is_array($datesRaw) ? $datesRaw : iterator_to_array($datesRaw);

        /** @var Collection<int, non-falsy-string> $result */
        $result = collect($dates)->map(static function (mixed $date): string {
            if (! \is_string($date) || $date === '') {
                return '';
            }
            try {
                return Carbon::parse($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return '';
            }
        })->filter(static fn (string $v): bool => $v !== '')->values(); // Remove empty strings and reindex

        /** @var Collection<int, string> $resultTyped */
        $resultTyped = $result;

        return $resultTyped;
    }

    /**
     * Verifica se una data è abilitata.
     */
    public function isDateEnabled(string $date): bool
    {
        return $this->getEnabledDates()->isEmpty() || $this->getEnabledDates()->contains($date);
    }

    /**
     * Genera i dati del calendario per il mese corrente.
     *
     * @return array<string, mixed>
     */
    public function generateCalendarData(): array
    {
        // ✅ Validazione di sicurezza - assicura che currentViewMonth sia valido
        if (empty($this->currentViewMonth) || ! preg_match('/^\d{4}-\d{2}$/', $this->currentViewMonth)) {
            $this->currentViewMonth = now()->format('Y-m');
        }

        /** @phpstan-ignore method.nonObject */
        $targetMonth = Carbon::createFromFormat('Y-m', $this->currentViewMonth)->startOfMonth();
        /** @phpstan-ignore-next-line */
        $firstDay = $targetMonth->copy()->startOfWeek(Carbon::MONDAY);
        $lastDay = $targetMonth->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $weeks = collect();
        $currentDay = $firstDay->copy();

        while ($currentDay->lte($lastDay)) {
            $week = collect();

            for ($i = 0; $i < 7; $i++) {
                $isCurrentMonth = $currentDay->month === $targetMonth->month;
                $isToday = $currentDay->isToday();

                // Gestione sicura del controllo selezione
                $isSelected = false;
                try {
                    $state = $this->getState();
                    if ($state && \is_string($state)) {
                        $isSelected = $currentDay->isSameDay(Carbon::parse($state));
                    }
                } catch (\Throwable $e) {
                    $isSelected = false;
                }

                $isEnabled = $this->isDateEnabled($currentDay->format('Y-m-d')) && $isCurrentMonth;

                $week->push([
                    'dateString' => $currentDay->format('Y-m-d'),
                    'datetime' => $currentDay->format('Y-m-d'),
                    'day' => $currentDay->day,
                    'isCurrentMonth' => $isCurrentMonth,
                    'isToday' => $isToday,
                    'isSelected' => $isSelected,
                    'isEnabled' => $isEnabled,
                ]);

                $currentDay->addDay();
            }

            $weeks->push($week->toArray());
        }

        return [
            'weeks' => $weeks->toArray(),
            'month' => $targetMonth,
            'monthName' => $targetMonth->translatedFormat('F'),
            'year' => $targetMonth->year,
            'weekdays' => $this->getLocalizedWeekdays(),
        ];
    }

    /**
     * Ottiene i dati per la vista.
     *
     * @return array<string, mixed>
     */
    public function getViewData(): array
    {
        $calendarData = $this->generateCalendarData();

        return array_merge(parent::getViewData(), [
            'calendarData' => $calendarData,
            'currentViewMonth' => $this->currentViewMonth,
            'currentValue' => $this->getState(),
            'enabledDates' => $this->getEnabledDates(),
            'statePath' => $this->getStatePath(),
            'monthName' => $calendarData['monthName'],
            'year' => $calendarData['year'],
            'weekdays' => $calendarData['weekdays'],
        ]);
    }

    /**
     * Ottiene i giorni della settimana localizzati da Carbon.
     *
     * @return array<string>
     */
    protected function getLocalizedWeekdays(): array
    {
        $weekdays = [];
        $monday = Carbon::now()->startOfWeek(Carbon::MONDAY);

        for ($i = 0; $i < 7; $i++) {
            /* @phpstan-ignore property.nonObject */
            $weekdays[] = $monday->copy()->addDays($i)->locale(App::getLocale())->shortLocaleDayOfWeek[0];
        }

        return $weekdays;
    }
}
