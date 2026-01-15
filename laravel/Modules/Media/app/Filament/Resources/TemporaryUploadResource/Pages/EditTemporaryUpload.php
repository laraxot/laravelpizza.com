<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\TemporaryUploadResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Media\Filament\Resources\TemporaryUploadResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditTemporaryUpload extends XotBaseEditRecord
{
    protected static string $resource = TemporaryUploadResource::class;

    /**
     * @return array<string, \Filament\Actions\Action|\Filament\Actions\ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }
}
