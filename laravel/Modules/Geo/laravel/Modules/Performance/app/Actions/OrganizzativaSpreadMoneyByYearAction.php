<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Spatie\QueueableAction\QueueableAction;

/**
 * ---
 */
class OrganizzativaSpreadMoneyByYearAction
{
    use QueueableAction;

    public function execute(string $year): void
    {
        /*
        $this->updateQuotaTeorica();
        $this->updateBudgetAssegnato();
        $this->updateQuotaEffettiva();
        $this->updateResti();
        $this->updateTotStabi();
        $this->updateRestiPond();
        $this->updateImportoTotale();
        $this->checkSum();
        */
    }
}
