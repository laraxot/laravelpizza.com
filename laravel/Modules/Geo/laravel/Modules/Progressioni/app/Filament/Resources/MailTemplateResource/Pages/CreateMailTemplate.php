<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MailTemplateResource\Pages;

use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\CreateMailTemplate as NotifyCreateMailTemplate;
use Modules\Progressioni\Filament\Resources\MailTemplateResource;

class CreateMailTemplate extends NotifyCreateMailTemplate
{
    protected static string $resource = MailTemplateResource::class;
}
