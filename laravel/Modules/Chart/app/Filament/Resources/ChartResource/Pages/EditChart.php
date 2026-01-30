<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\ChartResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Chart\Filament\Resources\ChartResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditChart extends XotBaseEditRecord
{
    protected static string $resource = ChartResource::class;

    /**
     * @return array<string, \Filament\Actions\Action | \Filament\Actions\ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
