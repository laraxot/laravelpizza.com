<?php

declare(strict_types=1);
/**
 * @see https://gitlab.com/amvisor/filament-failed-jobs/-/blob/master/src/resources/FailedJobsResource.php
 */

namespace Modules\Job\Filament\Resources;

use Modules\Job\Filament\Resources\FailedJobResource\Pages\ListFailedJobs;
use Modules\Job\Models\FailedJob;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class FailedJobResource extends XotBaseResource
{
    protected static ?string $model = FailedJob::class;

    #[Override]
    public function getFormSchemaOld(): array
    {
        return [];
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListFailedJobs::route('/'),
        ];
    }
}
