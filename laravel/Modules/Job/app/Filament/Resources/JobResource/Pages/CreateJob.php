<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobResource\Pages;

use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Modules\Job\Filament\Resources\JobResource;

class CreateJob extends XotBaseCreateRecord
{
    protected static string $resource = JobResource::class;
}
