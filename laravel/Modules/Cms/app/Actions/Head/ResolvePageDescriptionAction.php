<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Illuminate\Support\Str;
use Modules\Cms\Models\Page;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_replace;

/**
 * Descrizione di una pagina CMS, ricavata dal suo stesso testo: il primo `subtitle` (o `description`) dei blocchi
 * nella lingua richiesta, di solito quello dell'hero. Non si inventa nulla e non si ripiega su un'altra lingua:
 * senza testo adatto restituisce `null` e il chiamante usa la descrizione del sito.
 */
final class ResolvePageDescriptionAction
{
    use QueueableAction;

    /** Oltre ~160 caratteri i motori accorciano la descrizione da soli. */
    private const int LIMIT = 160;

    /** Sotto questa lunghezza il testo è un'etichetta, non una descrizione. */
    private const int MINIMUM = 20;

    /** @var list<string> */
    private const array KEYS = ['subtitle', 'description'];

    public function execute(Page $page, string $locale): ?string
    {
        return $this->fromRaw($page->getRawOriginal('content_blocks'), $locale);
    }

    public function fromRaw(mixed $rawBlocks, string $locale): ?string
    {
        $map = (new ResolveWrittenLocalesAction)->localeMap($rawBlocks);
        $blocks = $map !== null ? ($map[$locale] ?? null) : null;
        if (! is_array($blocks)) {
            return null;
        }

        foreach ($blocks as $block) {
            $data = is_array($block) ? ($block['data'] ?? null) : null;
            if (! is_array($data)) {
                continue;
            }

            foreach (self::KEYS as $key) {
                $text = $this->clean($data[$key] ?? null);
                if ($text !== null) {
                    return $this->truncate($text);
                }
            }
        }

        return null;
    }

    private function clean(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $text = Str::of(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8'))->replaceMatches('/\s+/u', ' ')->trim()->toString();

        // Una chiave di traduzione grezza («ns::file.chiave») non è testo da pubblicare.
        return mb_strlen($text) >= self::MINIMUM && ! str_contains($text, '::') ? $text : null;
    }

    private function truncate(string $text): string
    {
        if (mb_strlen($text) <= self::LIMIT) {
            return $text;
        }

        $cut = mb_substr($text, 0, self::LIMIT - 1);
        $space = mb_strrpos($cut, ' ');

        return rtrim($space !== false && $space > self::LIMIT / 2 ? mb_substr($cut, 0, $space) : $cut, ' ,.;:-').'…';
    }
}
