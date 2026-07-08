<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Auth;

use Filament\Pages\Concerns\HasRoutes;
use Modules\Xot\Filament\Pages\Auth\XotBaseLogin;

class Login extends XotBaseLogin
{
    use HasRoutes;

    protected static string $routePath = 'newlogin';

    /**
     * View personalizzata per la pagina di login.
     * Rimuove il logo duplicato e migliora il layout.
     */
    protected string $view = 'filament-panels::pages.auth.login';
}
