<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobManagerResource\Pages;

use Modules\Job\Filament\Resources\JobManagerResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListJobManagers extends XotBaseListRecords
{
    protected static string $resource = JobManagerResource::class;
}
