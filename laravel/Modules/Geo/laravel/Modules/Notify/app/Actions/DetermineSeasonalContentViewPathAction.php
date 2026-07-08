<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Carbon\Carbon;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class DetermineSeasonalContentViewPathAction
{
    use QueueableAction;

    /**
     * Determines the appropriate seasonal email content view path (Blade view path).
     *
     * @param  string  $defaultViewName  The default content view file name (e.g., 'base-content').
     * @return string The Blade view path for the seasonal content (e.g., 'sixteen::emails.christmas-content').
     */
    public function execute(string $defaultViewName = 'base-content'): string
    {
        $viewFileName = $this->determineViewFileName($defaultViewName);

        // Convert file name to Blade view path
        // e.g., 'christmas-content' -> 'sixteen::emails.christmas-content'
        $viewNameWithoutExtension = pathinfo($viewFileName, PATHINFO_FILENAME);

        return 'sixteen::emails.'.$viewNameWithoutExtension;
    }

    /**
     * Determines the content view file name based on the current date.
     */
    private function determineViewFileName(string $defaultViewName): string
    {
        $today = Carbon::now();
        $month = $today->month;
        $day = $today->day;

        // Christmas season: December 1 to January 10
        if (($month === 12 && $day >= 1) || ($month === 1 && $day <= 10)) {
            return 'christmas-content'; // Returns the base name, will be 'christmas-content.blade.php'
        }

        // Easter period: Good Friday to Easter Monday
        $easter = $this->getEasterDate($today->year);
        $easterStart = $easter->copy()->subDays(2);
        $easterEnd = $easter->copy()->addDays(1);

        if ($today->between($easterStart, $easterEnd)) {
            return 'easter-content';
        }

        // Summer period: July 15 to August 31
        if (($month === 7 && $day >= 15) || ($month === 8)) {
            return 'summer-content';
        }

        // Halloween: October 25 to November 1
        if (($month === 10 && $day >= 25) || ($month === 11 && $day <= 1)) {
            return 'halloween-content';
        }

        // Default content view
        return $defaultViewName;
    }

    /**
     * Calculate Easter date using the computus algorithm.
     *
     * @param  int  $year  The year to calculate Easter for
     * @return Carbon Easter date for the given year (never null)
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
        Assert::isInstanceOf($carbon, Carbon::class); // Added

        return $carbon;
    }
}
