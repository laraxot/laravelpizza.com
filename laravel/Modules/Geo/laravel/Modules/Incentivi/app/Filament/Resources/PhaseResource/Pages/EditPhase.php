<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\PhaseResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Incentivi\Filament\Resources\PhaseResource;
use Modules\Incentivi\Models\Phase;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPhase extends XotBaseEditRecord
{
    protected static string $resource = PhaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        if (! $this->record instanceof Phase) {
            return [];
        }

        $nameAttr = $this->record->getAttribute('name');
        $phase_name = is_string($nameAttr) ? $nameAttr : (string) $nameAttr;
        $project = $this->record->project;
        $project_name = $project ? $project->nome : '';

        return [
            url('incentivi/admin/projects') => 'Progetti',
            url('incentivi/admin/projects/'.($this->record->project_id ?? 0).'/edit') => $project_name,
            url('incentivi/admin/projects/'.($this->record->project_id ?? 0).'/phases') => 'Fasi',
            url('incentivi/admin/phases/'.($this->record->id ?? 0).'/edit') => $phase_name,
            url('incentivi/admin/phases/'.($this->record->id ?? 0).'/edit#') => 'Modifica',
        ];
    }
}
