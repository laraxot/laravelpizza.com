<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Pages;

use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;
use Modules\Notify\Filament\Resources\MailTemplateResource;

class CreateMailTemplate extends LangBaseCreateRecord
{
    protected static string $resource = MailTemplateResource::class;
}
