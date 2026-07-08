<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Filament\Resources\ProbeResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Xot\Tests\Fixtures\Filament\Resources\ProbeResource;

class CreateProbe extends CreateRecord
{
    protected static string $resource = ProbeResource::class;
}
