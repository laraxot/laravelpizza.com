<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\EventResource\Pages;

use Modules\Gdpr\Filament\Resources\EventResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditEvent extends XotBaseEditRecord
{
    protected static string $resource = EventResource::class;
}
