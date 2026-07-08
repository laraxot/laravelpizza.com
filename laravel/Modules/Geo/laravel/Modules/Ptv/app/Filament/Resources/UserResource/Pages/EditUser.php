<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\UserResource\Pages;

use Modules\Ptv\Filament\Resources\UserResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditUser extends XotBaseEditRecord
{
    protected static string $resource = UserResource::class;
}
