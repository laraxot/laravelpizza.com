<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;

use Override;
use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListNotificationTemplates extends XotBaseListRecords
{
    protected static string $resource = NotificationTemplateResource::class;

    #[Override]
    public function getTableColumns(): array
    {
        return [];
    }
}
