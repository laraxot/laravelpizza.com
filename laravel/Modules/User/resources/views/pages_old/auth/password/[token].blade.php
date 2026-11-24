<?php

declare(strict_types=1);

use function Laravel\Folio\name;

/*
 * `/{lang}/auth/password/{token}`: the link in the reset email (`route('password.reset')`, UserServiceProvider).
 * The theme `pages/auth` folder does not have this page and Folio does not fall back to `[container0]`, so this module
 * page serves it. It is transport only: the form and the reset live in `ResetPasswordWidget`, which gets the token here
 * (under Folio `request()->route('token')` is null).
 */
name('password.reset');
?>

{{--
  Nuova password dal link della mail (DCP-290): stesso guscio e stessa resa del login. `$token` e' il segmento del percorso
  (Folio), `?email=` precompila l'indirizzo se il link lo porta. Logica: ResetPasswordWidget (una sola cifratura, evento PasswordReset).
--}}
<x-layouts.app
    :title="__('user::password_recovery.reset_title')"
    :meta-description="__('user::password_recovery.reset_intro')"
>
    <div class="page-content content" data-dc data-side="content">
        @include('pub_theme::components.pages.auth-password-token', ['token' => $token, 'email' => request()->query('email')])
    </div>
</x-layouts.app>
