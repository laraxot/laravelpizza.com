# Logo e Branding Guidelines - Laravel Pizza Meetups

## Overview

Il logo ufficiale del modulo Meetup è **un solo file**: `Modules/Meetup/resources/svg/logo.svg`. Si usa ovunque tramite icona Filament `meetup-logo` (vedi [svg-icons-no-hardcoded-blade.md](svg-icons-no-hardcoded-blade.md)). Il componente `<x-ui.logo>` usa internamente `meetup-logo`.

## Regola critica: non sostituire logo.svg

- **Single source of truth**: il logo è il contenuto attuale di `Modules/Meetup/resources/svg/logo.svg`.
- **Non sovrascrivere** il file con altre interpretazioni (pizza slice, icone diverse, ecc.) a meno che non sia **esplicitamente richiesto** dal committente.
- Se si deve cambiare il logo, aggiornare questo file e concordare con il team/committente.

## Uso nelle Blade

```blade
<x-filament::icon icon="meetup-logo" class="h-12 w-12 text-red-500" />
```

Oppure tramite componente:

```blade
<x-ui.logo class="h-8 w-8" />
```

## Caratteristiche tecniche (file logo.svg)

- **ViewBox**: `0 0 24 24`
- **Fill**: `none`, **Stroke**: `currentColor` (eredita colore da `class`)
- Dimensioni: controllate da class Tailwind (es. `h-8 w-8`, `h-12 w-12`, `h-24 w-24`).

## Dimensioni consigliate

- **Navigation**: `h-8 w-8` o `h-12 w-12`
- **Hero**: `h-20 w-20` o `h-24 w-24`
- **Footer**: `h-8 w-8`

## Colori

- Primary: `text-red-500`; hover: `text-red-400`; su sfondo scuro: `text-white`.

## Best practices

- Usare sempre `meetup-logo` (file logo.svg); non duplicare SVG inline.
- Non sostituire il contenuto di logo.svg senza richiesta esplicita.
- Mantenere `currentColor` nel file SVG per ereditare colore da class.

## Riferimenti

- [svg-icons-no-hardcoded-blade.md](svg-icons-no-hardcoded-blade.md)
- [Themes/Meetup/docs/svg-icons-no-hardcoded-blade.md](../../Themes/Meetup/docs/svg-icons-no-hardcoded-blade.md)
- Regola: `.cursor/rules/svg-no-hardcoded-blade-icons-meetup.mdc`
