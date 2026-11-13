<?php

declare(strict_types=1);

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Modules\User\Actions\Auth\HasVerifiedIdentityAction;
use Symfony\Component\HttpFoundation\Response;

/**
 * Come il middleware `verified` di Laravel, ma accetta anche gli accessi SPID/CIE senza email (vedi {@see HasVerifiedIdentityAction}).
 * Chi non ha un'identità verificata va alla pagina `verification.notice` e ci torna dopo il link.
 */
class EnsureVerifiedIdentity
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app(HasVerifiedIdentityAction::class)->execute($request->user())) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            abort(403, 'Your email address is not verified.');
        }

        return Redirect::guest(route('verification.notice'));
    }
}
