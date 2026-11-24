---
title: "Contratto Filament layout — @filamentStyles / @filamentScripts"
type: rule
module: Cms
status: active
qmd: "filament 5 filamentStyles filamentScripts cms head foot layout notifications vite"
related:
  - ./head-component-adoption-plan.md
  - ../wiki/rules/frontend-stack-canonical.md
  - ../stories/head-sixteen-layout-migration.story.md
  - ../frontoffice-flow.md
  - ../prompts/02.md
---

# Contratto Filament layout (Cms head / foot)

## Scopo e perché

Il front office Laraxot usa componenti Filament/Livewire **fuori** dai panel (notifiche, widget, form). Filament 5 richiede esplicitamente nel layout:

1. `@filamentStyles` nel `<head>` (prima del CSS Vite dell’app/tema)
2. `@filamentScripts` a fine `<body>` (dopo le notifications, prima del JS Vite)

Fonte: [Filament 5 — Configuring your layout](https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout).

Senza queste direttive i componenti FO restano senza CSS/JS: non è un dettaglio estetico, è un contratto di boot.

Questo documento **non** sostituisce [head-component-adoption-plan.md](./head-component-adoption-plan.md) (SEO/parity Sixteen): lo completa sul pezzo asset Filament. Link da: `docs/prompts/02.md`, `frontend-stack-canonical`, story head Sixteen.

## Owner e file

| Pezzo | Path | Direttiva obbligatoria |
|---|---|---|
| Head FO | `resources/views/components/head.blade.php` | `@filamentStyles` |
| Foot FO | `resources/views/components/foot.blade.php` | `@filamentScripts` |
<<<<<<< .merge_file_2vUDJd
| Componenti | `app/View/Components/Head.php`, `Foot.php` | renderano le view sopra; prop `panelAssets` (default `true`) per i siti pubblici senza componenti Filament |
=======
<<<<<<< HEAD
| Componenti | `app/View/Components/Head.php`, `Foot.php` | renderano le view sopra |
=======
<<<<<<< HEAD
| Componenti | `app/View/Components/Head.php`, `Foot.php` | renderano sempre le view sopra |
=======
| Componenti | `app/View/Components/Head.php`, `Foot.php` | renderano le view sopra |
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> .merge_file_1JYKoD
| Temi | es. Trattoria `layouts/main` | usano `<x-cms::head />` + `<x-cms::foot />` — **non** duplicare né omettere |

## Ordine canonico (KISS)

```blade
{{-- head --}}
@filamentStyles
@vite(['resources/css/app.css'], 'themes/'.$pubTheme)

{{-- foot --}}
@livewire('notifications')
@filamentScripts
@vite(['resources/js/app.js'], 'themes/'.$pubTheme)
```

- Notifications: **sempre** `@livewire('notifications')`, mai wrappato in `@auth` (doc Filament).
- `@livewireStyles` / `@livewireScripts`: non richiesti se `livewire.inject_assets` è true e si usano le direttive Filament.
<<<<<<< .merge_file_2vUDJd
- `<x-cms::head :panel-assets="false" />` / `<x-cms::foot :panel-assets="false" />`: `@filamentStyles`, lo script del tema scuro, `@livewire('notifications')` e `@filamentScripts` stanno dentro `@if ($panelAssets)` e si saltano (meno CSS/JS su telefono); `@vite` del tema resta sempre. Default `true`: nessun tema lo spegne oggi.
- `<x-cms::head stylesheet="resources/css/site.css" />`: l'entry Vite del CSS e' una prop (default `resources/css/app.css`), cosi' un tema serve un foglio piu' leggero dove non servono i componenti Filament (Meetup: `site.css` ai visitatori anonimi, `app.css` in login/registrazione e da loggati; test `Modules/Meetup/tests/Feature/SeoTechnicalTest.php`).
- `@stack('head')` sta nel `<head>` dopo il CSS: layout e pagine vi aggiungono tag con `@push('head')` (JS del tema, JSON-LD `Event` del dettaglio evento). Senza lo stack quei tag non arrivavano mai.
=======
>>>>>>> .merge_file_1JYKoD

## Anti-pattern

- Rimuovere `@filamentStyles` / `@filamentScripts` “per alleggerire” il FO
- Mettere notifications solo per utenti autenticati
- Duplicare le direttive nei temi che già includono `x-cms::head` / `x-cms::foot`
<<<<<<< .merge_file_2vUDJd
- Passare `:panel-assets="false"` in una pagina che usa componenti Filament/Livewire o le notifiche: restano senza CSS/JS
=======
<<<<<<< HEAD
=======
- Aggiungere una prop `panelAssets` che non viene valorizzata dai caller
>>>>>>> laraxot/dev
>>>>>>> .merge_file_1JYKoD
- Aggiungere `@filamentStyles` in `metatags` **e** in `head` sulla stessa pagina (una sola fonte)

## Verifica

- Pest: `tests/Unit/Views/FilamentLayoutDirectivesTest.php` (presenza letterale nelle Blade Cms)
- Smoke FO: pagina tema con `<x-cms::head>` / `<x-cms::foot>` carica senza errori console su asset Filament
