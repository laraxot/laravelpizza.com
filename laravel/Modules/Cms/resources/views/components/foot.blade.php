{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout

  Ordine obbligatorio a fine <body>:
  1. @livewire('notifications') — flash Filament (sempre, non solo per utenti autenticati)
  2. @filamentScripts — OBBLIGATORIO (JS Filament/Livewire per componenti FO)
  3. @vite JS del tema

  @livewireScripts non serve: config('livewire.inject_assets') = true.
<<<<<<< HEAD
  Con :panel-assets="false" i punti 1 e 2 si saltano (siti pubblici senza componenti Filament).
--}}
@if ($panelAssets)
    @livewire('notifications')

    @filamentScripts
@endif
=======
<<<<<<< HEAD
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
=======
>>>>>>> laraxot/dev
--}}
@livewire('notifications')

@filamentScripts
>>>>>>> laraxot/dev
@vite(['resources/js/app.js'], 'themes/'.$pubTheme)

@stack('scripts')
@yield('scripts')
