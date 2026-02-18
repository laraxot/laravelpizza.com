<?php

declare(strict_types=1);

namespace Modules\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = Auth::user();
        if (null === $user) {
            return redirect()->route('filament.user.auth.login');
        }

        // Ottieni il valore hash in modo sicuro
        $routeHash = $request->route('hash');
        if (null === $routeHash) {
            throw new \InvalidArgumentException('Hash di verifica mancante');
        }

        $stringRouteHash = is_string($routeHash) ? $routeHash : '';

        // Utilizziamo getEmailForVerification() solo se disponibile
        $userEmail = method_exists($user, 'getEmailForVerification')
            ? $user->getEmailForVerification()
            : ($user->email ?? '');

        if (! hash_equals(sha1($userEmail), $stringRouteHash)) {
            throw new AuthorizationException();
        }

        // Verifichiamo l'email solo se il metodo esiste
        if (method_exists($user, 'hasVerifiedEmail') && $user->hasVerifiedEmail()) {
            return redirect()->intended(Filament::getUrl());
        }

        // Contrassegna l'email come verificata solo se il metodo esiste
        if (method_exists($user, 'markEmailAsVerified')) {
            $user->markEmailAsVerified();
        }

        // Verificare che l'utente implementi l'interfaccia MustVerifyEmail
        if (! $user instanceof MustVerifyEmail) {
            throw new \InvalidArgumentException('L\'utente deve implementare l\'interfaccia MustVerifyEmail');
        }

        event(new Verified($user));

        return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
    }
}
