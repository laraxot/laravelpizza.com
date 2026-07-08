<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Pages;

use Modules\Notify\Filament\Resources\NotificationTemplateResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage;

class PreviewNotificationTemplate extends XotBaseResourcePage
{
    protected static string $resource = NotificationTemplateResource::class;

    protected string $view = 'notify::filament.resources.notification-template-resource.pages.preview-notification-template';

    public function getTitle(): string
    {
        return __('notify::template.preview.title');
    }

    public function getSubheading(): string
    {
        return __('notify::template.preview.subheading');
    }
}
