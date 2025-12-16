<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ConsentResource\Pages;

use Modules\Gdpr\Filament\Resources\ConsentResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditConsent extends XotBaseEditRecord
{
    protected static string $resource = ConsentResource::class;
}
