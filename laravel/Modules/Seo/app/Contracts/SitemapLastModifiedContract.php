<?php

declare(strict_types=1);

namespace Modules\Seo\Contracts;

use DateTimeInterface;

/**
 * Date di ultima modifica per la sitemap (`<lastmod>`), facoltative accanto a SitemapPathsContract.
 *
 * Una fonte gia' taggata con SitemapPathsContract::TAG che implementa anche questo contratto da' la data vera di ogni
 * percorso (di solito `updated_at`). Google e Bing usano `<lastmod>` solo se e' affidabile: un percorso senza data vera
 * resta senza `<lastmod>`, mai una data inventata. `seo:indexnow` usa le stesse date per reinviare le pagine cambiate.
 *
 * @see Modules/Seo/docs/adr/search-engine-presence.md
 */
interface SitemapLastModifiedContract
{
    /**
     * @return array<string, DateTimeInterface> percorso (come in SitemapPathsContract::execute) => ultima modifica
     */
    public function lastModified(): array;
}
