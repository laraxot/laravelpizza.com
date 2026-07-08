<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Resources\WebServiceResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Sigma\Filament\Resources\WebServiceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditWebService extends XotBaseEditRecord
{
    protected static string $resource = WebServiceResource::class;

    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
