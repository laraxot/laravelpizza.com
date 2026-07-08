<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MessageResource\Pages;

use Modules\Ptv\Filament\Resources\MessageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

abstract class BaseEditMessage extends XotBaseEditRecord
{
    protected static string $resource = MessageResource::class;
}
