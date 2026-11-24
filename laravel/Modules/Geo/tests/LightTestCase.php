<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

<<<<<<< .merge_file_AzgVPr
<<<<<<< HEAD
=======
<<<<<<< HEAD
use Illuminate\Support\Facades\Http;
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
use Illuminate\Support\Facades\Http;
>>>>>>> .merge_file_sK14Fm
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * LightTestCase - Base test class for Geo module.
 * Extends XotBaseTestCase for common test functionality.
 */
<<<<<<< .merge_file_AzgVPr
<<<<<<< HEAD
abstract class LightTestCase extends XotBaseTestCase {}
=======
<<<<<<< HEAD
=======
>>>>>>> .merge_file_sK14Fm
abstract class LightTestCase extends XotBaseTestCase
{
    /**
     * Nessun test di questo modulo deve uscire in rete.
     *
     * ## Perche' serve dichiararlo
     *
     * `Http::fake(['maps.googleapis.com/*' => ...])` **non blocca gli altri
     * host**: una richiesta che nessuna regola intercetta passa alla rete vera.
     * Quattro test di Geo lo facevano senza saperlo, e il risultato era:
     *
     *     cURL error 28: SSL connection timeout
     *       for https://api.open-meteo.com/v1/geocoding?name=Fake%20Address%20XYZ
     *     cURL error 6: Could not resolve host: dev.virtualearth.net
     *
     * `GetCoordinatesByAddressAction` prova cinque fornitori in cascata —
     * Google, Bing, OpenCage, Nominatim, open-meteo — e **gli ultimi due non
     * vogliono chiavi**: azzerare le chiavi nella configurazione non spegne la
     * catena, la fa solo arrivare piu' in fondo. Un test che finge solo Google
     * crede di aver finto tutto.
     *
     * Con `preventStrayRequests()` una richiesta non prevista **lancia**, e il
     * messaggio dice quale URL: il test fallisce subito e per la ragione giusta,
     * invece di attendere un timeout e incolpare la rete. Fuori da questo
     * container, dove la rete c'e', sarebbe peggio: il test passerebbe
     * interrogando un servizio vero, con tempi e risposte che cambiano da una
     * corsa all'altra (base_quaeris_fila5#241).
     */
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }
}
<<<<<<< .merge_file_AzgVPr
=======
abstract class LightTestCase extends XotBaseTestCase {}
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_sK14Fm
