<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Filament\Resources\ActivityResource\Schemas\ActivityForm;

/**
 * Resource con canRestore controllabile per test restoreActivity.
 */
final class ListLogActivitiesRestorableResource extends ActivityResource
{
    public static bool $restoreAllowed = true;

    public static function canRestore(Model $record): bool
    {
        return self::$restoreAllowed;
    }

    public static function getFormClass(): string
    {
        return ActivityForm::class;
    }
}
