<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Pages;

use Modules\Job\Filament\Resources\JobsWaitingResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateJobsWaiting extends XotBaseCreateRecord
{
    protected static string $resource = JobsWaitingResource::class;
}
