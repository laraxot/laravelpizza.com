---
title: "Architettura del componente Foot (coda documento)"
type: concept
module: Cms
status: approved
created: 2026-11-09
updated: 2026-11-09
tags: [cms, blade, architecture, foot, scripts, theme, document-shell]
qmd: "cms foot component document tail scripts stack livewire filament vite theme"
related:
  - "./seo-head-architecture.md"
  - "./stories/cms-foot-component.story.md"
---

# Architettura del componente Foot

> Simmetrico a `Head`: il layout non scrive a mano la coda del documento, il
> modulo Cms la fornisce come componente canonico.

## Confine

`Head` copre tutto cio' che vive in `<head>` (elemento completo, aperto e
chiuso); `Foot` copre il **contenuto** di coda del `<body>`: script, stack e
yield. insieme formano la **document shell** canonica del front office: il
tema resta bridge (markup, sezioni, slot) e non duplica piu' script e stack.

I tag `</body>`/`</html>` **restano nel layout**: sono chiusure di elementi
aperti dal layout stesso (`<html>`, `<body>`). Un componente che emettesse
solo tag di chiusura per elementi che non ha aperto sarebbe un frammento
strutturalmente non valido — la simmetria corretta e': `Head` possiede
l'elemento `<head>` intero, `Foot` possiede solo il contenuto finale del body.

## Perche' esiste

Prima di `Foot` ogni layout ripeteva a mano:

- `@livewire('notifications')` (componente notifiche Filament);
- `@filamentScripts`;
- `@vite(['resources/js/app.js'], 'themes/{Tema}')` — con il nome del tema
  cablato in ogni file;
- `@yield('scripts')` — **e basta**: nessun layout Ventuno emetteva
  `@stack('scripts')`, quindi ogni `@push('scripts')` dei componenti
  (Predict, Cms, Geo) veniva silenziosamente scartato.

`Foot` risolve entrambi i problemi: una sola fonte per la coda e `@stack`
finalmente renderizzato.

## Comportamento

`Modules\Cms\View\Components\Foot::render()` risolve `pubTheme` da
`MetatagData` (la stessa sorgente di `Head`, quindi CSS e JS del tema non
possono divergere) e renderizza `cms::components.foot`, che emette in ordine:

1. `@livewire('notifications')` — deve stare nel DOM prima che Alpine/Livewire
   partano (Livewire ha `inject_assets => true` e inietta i propri asset
   automaticamente prima di `</body>`: `@livewireScripts` non serve);
2. `@filamentScripts`;
3. `@vite(['resources/js/app.js'], 'themes/'.$pubTheme)` — modulo defer,
   eseguito dopo il parse (vedi ordering Livewire/Alpine nei docs Sixteen);
4. `@stack('scripts')` — contenuto dei `@push('scripts')`;
5. `@yield('scripts')` — sezioni Folio `@section('scripts')`.

`foot.blade.php` **non** emette `</body>`/`</html>`: la chiusura del
documento e' responsabilita' del layout, che ha aperto i tag.

## Registrazione

- `CmsServiceProvider::boot()`: `Blade::component('cms::foot', Foot::class)`
  (registrazione esplicita, come `cms::head`, per i bundle senza discovery).
- `app/View/Components/_components.json`: entry `foot` per la discovery
  filesystem.

## Uso nei layout

```blade
<!DOCTYPE html>
<html lang="...">
    <x-cms::head />
    <body>
        ...header, main, sezioni CMS...
        <x-cms::foot />
    </body>
</html>
```

Il layout chiude `</body>`/`</html>` **dopo** `<x-cms::foot />`: la
chiusura del documento appartiene a chi ha aperto `<html>`/`<body>`.

## File

- `Modules/Cms/app/View/Components/Foot.php`
- `Modules/Cms/resources/views/components/foot.blade.php`
- Adottato in `Themes/TwentyOne/resources/views/components/layouts/app.blade.php`
  e `Themes/TwentyOne/resources/views/layouts/base.blade.php`.
