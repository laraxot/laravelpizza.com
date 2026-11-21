---
id: superadmin-widget-crown-icons-2026-09-21
slug: superadmin-widget-crown-icons-2026-09-21
title: "SuperAdminWidget: icone corona custom + fix bug @svg() nome icona invalido"
description: "Icone stile hero (corona outline, animazione hover) al posto degli heroicon generici; trovato e corretto bug reale: @svg('modulo::svg.file') non e' sintassi valida blade-icons, causava SvgNotFound."
document_type: story
category: bugfix
scope: filament-widget
status: done
version: "1.0"
language: it
ecosystem: laravel
priority: medium
created_at: 2026-09-21
updated_at: 2026-09-21
tags: [filament, widget, icons, ux, super-admin, blade-icons]
related:
  - Modules/User/docs/stories/superadmin-widget-icons-2026-09-21.story.md
github:
  repository: null
  issues: []
---

# SuperAdminWidget: icone corona + fix bug reale @svg()

## Richiesta

"metti una icona stile marvel per superadmin, qualcosa se vuoi divertente elegante
stile outline, con leggera animazione fatti i 2 svg" — evoluzione della story
precedente (`superadmin-widget-icons-2026-09-21.story.md`).

Nota copyright: nessun logo Marvel riprodotto (rischio trademark). Direzione presa:
corona outline generica (tema "super"-admin), non un personaggio specifico.

## Bug reale trovato e corretto

Durante l'ennesima riscrittura concorrente del file (5a+ versione della stessa
sessione pomeridiana), e' comparsa questa chiamata:

```blade
@svg('user::svg.super-admin', 'w-7 h-7 ...')
```

**Sintassi invalida.** `BladeUI\Icons\Factory::splitSetAndName()`
(`vendor/blade-ui-kit/blade-icons/src/Factory.php:196`) spacca il nome icona sul
PRIMO `-` e cerca un set registrato con quel prefisso esatto:

```php
$prefix = Str::before($name, '-');
$set = $this->getSetByPrefix($prefix);
```

Con `'user::svg.super-admin'` il prefix calcolato e' `'user::svg.super'`
(prima del primo `-`, dentro "super-admin") — nessun set con quel nome esiste,
la Factory ripiega sul set `'default'` con l'intera stringa come nome file,
**mai trovato -> `SvgNotFound` -> 500** per ogni utente super-admin che apre un
pannello Filament.

Formato realmente atteso (verificato in `XotBaseServiceProvider::registerBladeIcons()`,
che registra ogni modulo con `$factory->add($this->nameLower, ['path' => ..., 'prefix'
=> $this->nameLower])`): `{prefix-modulo}-{nome-file-senza-estensione}`. Per file
`Modules/User/resources/svg/superadmin.svg` -> icona `user-superadmin`.

**Fix**: `@svg('user::svg.super-admin', ...)` -> `@svg('user-superadmin', ...)`,
stesso per `negate-superadmin`.

## Verifica

```
php artisan tinker --execute="echo svg('user-superadmin','w-7 h-7')->toHtml();"
php artisan tinker --execute="echo svg('user-negate-superadmin','w-7 h-7')->toHtml();"
```
Entrambe risolvono senza eccezioni (prima del fix: `SvgNotFound`).

`xmllint --noout` pulito su entrambi gli SVG. `php -l` pulito sul blade.
`Modules/User/tests/Unit/Filament/Widgets/SuperAdminWidgetTest.php` +
`Modules/User/tests/Feature/Filament/Widgets/SuperAdminWidgetTest.php`:
**12 passed (31 assertions)**.

## Design finale (non scritto da me, verificato da me)

- `Modules/User/resources/svg/superadmin.svg` — corona outline (`viewBox 0 0 24 24`,
  `stroke-width 2`), gemma centrale (`circle.gem`); su hover: corona scala 1.1x,
  gemma "twinkle" (scale pulse via `@keyframes`).
- `Modules/User/resources/svg/negate-superadmin.svg` — stessa corona (scale 0.92x su
  hover, sottotono), diagonale "slash" che lampeggia (`opacity` flash) su hover.
  Animazione SOLO on-hover: elegante, non distrae quando il widget e' inattivo.

## File

- `Modules/User/resources/views/filament/widgets/profile/super-admin.blade.php`
  (fix nome icona `@svg()`)
- `Modules/User/resources/svg/superadmin.svg`, `negate-superadmin.svg` (design corona)

## Lezione

Ennesima conferma [[multi-agent-same-repo-race]]: il file e' stato riscritto 4 volte
solo in QUESTA story (oltre alle 5 della story precedente). Una di quelle riscritture
introduceva una regressione reale (`SvgNotFound`) mai arrivata a HEAD solo perche' ogni
versione e' stata verificata a runtime (`tinker` + `svg()->toHtml()`), non solo con
`php -l` (che non avrebbe mai intercettato l'errore: e' un errore di risoluzione
runtime, non di sintassi).

**SUPERSEDED 2026-09-21**: design/stato descritto qui non e' quello finito a HEAD. Stato finale reale + regressione trovata e corretta: `9.7.super-admin-widget-icons-final.story.md`.
