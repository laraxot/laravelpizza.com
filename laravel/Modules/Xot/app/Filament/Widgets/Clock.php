<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

// use Symfony\Component\Console\Output\BufferedOutput;

use Filament\Widgets\Widget;

class Clock extends Widget
{
    public string $start = '';

    protected string $view = 'xot::filament.widgets.clock';

    public function begin(): void
    {
        // while ($start >= 0
        $cond = true;
        while ($cond) {
            // Stream the current count to the browser...
            $this->stream(
                to: 'count',
                content: $start,
                replace: true,
            );

            // Pause for 1 second between numbers...
            // sleep(1);

            // Decrement the counter...
            // $start = $this->start - 1;
            $start = (string);
            if ('impossible' === $start
                $cond = false;
            }
        }
    }
}
