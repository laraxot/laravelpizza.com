# SVG: file .svg e icone Meetup (no inline nelle Blade)

## Filosofia

- **Un’icona = un file** in `Modules/Meetup/resources/svg/`.
- **Nessun SVG inline** nelle Blade: si inquina il template e si duplica il markup. Tutte le icone del modulo/tema Meetup (logo, nav, social) vivono in file `.svg` e si richiamano con `<x-filament::icon icon="meetup-{nome}" />`.

## Dove sono i file

- **Path**: `laravel/Modules/Meetup/resources/svg/`.
- **Registrazione**: il set è registrato da `XotBaseServiceProvider` (Xot) con prefix `meetup`; il path è risolto da `GetModulePathByGeneratorAction` (assets) + `../svg`. Ogni file `nome.svg` diventa icona `meetup-nome`.

## Convenzione nomi

- **Logo**: `logo.svg` → `meetup-logo`.
- **Nav**: `icon-calendar.svg`, `icon-community.svg`, `icon-sponsors.svg`, `icon-chat.svg` → `meetup-icon-calendar`, `meetup-icon-community`, `meetup-icon-sponsors`, `meetup-icon-chat`.
- **UI header/nav**: `icon-language.svg`, `icon-chevron-down.svg`, `icon-check.svg`, `icon-menu.svg` → `meetup-icon-language`, `meetup-icon-chevron-down`, `meetup-icon-check`, `meetup-icon-menu`.
- **Social**: `facebook.svg`, `twitter.svg`, `github.svg` → `meetup-facebook`, `meetup-twitter`, `meetup-github`.

## Logo: non sovrascrivere logo.svg

Il logo ufficiale del modulo Meetup è il **contenuto attuale** di `Modules/Meetup/resources/svg/logo.svg`. **Non sostituire** questo file con altre interpretazioni (pizza slice, icone diverse, ecc.) a meno che non sia **esplicitamente richiesto** dal committente. Vedi [logo-branding-guidelines.md](logo-branding-guidelines.md).

## Uso nelle Blade (tema Meetup)

```blade
<x-filament::icon icon="meetup-logo" class="h-12 w-12 text-red-500" />
<x-filament::icon icon="meetup-icon-calendar" class="h-5 w-5" />
<x-filament::icon icon="meetup-facebook" class="w-6 h-6" />
```

## Contenuto dei file SVG

- Solo il markup SVG (elemento `<svg>...</svg>`), senza wrapper HTML.
- Preferire `stroke="currentColor"` o `fill="currentColor"` per ereditare il colore da `class` (es. `text-red-500`).
- Evitare dimensioni fisse nel file; usare `class="h-5 w-5"` (o simili) sul componente.

## Componenti che usano meetup-* (no SVG inline)

- `Themes/Meetup/resources/views/components/sections/header.blade.php` (header principale)
- `Themes/Meetup/resources/views/components/sections/header/v1.blade.php` (header v1: logo, icon-calendar, icon-chat, icon-language, icon-chevron-down, icon-check, icon-menu)
- `Themes/Meetup/resources/views/components/sections/footer.blade.php`

Se aggiungi una nuova sezione/componente con icone, crea il file in `Modules/Meetup/resources/svg/` e usa `meetup-{nome}`.

## Riferimenti

- Regola: [.cursor/rules/svg-no-hardcoded-blade-icons-meetup.mdc](../../../../.cursor/rules/svg-no-hardcoded-blade-icons-meetup.mdc)
- Memoria: [.cursor/memories/svg-icons-meetup-blade.md](../../../../.cursor/memories/svg-icons-meetup-blade.md)
- Tema: [Themes/Meetup/docs/svg-icons-no-hardcoded-blade.md](../../../themes/meetup/docs/svg-icons-no-hardcoded-blade.md)
- Logo: [logo-branding-guidelines.md](logo-branding-guidelines.md)
