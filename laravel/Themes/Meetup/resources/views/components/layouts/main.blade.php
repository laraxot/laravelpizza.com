<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <script>
        (function(){var d=document.documentElement;try{var v=localStorage.getItem('theme_dark');if(v==='false')d.classList.remove('dark');else d.classList.add('dark');}catch(e){d.classList.add('dark');}})();
    </script>
    <x-metatags>
        {{-- Font Inter incluso nel CSS del tema (@fontsource-variable/inter): nessuna richiesta a Google --}}

        @livewireStyles
    </x-metatags>
    <body class="font-sans antialiased bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-white transition-colors duration-200">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-white focus:text-black focus:px-4 focus:py-3 focus:rounded-lg">
            Skip to main content
        </a>
        {{ $slot }}

        @livewireScripts
        {{-- JS dei componenti Filament (schemi, form, azioni) usati dai widget pubblici di login e registrazione --}}
        @filamentScripts
    </body>
</html>
