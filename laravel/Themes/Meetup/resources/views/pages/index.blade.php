<?php

use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;

name('home');
middleware(PageSlugMiddleware::class);

new class extends Component {};

?>

<x-layouts.app>
    @volt('home')
        {{-- Larghezza piena come le altre pagine CMS: la colonna laterale era sempre vuota e il hero finiva in un riquadro bianco --}}
        <div>
            <x-page side="content" slug="home" />
        </div>
    @endvolt
</x-layouts.app>
