---
<<<<<<< .merge_file_vYDDoR
title: "Direttive Filament nel layout UI (progetti senza Cms)"
=======
<<<<<<< HEAD
title: "Direttive Filament nel layout UI (progetti senza Cms)"
=======
<<<<<<< .merge_file_qpHdt8
title: "Direttive Filament nel layout UI (PTVX senza Cms)"
=======
title: "Direttive Filament nel layout UI (progetti senza Cms)"
>>>>>>> .merge_file_ClD86L
>>>>>>> laraxot/dev
>>>>>>> .merge_file_OS2W8r
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

<<<<<<< .merge_file_vYDDoR
- [x] Nei progetti senza `Cms` non viene introdotto `Modules/Cms` né file Cms inesistenti.
- [x] Layout UI/User: `@filamentStyles` nel `head`, `@filamentScripts` e notifications nudo nel `body`.
=======
<<<<<<< HEAD
- [x] Nei progetti senza `Cms` non viene introdotto `Modules/Cms` né file Cms inesistenti.
- [x] Layout UI/User: `@filamentStyles` nel `head`, `@filamentScripts` e notifications nudo nel `body`.
=======
<<<<<<< .merge_file_qpHdt8
- [x] Il layout reale contiene `@filamentStyles` nel `head`.
- [x] Il layout reale contiene `@filamentScripts` nel `body`.
- [x] Nessun file Cms inesistente viene introdotto.
## Religione portfolio

`Cms` **non** sta in `base_ptvx_fila5` e non va introdotto. Il contratto
Filament 5 si impara dai progetti FO che hanno `Cms` (`head`/`foot`), e si
applica ai layout **reali** di questo progetto: `UI` e `User`.

Fonte: [Configuring your layout](https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout).

Obblighi (stessi di `cms::head` / `cms::foot` altrove):

1. `@filamentStyles` in `<head>` (prima del CSS Vite del tema/app).
2. `@livewire('notifications')` a fine body **senza** `@auth`.
3. `@filamentScripts` a fine `<body>`.

## Layout owner in PTVX

- `Modules/UI/.../layouts/main.blade.php` e `master.blade.php`
- `Modules/User/.../layouts/main.blade.php`

## Acceptance criteria

- [x] Nessun `Modules/Cms` nel checkout PTVX.
- [x] Layout UI/User: Styles + Scripts + notifications nudo.
=======
- [x] Nei progetti senza `Cms` non viene introdotto `Modules/Cms` né file Cms inesistenti.
- [x] Layout UI/User: `@filamentStyles` nel `head`, `@filamentScripts` e notifications nudo nel `body`.
>>>>>>> .merge_file_ClD86L
>>>>>>> laraxot/dev
>>>>>>> .merge_file_OS2W8r
- [x] Pest `FilamentLayoutDirectivesTest` verde (file-read, no DB).
- [x] Memoria portfolio aggiornata col mapping Cms→UI.
