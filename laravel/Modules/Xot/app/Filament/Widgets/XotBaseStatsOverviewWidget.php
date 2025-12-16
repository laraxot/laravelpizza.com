<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as FilamentStatsOverviewWidget;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Classe base per i widget StatsOverview del sistema Xot.
 *
 * Fornisce funzionalità comuni per tutti i widget di statistiche overview.
 * Estende Filament\Widgets\StatsOverviewWidget e aggiunge funzionalità specifiche del progetto.
 */
abstract class XotBaseStatsOverviewWidget extends FilamentStatsOverviewWidget
{
    use TransTrait;
}
