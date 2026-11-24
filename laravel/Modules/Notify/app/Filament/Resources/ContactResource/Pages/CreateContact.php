<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\ContactResource\Pages;

use Modules\Notify\Filament\Resources\ContactResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateContact extends XotBaseCreateRecord
{
    protected static string $resource = ContactResource::class;
}
