<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Modules\Lang\Filament\Resources\LangBaseResource;
use Modules\Notify\Models\MailTemplate;

class MailTemplateResource extends LangBaseResource
{
    protected static ?string $model = MailTemplate::class;
}
