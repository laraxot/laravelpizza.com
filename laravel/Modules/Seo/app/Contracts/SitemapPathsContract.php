<?php

declare(strict_types=1);

namespace Modules\Seo\Contracts;

/**
 * Fonte di percorsi per la sitemap (DCP-273).
 *
 * Un modulo che possiede pagine di dettaglio proprie (un articolo, una segnalazione) le elenca implementando questo contratto e
 * registrando la classe nel proprio service provider: `$this->app->tag([MiaFonte::class], SitemapPathsContract::TAG)`.
 * Seo legge solo il tag, quindi non conosce i modelli degli altri moduli e la dipendenza va dal modulo proprietario verso Seo.
 *
 * Regola per chi implementa: elencare un percorso se e solo se la sua pagina risponde con quel contenuto, usando la stessa query
 * della rotta di dettaglio (un URL elencato che risponde 404 o con un modello vuoto e' un errore del report Sitemap).
 */
interface SitemapPathsContract
{
    /** Tag del container sotto cui i moduli registrano le proprie fonti. */
    public const string TAG = 'seo.sitemap.paths';

    /**
     * @return list<string> percorsi senza lingua ne' barra iniziale, gia' codificati per l'URL: 'blog/un-articolo', 'tickets/35'
     */
    public function execute(): array;
}
