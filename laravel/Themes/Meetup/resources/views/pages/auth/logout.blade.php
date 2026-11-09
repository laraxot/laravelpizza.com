<?php

declare(strict_types=1);

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

use function Laravel\Folio\name;

/*
 * Pagina GET di logout (es. link da email o bookmark).
 * Il nome di rotta è "auth.logout" e non "logout": quest'ultimo appartiene alla rotta POST
 * di Modules/User/routes/web.php usata dai form di navigazione; due rotte con lo stesso nome
 * renderebbero route('logout') dipendente dall'ordine di registrazione.
 */
name('auth.logout');

new class extends Component
{
    public function logout(Logout $logout): void
    {
        if (auth()->check()) {
            $logout();
        }

        $this->redirect(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeUrl('/'));
    }
};

?>

<x-layouts.main>
    @volt('auth.logout')
        <div wire:init="logout" class="flex min-h-screen items-center justify-center">
            <p class="text-lg">{{ __('pub_theme::auth.logout.in_progress') }}</p>
        </div>
    @endvolt
</x-layouts.main>
