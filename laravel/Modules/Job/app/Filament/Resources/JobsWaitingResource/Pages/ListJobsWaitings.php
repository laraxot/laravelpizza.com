<?php

declare(strict_types=1);
/**
 * ---.
 */

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Pages;

use Modules\Job\Filament\Resources\JobsWaitingResource;
use Modules\Job\Filament\Resources\JobsWaitingResource\Widgets\JobsWaitingOverview;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListJobsWaitings extends XotBaseListRecords
{
    protected static string $resource = JobsWaitingResource::class;

    /**
     * @return array<class-string>
     */
    public function getHeaderWidgets(): array
    {
        return [
            JobsWaitingOverview::class,
        ];
    }
}
