<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\UserResource\Pages;

use Modules\Ptv\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateUser extends XotBaseCreateRecord
{
    protected static string $resource = UserResource::class;
}
