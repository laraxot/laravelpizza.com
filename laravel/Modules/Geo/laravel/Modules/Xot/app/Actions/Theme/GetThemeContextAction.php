<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Theme;

use Carbon\Carbon;
use Spatie\QueueableAction\QueueableAction;

// Added

/**
 * Action to determine the current thematic context (season, holiday, etc.).
 *
 * This is a central source of truth for "What time of year is it?" from a
 * thematic perspective, allowing Themes and Modules to adapt their
 * behavior/visuals accordingly.
 */
class GetThemeContextAction
{
    use QueueableAction;

    /**
     * Determine the current active context.
     *
     * @return string One of: 'christmas', 'easter', 'summer', 'halloween', 'default'
     */
    public function execute(): string
    {
        $today = Carbon::now();
        $month = $today->month;
        $day = $today->day;

        // Christmas season: December 1 to January 10
        if ((12 === $month && $day >= 1) || (1 === $month && $day <= 10)) {
            return 'christmas';
        }

        // Easter period: Good Friday to Easter Monday
        $easter = $this->getEasterDate($today->year);
        $easterStart = $easter->copy()->subDays(2);
        $easterEnd = $easter->copy()->addDays(1);

        if ($today->between($easterStart, $easterEnd)) {
            return 'easter';
        }

        // Summer period: July 15 to August 31
        if ((7 === $month && $day >= 15) || (8 === $month)) {
            return 'summer';
        }

        // Halloween: October 25 to November 1
        if ((10 === $month && $day >= 25) || (11 === $month && $day <= 1)) {
            return 'halloween';
        }

        return 'default';
    }

    /**
     * Calculate Easter date using the computus algorithm.
     */
    private function getEasterDate(int $year): Carbon
    {
        $a = $year % 19;
        $b = intdiv($year, 100);
        $c = $year % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        $carbon = Carbon::create($year, $month, $day);
        if (! $carbon instanceof Carbon) {
            throw new \RuntimeException('Failed to create Easter date');
        }

        return $carbon;
    }
}
