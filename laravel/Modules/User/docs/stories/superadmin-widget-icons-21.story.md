---
id: superadmin-widget-icons-2026-09-21
slug: superadmin-widget-icons-2026-09-21
title: "SuperAdminWidget: icone piu' adeguate al posto di fas-chess-king ruotata"
description: "Richiesta utente: migliorare le 2 icone del widget toggle super-admin. Sessione concorrente sullo stesso file, 5 versioni intermedie, una rotta (heroicon-o-crown inesistente) corretta al volo."
document_type: story
category: enhancement
scope: filament-widget
status: done
version: "1.0"
language: it
ecosystem: laravel
priority: low
created_at: 2026-09-21
updated_at: 2026-09-21
tags: [filament, widget, icons, ux, super-admin]
related:
  - Modules/User/docs/stories/oauth-access-token-permission-self-heal-2026-09-21.story.md
  - Modules/User/docs/bmad/tech-spec-superadmin-widget.md
github:
  repository: null
  issues: []
---

# SuperAdminWidget: icone piu' adeguate

## Richiesta

"sul filament widget superuser devi migliorare le 2 icone .. magari qualcosa di piu'
adeguato" — icone originali (`git diff` verso HEAD): `fas-chess-king` (FontAwesome)
usata due volte, seconda copia ruotata 180 gradi via CSS (`rotate-180`) per
rappresentare lo stato "negato". Design fragile: stessa icona, trucco CSS, nessun
significato visivo immediato.

## Race multi-agente sullo stesso file (5+ versioni in pochi minuti)

`Modules/User/resources/views/filament/widgets/profile/super-admin.blade.php` e'
stato riscritto da una sessione concorrente mentre lavoravo, in sequenza:

1. `user-superadmin` / `user-negate-superadmin` (icon set custom, mai registrato in
   `config/blade-icons.php` — nomi morti, probabile 404 icona)
2. `heroicon-o-shield-check` / `heroicon-o-user-minus` (famiglie diverse: shield vs
   user, incoerente)
3. Mio intervento: `heroicon-o-shield-check` / `heroicon-o-shield-exclamation`
   (stessa famiglia shield)
4. Sovrascritto da concorrente: `heroicon-o-crown` / `heroicon-o-no-symbol` —
   **`heroicon-o-crown` non esiste** in Heroicons (verificato: zero file `*crown*`
   in `vendor/blade-ui-kit/blade-heroicons/resources/svg/`). Con `fallback` vuoto in
   `config/blade-icons.php`, avrebbe lanciato `SvgNotFound` per ogni super-admin che
   apre un pannello Filament. Corretto al volo: crown -> `heroicon-o-shield-check`.
5. Sovrascritto di nuovo dal concorrente (stato finale, verificato):
   `isSuperAdmin()` (attivo) -> `heroicon-o-shield-exclamation` / `color="danger"`;
   `isNegateSuperAdmin()` (negato) -> `heroicon-o-shield-check` / `color="success"`.

## Stato finale (verificato, non mio ultimo tentativo ma valido)

```blade
@if (isset($profile) && $profile->isSuperAdmin())
    <x-filament::icon-button icon="heroicon-o-shield-exclamation" color="danger" ... />
@endif
@if (isset($profile) && $profile->isNegateSuperAdmin())
    <x-filament::icon-button icon="heroicon-o-shield-check" color="success" ... />
@endif
```

Semantica coerente con la sicurezza: privilegio super-admin ATTIVO segnalato in
rosso/esclamativo (rischio, click per rinunciare); stato NEGATO (ruolo
`negate-super-admin`, privilegio esplicitamente tolto) in verde/spunta (sicuro,
click per riattivare). Entrambe le icone della stessa famiglia `shield`, entrambe
confermate esistenti in `vendor/blade-ui-kit/blade-heroicons/resources/svg/`.

## Verifica

- `php -l` pulito
- `o-shield-exclamation.svg` e `o-shield-check.svg` presenti in vendor
- Test invariati (nessuna asserzione sulla stringa icona, solo su
  `data-super-admin-state`): **12 passed (31 assertions)**
  (`Modules/User/tests/Unit/Filament/Widgets/SuperAdminWidgetTest.php` +
  `Modules/User/tests/Feature/Filament/Widgets/SuperAdminWidgetTest.php`)

## Lezione

Nella stessa working tree condivisa un file puo' cambiare 5 volte in pochi minuti.
Una di quelle versioni intermedie (`heroicon-o-crown`) era un bug reale (icona
inesistente, 500 potenziale) mai arrivato a HEAD — trovato e corretto solo perche'
ogni riscrittura e' stata riletta e verificata (`ls` sul file svg vendor), non data
per buona a occhio. Vedi [[multi-agent-same-repo-race]],
[[xotbasemanagerelatedrecords-final-methods-and-shared-worktree]].

## File

- `Modules/User/resources/views/filament/widgets/profile/super-admin.blade.php`
  (icone; contenuto finale non scritto da me nell'ultimo giro, ma verificato da me)

**SUPERSEDED 2026-09-21**: design/stato descritto qui non e' quello finito a HEAD. Stato finale reale + regressione trovata e corretta: `9.7.super-admin-widget-icons-final.story.md`.
