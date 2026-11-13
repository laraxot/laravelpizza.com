<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers\Auth;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\User\Http\Controllers\Controller;

/**
 * Rotta `verification.verify` (PRD-02): segna l'indirizzo come verificato dopo i controlli su utente, id e hash.
 *
 * `id` e `hash` si leggono per nome dalla rotta: il dispatcher passa i parametri scalari per posizione, e un prefisso
 * `{lang}` li sposterebbe (`$id` riceverebbe la lingua).
 */
class EmailVerificationController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! $user instanceof MustVerifyEmail) {
            throw new AuthorizationException;
        }

        $id = $request->route('id');
        $hash = $request->route('hash');
        if (! \is_string($id) || ! \is_string($hash)) {
            throw new AuthorizationException;
        }

        $userId = $user->getAuthIdentifier();
        if (! \is_scalar($userId) || ! hash_equals((string) $userId, $id)) {
            throw new AuthorizationException;
        }

        if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            throw new AuthorizationException;
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        // Chi conferma l'email di solito vuole segnalare: senza una pagina "intended" ancora valida si va al modulo,
        // non alla home (l'URL intended della registrazione e' gia' stato consumato).
        return redirect()->intended(LaravelLocalization::localizeURL('/tickets/create'));
    }
}
