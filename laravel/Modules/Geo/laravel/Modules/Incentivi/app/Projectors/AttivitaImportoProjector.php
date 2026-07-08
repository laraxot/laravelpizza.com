<?php

declare(strict_types=1);

namespace Modules\Incentivi\Projectors;

use Illuminate\Support\Facades\Log;
use Modules\Incentivi\Events\ProgettoImportoTotaleUpdated;
use Modules\Incentivi\Models\Project;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AttivitaImportoProjector extends Projector
{
    public function onImportUpdated(ProgettoImportoTotaleUpdated $event): void
    {
        $project = Project::find($event->projectId);

        Log::warning("Progetto non trovato con uuid: {$event->projectId}");

        // $activity->importo = ($event->componente_incentivante * $activity->quota_percentuale) / 100;

        // $activity->writeable()->save();
    }
}
