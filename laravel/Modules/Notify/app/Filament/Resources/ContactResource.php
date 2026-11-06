<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources;

use Modules\Notify\Models\Contact;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ContactResource extends XotBaseResource
{
    protected static ?string $model = Contact::class;
}
