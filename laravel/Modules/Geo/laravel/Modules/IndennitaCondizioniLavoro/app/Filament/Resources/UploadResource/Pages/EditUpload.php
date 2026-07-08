<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\UploadResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditUpload extends XotBaseEditRecord
{
    protected static string $resource = UploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
