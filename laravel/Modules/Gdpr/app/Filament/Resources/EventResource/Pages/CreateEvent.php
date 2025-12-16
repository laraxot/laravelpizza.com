<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\EventResource\Pages;

use Modules\Gdpr\Filament\Resources\EventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateEvent extends XotBaseCreateRecord
{
    protected static string $resource = EventResource::class;
}
