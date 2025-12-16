<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditAddress extends XotBaseEditRecord
{
    protected static string $resource = AddressResource::class;

    /**
     * @return array<Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
