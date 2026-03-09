<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Pages;

use Illuminate\Support\Facades\Artisan;
use Modules\Xot\Filament\Pages\XotBasePage;

class JobStatus extends XotBasePage
{
    public string $out = '';

    protected string $view = 'job::filament.pages.job-status';

    public function artisan(string $cmd): void
    {
        $this->out = '';
        Artisan::call($cmd);
        $this->out .= Artisan::output();
    }

    public function getViewData(): array
    {
        return [
            'acts' => $this->getActs(),
        ];
    }

    public function getActs(): array
    {
        return [
            (object) ['name' => 'queue:clear', 'label' => 'Delete all of the jobs from the specified queue'],
            (object) ['name' => 'queue:failed', 'label' => 'List all of the failed queue jobs'],
            (object) ['name' => 'queue:flush', 'label' => 'Flush all of the failed queue jobs'],
            (object) ['name' => 'queue:restart', 'label' => 'Restart queue worker daemons'],
            (object) ['name' => 'route:list', 'label' => 'Route list'],
        ];
    }
}
