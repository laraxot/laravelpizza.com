{{--
  Contratto Filament 5.x — Configuring your layout:
  https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout

  Ordine obbligatorio a fine <body>:
  1. @livewire('notifications') — flash Filament (sempre, non solo per utenti autenticati)
  2. @filamentScripts — OBBLIGATORIO (JS Filament/Livewire per componenti FO)
  3. @vite JS del tema

  @livewireScripts non serve: config('livewire.inject_assets') = true.
  Con :panel-assets="false" i punti 1 e 2 si saltano (siti pubblici senza componenti Filament).
<<<<<<< .merge_file_nLaNH9
<<<<<<< .merge_file_6LLP8c
<<<<<<< .merge_file_sXmCf7
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
=======
>>>>>>> .merge_file_o0yr35
=======
>>>>>>> .merge_file_qZe3wq
=======
>>>>>>> .merge_file_Iflp0x
--}}
@if ($panelAssets)
    @livewire('notifications')

    @filamentScripts
@endif
<<<<<<< .merge_file_nLaNH9
<<<<<<< .merge_file_6LLP8c
<<<<<<< .merge_file_sXmCf7
=======
=======
>>>>>>> .merge_file_qZe3wq
=======
>>>>>>> .merge_file_Iflp0x
  @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
--}}
@livewire('notifications')

@filamentScripts
<<<<<<< .merge_file_nLaNH9
<<<<<<< .merge_file_6LLP8c
>>>>>>> .merge_file_o0yr35
=======
>>>>>>> .merge_file_qZe3wq
=======
>>>>>>> .merge_file_Iflp0x
@vite(['resources/js/app.js'], 'themes/'.$pubTheme)

@stack('scripts')
@yield('scripts')
