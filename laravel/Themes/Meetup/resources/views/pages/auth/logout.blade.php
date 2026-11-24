<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\User\Http\Volt\LogoutAction;

use function Laravel\Folio\name;

/*
 * Pagina GET di logout (es. link da email o bookmark): mostra "disconnessione in corso" e, al caricamento
 * (wire:init), chiude la sessione con la stessa action della rotta POST `logout`.
 * Il nome di rotta è "auth.logout" e non "logout": quest'ultimo appartiene alla rotta POST di
 * Modules/User/routes/web.php usata dai form di navigazione; due rotte con lo stesso nome renderebbero
 * route('logout') dipendente dall'ordine di registrazione.
 */
name('auth.logout');

/**
 * @see Themes/Meetup/docs/authentication-ui-ux.md
 */
new class extends Component
{
    /**
     * @see Themes/Meetup/docs/authentication-ui-ux.md
     */
    public function logout(LogoutAction $logout): void
    {
        $this->redirect($logout(LaravelLocalization::getCurrentLocale())->getTargetUrl());
    }
};

?>

<<<<<<< .merge_file_dtJY8c
<x-layouts.main>
    @volt('auth.logout')
        <div wire:init="logout" class="flex min-h-screen items-center justify-center">
            <p class="text-lg">{{ __('pub_theme::auth.logout.in_progress') }}</p>
        </div>
    @endvolt
</x-layouts.main>
=======
<h1 wire:init="logout">{{ __('pub_theme::auth.logout.goodbye.message') }}</h1>
>>>>>>> .merge_file_DAqKC1
