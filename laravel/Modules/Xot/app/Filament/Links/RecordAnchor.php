<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Links;

use Livewire\Livewire;
use Safe\Exceptions\UrlException;

use function Safe\parse_url;
use function Safe\preg_match;

/**
 * Ancora HTML di una riga di elenco.
 */
final class RecordAnchor
{
    public const string PREFIX = 'record-';

    public const string RETURN_TO_PARAMETER = 'return_to';

    /**
     * Caratteri che il browser legge in modo diverso da `parse_url()`: `\` vale `/`, tab, a capo e
     * spazi iniziali vengono ignorati. `/\evil.example` e `/<TAB>/evil.example` non hanno host per
     * `parse_url()` ma il browser li apre come `//evil.example`.
     */
    private const string UNSAFE_URL_CHARACTERS = '/[\x00-\x20\x7f\\\\]/';

    public static function id(int|string $key): string
    {
        return self::PREFIX.$key;
    }

    public static function fragment(int|string $key): string
    {
        return '#'.self::id($key);
    }

    public static function appendTo(string $url, int|string $key): string
    {
        return explode('#', $url, 2)[0].self::fragment($key);
    }

    /**
     * URL della pagina d'elenco da usare come `return_to`.
     *
     * In una richiesta Livewire (filtro, ordinamento, paginazione) `request()` e' l'endpoint di
     * aggiornamento, non la pagina: un ritorno verso quell'URL non esiste come pagina.
     */
    public static function currentUrl(): string
    {
        return Livewire::isLivewireRequest() ? Livewire::originalUrl() : request()->fullUrl();
    }

    public static function appendReturnTo(string $url, string $returnTo, int|string|null $key = null): string
    {
        if ($key !== null) {
            $returnTo = self::appendTo($returnTo, $key);
        }

        $separator = str_contains($url, '?') ? '&' : '?';

        return $url.$separator.http_build_query([
            self::RETURN_TO_PARAMETER => $returnTo,
        ], '', '&', PHP_QUERY_RFC3986);
    }

    public static function resolveReturnTo(?string $returnTo, int|string $key): ?string
    {
        if (! is_string($returnTo) || $returnTo === '' || preg_match(self::UNSAFE_URL_CHARACTERS, $returnTo) === 1) {
            return null;
        }

        try {
            $parsed = parse_url($returnTo);
        } catch (UrlException) {
            return null;
        }

        $fragment = isset($parsed['fragment']) && is_string($parsed['fragment']) ? $parsed['fragment'] : null;

        if (
            ! self::isSameOrigin($returnTo)
            || ($fragment !== null && preg_match('/^record-[A-Za-z0-9._~-]+$/', $fragment) !== 1)
        ) {
            return null;
        }

        return self::appendTo($returnTo, $key);
    }

    /**
     * Stessa origine = schema, host e porta della richiesta: confrontare solo l'host lascia passare
     * `https://host/` su un'app in http e `host:8080`. Un percorso relativo vale se inizia con una sola `/`.
     */
    private static function isSameOrigin(string $url): bool
    {
        if (str_starts_with($url, '/')) {
            return ! str_starts_with($url, '//');
        }

        return str_starts_with($url, request()->getSchemeAndHttpHost().'/');
    }
}
