<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ActivityResource\Actions;

use Filament\Actions\Action;
use Livewire\Component;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Models\Project;

class ViewProjectAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('Torna alle Attività del Progetto')
            ->icon('heroicon-o-arrow-uturn-left')
            ->url(function (Component $livewire): ?string {
                $data = $livewire->getPropertyValue('data');
                if (! is_array($data)) {
                    return null;
                }
                $projectId = $data['project_id'] ?? null;
                if ($projectId === null) {
                    return null;
                }
                $project = Project::findOrFail($projectId);

                return ProjectResource::getUrl('activities', ['record' => $project]);
            });
    }

    public static function getDefaultName(): ?string
    {
        return 'ViewProjectAction';
    }
}
