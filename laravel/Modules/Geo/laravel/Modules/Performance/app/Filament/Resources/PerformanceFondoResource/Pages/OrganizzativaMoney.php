<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\PerformanceFondoResource\Pages;

use Modules\Performance\Actions\Organizzativa as ActionsOrgaizzativa;
use Modules\Performance\Filament\Resources\PerformanceFondoResource;
use Modules\Performance\Models\Organizzativa;
use Modules\Ptv\Actions as ActionsPtv;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class OrganizzativaMoney extends XotBaseViewRecord
{
    // use InteractsWithRecord;

    protected static string $resource = PerformanceFondoResource::class;

    /**
     * @return array<string, mixed>
     */
    public function getInfolistSchema(): array
    {
        return [];
    }

    /**
     * ---.
     */
    public function getView(): string
    {
        // restituisce performance::resources.performance-fondo-resource.pages.organizzativa-money
        // forse e' meglio performance::filament.
        // $view = app(GetViewAction::class)->execute();
        // dddx($view);
        // $view = 'performance::filament.resources.performance-fondo.pages.organizzativa-money';

        $view = 'performance::performance_fondo.pages.organizzativa_money';

        return $view;
    }

    /**
     * @return array<string, mixed>
     */
    public function getViewData(): array
    {
        $year = (string) ($this->record->anno ?? 0);
        $type = 'dip';
        $class = Organizzativa::class;
        // app(ActionsPtv\Check\CheckValutatoreAction::class)->execute($class, $year, $type);
        app(ActionsPtv\Scheda\UpdateGgAnnoAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\UpdateGgPresenzaDalalAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateGgPresenzaDalalAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\UpdatepercParttimepondDalal::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdatePercParttimepondDalalAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\UpdateAssenzeAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateAssenzeAction::class)->execute($class, $year, $type);
        // app(UpdateHaDirittoAction::class)->execute(Organizzativa::class, $year, 'dip');
        // app(ActionsOrgaizzativa\UpdateQuotaTeoricaAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateQuotaTeoricaAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\UpdateBudgetAssegnatoAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateBudgetAssegnatoAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\UpdateQuotaEffettivaAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateQuotaEffettivaAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\UpdateRestiAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateRestiAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\UpdateTotStabiAction::class)->execute($year, 'dip');
        // app(ActionsOrgaizzativa\UpdateRestiPondAction::class)->execute($year, 'dip');
        // app(ActionsOrgaizzativa\UpdateTotValutatoreIdAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateTotValutatoreIdAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\UpdateRestiPondByValutatoreIdAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateRestiPondByValutatoreIdAction::class)->execute($class, $year, $type);

        // app(ActionsOrgaizzativa\UpdateImportoTotaleAction::class)->execute($year, 'dip');
        // app(ActionsOrgaizzativa\UpdateImportoTotaleByValutatoreIdAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\UpdateImportoTotaleByValutatoreIdAction::class)->execute($class, $year, $type);
        // app(ActionsOrgaizzativa\CheckSumAction::class)->execute($year, $type);
        app(ActionsPtv\Scheda\CheckSumAction::class)->execute($class, $year, $type);

        return [
            'title' => 'Organizzativa Money',
            'icon' => 'heroicon-o-currency-euro',
            'year' => $year,
            'type' => $type,
        ];
    }
}
