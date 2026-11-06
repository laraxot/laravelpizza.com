<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Config;

use Modules\Xot\Contracts\YearsConfigContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Anni da proporre in un filtro/select condiviso, secondo il modulo in cui gira.
 *
 * I componenti di Ptv (filtri anno, azioni di import, ...) sono usati da piu' moduli: passano il
 * modello della tabella (o la pagina) e ricevono gli `anni` della SettingPage di quel modulo.
 * Se il modulo non ha anni configurabili, resta l'elenco che il componente aveva nel codice.
 */
class GetYearOptionsAction
{
    use QueueableAction;

    /**
     * @param  list<int>  $fallback  elenco storico del componente
     * @return array<int, string> anno => etichetta, dal piu' recente
     */
    public function execute(string $class, array $fallback): array
    {
        $config = app(ResolveModuleConfigDataAction::class)->execute($class);
        if ($config instanceof YearsConfigContract) {
            return $config->getAnniOptions();
        }

        $options = [];
        foreach (array_reverse($fallback) as $year) {
            $options[$year] = (string) $year;
        }

        return $options;
    }
}
