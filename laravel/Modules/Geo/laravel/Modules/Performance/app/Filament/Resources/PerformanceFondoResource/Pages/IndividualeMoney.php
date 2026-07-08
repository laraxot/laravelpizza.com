<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages;

use Modules\Performance\Actions\Individuale as ActionsIndividuale;
use Modules\Performance\Actions\UpdateHaDirittoAction;
use Modules\Performance\Filament\Resources\PerformanceFondoResource;
use Modules\Performance\Models\Individuale;
use Modules\Ptv\Actions as ActionsPtv;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

/**
 * Undocumented class.
 *
 * @param  Individuale  $record
 */
class IndividualeMoney extends XotBaseViewRecord
{
    protected static string $resource = PerformanceFondoResource::class;

    /**
     * Restituisce la view per la pagina IndividualeMoney.
     */
    public function getView(): string
    {
        // Segue la stessa convenzione di OrganizzativaMoney
        $view = 'performance::performance_fondo.pages.individuale_money';

        return $view;
    }

    /**
     * Restituisce lo schema dell'infolist per la visualizzazione dei dettagli del record.
     *
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    public function getInfolistSchema(): array
    {
        return [];
    }

    /**
     * Esegue la pipeline di calcolo per la performance individuale.
     * Restituisce dati per la view.
     */
    public function getViewData(): array
    {
        // PHPStan Level 10: isset() invece di property_exists() per Eloquent magic properties
        if (! is_object($this->record) || ! isset($this->record->anno)) {
            throw new \RuntimeException('Record non valido o senza proprietà anno');
        }

        $year = (string) ($this->record->anno ?? 0);

        $type = 'dip';
        /*
        app(ActionsIndividuale\UpdateAssenzeAction::class)->execute($year, 'dip');
        // app(UpdateHaDirittoAction::class)->execute(Organizzativa::class, $year, 'dip');
        app(ActionsIndividuale\UpdateQuotaTeoricaAction::class)->execute($year, 'dip');
        app(ActionsIndividuale\UpdateBudgetAssegnatoAction::class)->execute($year, 'dip');
        app(ActionsIndividuale\UpdateQuotaEffettivaAction::class)->execute($year, 'dip');
        app(ActionsIndividuale\UpdateRestiAction::class)->execute($year, 'dip');
        // app(ActionsIndividuale\UpdateTotStabiAction::class)->execute($year, 'dip');
        // app(ActionsIndividuale\UpdateRestiPondAction::class)->execute($year, 'dip');
        app(ActionsIndividuale\UpdateTotValutatoreIdAction::class)->execute($year, 'dip');
        app(ActionsIndividuale\UpdateRestiPondByValutatoreIdAction::class)->execute($year, 'dip');

        // app(ActionsIndividuale\UpdateImportoTotaleAction::class)->execute($year, 'dip');
        app(ActionsIndividuale\UpdateImportoTotaleByValutatoreIdAction::class)->execute($year, 'dip');
        app(ActionsIndividuale\CheckSumAction::class)->execute($year, 'dip');
        */

         $year = (string) ($this->record->anno ?? 0);
        $type = 'dip';
        $class = Individuale::class;
        // app(ActionsPtv\Check\CheckValutatoreAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateGgAnnoAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateGgPresenzaDalalAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdatePercParttimepondDalalAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateAssenzeAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateQuotaTeoricaAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateBudgetAssegnatoAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateQuotaEffettivaAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateRestiAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateTotValutatoreIdAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateRestiPondByValutatoreIdAction::class)->execute($class, $year, $type);

        app(ActionsPtv\Scheda\UpdateImportoTotaleByValutatoreIdAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\CheckSumAction::class)->execute($class, $year, $type);


        return [
            'title' => 'Individuale Money',
            'icon' => 'heroicon-o-currency-euro',
        ];
    }
}
