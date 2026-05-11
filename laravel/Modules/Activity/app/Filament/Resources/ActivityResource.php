<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Modules\Activity\Filament\Resources\ActivityResource\Pages\CreateActivity;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\EditActivity;
use Modules\Activity\Filament\Resources\ActivityResource\Pages\ListActivities;
use Modules\Activity\Models\Activity;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

/**
 * Activity Resource Class.
 *
 * This resource class is responsible for configuring the Activity model in the Filament admin panel.
 * It defines the form schema, relations, and pages for managing activity records.
 *
 * NOTE: XotBaseResource does the magic:
 * - form() is FINAL, auto-discovers Schemas/ActivityForm::configure($schema)
 * - table() is FINAL, auto-discovers Tables/ActivitiesTable::configure($table)
 * - Just implement getPages() override, nothing else.
 */
class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListActivities::route('/'),
            'create' => CreateActivity::route('/create'),
            'edit' => EditActivity::route('/{record}/edit'),
        ];
    }
}
