<?php

declare(strict_types=1);
/**
 * @see https://github.com/mooxphp/jobs/tree/main
 */

namespace Modules\Job\Filament\Resources;

use Modules\Job\Filament\Resources\JobManagerResource\Pages\CreateJobManager;
use Modules\Job\Filament\Resources\JobManagerResource\Pages\EditJobManager;
use Modules\Job\Filament\Resources\JobManagerResource\Pages\ListJobManagers;
use Modules\Job\Filament\Resources\JobManagerResource\Widgets\JobStatsOverview;
use Modules\Job\Models\JobManager;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class JobManagerResource extends XotBaseResource
{
    protected static ?string $model = JobManager::class;

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListJobManagers::route('/'),
            'create' => CreateJobManager::route('/create'),
            'edit' => EditJobManager::route('/{record}/edit'),
        ];
    }

    #[Override]
    public static function getWidgets(): array
    {
        return [
            JobStatsOverview::class,
        ];
    }
}
