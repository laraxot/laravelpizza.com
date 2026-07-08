<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\BaseProfileResource\Pages;

use Modules\User\Filament\Resources\BaseProfileResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditProfile extends XotBaseEditRecord
{
    protected static string $resource = BaseProfileResource::class;
}
