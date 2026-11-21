---
title: "Piano di miglioramento — Activity"
type: plan
status: review
updated: 2026-11-16
module: Activity
qmd: "piano miglioramento Activity P1 P2 audit trail append-only redazione test sequenza criteri completamento"
related:
  - ./audits/activity-audit.md
  - ./epics.md
  - ./decision-log.md
---

# Piano di miglioramento — Activity

Derivato dall'[audit profondo](./audits/activity-audit.md). Nessun P0 emerso dal codice; i P1 riguardano l'integrità del registro.
Epic e AC: [epics.md](./epics.md).

## P1 (ordine di esecuzione)

1. **E4** — test onesti: ripristinare i corpi da `7cf6bc58`, chiudere i 19 skip. Prima di tutto: senza test non si cambia il resto.
2. **E3** — `LoginListener`: decidere D-3 (implementare o rimuovere).
3. **E2** — redazione segreti nelle Action di logging.
4. **E1** — Resource in sola lettura + permesso dedicato per la retention.

## P2

1. Policy → `ActivityBasePolicy` (bypass `activity::admin`) o ADR annotato.
2. Deduplicare contratti/logger; rimuovere `Adapters/*` senza caller.
3. `TestModel` + migration fuori dalla produzione; `_bak/` fuori dall'albero.
4. Igiene: 8 `.md` e 4 `*.code-workspace` fuori dalla root; frontmatter su 331 `.md`.
5. Dal piano precedente, ancora aperti: test negativi su pannello, mass assignment ed export;
   rimuovere viste legacy (`admin_test`) se morte; profiling N+1; zero label hardcoded e
   traduzioni Lang allineate alle Resource `XotBase*`; cercare con `rg` dipendenze inverse verso moduli peer.

## Sequenza e gate

1. Story disgiunte + lock (`bashscripts/lock/`).
2. PHPStan `Modules/Activity` = 0 (oggi 0).
3. Pest mirato su scratch DB: nessun `migrate:fresh`/`RefreshDatabase`/`--force`.
4. Aggiornare [ECC](../ecc/00-index.md) e `qmd update`.

## Criteri di completamento

- [ ] 0 file test senza casi; skip motivati
- [ ] Registro non modificabile da UI (Pest 403)
- [ ] Nessun segreto in `properties` (Pest su `User`)
- [ ] PHPStan `Modules/Activity` = 0
- [ ] ECC `00-index` aggiornato
- [ ] Pest osservabile o skip motivato
