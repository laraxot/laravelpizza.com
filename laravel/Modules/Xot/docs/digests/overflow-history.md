---
<<<<<<< HEAD
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 3 file oltre target 100.

### `bmad/stories/0174-docs-ceiling-100-md.story.md` — Docs moduli/temi ≤100 .md (ceiling)


# Docs moduli/temi ≤100 .md (ceiling)

## Context and Problem Statement

Ogni cartella `docs/` di modulo/tema deve restare navigabile per umani e LLM.
Oggi 19/21 owner superano 100 file `.md` (Notify ~2400, User ~2100). Come
rientrare a ≤100 senza perdere decisioni attive, con unione e sintesi (non stub
redirect)?

## Decision Drivers

- Ordine utente: max 100 `.md` per `docs/` di modulo/tema; unire, compattare, sintetizzare
- BMAD + second brain + swarm parallelo + lock
- Conservare story `in-progress`/`review` e ADR/contracts essenziali
- History in git; niente commit da questa lane

## Considered Options

- Solo exact-dup (~288 rimozioni) — insufficiente

### `bmad/stories/0175-no-docs-archive-folders.story.md` — Story 0175 — No docs archive folders


# Story 0175 — No docs archive folders

## Context and Problem Statement

Cartelle `docs/archivio/`, `archive/`, `_archive/` (e simili) fungono da backup
parallelo a Git: secondo SSoT, tetto docs gonfiato, canone non curato. Come
vietarle senza perdere ripristinabilità?

## Decision Drivers

- Ordine utente: niente dump `.md` in cartelle archivio; ripristino = Git
- KISS/DRY + ceiling ≤100 `.md` per owner docs
- Enforcement meccanico (`.gitignore` + Pest)

## Considered Options

- Tenere archivio + stub — rifiutato (secondo SSoT)
- Quarantena fuori da `docs/` — rifiutato (ancora dump)
- **Vietare i nomi cartella sotto `docs/`; storia = Git** — scelto

### `wiki/docs-md-hygiene-debt.md` — Docs md hygiene debt — puntatore misurato


# Docs md hygiene debt — puntatore misurato

SSoT operativo della campagna: [docs-md-filename-date-debt.story.md](../bmad/stories/docs-md-filename-date-debt.story.md).
Questo file è solo un **puntatore corto** (misure + next), non un secondo inventario.

## Perché

I `.md` sotto `Modules/*/docs` e `Themes/*/docs` sono chiavi del second brain.
Date nel filename, duplicati exact/near e marker `<<<<<<<` degradano ricerca e gate
(bootstrap PHPStan fallisce su **PHP** con marker; i md contaminati restano rumore).

## Misura 2026-11-25 (Modules+Themes `docs/`)

| Metrica | Valore |
|---------|-------:|
| Totale `.md` | **15909** |
| Filename con data/year (tutti) | **~36** |
| di cui ACTIVE (non stub, excl. `cci-2026*`) | **0** (boy-scout 2026-11-25b: 5→0) |
| di cui stub `superseded_by` | **~3
- laravel/Modules/Xot/docs/digests/archive-parcheggio.md
- laravel/Modules/Xot/docs/digests/archive-raw.md
- laravel/Modules/Xot/docs/digests/aliases-removed.md
=======
title: "Overflow history Xot"
type: digest
status: active
qmd: "xot docs ceiling overflow"
---

# Overflow history Xot

Overflow Xot ceiling: 35 file.

### `license.md` — license



The MIT License (MIT)

Copyright (c) :vendor_name <author@domain.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The MIT License (MIT)


### `stories/0024-ci-deploy-ops-hardening.story.md` — CI, deploy e operazioni pronte per la produzione


# CI, deploy e operazioni pronte per la produzione

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0022-blade-icons-set-from-resources-svg.story.md` — Le icone dei moduli si registrano da `resources/svg`


# Le icone dei moduli si registrano da `resources/svg`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0049-superadmin-only-operational-pages.story.md` — Pagine operative e scrittura di `.env` riservate al super-admin


# Pagine operative e scrittura di `.env` riservate al super-admin

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0025-collision-rewrite-complete-files.story.md` — Collisioni: riscrivere il file completo, non scegliere un lato


# Collisioni: riscrivere il file completo, non scegliere un lato

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0050-sync-unrelated-histories-repair.story.md` — Sync del 2026-11-19: riparazione e prevenzione


# Sync del 2026-11-19: riparazione e prevenzione

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0045-root-untrack-bashscripts-and-claude.story.md` — bashscripts e .claude fuori dal versionamento del root, ADR conformi


# bashscripts e .claude fuori dal versionamento del root, ADR conformi

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0028-fix-double-encoded-utf8-action.story.md` — FixDoubleEncodedUtf8Action: riparare il testo UTF-8 codificato due volte


# FixDoubleEncodedUtf8Action: riparare il testo UTF-8 codificato due volte

## Context and Problem Statement

Nei backup locali del 2026-10-23 (`geek_quaeris_backup_server_23_10_2025`, `quaeris_survey_23_10_2025`) i
testi sono codificati due volte: «Sì» e' salvato come `SÃ¬` (byte `53 C383 C2AC` invece di `53 C3AC`), in
colonne `utf8mb4` lette con connessione `utf8mb4`. E' la firma di un dump UTF-8 importato come `latin1`
(che in MySQL e' Windows-1252). Il primo consumatore che se ne accorge e' il pulsante «Configura i grafici»
di Quaeris: riconosce il Sì/No dal testo delle risposte e su `SÃ¬

### `stories/0016-file-type-icons-heroicons-outline.story.md` — Story 8.5: icone `xot-files.*` (pdf, xls, xlsx) ridisegnate in stile Heroicons outline


# Story 8.5: icone `xot-files.*` (pdf, xls, xlsx) ridisegnate in stile Heroicons outline

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0031-harness-workshop-adoption-all-packages.story.md` — Story: adozione della metodologia harness su tutti i moduli e temi


# Story: adozione della metodologia harness su tutti i moduli e temi

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0033-module-sync-stale-snapshot-and-phpstan-zero.story.md` — Sync dei moduli da copia vecchia: marker, regressioni e PHPStan a zero


# Sync dei moduli da copia vecchia: marker, regressioni e PHPStan a zero

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0021-audit-qualita.story.md` — Story — audit qualità del modulo Xot


# Story — audit qualità del modulo Xot

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `stories/0030-harness-adr-e-contratti-in-ogni-pacchetto.story.md` — Story — harness: ADR e contratti verificabili in ogni pacchetto


# Story — harness: ADR e contratti verificabili in ogni pacchetto

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0045-cleanup-all-modules.story.md` — Fleet: `git status` + marker in HEAD + quality tools


# Fleet: `git status` + marker in HEAD + quality tools

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0027-phpstan-modules-480-errors-2.story.md` — PHPStan Modules 2026-10-05 — baseline 480 errori / 68 file


# PHPStan Modules 2026-10-05 — baseline 480 errori / 68 file

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0003-module-service-test-decision.story.md` — [STORY] Adeguamento test dopo rimozione ModuleService


# [STORY] Adeguamento test dopo rimozione ModuleService

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0051-deep-audit-remediation-session.story.md` — Audit estremamente approfondito PTVX — remediation


# Audit estremamente approfondito PTVX — remediation

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0031-psr-4-autoload-compliance-fleet.story.md` — Story 5.301: PSR-4 autoload compliance fleet + runtime smoke verde


# Story 5.301: PSR-4 autoload compliance fleet + runtime smoke verde

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0038-all-modules-audit-pack.story.md` — Story: audit completo di tutti i moduli con BMAD ed ECC


# Story: audit completo di tutti i moduli con BMAD ed ECC

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0017-bmad-docs-fleet-completion.story.md` — 5.249 — BMAD docs fleet: documenti canonici mancanti in ogni modulo


# 5.249 — BMAD docs fleet: documenti canonici mancanti in ogni modulo

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0061-docs-modules-themes-continuous-reorg.story.md` — Riorganizzazione continua docs moduli e temi


# Riorganizzazione continua docs moduli e temi

## Context and Problem Statement

Direttiva utente permanente (2026-09-29): studiare, aggiornare, migliorare e
organizzare meglio `laravel/Modules/*/docs` e `laravel/Themes/*/docs`, sempre
con BMAD + second brain. Questa story e' il registro della campagna: ogni
passata aggiunge misura, azioni e backlog qui, non in nuovi file.

Regole verificate sul filesystem (non sulla wiki): story in
`docs/bmad/stories/`, nomi kebab-case, ogni modulo ha `docs/purpose.md`,
frontmatter sui `.md`, mai cancellare ne' rinumerare story.
La policy BMAD e' applicata 

### `bmad/stories/0055-docs-100-fleet-merge-3.story.md` — Epic: Docs ≤100 .md ricorsivi via merge (fleet-wide, 2026-10-05)


# Epic: Docs ≤100 .md ricorsivi via merge (fleet-wide, 2026-10-05)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0030-no-empty-list-base-classes.story.md` — 5.300 — Niente base List vuote: la base di dominio esiste già


# 5.300 — Niente base List vuote: la base di dominio esiste già

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0004-phpstan-modules-remediation.story.md` — Scopo


# Scopo

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0035-docs-consolidation-audit-strategy.story.md` — Story 8.25 — Docs Consolidation Audit + Strategy


# Story 8.25 — Docs Consolidation Audit + Strategy

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0058-docs-cross-module-dedup.story.md` — Docs cross-module: canonico unico


# Docs cross-module: canonico unico

## Context and Problem Statement

Le lane per modulo (story `docs-semantic-consolidation-swarm`) fondono i duplicati
**dentro** un modulo/tema. Restano i duplicati **tra** owner: 68 gruppi con corpo
identico e 298 file (misura 2026-11-25, esclusi `raw/`, `stories/`, `bmad/`,
template e nomi convenzionali). I piu' grandi: `Asset binari` in 17 owner,
`Massima confidenza agente` in 13, `context-overflow-prevention` in 10,
`html2pdf` in 4. Nessuna lane possiede la scelta del canonico cross-module.

## Decision Drivers

- Richiesta utente / acceptance criteria 

### `bmad/stories/0050-data-sacred-adr.story.md` — Story: formalizza ADR dati sacri e test isolati


# Story: formalizza ADR dati sacri e test isolati

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0048-codex-project-setup.story.md` — Installazione setup automazioni per Codex


# Installazione setup automazioni per Codex

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0022-user-module-clusters-widgets-actions.story.md` — 5.256 — Modulo User: cluster, widget, azioni, DRY/KISS/UI-UX/a11y


# 5.256 — Modulo User: cluster, widget, azioni, DRY/KISS/UI-UX/a11y

## Context and Problem Statement

Il campo `email` compare in 6 form, ma non con la stessa configurazione:

| Form | Configurazione |
|---|---|
| `TeamInvitationForm` | `->email()->required()->maxLength(255)` |
| `PasswordResetForm` | `->email()->required()->maxLength(255)` |
| `ProfileForm` | ora identica alle due precedenti |
| `Widgets/Auth/UserForm.php` | due sezioni diverse, con `autofocus()`, `autocomplete('username')` e `extraInputAttributes` per il widget |

Tre usi identiche su tre form **non** giustificano un compo

### `bmad/stories/0025-phpstan-modules-current-remediation.story.md` — 5.260: PHPStan `analyse Modules`: baseline corrente


# 5.260: PHPStan `analyse Modules`: baseline corrente

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0057-docs-consolidation-orphan-files.story.md` — Docs consolidation: orphan files + structure normalization: 2026-10-06


# Docs consolidation: orphan files + structure normalization: 2026-10-06

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0063-docs-prompts-reorganization.story.md` — Obiettivo


# Obiettivo

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0032-release-readiness-asset-temi-document-root.story.md` — Release readiness: asset temi, document root, test nei moduli


# Release readiness: asset temi, document root, test nei moduli

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0047-cms-absence-bootstrap-cleanup.story.md` — Story BMAD — Rimozione del modulo Cms dal checkout PTVX


# Story BMAD — Rimozione del modulo Cms dal checkout PTVX

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)

### `bmad/stories/0024-prompts-execute-improve.story.md` — 5.258 — Prompt: prima eseguirli, poi migliorarli


# 5.258 — Prompt: prima eseguirli, poi migliorarli

## Context and Problem Statement

Un prompt non si migliora leggendolo: si migliora eseguendolo e annotando dove l'agente si e'
bloccato (comando inesistente, path sbagliato, regola contraddittoria, gate non eseguibile).
Senza esecuzione un "miglioramento" e' solo riformattazione.

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options
>>>>>>> laraxot/dev
