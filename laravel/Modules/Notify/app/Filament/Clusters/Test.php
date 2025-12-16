<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters;

use Filament\Clusters\Cluster;

class Test extends Cluster
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2';

    // protected static ?string $navigationParentItem = 'Notifications';
    // protected static ?string $navigationGroup = 'Settings';
}
