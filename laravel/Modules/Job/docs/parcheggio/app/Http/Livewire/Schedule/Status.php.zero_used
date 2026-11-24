<?php

declare(strict_types=1);

namespace Modules\Job\Http\Livewire\Schedule;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Modules\Xot\Actions\GetViewAction;

/**
 * Class Schedule\Status.
 */
class Status extends Component
{
    /** @var array<string, mixed> */
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
        if (! in_array($cmd, $this->getAllowedCommands(), true)) {
            return;
        }

        $this->out .= '<hr/>';
        Artisan::call($cmd);
        $this->out .= e(Artisan::output());
        $this->out .= '<hr/>';
    }

    /**
     * @return list<string>
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

    /**
     * @return Collection<int, Event>
     */
    public function getScheduledJobs(): Collection
    {
        if (app()->runningInConsole()) {
            /** @var Collection<int, Event> $empty */
            $empty = collect([]);

            return $empty;
        }
        // Kernel removed in laravel 11
        // new Kernel(app(), new Dispatcher);
        $schedule = app(Schedule::class);

        /** @var Collection<int, Event> $events */
        $events = collect($schedule->events())->values();

        return $events;
    }
}
