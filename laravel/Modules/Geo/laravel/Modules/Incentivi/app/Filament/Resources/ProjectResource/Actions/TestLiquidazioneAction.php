<?php

/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Actions;

use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Models\Project;

/**
 * How to get the current project inside an EditPage using "Model $project" as a parameter:
 *
 * How to get the main project:
 * $project = $project;
 * $project_name = $project->nome;
 *
 * How to get relationships:
 * $projet_workgroup = $project->workgroup;
 * $project_activities = $project->activities;
 */
class TestLiquidazioneAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('test liquidazione')
            ->color('primary')
            ->url(fn (Model $project) => route('filament.liquidazione', $project));
    }

    public static function getDefaultName(): ?string
    {
        return 'TestLiquidazioneAction';
    }
}
