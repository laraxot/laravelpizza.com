<?php

declare(strict_types=1);

use function Laravel\Folio\name;

name('password.request');

?>

{{--
  Password dimenticata (DCP-290): stesso guscio, stessa resa e stessa lingua del login. Prima era lo scaffold Volt in inglese,
  senza header, footer ne' main. Logica: ForgotPasswordWidget (Spatie Password broker); testi: user::password_recovery.*.
--}}
<x-layouts.app
    :title="__('user::password_recovery.title')"
    :meta-description="__('user::password_recovery.intro')"
>
    <div class="page-content content" data-dc data-side="content">
        @include('pub_theme::components.pages.auth-password-reset')
    </div>
</x-layouts.app>
