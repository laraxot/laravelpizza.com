<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\LettIResource\Pages;

use Filament\Schemas\Components\Component;
use Modules\IndennitaResponsabilita\Filament\Resources\LettIResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewLettI extends XotBaseViewRecord
{
    protected static string $resource = LettIResource::class;

    /**
     * @return array<int|string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return [];
    }
}
