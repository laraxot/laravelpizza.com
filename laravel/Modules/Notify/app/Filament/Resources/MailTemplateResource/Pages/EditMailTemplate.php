<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Pages;

use Modules\Lang\Filament\Resources\Pages\LangBaseEditRecord;
use Modules\Notify\Filament\Resources\MailTemplateResource;

class EditMailTemplate extends LangBaseEditRecord
{
    protected static string $resource = MailTemplateResource::class;
}
