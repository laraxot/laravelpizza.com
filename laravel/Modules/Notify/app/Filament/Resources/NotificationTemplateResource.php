<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages\PreviewNotificationTemplate;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Xot\Filament\Resources\XotBaseResource;

class NotificationTemplateResource extends XotBaseResource
{
    protected static ?string $model = NotificationTemplate::class;

    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
            'preview' => PreviewNotificationTemplate::route('/{record}/preview')];
    }

    /*
     * public static function getEloquentQuery(): Builder
     * {
     * return parent::getEloquentQuery()
     * ->orderBy('name');
     * }
     */
}
