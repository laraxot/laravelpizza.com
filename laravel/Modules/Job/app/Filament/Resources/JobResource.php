<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources;

<<<<<<< .merge_file_KsP4gE
use Modules\Job\Filament\Resources\JobResource\Pages\CreateJob;
use Modules\Job\Filament\Resources\JobResource\Pages\EditJob;
=======
use Modules\Job\Filament\Resources\JobResource\Pages\BoardJobs;
>>>>>>> .merge_file_WCVqxk
use Modules\Job\Filament\Resources\JobResource\Pages\ListJobs;
use Modules\Job\Filament\Resources\JobResource\Widgets\JobStatsOverview;
use Modules\Job\Models\Job;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class JobResource extends XotBaseResource
{
    protected static ?string $model = Job::class;

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        // D-3: jobs è scritto dalla coda — niente Create/Edit/payload.
        return [
            'index' => ListJobs::route('/'),
<<<<<<< .merge_file_KsP4gE
            'create' => CreateJob::route('/create'),
            'edit' => EditJob::route('/{record}/edit'),
=======
            'board' => BoardJobs::route('/board'),
>>>>>>> .merge_file_WCVqxk
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
