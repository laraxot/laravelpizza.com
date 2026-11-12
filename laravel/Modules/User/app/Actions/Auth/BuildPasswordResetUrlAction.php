<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use function Safe\preg_replace;

/**
 * URL assoluto del link di reset password nell'email (SEC-007).
 *
 * La radice viene da `config('app.url')`, mai dalla richiesta: `url()` usa l'header `Host`, che chi chiede il reset puo' scegliere,
 * e il link nella casella della vittima punterebbe a un dominio dell'attaccante. Il percorso e' relativo (`route(..., false)`),
 * quindi non dipende dalla richiesta.
 */
final class BuildPasswordResetUrlAction
{
    /**
     * @param  string|null  $email  aggiunta come `?email=`: la pagina del reset la precompila
     */
    public function execute(string $token, ?string $email = null): string
    {
        $root = config('app.url');
        // Lingua letta PRIMA di route(): la generazione dell'URL Folio localizzato reimposta la lingua.
        $locale = app()->getLocale();
        $path = route('password.reset', ['token' => $token], false);
        app()->setLocale($locale);

        // Con le rotte localizzate il percorso porta la prima lingua registrata (/it/...): si usa quella della
        // richiesta, così chi ha chiesto il reset in inglese riceve il link alla pagina in inglese.
        $supported = config('laravellocalization.supportedLocales');
        if (is_array($supported) && array_key_exists($locale, $supported)) {
            $path = preg_replace('#^/[a-z]{2}(?=/)#', '/'.$locale, $path);
        }

        if (is_string($email) && $email !== '') {
            $path .= (str_contains($path, '?') ? '&' : '?').http_build_query(['email' => $email]);
        }

        return rtrim(is_string($root) ? $root : '', '/').$path;
    }
}
