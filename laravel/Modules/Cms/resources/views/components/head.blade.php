{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout

  OBBLIGATORIO in <head>: @filamentStyles (prima del CSS Vite del tema).
  Senza di esso i componenti Filament/Livewire fuori pannello non hanno CSS.
  @livewireStyles non si ripete: gli asset Livewire sono già coperti da Filament + inject_assets.
<<<<<<< HEAD
  Con :panel-assets="false" (siti pubblici senza componenti Filament) CSS Filament e script del tema scuro
  non si caricano: Livewire, se la pagina ha componenti, si inietta da solo.
=======
<<<<<<< HEAD
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
--}}
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @head
    <style>[x-cloak] { display: none !important; }</style>
<<<<<<< HEAD
<<<<<<< .merge_file_xcVzDk
=======
>>>>>>> laraxot/dev
    <script>
        if (typeof Storage !== 'undefined' && localStorage.getItem('dark_mode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
<<<<<<< HEAD
    @livewireStyles
    @filamentStyles
    @vite([$stylesheet], 'themes/'.$pubTheme)
    @stack('head')
    @stack('styles')
=======
    @if ($panelAssets)
        <script>
            if (typeof Storage !== 'undefined' && localStorage.getItem('dark_mode') === 'true') {
                document.documentElement.classList.add('dark');
            }
        </script>
        @filamentStyles
    @endif
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
>>>>>>> .merge_file_VJcXnj
=======
    @filamentStyles
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
<<<<<<< HEAD
=======
    {{-- Stili dei blocchi della pagina (@push('styles'), per esempio content.simple): senza lo stack non arrivavano mai. --}}
    @stack('styles')
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
</head>
