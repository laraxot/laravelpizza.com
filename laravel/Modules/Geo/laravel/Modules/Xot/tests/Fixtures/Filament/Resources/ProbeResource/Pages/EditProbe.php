<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Filament\Resources\ProbeResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\Xot\Tests\Fixtures\Filament\Resources\ProbeResource;

class EditProbe extends EditRecord
{
    protected static string $resource = ProbeResource::class;
}
