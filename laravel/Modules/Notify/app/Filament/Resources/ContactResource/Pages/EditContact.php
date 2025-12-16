<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\ContactResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Notify\Filament\Resources\ContactResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditContact extends XotBaseEditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
