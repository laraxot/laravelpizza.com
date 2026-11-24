{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout

  OBBLIGATORIO in <head>: @filamentStyles (prima del CSS Vite del tema).
  Senza di esso i componenti Filament/Livewire fuori pannello non hanno CSS.
  @livewireStyles non si ripete: gli asset Livewire sono già coperti da Filament + inject_assets.
  Con :panel-assets="false" (siti pubblici senza componenti Filament) CSS Filament e script del tema scuro
  non si caricano: Livewire, se la pagina ha componenti, si inietta da solo.
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
--}}
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @head
    <style>[x-cloak] { display: none !important; }</style>
<<<<<<< .merge_file_3ZlJ1k
=======
    <script>
        if (typeof Storage !== 'undefined' && localStorage.getItem('dark_mode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
<<<<<<< .merge_file_9EnhGR
<<<<<<< .merge_file_YsdCNR
<<<<<<< .merge_file_jEvbsY
>>>>>>> .merge_file_rvBUmt
=======
>>>>>>> .merge_file_HoUbwL
=======
>>>>>>> .merge_file_Q5o35g
=======
>>>>>>> .merge_file_DYnleC
    @if ($panelAssets)
        <script>
            if (typeof Storage !== 'undefined' && localStorage.getItem('dark_mode') === 'true') {
                document.documentElement.classList.add('dark');
            }
        </script>
        @filamentStyles
    @endif
<<<<<<< .merge_file_9EnhGR
<<<<<<< .merge_file_YsdCNR
<<<<<<< .merge_file_jEvbsY
<<<<<<< .merge_file_3ZlJ1k
    @vite([$stylesheet], 'themes/'.$pubTheme)
    {{-- Tag aggiunti dalle pagine e dai layout (@push('head'): JSON-LD dell'evento, JS del tema). --}}
    @stack('head')
=======
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
    @filamentStyles
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
>>>>>>> .merge_file_rvBUmt
=======
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
    @filamentStyles
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
>>>>>>> .merge_file_HoUbwL
=======
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
    @filamentStyles
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
>>>>>>> .merge_file_Q5o35g
=======
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
    @filamentStyles
    @vite(['resources/css/app.css'], 'themes/'.$pubTheme)
>>>>>>> .merge_file_DYnleC
    {{-- Stili dei blocchi della pagina (@push('styles'), per esempio content.simple): senza lo stack non arrivavano mai. --}}
    @stack('styles')
</head>
