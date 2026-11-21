<?php

use function Laravel\Folio\{middleware, name};

use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('home');
middleware(PageSlugMiddleware::class);

new class extends Component {};

?>

<x-layouts.app>
    @volt('home')
    <div class="min-h-screen bg-gray-100">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
            {{-- Contenuto Principale (3/4 larghezza) - Occupa 3 colonne su 4 --}}
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <x-page side="content" slug="home" />
                </div>
            </div>

            {{-- Sidebar Destra (1/4 larghezza) - Occupa 1 colonna su 4 --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <x-page side="sidebar" slug="home" />
                </div>
            </div>
        </div>
    </div>
    @endvolt
</x-layouts.app>
