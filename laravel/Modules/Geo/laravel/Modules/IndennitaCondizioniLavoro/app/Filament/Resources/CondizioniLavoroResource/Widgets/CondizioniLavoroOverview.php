<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class CondizioniLavoroOverview extends XotBaseWidget
{
    protected string $view = 'indennitacondizionilavoro::filament.resources.user-resource.widgets.user-overview';

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [];
    }
}
