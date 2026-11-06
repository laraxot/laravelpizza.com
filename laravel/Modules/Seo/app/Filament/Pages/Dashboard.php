<?php

declare(strict_types=1);

namespace Modules\Seo\Filament\Pages;

use Modules\Seo\Filament\Widgets\GenerateSitemapWidget;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    /**
     * @return array<string, mixed>
     */
    public function getWidgets(): array
    {
        return [
            'sitemap' => GenerateSitemapWidget::class,
        ];
    }
}
