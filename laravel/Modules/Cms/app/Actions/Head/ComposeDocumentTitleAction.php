<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_replace;

/**
 * Titolo del documento: «Pagina — Brand», con un solo separatore e il brand una sola volta.
 *
 * I titoli del CMS portano già il brand con separatori diversi («FAQ - Domande - Brand», «Home / Brand»):
 * si toglie quello e si ricompone, così ogni pagina ha la stessa forma e le briciole di pane
 * (`withoutBrand`) usano il nome breve della pagina.
 */
final class ComposeDocumentTitleAction
{
    use QueueableAction;

    private const string SEPARATOR = ' — ';

    /** Caratteri che separano il brand dal titolo nei contenuti già scritti. */
    private const string SEPARATORS = '\-–—|\/·:';

    public function execute(string $pageTitle, string $brand): string
    {
        $title = $this->withoutBrand($pageTitle, $brand);
        $brand = trim($brand);

        if ('' === $title) {
            return $brand;
        }

        if ('' === $brand || false !== mb_stripos($title, $brand)) {
            return $title;
        }

        return $title.self::SEPARATOR.$brand;
    }

    /**
     * Titolo senza il brand in testa o in coda (con qualunque separatore); vuoto se il titolo è solo il brand.
     */
    public function withoutBrand(string $title, string $brand): string
    {
        $title = trim($title);
        $brand = trim($brand);

        if ('' === $brand) {
            return $title;
        }

        if (mb_strtolower($title) === mb_strtolower($brand)) {
            return '';
        }

        $quoted = preg_quote($brand, '/');
        $separators = self::SEPARATORS;
        $title = preg_replace('/\s*['.$separators.']\s*'.$quoted.'\s*$/iu', '', $title);
        $title = preg_replace('/^'.$quoted.'\s*['.$separators.']\s*/iu', '', $title);

        return trim($title);
    }
}
