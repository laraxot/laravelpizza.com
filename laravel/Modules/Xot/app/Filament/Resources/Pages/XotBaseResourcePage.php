<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page as FilamentResourcePage;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

abstract class XotBaseResourcePage extends FilamentResourcePage
{
    use HasRelationManagers;
    use InteractsWithRecord;
    use NavigationLabelTrait;

    protected static string $resource;
}
