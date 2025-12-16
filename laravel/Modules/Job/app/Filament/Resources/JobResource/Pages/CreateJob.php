<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobResource\Pages;

use Modules\Job\Filament\Resources\JobResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateJob extends XotBaseCreateRecord
{
    protected static string $resource = JobResource::class;
}
