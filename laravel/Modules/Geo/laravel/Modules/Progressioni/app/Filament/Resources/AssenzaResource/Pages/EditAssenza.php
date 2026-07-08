<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\AssenzaResource\Pages;

use Modules\Progressioni\Filament\Resources\AssenzaResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditAssenza extends XotBaseEditRecord
{
    protected static string $resource = AssenzaResource::class;
}
