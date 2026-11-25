---
title: "IDColumn obbligatoria su ogni tabella Filament (+ anchor self-link)"
status: in-progress
module: UI
created: 2026-11-25
updated: 2026-11-25
related:
  - ../../adr/0002-idcolumn-mandatory-on-tables.md
  - ../../id-column-record-anchor.md
  - ../../../../Xot/docs/filament/record-anchor-return-to.md
  - ../../../../Progressioni/docs/contracts/sigma-verification-tabs.md
qmd: "IDColumn mandatory Filament tables RecordAnchor self-link servizi 11254"
---
# IDColumn obbligatoria su ogni tabella Filament

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

## Fact-gate

1. **Supersede**: nessuno; rafforza doc `id-column-record-anchor.md` + gap Servizi (override senza id).
2. **Link da**: `docs/sprint-status.yaml` → UI/idcolumn-mandatory-filament-tables; ADR UI `0002-idcolumn-mandatory-on-tables`.
3. **Perche'**: tab Servizi scheda 11254 senza colonna `id`; le foglie che overrideano `getTableColumns` dimenticano IDColumn.
4. **User verbatim**: «in http://personale2022.prov.tv.local/progressioni/admin/schedas/11254/servizi manca la colonna id, in tutte le tabelle filament ci deve essere la colonna id di tipo IDColumn che puoi anche studiare e migliorare con anchor link per fare tante cose belle , fa tutto con bmad + ecc + second brain devi aggiornare anche docs/adr del modulo piu' adatto».

## Scope

| File | Azione |
|---|---|
| `UI/.../IDColumn.php` | self-link `#record-{id}` + copyable id |
| `UI/docs/adr/0002-idcolumn-mandatory-on-tables.md` | ADR accepted |
| `Ptv/.../BaseSigmaHistoryScheda.php` | prepend IDColumn SSoT |
| `Base{Servizi,Qualifiche,Storico,IntegParams}Scheda` | `getTableColumns` + `withIdColumn` (mai `getSigmaTableColumns`) |
| `BaseAssenzeScheda` | `TextColumn('id')` → `IDColumn` |

## Acceptance

- [ ] `/schedas/{id}/servizi` espone colonna id = IDColumn (anchor `#record-*`)
- [ ] Tutte le tab Sigma history condividono prepend SSoT
- [ ] ADR UI + doc anchor aggiornati
- [ ] PHPStan OK; Pest skip `10.100.200.15`


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
