<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire\Schedule;

use App\Console\Kernel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Modules\Xot\Actions\GetViewAction;

/**
 * Class Schedule\Status.
 */
class Status extends Component
{
    public array $form_data = [];

    public string $out = '';

    public string $old_value = '';

    public function render(): Renderable
    {
        $view = app(GetViewAction::class)->execute();

        $acts = [
            (object) [
                'name' => 'job:schedule-list',
                'label' => 'job:schedule-list',
            ],
            (object) [
                'name' => 'schedule:clear-cache',
                'label' => 'Delete the cached mutex files created by scheduler',
            ],
            (object) [
                'name' => 'schedule:list',
                'label' => 'List the scheduled commands',
            ],
            (object) [
                'name' => 'schedule:run',
                'label' => 'Run the scheduled commands',
            ],
            (object) [
                'name' => 'schedule:test',
                'label' => 'Run a scheduled command',
            ],
            (object) [
                'name' => 'schedule:work',
                'label' => 'Start the schedule worker',
            ],
            (object) [
                'name' => 'schedule-monitor:sync',
                'label' => 'schedule-monitor:sync',
            ],
            (object) [
                'name' => 'schedule-monitor:list',
                'label' => 'schedule-monitor:list',
            ],
        ];

        $view_params = [
            'view' => $view,
            'acts' => $acts,
        ];

        return view($view, $view_params);
    }

    public function artisan(string $cmd): void
    {
        $this->out .= '<hr/>';
        Artisan::call($cmd);
        $this->out .= Artisan::output();
        $this->out .= '<hr/>';
    }

    public function getScheduledJobs(): Collection
    {
        if (app()->runningInConsole()) {
            return collect([]);
        }
        // Kernel removed in laravel 11
        // new Kernel(app(), new Dispatcher);
        $schedule = app(Schedule::class);

        return collect($schedule->events());
    }
}
