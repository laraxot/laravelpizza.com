<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Pages;

use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewAddress extends XotBaseViewRecord
{
    protected static string $resource = AddressResource::class;

    #[\Override]
    public function getInfolistSchema(): array
    {
        return [];
    }
}
