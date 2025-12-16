<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\Pages;

use Modules\Meetup\Filament\Resources\EventResource as EventResourceClass;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateEvent extends XotBaseCreateRecord
{
    protected static string $resource = EventResourceClass::class;
}
