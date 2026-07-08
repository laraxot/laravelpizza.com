<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\DefaultActivity;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateProject extends XotBaseCreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function afterCreate(): void
    {
        $project = $this->getRecord();

        if (! $project instanceof Project) {
            return;
        }

        $this->createProjectActivities($project);

        $this->attachRUPAndDEC($project);
    }

    protected function createProjectActivities(Project $project): void
    {
        $projectType = $project->tipo ?? '';
        $listaDefaultActivity = DefaultActivity::where('tipo', $projectType)->get();

        $incentiveComponent = is_numeric($project->componente_incentivante)
            ? (float) $project->componente_incentivante
            : 0.0;

        foreach ($listaDefaultActivity as $activity) {
            Activity::create([
                'nome' => $activity->nome,
                'tipo' => $activity->tipo,
                'quota_percentuale' => $activity->quota_percentuale,
                'importo' => $incentiveComponent * ($activity->quota_percentuale / 100),
                'anno_competenza' => $activity->anno_competenza,
                'project_id' => isset($project->id) ? $project->id : null,
            ]);
        }
    }

    protected function attachRUPAndDEC(Project $project): void
    {
        $rupId = $project->rup;
        if ($rupId && ! $project->employees()->where('employee_id', $rupId)->where('project_id', $project->id)->exists()) {
            $project->employees()->attach($rupId, ['type' => 'employee_project']);
        }

        $decId = $project->dec;
        if ($decId && ! $project->employees()->where('employee_id', $decId)->where('project_id', $project->id)->exists()) {
            $project->employees()->attach($decId, ['type' => 'employee_project']);
        }
    }
}
