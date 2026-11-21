<<<<<<< .merge_file_gFZWIe
@props(['title' => null, 'description' => null])
@php
    // Titolo e descrizione espliciti (slot o attributo) per <title> e meta description; senza, li decide il CMS.
    $metaTitle = filled($title) ? trim(strip_tags((string) $title)) : null;
    $metaDescription = filled($description) ? trim(strip_tags((string) $description)) : null;
    // Componenti Filament solo dove servono: moduli di accesso e registrazione (/{lingua}/auth/...) e menu utente da
    // loggati. Il visitatore anonimo (e Googlebot) scarica CSS e JS più leggeri (issue #584).
    $needsFilament = auth()->check() || request()->is('*/auth', '*/auth/*');
@endphp
=======
>>>>>>> .merge_file_Cod40S
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <script>
        (function(){var d=document.documentElement;try{var v=localStorage.getItem('theme_dark');if(v==='false')d.classList.remove('dark');else d.classList.add('dark');}catch(e){d.classList.add('dark');}})();
    </script>
<<<<<<< .merge_file_gFZWIe
    {{-- <head> del CMS (Modules/Cms/View/Components/Head): titolo, descrizione, canonical, hreflang delle sole lingue scritte,
         robots, Open Graph, dati strutturati (Organization/WebSite in home, pagina + briciole altrove). Le pagine aggiungono
         i loro tag con @push('head') (es. JSON-LD Event nel dettaglio evento). --}}
    @push('head')
        @vite(['resources/js/app.js'], 'themes/'.\Modules\Xot\Datas\MetatagData::make()->getPubTheme())
    @endpush
    <x-cms::head :title="$metaTitle" :description="$metaDescription" :stylesheet="$needsFilament ? 'resources/css/app.css' : 'resources/css/site.css'" />
=======
    <x-metatags>
        {{-- Meetup Theme Fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @livewireStyles
    </x-metatags>
>>>>>>> .merge_file_Cod40S
    <body class="font-sans antialiased bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-white transition-colors duration-200">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-white focus:text-black focus:px-4 focus:py-3 focus:rounded-lg">
            {{ __('pub_theme::layout.skip_links.main_content.label') }}
        </a>
        {{ $slot }}

        @livewireScripts
<<<<<<< .merge_file_gFZWIe
        {{-- JS dei componenti Filament (schemi, form, azioni) usati dai widget pubblici di login e registrazione --}}
        @if($needsFilament)
            @filamentScripts
        @endif
=======
        @filamentScripts(withCore: true)
>>>>>>> .merge_file_Cod40S
    </body>
</html>
