<?php

declare(strict_types=1);

// app/Rules/OpeningHoursRule.php

namespace Modules\UI\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Modules\UI\Actions\Datetime\GetDaysMappingAction;
use Modules\Xot\Filament\Traits\TransTrait;

class OpeningHoursRule implements ValidationRule
{
    use TransTrait;

    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function validate(string $_attribute, mixed $value, \Closure $fail): void
    {
        $days = app(GetDaysMappingAction::class)->execute();
        /*
         * foreach ($days as $dayKey => $dayLabel) {
         * $hours = $value[$dayKey];
         *
         * foreach ($hours as $hourKey => $hour) {
         * if(is_string($hour) && $hour===''){
         *
         * $fail("L'orario di {$hourKey} deve essere impostato per il {$dayLabel}.");
         * }
         * }
         * }
         */
        foreach ($days as $dayKey => $dayLabel) {
            /* @phpstan-ignore-next-line */
            $dayHours = $value[$dayKey] ?? [];

            if (! \is_array($dayHours)) {
                continue;
            }

            // Type narrowing per dayLabel
            $dayLabelString = \is_string($dayLabel) ? $dayLabel : (string) $dayLabel;

            // Valida ogni sessione (mattina e pomeriggio)
            $this->validateSession($dayHours, 'morning', $dayLabelString, $fail);
            $this->validateSession($dayHours, 'afternoon', $dayLabelString, $fail);

            // Valida la coerenza tra sessioni dello stesso giorno
            $this->validateDayLogic($dayHours, $dayLabelString, $fail);
        }
    }

    /**
     * Valida la coerenza tra le sessioni dello stesso giorno.
     */
    private function validateDayLogic(array $dayHours, string $dayLabel, \Closure $fail): void
    {
        $morningTo = $this->cleanTimeValue($dayHours['morning_to'] ?? null);
        $afternoonFrom = $this->cleanTimeValue($dayHours['afternoon_from'] ?? null);

        // Se ci sono entrambe le sessioni, la chiusura mattina deve essere prima dell'apertura pomeriggio
        if (null !== $morningTo && null !== $afternoonFrom) {
            if ($morningTo >= $afternoonFrom) {
                $fail(static::trans('validation.morning_before_afternoon', params: ['day' => $dayLabel]));
            }
        }
    }

    /**
     * Valida una sessione specifica (mattina o pomeriggio).
     */
    private function validateSession(array $dayHours, string $session, string $dayLabel, \Closure $fail): void
    {
        $fromKey = "{$session}_from";
        $toKey = "{$session}_to";
        $sessionLabel = 'morning' === $session
            ? static::trans('validation.opening_hours.morning')
            : static::trans('validation.opening_hours.afternoon');

        $fromTime = $this->cleanTimeValue($dayHours[$fromKey] ?? null);
        $toTime = $this->cleanTimeValue($dayHours[$toKey] ?? null);
        /*
         * // Validazione formato orario
         * if ($fromTime !== null && !$this->isValidTimeFormat($fromTime)) {
         * $fail("L'orario di apertura {$sessionLabel} per {$dayLabel} deve essere nel formato HH:MM.");
         * return;
         * }
         *
         * if ($toTime !== null && !$this->isValidTimeFormat($toTime)) {
         * $fail("L'orario di chiusura {$sessionLabel} per {$dayLabel} deve essere nel formato HH:MM.");
         * return;
         * }
         */
        // Validazione completezza: se uno è specificato, anche l'altro deve esserlo
        if (null !== $fromTime && null === $toTime) {
            $fail(static::trans('validation.opening_hours.missing_closing_time', params: [
                'session' => $sessionLabel,
                'day' => $dayLabel,
            ]));

            return;
        }

        if (null !== $toTime && null === $fromTime) {
            $fail(static::trans('validation.opening_hours.missing_opening_time', params: [
                'session' => $sessionLabel,
                'day' => $dayLabel,
            ]));

            return;
        }

        // Validazione logica: apertura deve essere prima della chiusura
        if (null !== $fromTime && null !== $toTime) {
            if ($fromTime >= $toTime) {
                $fail(static::trans('validation.opening_hours.opening_before_closing', params: [
                    'session' => $sessionLabel,
                    'day' => $dayLabel,
                ]));

                return;
            }
        }
    }

    /**
     * Pulisce il valore dell'orario (rimuove stringhe vuote, spazi, etc.).
     */
    private function cleanTimeValue(mixed $value): ?string
    {
        if (null === $value || '' === $value || '--:--' === $value) {
            return null;
        }

        if (\is_string($value)) {
            $cleaned = trim($value);

            return '' === $cleaned ? null : $cleaned;
        }

        return null;
    }

    /*
     * Verifica se l'orario è nel formato HH:MM valido.
     */
    /*
    private function isValidTimeFormat(string $time): bool
    {
        return (bool) preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $time);
    }
        */
}
