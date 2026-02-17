<?php

/**
 * Handles the email verification process for authenticated users.
 *
 * This controller method is responsible for verifying a user's email address
 * when they click on a verification link. It checks that the user is
 * authenticated, that the provided ID and hash match the user's information,
 * and that the email has not already been verified. If the verification is
 * successful, it marks the email as verified and dispatches a Verified event.
 *
 * @param string $id   the ID of the user to be verified
 * @param string $hash the hash of the user's email address
 *
 * @throws AuthorizationException if the verification fails
 *
 * @return RedirectResponse a redirect response to the home page
 */
declare(strict_types=1);

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Controllers\Controller;

class EmailVerificationController extends Controller
{
    public function __invoke(string $id, string $hash): RedirectResponse
    {
        $user = Auth::user();
        if (null === $user) {
            throw new AuthorizationException();
        }

        if (! hash_equals($id, (string) Auth::id())) {
            throw new AuthorizationException();
        }

        if (! hash_equals($hash, sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        if ($user->hasVerifiedEmail()) {
            return redirect(route('home'));
        }

        $user->markEmailAsVerified();

        // Verificare che l'utente implementi l'interfaccia MustVerifyEmail
        if (! $user instanceof MustVerifyEmail) {
            throw new \InvalidArgumentException('L\'utente deve implementare l\'interfaccia MustVerifyEmail');
        }

        event(new Verified($user));

        return redirect(route('home'));
    }
}
