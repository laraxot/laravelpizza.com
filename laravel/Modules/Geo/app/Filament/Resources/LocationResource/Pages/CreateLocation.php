<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Pages;

// use Cheesegrits\FilamentGoogleMaps\Concerns\InteractsWithMaps; // Pacchetto non installato
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;
use Webmozart\Assert\Assert;

class CreateLocation extends XotBaseCreateRecord
{
    // use InteractsWithMaps; // Pacchetto non installato

    protected static string $resource = LocationResource::class;

    protected function getRedirectUrl(): string
    {
        Assert::string($url = $this->getResource()::getUrl('index'));

        return $url;
    }
}
