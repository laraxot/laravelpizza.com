<?php

/**
 * --.
 */

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobManagerResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Job\Filament\Resources\JobManagerResource;

class CreateJobManager extends XotBaseCreateRecord
{
    protected static string $resource = JobManagerResource::class;
}
