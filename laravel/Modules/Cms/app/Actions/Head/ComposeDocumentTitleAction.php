<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
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

        if ($title === '') {
            return $brand;
        }

        if ($brand === '' || mb_stripos($title, $brand) !== false) {
            return $title;
        }

        return $title.$this->separator().$brand;
    }

    /**
     * Separatore fra titolo e brand: il tenant lo dichiara in `config/{tenant}/fixcity/head.php`
     * (`title_separator`, default ` — `). Sixteen usa ` | ` per parita' con il front office storico (D-2).
     */
    private function separator(): string
    {
        // I test unitari puri non bootstrappano il container: senza `app()` vale il default del modulo.
        try {
            $config = app(GetTenantConfigArrayAction::class)->execute('head');
        } catch (\Throwable) {
            return self::SEPARATOR;
        }

        $separator = $config['title_separator'] ?? null;

        return is_string($separator) && trim($separator) !== '' ? $separator : self::SEPARATOR;
    }

    /**
     * Titolo senza il brand in testa o in coda (con qualunque separatore); vuoto se il titolo è solo il brand.
     */
    public function withoutBrand(string $title, string $brand): string
    {
        $title = trim($title);
        $brand = trim($brand);

        if ($brand === '') {
            return $title;
        }

        if (mb_strtolower($title) === mb_strtolower($brand)) {
            return '';
        }

        $quoted = preg_quote($brand, '/');
        $separators = self::SEPARATORS;
        $title = Str::of($title)
            ->replaceMatches('/\s*['.$separators.']\s*'.$quoted.'\s*$/iu', '')
            ->replaceMatches('/^'.$quoted.'\s*['.$separators.']\s*/iu', '')
            ->toString();

        return trim($title);
    }
}
