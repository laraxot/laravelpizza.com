<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Clusters;

use Filament\Clusters\Cluster;

class Profile extends Cluster
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2';
}
