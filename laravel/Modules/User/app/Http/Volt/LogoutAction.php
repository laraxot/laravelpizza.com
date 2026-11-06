<?php

declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function Safe\parse_url;

/*
 * Attribute class Volt\Routing\Attribute\Post does not exist.
 *
 * #[Post('/it/auth/logout', name: 'logout', middleware: ['web', 'auth'])]
 * #[Post('/en/auth/logout', name: 'logout.en', middleware: ['web', 'auth'])]
 */
final class LogoutAction
{
    public function __invoke(?string $lang = null): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        // La route `home` non esiste: la home del front office e' /{locale}
        return redirect('/'.($lang ?? $this->localeFromReferer() ?? app()->getLocale()));
    }

    /**
     * `POST /logout` non ha il prefisso lingua: la lingua in cui l'utente stava navigando sta nel percorso del Referer.
     * Si accetta solo una lingua supportata, cosi' un Referer inventato non decide la destinazione.
     * ponytail: senza Referer (scelta del browser) si ricade sulla lingua dell'app; un campo nascosto nei form la renderebbe esatta.
     */
    private function localeFromReferer(): ?string
    {
        $path = parse_url((string) request()->headers->get('referer'), PHP_URL_PATH);
        $first = is_string($path) ? explode('/', trim($path, '/'))[0] : '';

        return in_array($first, LaravelLocalization::getSupportedLanguagesKeys(), true) ? $first : null;
    }
}
