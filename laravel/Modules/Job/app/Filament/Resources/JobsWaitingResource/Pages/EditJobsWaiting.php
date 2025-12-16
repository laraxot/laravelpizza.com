<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobsWaitingResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Job\Filament\Resources\JobsWaitingResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditJobsWaiting extends XotBaseEditRecord
{
    protected static string $resource = JobsWaitingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
