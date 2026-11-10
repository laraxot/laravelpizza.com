<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\PerformerResource\Pages;

use Modules\Meetup\Filament\Resources\PerformerResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditPerformer extends XotBaseEditRecord
{
    protected static string $resource = PerformerResource::class;
}
