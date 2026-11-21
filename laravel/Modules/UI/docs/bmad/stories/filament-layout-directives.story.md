---
title: "Direttive Filament nel layout UI (progetti senza Cms)"
type: story
status: done
module: UI
updated: 2026-11-16
qmd: "Filament layout @filamentStyles @filamentScripts UI main master notifications no Cms"
related:
  - ../../../../../../docs/wiki/memories/filament5-layout-contract-shared-modules.md
  - ../../../Xot/docs/bmad/stories/module-portfolio-topology-no-cms-in-ptvx.story.md
---

# Direttive Filament nel layout UI

## Contesto

In alcuni progetti del portfolio (es. PTVX, solo pannello) il modulo `Cms` **non** è
presente e non va introdotto: i percorsi `Modules/Cms/resources/views/components/head.blade.php`
e `foot.blade.php` lì non esistono. Il contratto Filament 5 si impara dai progetti front office
che hanno `Cms` (`head`/`foot`) e si applica ai layout **reali** del progetto: `UI` e `User`.

Fonte: [Configuring your layout](https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout).

## Regola funzionale

Nei layout Blade che ospitano componenti Filament/Livewire (stessi obblighi di
`cms::head` / `cms::foot` altrove):

1. `@filamentStyles` in `<head>` (prima del CSS Vite del tema/app).
2. `@livewire('notifications')` a fine body **senza** `@auth`.
3. `@filamentScripts` a fine `<body>`.

## Layout owner

- `Modules/UI/resources/views/components/layouts/main.blade.php` e `master.blade.php`
- `Modules/User/.../layouts/main.blade.php`

## Implementazione

- aggiunto `@filamentStyles` nel `head` del layout UI;
- aggiunto `@filamentScripts` nel `body` del layout UI;
- `@livewire('notifications')` nudo, senza `@auth`/`@endauth`;
- non creati file o moduli Cms inesistenti;
- non modificati layout che già rispettavano il contratto.

## Verifica

- Pest `FilamentLayoutDirectivesTest` (lettura file, senza DB);
- PHPStan e rendering del layout in ambiente non produttivo;
- il gate Pest completo resta dipendente dalla disponibilità del database di test.

## Acceptance criteria

- [x] Nei progetti senza `Cms` non viene introdotto `Modules/Cms` né file Cms inesistenti.
- [x] Layout UI/User: `@filamentStyles` nel `head`, `@filamentScripts` e notifications nudo nel `body`.
- [x] Pest `FilamentLayoutDirectivesTest` verde (file-read, no DB).
- [x] Memoria portfolio aggiornata col mapping Cms→UI.
