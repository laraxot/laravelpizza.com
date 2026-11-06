<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\FeatureResource\Pages;

use Modules\User\Filament\Resources\FeatureResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListFeatures extends XotBaseListRecords
{
    protected static string $resource = FeatureResource::class;
}
