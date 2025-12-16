<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationResource\Pages;

use Override;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Modules\Notify\Filament\Resources\NotificationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewNotification extends XotBaseViewRecord
{
    protected static string $resource = NotificationResource::class;

    /**
     * @return array<\Filament\Schemas\Components\Component>
     */
    #[Override]
    protected function getInfolistSchema(): array
    {
        return [
            Section::make()->schema([
                TextEntry::make('id'),
                TextEntry::make('type'),
                TextEntry::make('notifiable_type'),
                TextEntry::make('notifiable_id'),
                TextEntry::make('data'),
                TextEntry::make('read_at')->dateTime(),
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('updated_at')->dateTime(),
            ]),
        ];
    }
}
