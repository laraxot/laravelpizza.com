<?php

/**
 * Activity Resource Class.
 *
 * Orchestrator Filament per il modello Activity: form/table via Schema/Table XotBase auto-discovery.
 */

declare(strict_types=1);

namespace Modules\Activity\Filament\Resources;

use Modules\Activity\Models\Activity;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource audit log: solo modello; form in Schemas/ActivityForm, colonne in Tables/ActivitiesTable.
 */
class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;
}
