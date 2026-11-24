---
title: "Piano di miglioramento — User"
type: plan
status: review
updated: 2026-11-16
module: User
qmd: "piano miglioramento User P0 P1 P2 BMAD"
---

# Piano di miglioramento — User

Derivato dall'[audit](./audits/user-audit.md).

## P0

1. Bonificare marker/conflict se presenti (ora: 0).
2. Chiudere policy troppo permissive (`return true` ≈ 8) con matrice ruolo×ability.
3. Blocchi sicurezza runtime (auth panel, mass assignment, export) con test negativi.

## P1

1. Portare Services (0) ad Actions Queueable dove applicabile.
2. Alzare copertura test (attuale 233 test / 713 app PHP).
3. Allineare Filament (resources=26) a XotBase* e traduzioni Lang.
4. Spezzare dipendenze inverse verso verticali peer se rilevate con `rg`.

## P2

1. Deduplicare docs BMAD/ECC storici; frontmatter YAML + `qmd` su ogni `.md` attivo.
2. Rimuovere legacy views/admin_test se dead.
3. Profiling N+1 e i18n (zero label hardcoded).

## Sequenza

1. Story P0 disgiunte + lock.
2. PHPStan modulo verde (già ok a livello `Modules`).
3. Pest mirato o skip documentato.
4. Aggiornare ECC checklist e QMD.

## Criteri di completamento

- [ ] P0 chiusi con Pest di regressione
- [ ] PHPStan `Modules/User` = 0
- [ ] Pest osservabile o skip motivato
- [ ] ECC `00-index` aggiornato con esiti
