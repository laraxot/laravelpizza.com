<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Widgets\Widget;
use Modules\Meetup\Filament\Actions\ImportEventsAction;
use Modules\Meetup\Filament\Resources\EventResource;
use Modules\Meetup\Filament\Widgets\EventStatsOverviewWidget;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListEvents extends XotBaseListRecords
{
    protected static string $resource = EventResource::class;

    /**
     * Get the header actions.
     *
     * @return array<string, Action|ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make()->icon('heroicon-o-plus'),
            'import_events' => ImportEventsAction::make(),
        ];
    }

    /**
     * Get the header widgets for the page.
     *
     * @return array<int, class-string<Widget>>
     */
    #[Override]
    protected function getHeaderWidgets(): array
    {
        // Un solo riepilogo: EventsStats duplicava i contatori (in inglese e con un totale iscritti diverso),
        // RecentEventsWidget ripeteva la tabella sottostante. Grafico e ultimi eventi restano nella Meetup Dashboard.
        return [
            EventStatsOverviewWidget::class,
        ];
    }
}
