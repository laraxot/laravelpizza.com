<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Seo;

use Modules\Meetup\Models\Event;
use Modules\Seo\Contracts\SitemapPathsContract;

/**
 * Pagine di dettaglio degli eventi per la sitemap (/{lingua}/events/{slug}).
 *
 * Stessa regola della pagina di dettaglio per un visitatore anonimo: solo eventi pubblicati, futuri e passati (un
 * evento passato resta una pagina valida, con il resoconto). Bozze ed eventi in attesa risponderebbero 404.
 * Registrata sotto SitemapPathsContract::TAG in MeetupServiceProvider: il modulo Seo non conosce gli eventi.
 */
final class ListEventSitemapPathsAction implements SitemapPathsContract
{
    /** @return list<string> */
    public function execute(): array
    {
        return array_values(Event::query()
            ->published()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->orderBy('start_date')
            ->pluck('slug')
            ->filter(static fn (mixed $slug): bool => is_string($slug))
            ->map(static fn (string $slug): string => 'events/'.rawurlencode($slug))
            ->all());
    }
}
