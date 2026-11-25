<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

class Clock extends XotBaseWidget
{
    public string $start = '';

    /** @var view-string */
    protected string $view = 'xot::filament.widgets.clock';

    public function begin(): void
    {
        // while ($this->start >= 0) {
        $cond = true;
        while ($cond) {
            // Stream the current count to the browser...
            $this->stream(
                to: 'count',
                content: $this->start,
                replace: true,
            );

            // Pause for 1 second between numbers...
            // sleep(1);

            // Decrement the counter...
            // $this->start = $this->start - 1;
            $this->start = (string) now();
            if ($this->start === 'impossible') {
                $cond = false;
            }
        }
    }
}
