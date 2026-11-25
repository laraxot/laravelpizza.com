---
type: note
tags: [documentation]
created: 2026-09-26
qmd: "5.87.rating contract usage.story"
issues: []
discussions: []
title: "RatingContract formalizzazione e uso nei consumatori"
epic: "5"
story: "5.87"
slug: rating-contract-formalizzazione-uso-consumatori
status: in-progress
module: Rating
updated: 2026-09-09
gh_issue: "https://github.com/provtv/module_rating_fila5/issues/37"
gh_discussion: "https://github.com/provtv/module_rating_fila5/discussions/38"
related_repo_remote: "provtv/module_rating_fila5"
related_stories:
  - "laravel/Modules/Rating/docs/stories/5.91.rating-contract-usage.story.md"
  - "docs/stories/0059-5-84-docs-md-naming-compliance.story.md"
  - "docs/stories/0060-5-85-stop-using-docs-chat-use-bmad-stories.story.md"
---
# Story

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Contesto

L'interfaccia `RatingContract` esiste già in `laravel/Modules/Rating/app/Models/Contracts/RatingContract.php`. Definisce le proprietà comuni a tutti i modelli Rating consumati dai sei moduli (Ptv, Progressioni, User, IndennitaResponsabilita, Media, Sigma):

- `is_readonly`: il criterio si compila o si calcola
- `rule`: regola di validazione
- `parent_id`: se il criterio è figlio di un altro (opzione vs campo)
- `title`, `txt`: nome tecnico e leggibile (diversi!)
- `slug`: identificativo stabile

Il contract serve a **tipizzare i consumatori** senza legarli a `BaseRating` (classe astratta di questo modulo), e a rendere esplicito cosa un "criterio" deve garantire per partecipare alla costruzione di form, colonne e filamenti.

## Stato attuale

- `RatingContract` esiste già ed è implementato da tutti i Rating concreti (Rating, PtvRating, ProgressioniRating, ...).
- Il trait `HasRatingsTrait` usa già `$rating->is_readonly`, `$rating->rule`, `$rating->children`, `$rating->getLabel()`: tutte proprietà coperte dal contract.
- **Gap da colmare**: aggiungere type-hint `RatingContract` dove i singoli rating passano fuori dal trait (nelle pagine Filament, nelle colonne, nei filtri) affinché il contratto sia verificabile staticamente.

## Azioni

1. **Aggiungere type-hint `?RatingContract`** dove un singolo rating esce dal trait:
   - In `CompilaIndennitaResponsabilita::decorateRatingField()`: già implementa `RatingsFormCallerContract`, quindi può ricevere `?RatingContract` come type-hint su `$rating`.
   - In eventuali altri consumer (colonne, filtri) che iterano `$record->ratings`.

2. **Aggiornare `phpstan`** a level max su Rating per verificare che il contract sia rispettato.

3. **Documentare nei docs/** del modulo Rating come e dove usare `RatingContract` vs `BaseRating` vs `Rating` (vedi `docs/wiki/concepts/rating-contract-vs-model.md` da creare).

4. **Non duplicare** il contract: se un nuovo modulo Rating deve essere creato, estendere l'interfaccia esistente, non definirne uno nuovo.

## GitHub (tracciamento)

- Issue: `https://github.com/provtv/module_rating_fila5/issues/37`
- Discussion: `https://github.com/provtv/module_rating_fila5/discussions/38`
- Remote Rating: `provtv/module_rating_fila5`

## Verify

- PHPStan su Rating: rate scende (o mantiene 0 se già zero)
- Tutti i consumatori che ricevono `$rating` hanno `?RatingContract` o `Rating` come type-hint (dove appropriato)
- I docs del modulo sono stati aggiornati (vedi story correlate)

### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
