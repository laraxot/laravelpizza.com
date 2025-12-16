<?php

declare(strict_types=1);

namespace Modules\User\Http\Volt;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/*
 * Attribute class Volt\Routing\Attribute\Post does not exist.
 *
 * #[Post('/logout', name: 'logout', middleware: ['web', 'auth'])]
 */
final class LogoutAction
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home');
    }
}
