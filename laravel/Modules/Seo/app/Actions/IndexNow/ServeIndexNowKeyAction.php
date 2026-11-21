<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\IndexNow;

use Illuminate\Http\Response;
use Modules\Seo\Datas\SeoConfigData;

/**
 * File di verifica IndexNow: `GET /{chiave}.txt` risponde con la chiave, solo se e' quella configurata.
 *
 * I motori che ricevono un invio scaricano questo file per verificare che le URL siano del sito. Qualunque altro
 * `/{x}.txt` risponde 404, come se la rotta non esistesse; con IndexNow spento non esiste nessun file.
 *
 * @see Modules/Seo/docs/adr/search-engine-presence.md
 */
final class ServeIndexNowKeyAction
{
    public function __invoke(string $key): Response
    {
        $configured = SeoConfigData::make()->indexNowKey();
        abort_if($configured === null || ! hash_equals($configured, $key), 404);

        return response($configured, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
