<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ProfileResource\Pages;

use Modules\Gdpr\Filament\Resources\ProfileResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateProfile extends XotBaseCreateRecord
{
    protected static string $resource = ProfileResource::class;
}
