<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

/**
 * Cluster Appearance per raggruppare pagine di personalizzazione aspetto.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseCluster, MAI Filament\Clusters\Cluster direttamente!
 *
 * @see XotBaseCluster
 * @see \Modules\User\docs\errori\class-page-not-found.md
 */
class Appearance extends XotBaseCluster {}
