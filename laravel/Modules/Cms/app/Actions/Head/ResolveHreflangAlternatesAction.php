<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\QueueableAction\QueueableAction;

/**
 * Alternative linguistiche (hreflang) della pagina corrente.
 *
 * Ogni versione deve elencare se stessa e tutte le altre con URL assolute
 * (Google: link reciproci); `x-default` punta alla lingua predefinita.
 */
final class ResolveHreflangAlternatesAction
{
    use QueueableAction;

    public const string X_DEFAULT = 'x-default';

    /**
     * @param list<string>|null $onlyLocales lingue in cui la pagina esiste davvero; `null` = tutte quelle supportate
     *
     * @return array<string, string> codice lingua => URL assoluta
     */
    public function execute(?array $onlyLocales = null): array
    {
        $urls = [];
        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $code) {
            $url = LaravelLocalization::getLocalizedURL($code, null, [], true);
            if (is_string($url) && (null === $onlyLocales || in_array((string) $code, $onlyLocales, true))) {
                $urls[(string) $code] = $url;
            }
        }

        return $this->build($urls, LaravelLocalization::getDefaultLocale());
    }

    /**
     * @param array<string, string> $localizedUrls codice lingua => URL della stessa pagina in quella lingua
     *
     * @return array<string, string>
     */
    public function build(array $localizedUrls, string $defaultLocale): array
    {
        $alternates = [];
        foreach ($localizedUrls as $code => $url) {
            $alternates[$code] = $this->withoutQuery($url);
        }

        if (count($alternates) < 2) {
            return [];
        }

        if (isset($alternates[$defaultLocale])) {
            $alternates[self::X_DEFAULT] = $alternates[$defaultLocale];
        }

        return $alternates;
    }

    private function withoutQuery(string $url): string
    {
        return explode('#', explode('?', $url, 2)[0], 2)[0];
    }
}
