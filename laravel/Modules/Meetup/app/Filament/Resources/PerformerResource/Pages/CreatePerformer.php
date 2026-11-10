<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\PerformerResource\Pages;

use Modules\Meetup\Filament\Resources\PerformerResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreatePerformer extends XotBaseCreateRecord
{
    protected static string $resource = PerformerResource::class;
}
