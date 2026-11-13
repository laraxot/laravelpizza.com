<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\GeoData;

use Spatie\QueueableAction\QueueableAction;

/**
 * File dei comuni italiani da cui Region, Province e Locality (select dell'indirizzo) leggono le opzioni.
 *
 * `comuni-istat.json` e' l'elenco completo (7.904 comuni, fonte ISTAT, formato di matteocontrini/comuni-json:
 * `regione` e `provincia` come {codice, nome}, `cap` come lista). `comuni.json` resta il piccolo campione
 * usato da Comune e dai test: con quello le select proponevano 3 regioni e un cantiere in Emilia-Romagna
 * non si poteva registrare.
 */
class GetItalianMunicipalitiesPathAction
{
    use QueueableAction;

    public function execute(): string
    {
        $full = module_path('Geo', 'resources/json/comuni-istat.json');

        return is_file($full) ? $full : module_path('Geo', 'resources/json/comuni.json');
    }
}
