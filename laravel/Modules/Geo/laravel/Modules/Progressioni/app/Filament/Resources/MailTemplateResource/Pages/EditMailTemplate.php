<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MailTemplateResource\Pages;

use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\EditMailTemplate as NotifyEditMailTemplate;
use Modules\Progressioni\Filament\Resources\MailTemplateResource;

class EditMailTemplate extends NotifyEditMailTemplate
{
    protected static string $resource = MailTemplateResource::class;
}
