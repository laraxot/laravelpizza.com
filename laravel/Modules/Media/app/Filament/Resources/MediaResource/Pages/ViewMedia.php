<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\MediaResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Modules\Media\Filament\Resources\MediaResource;
use Modules\Media\Filament\Resources\MediaResource\Widgets\ConvertWidget;
use Modules\Media\Models\Media;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use UnexpectedValueException;

class ViewMedia extends XotBaseViewRecord
{
    protected static string $resource = MediaResource::class;

    /**
     * @return array<string, DeleteAction>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    protected function getHeaderWidgets(): array
    {
        $record = $this->getRecord();
        if (! $record instanceof Media) {
            throw new UnexpectedValueException('The media view requires a Media record.');
        }

        return [
            ConvertWidget::make(['record' => $record]),
        ];
    }
}
