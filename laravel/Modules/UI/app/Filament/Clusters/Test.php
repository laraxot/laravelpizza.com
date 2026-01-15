<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

/**
 * Cluster di test per il modulo UI.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseCluster, MAI Filament\Clusters\Cluster direttamente!
 */
final class Test extends XotBaseCluster
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
}
