<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobResource\Pages;

use Modules\Job\Filament\Resources\JobResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListJobs extends XotBaseListRecords
{
    protected static string $resource = JobResource::class;
}
