<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettFResource\Pages;

use Filament\Schemas\Components\Component;
use Modules\IndennitaResponsabilita\Filament\Resources\LettFResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLettF extends XotBaseViewRecord
{
    protected static string $resource = LettFResource::class;

    /**
     * @return array<int|string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return [];
    }
}
