<?php

declare(strict_types=1);

/**
 * ---.
 */

namespace Modules\Job\Traits;

trait FormatSeconds
{
    public function formatSeconds(int $seconds): string
    {
        $days = floor($seconds / (60 * 60 * 24));
        $seconds -= $days * 60 * 60 * 24;

        $hours = floor($seconds / (60 * 60));
        $seconds -= $hours * 60 * 60;

        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        $formattedSeconds = '';

        if ($days > 0) {
            $formattedSeconds .= "{$days} d ";
        }

        if ($hours > 0 || $days > 0) {
            $formattedSeconds .= "{$hours} h ";
        }

        if ($minutes > 0 || $hours > 0 || $days > 0) {
            $formattedSeconds .= "{$minutes} m ";
        }

        if ($days < 1 && ($seconds > 0 || $minutes > 0 || $hours > 0)) {
            $formattedSeconds .= "{$seconds} s";
        }

        return $formattedSeconds;
    }
}
