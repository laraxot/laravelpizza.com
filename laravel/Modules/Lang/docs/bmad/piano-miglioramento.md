---
title: "Piano di miglioramento — Lang"
type: plan
status: review
updated: 2026-11-16
module: Lang
qmd: "piano miglioramento Lang P1 P2 tracker chiavi mancanti test coverage config morta Post hardcoded sequenza criteri"
related:
  - ./audits/lang-audit.md
  - ./epics.md
  - ./decision-log.md
---

# Piano di miglioramento — Lang

<<<<<<< .merge_file_aPe5Nk
<<<<<<< .merge_file_MFwMYE
=======
=======
>>>>>>> .merge_file_K7vHhm
<<<<<<< HEAD
=======
<<<<<<< .merge_file_oSXWcx
Derivato dall'[audit](./audits/lang-audit.md).

## P0

1. Bonificare marker/conflict se presenti (ora: 0).
2. Chiudere policy troppo permissive (`return true` ≈ 2) con matrice ruolo×ability.
3. Blocchi sicurezza runtime (auth panel, mass assignment, export) con test negativi.

## P1

1. Portare Services (0) ad Actions Queueable dove applicabile.
2. Alzare copertura test (attuale 51 test / 72 app PHP).
3. Allineare Filament (resources=2) a XotBase* e traduzioni Lang.
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
- [ ] PHPStan `Modules/Lang` = 0
- [ ] Pest osservabile o skip motivato
- [ ] ECC `00-index` aggiornato con esiti
=======
>>>>>>> .merge_file_36WNOd
>>>>>>> laraxot/dev
<<<<<<< .merge_file_aPe5Nk
>>>>>>> .merge_file_cBhwTv
=======
>>>>>>> .merge_file_K7vHhm
Derivato dall'[audit profondo](./audits/lang-audit.md). Epic e AC: [epics.md](./epics.md). Nessun P0.

## P1

1. **E1** — D-2: cablare o ritirare il tracker DB delle chiavi mancanti.
2. **E2** — applicare le migration `user_id` UUID sul DB sorgente (additive) e riportare `tests/Feature` a verde.
3. **E3** — sostituire i 4 test «coverage» con test di comportamento (D-4).
4. Docs: gap-fill fatto (purpose, architecture, decision-log, epics); resta `docs/business-logic-overview.md` e 111 `.md` con nome non conforme.

## P2

1. **E4** — togliere le 2 stringhe letterali di `LocaleSwitcherRefresh`.
2. D-1 — `config/lang.php` mai letto.
3. D-3 — `Post` dentro Lang.
4. Codice morto: `WriteTranslationFileAction`, `ReadTranslationFileAction`.
5. `GetTransPathAction`: allowlist di namespace e locale (difesa in profondità).
6. Migration `create_*` in 3 generazioni: ridurre con una story additiva.
7. Dipendenze inverse verso moduli verticali: verificare con `rg` (oggi Lang dipende solo da Xot).
8. Profiling N+1 sulle pagine del pannello.

## Sequenza e gate

1. Story disgiunte + lock (`bashscripts/lock/`).
2. PHPStan `Modules/Lang` = 0.
3. Pest mirato su scratch DB: nessun `migrate:fresh`/`RefreshDatabase`/`--force`.
4. Aggiornare [ECC](../ecc/00-index.md) e `qmd update`.

## Criteri di completamento

- [ ] D-2 decisa e attuata
- [ ] `tests/Feature` verde su scratch DB
- [ ] 0 file `*CoverageTest`/`FinalGaps`
- [ ] `rg "->label\('[A-Za-z]" app` = 0 fuori eccezioni dichiarate
- [ ] PHPStan `Modules/Lang` = 0
