<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MailTemplateResource\Pages;

use Modules\IndennitaResponsabilita\Filament\Resources\MailTemplateResource;
use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\EditMailTemplate as NotifyEditMailTemplate;

class EditMailTemplate extends NotifyEditMailTemplate
{
    protected static string $resource = MailTemplateResource::class;
}
