<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

/**
 * Cluster Passport per raggruppare tutte le risorse OAuth.
 *
 * Questo cluster organizza tutte le funzionalità relative a Laravel Passport
 * in un'unica posizione per migliorare l'usabilità e l'organizzazione.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseCluster, MAI Filament\Clusters\Cluster direttamente!
 *
 * @see XotBaseCluster
 */
class Passport extends XotBaseCluster
{
}
