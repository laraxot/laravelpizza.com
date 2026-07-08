<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\Incentivi\Actions\UpdateActivitiesEmployeesAction;
use Modules\Incentivi\Filament\Resources\ActivityResource;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Project;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

/**
 * Undocumented class.
 *
 * @property Activity $record
 */
/**
 * @property Project|null $project
 */
class EditActivity extends XotBaseEditRecord
{
    protected static string $resource = ActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
            'torna-alle-attivita' => Action::make('torna-alle-attivita')
                ->label('Torna alle Attività del Progetto')
                ->icon('heroicon-c-arrow-left-circle')
                ->button()
                ->url(fn (Activity $activity) => ProjectResource::getUrl('activities', ['record' => $activity->project]),
                    shouldOpenInNewTab: false),
        ];
    }

    protected function getRelations(): array
    {
        return [
            // \App\Filament\Resources\ActivityResource\RelationManagers\EmployeesRelationManager::class,
        ];
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        if (! $this->record instanceof Activity) {
            return [];
        }

        $nome = $this->record->getAttribute('nome');
        $activity_name = is_string($nome) ? $nome : (string) $nome;
        $project = $this->record->project;
        $project_name = '';
        if ($project !== null && isset($project->nome)) {
            // Fix for PHPStan - avoid direct cast from mixed to string
            $nome = $project->nome;
            $project_name = is_string($nome) ? $nome : (is_numeric($nome) || is_bool($nome) ? (string) $nome : '');
        }

        return [
            url('incentivi/admin/projects') => 'Progetti',
            url('incentivi/admin/projects/'.($this->record->project_id ?? 0).'/edit') => $project_name,
            url('incentivi/admin/projects/'.($this->record->project_id ?? 0).'/activities') => 'Attività',
            url('incentivi/admin/activities/'.($this->record->id ?? 0).'/edit') => $activity_name,
            url('incentivi/admin/activities/'.($this->record->id ?? 0).'/edit#') => 'Modifica',
        ];
    }

    protected function afterSave(): void
    {
        if ($this->record instanceof Activity) {
            app(UpdateActivitiesEmployeesAction::class)->execute($this->record);
        }
    }
}
