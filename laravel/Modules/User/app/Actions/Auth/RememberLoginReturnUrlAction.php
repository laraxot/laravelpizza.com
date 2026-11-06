<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Http\Request;
use Safe\Exceptions\UrlException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\parse_url;
use function Safe\preg_match;

/**
 * Remembers the page that sent the user to the login page, so that `redirectIntended()` brings them back.
 *
 * The "Accedi" links on ticket, blog and event pages are plain links to `/{lang}/auth/login`. The source is
 * `?redirect=` (explicit, it wins) or the `Referer` header (only when the `auth` middleware has not already saved
 * the protected page in `url.intended`). Only URLs on the same host are kept: no open redirect. Auth pages are
 * ignored, so login never sends the user back to login or registration.
 */
final class RememberLoginReturnUrlAction
{
    use QueueableAction;

    public function execute(Request $request): void
    {
        $redirect = $request->query('redirect');
        $explicit = $this->sameHostUrl($request, is_string($redirect) ? $redirect : null);
        if ($explicit !== null) {
            session()->put('url.intended', $explicit);

            return;
        }

        if (session()->has('url.intended')) {
            return;
        }

        $referer = $this->sameHostUrl($request, $request->headers->get('referer'));
        if ($referer !== null) {
            session()->put('url.intended', $referer);
        }
    }

    private function sameHostUrl(Request $request, ?string $candidate): ?string
    {
        if ($candidate === null || $candidate === '' || str_contains($candidate, '\\') || preg_match('/[\x00-\x1F\x7F]/', $candidate) === 1) {
            return null;
        }

        // A relative path must start with exactly one slash: `//host` is another host for the browser.
        if (preg_match('#^/(?!/)#', $candidate) === 1) {
            $candidate = $request->getSchemeAndHttpHost().$candidate;
        }

        try {
            $parts = parse_url($candidate);
        } catch (UrlException) {
            return null;
        }

        if (! is_array($parts)) {
            return null;
        }

        $scheme = $parts['scheme'] ?? null;
        $host = $parts['host'] ?? null;
        $path = $parts['path'] ?? '/';
        if (! in_array($scheme, ['http', 'https'], true)
            || $host !== $request->getHost()
            || ! is_string($path)
            || preg_match('#(^|/)auth(/|$)#', $path) === 1) {
            return null;
        }

        return $candidate;
    }
}
