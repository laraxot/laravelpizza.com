<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\ProjectResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Modules\Incentivi\Filament\Resources\ProjectResource;

class ViewProjectReport extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected string $view = 'incentivi::filament.pages.projects.view-project-report';

    protected static ?string $title = 'Resoconto';

    protected static ?string $navigationLabel = 'Resoconto';
}
