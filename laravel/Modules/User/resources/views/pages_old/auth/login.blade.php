<?php

declare(strict_types=1);


use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

middleware(['guest']);
name('login');

?>
{{--
  Ripiego del modulo: il tema possiede la resa e User possiede il widget di autenticazione.
  Se Folio seleziona questo fallback prima della pagina del tema, deve comunque mantenere Design Comuni e Google OAuth.
  @see Modules/User/docs/adr/frontoffice-login-page-ownership.md
--}}
<x-layouts.app :title="__('user::login.title')">
    @if (view()->exists('pub_theme::components.pages.auth-login'))
        @include('pub_theme::components.pages.auth-login')
    @else
        <div class="mx-auto max-w-md px-4 py-12">
            @livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
        </div>
    @endif
</x-layouts.app>
