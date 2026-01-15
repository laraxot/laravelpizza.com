<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

/**
 * Cluster per la gestione dell'aspetto visivo del CMS.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseCluster, MAI Filament\Clusters\Cluster direttamente!
 */
class Appearance extends XotBaseCluster
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
}
