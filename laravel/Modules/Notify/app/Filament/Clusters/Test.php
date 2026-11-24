<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;

/**
 * Cluster di test per il modulo Notify.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseCluster, MAI Filament\Clusters\Cluster direttamente!
 */
class Test extends XotBaseCluster
{
    use SuperAdminOnlyTrait;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
}
