<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Modules\Cms\Models\Page;
use Safe\Exceptions\JsonException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_decode;

/**
 * Lingue in cui una pagina CMS è scritta davvero: titolo **e** contenuto presenti. Le altre ripiegano sulla lingua
 * predefinita (titolo tradotto con corpo italiano, o niente del tutto), quindi sono un duplicato e non vanno né in
 * hreflang né nella sitemap, e il `<head>` le marca `noindex`.
 *
 * Una sola regola per il `<head>` e per la sitemap.
 */
final class ResolveWrittenLocalesAction
{
    use QueueableAction;

    /**
     * @return list<string>|null `null` se il titolo non è leggibile come mappa lingua => testo: nessuna restrizione
     */
    public function execute(Page $page): ?array
    {
        return $this->fromRaw($page->getRawOriginal('title'), $page->getRawOriginal('content_blocks'));
    }

    /**
     * @param  mixed  $rawTitle  titolo grezzo: mappa lingua => testo (array o JSON)
     * @param  mixed  $rawBlocks  blocchi grezzi: mappa lingua => blocchi; `null` o non-mappa = il contenuto non è per lingua, conta solo il titolo
     * @return list<string>|null
     */
    public function fromRaw(mixed $rawTitle, mixed $rawBlocks = null): ?array
    {
        $titles = $this->localeMap($rawTitle);
        if ($titles === null) {
            return null;
        }

        $blocks = $this->localeMap($rawBlocks);
        if ($blocks !== null && array_is_list($blocks)) {
            $blocks = null;
        }

        $written = array_filter(
            $titles,
            fn (mixed $text, int|string $locale): bool => is_string($text) && trim($text) !== ''
                && ($blocks === null || $this->hasBodyBlocks($blocks[$locale] ?? null)),
            ARRAY_FILTER_USE_BOTH,
        );

        return array_values(array_map(strval(...), array_keys($written)));
    }

    /**
     * Una lingua con il solo `hero` e' una pagina vuota: indicizzarla e accoppiarla in hreflang a una pagina piena
     * danneggia entrambe. Un blocco di cui non si legge il tipo conta come corpo: un formato sconosciuto non nasconde mai una pagina.
     */
    private function hasBodyBlocks(mixed $localeBlocks): bool
    {
        if (! is_array($localeBlocks)) {
            return ! empty($localeBlocks);
        }

        foreach ($localeBlocks as $block) {
            if (! is_array($block) || 'hero' !== ($block['type'] ?? null)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Mappa lingua => valore da un array o da un JSON che comincia con `{`; `null` se non è una mappa leggibile.
     *
     * @return array<array-key, mixed>|null
     */
    public function localeMap(mixed $raw): ?array
    {
        if (is_string($raw)) {
            if (! str_starts_with(ltrim($raw), '{')) {
                return null;
            }

            try {
                $raw = json_decode($raw, true);
            } catch (JsonException) {
                return null;
            }
        }

        return is_array($raw) ? $raw : null;
    }
}
