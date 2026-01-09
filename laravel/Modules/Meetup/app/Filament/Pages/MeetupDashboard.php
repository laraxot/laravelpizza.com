<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Pages;

use Modules\Meetup\Filament\Widgets\EventCalendarWidget;
use Modules\Meetup\Filament\Widgets\MeetupStatsOverviewWidget;
use Modules\Meetup\Filament\Widgets\RecentEventsWidget;
use Modules\Xot\Filament\Pages\XotBasePage;
use Override;

class MeetupDashboard extends XotBasePage
{
    protected string $view = 'meetup::filament.pages.meetup-dashboard';

    /**
     * @return array<int, class-string>
     */
    public function getWidgets(): array
    {
        return [
            MeetupStatsOverviewWidget::class,
            EventCalendarWidget::class,
            RecentEventsWidget::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[Override]
    public function getFormSchema(): array
    {
        return [];
    }
}
