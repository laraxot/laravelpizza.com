<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

/**
 * Cluster per la gestione del profilo GDPR.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseCluster, MAI Filament\Clusters\Cluster direttamente!
 */
class Profile extends XotBaseCluster
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
}
