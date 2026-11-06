<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Widgets;

use Illuminate\Support\Facades\Artisan;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Gemello Filament del ritirato Http\Livewire\Schedule\Status.
 */
class ScheduleStatusWidget extends XotBaseWidget
{
    public string $out = '';

    /** @var view-string */
    protected string $view = 'job::filament.widgets.schedule-status';

    protected int|string|array $columnSpan = 'full';

    public function artisan(string $cmd): void
    {
        if (! in_array($cmd, $this->getAllowedCommands(), true)) {
            return;
        }

        $this->out .= '<hr/>';
        Artisan::call($cmd);
        $this->out .= e(Artisan::output());
        $this->out .= '<hr/>';
    }

    /**
     * @return array<int, string>
     */
    public function getAllowedCommands(): array
    {
        return [
            'job:schedule-list',
            'schedule:clear-cache',
            'schedule:list',
            'schedule:run',
            'schedule:test',
            'schedule-monitor:sync',
            'schedule-monitor:list',
        ];
    }
}
