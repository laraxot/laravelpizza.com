<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

/**
 * Cluster di test per il modulo Notify.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseCluster, MAI Filament\Clusters\Cluster direttamente!
 */
class Test extends XotBaseCluster
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
}
