<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Filament\Resources\ProbeResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Xot\Tests\Fixtures\Filament\Resources\ProbeResource;

class ListProbes extends ListRecords
{
    protected static string $resource = ProbeResource::class;
}
