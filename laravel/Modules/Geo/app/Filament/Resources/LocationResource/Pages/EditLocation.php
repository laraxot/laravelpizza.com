<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Webmozart\Assert\Assert;

class EditLocation extends XotBaseEditRecord
{
    // use InteractsWithMaps; // Pacchetto non installato

    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        Assert::string($url = $this->getResource()::getUrl('index'));

        return $url;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            //            LocationResource\Widgets\LocationMapTableWidget::class,
        ];
    }
}
