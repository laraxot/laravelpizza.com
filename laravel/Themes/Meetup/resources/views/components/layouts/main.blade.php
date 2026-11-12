@props(['title' => null, 'description' => null])
@php
    // Titolo e descrizione espliciti (slot o attributo) per <title> e meta description; senza, li decide il CMS.
    $metaTitle = filled($title) ? trim(strip_tags((string) $title)) : null;
    $metaDescription = filled($description) ? trim(strip_tags((string) $description)) : null;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <script>
        (function(){var d=document.documentElement;try{var v=localStorage.getItem('theme_dark');if(v==='false')d.classList.remove('dark');else d.classList.add('dark');}catch(e){d.classList.add('dark');}})();
    </script>
    <x-metatags :title="$metaTitle" :description="$metaDescription">
        {{-- Font Inter incluso nel CSS del tema (@fontsource-variable/inter): nessuna richiesta a Google --}}

        @livewireStyles
    </x-metatags>
    <body class="font-sans antialiased bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-white transition-colors duration-200">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-white focus:text-black focus:px-4 focus:py-3 focus:rounded-lg">
            {{ __('pub_theme::navigation.skip_to_content') }}
        </a>
        {{ $slot }}

        @livewireScripts
        {{-- JS dei componenti Filament (schemi, form, azioni) usati dai widget pubblici di login e registrazione --}}
        @filamentScripts
    </body>
</html>
