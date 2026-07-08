<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Clusters;

use Filament\Clusters\Cluster as FilamentCluster;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

class XotBaseCluster extends FilamentCluster
{
    use NavigationLabelTrait;
}
