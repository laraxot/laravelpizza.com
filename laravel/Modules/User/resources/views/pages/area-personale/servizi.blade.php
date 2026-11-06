<?php

declare(strict_types=1);

use Livewire\Volt\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('area-personale.servizi');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public function mount(): void
    {
        if (! auth()->check()) {
            $this->redirect(LaravelLocalization::localizeURL('/auth/login'));
        }
    }
};
?>

<x-layouts.app>
    <x-slot name="title">
        {{ __('pub_theme::ui.header_area_personale.my_services.label') }}
    </x-slot>

    @volt('area-personale.servizi')
        <main id="main-container" class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
            <header class="mb-8 max-w-3xl">
                <h1 class="text-3xl font-bold tracking-tight text-slate-950">{{ __('pub_theme::ui.header_area_personale.my_services.label') }}</h1>
                <p class="mt-2 text-lg text-slate-700">{{ __('pub_theme::ui.header_area_personale.my_services.description', ['default' => 'Elenco dei servizi disponibili per l\'utente']) }}</p>
            </header>
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-slate-700">{{ __('user::area_personale.services.placeholder.message') }}</p>
            </div>
        </main>
    @endvolt
</x-layouts.app>
