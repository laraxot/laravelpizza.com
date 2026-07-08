<?php

declare(strict_types=1);

namespace Modules\Incentivi\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProgettoImportoTotaleUpdated extends ShouldBeStored
{
    public int $projectId;

    public int $importoTotale;

    /**
     * @return void
     */
    public function __construct(int $projectId, int $importoTotale)
    {
        $this->projectId = $projectId;
        $this->importoTotale = $importoTotale;
    }
}
