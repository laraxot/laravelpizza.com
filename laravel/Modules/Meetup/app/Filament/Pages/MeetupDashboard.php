<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Pages;

use Filament\Pages\Page;
use Modules\Meetup\Filament\Widgets\EventCalendarWidget;

class MeetupDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Meetup Dashboard';

    protected static string $view = 'meetup::filament.pages.meetup-dashboard';

    protected static ?string $title = 'Meetup Dashboard';

    public function getWidgets(): array
    {
        return [
            EventCalendarWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 1;
    }
}