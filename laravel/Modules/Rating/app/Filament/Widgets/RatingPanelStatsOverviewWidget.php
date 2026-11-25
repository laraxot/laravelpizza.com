<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;

/**
 * Conteggi di pannello per la Dashboard Rating (criteri e morph).
 *
 * @see Modules/Rating/docs/rating-panel-dashboard.md
 */
class RatingPanelStatsOverviewWidget extends XotBaseStatsOverviewWidget
{
    /**
     * @return array<int, Stat>
     *
     * @see Modules/Rating/docs/rating-panel-dashboard.md
     */
    protected function getStats(): array
    {
        return [
            Stat::make(
                __('rating::panel_stats.ratings.label'),
                (string) Rating::query()->count(),
            )
                ->description(__('rating::panel_stats.ratings.description'))
                ->descriptionIcon('heroicon-m-star')
                ->color('primary'),
            Stat::make(
                __('rating::panel_stats.rating_morphs.label'),
                (string) RatingMorph::query()->count(),
            )
                ->description(__('rating::panel_stats.rating_morphs.description'))
                ->descriptionIcon('heroicon-m-link')
                ->color('success'),
        ];
    }
}
