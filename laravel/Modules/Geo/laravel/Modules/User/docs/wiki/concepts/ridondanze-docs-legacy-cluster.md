---
title: "Cluster documentazione legacy duplicata (User)"
type: concept
tags: [documentation, redundancy, user-module]
created: "2026-05-21"
updated: "2026-05-21"
related:
  - ../../../../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md
  - ../../../legacy/historical/redundancy-fixes-january.md
---

# Ridondanza documentazione `Modules/User/docs`

## Scopo

Il modulo User accumula anni di note agent/PHPStan; molte sono **near-duplicate** o differiscono solo per **`_`/`-`/maiuscole** nel nome file. Qui non si ricopia il contenuto: si lista **cosa collide** così gli editor possono gradualmente **fusionare/archiviare** senza perdere storicità nei path `legacy/`.

## Volume (audit 2026-05-22)

- **`docs/` totale:** ~3077 file `.md`
- **`docs/legacy/`** e **`docs/archive/`:** ~**723** file ciascuno (~**6.1M** — contenuto quasi speculare)
- **`docs/legacy/`:** ~**723** file (~24% del modulo) — snapshot agent multi-sessione
- **`phpstan` nel path nome:** ~293 file — log fix ripetuti, non regole viventi

## Cluster logout / Volt / auth UI

Stesso flusso documentato con varianti `logout-*`, `volt-folio-logout`, `volt_folio_logout`, `legacy/logout_*`:

**Canonico suggerito:** `docs/auth/logout.md` o `docs/wiki/troubleshooting/logout.md`. Il resto → stub `canonical:` verso quella pagina.

## Triple storage stesso filename

Esempio `testing.md` (contenuti diversi, nome ambiguo):

- `docs/bugs/testing.md` — bug `make:filament-user`, **non** guida test
- `docs/bugs/legacy/testing.md`, `docs/bugs/archive/testing.md`, `docs/bugs/TESTING.md`

Rinominare il bug in `bugs/make-filament-user-testing.md` ed eliminare stub `testing.md` in `bugs/*`.

## Performance auth (4 naming stesso topic)

`docs/performance/legacy/authentication-performance-optimization.md` e varianti `-1`, `AUTHENTICATION_*`, `authentication_performance_optimization.md` → un solo file canonico in `docs/performance/`.

## File “redundancy / dry-kiss phpstan” noti ridondanti

Stesso scaffolding editoriale ripetuto in più percorsi (testo quasi uguale, link a **`laravel/Modules/Xot/docs/filament/redundancy-rules.md`** ecc.):

- `docs/redundancy-fixes.md`
- `docs/redundancy-fixes-january.md`
- `docs/redundancy-fixes-january-1.md`
- `docs/redundancy-fixes-january-2026.md`
- `docs/redundancyes.md` (nome con typo storico da evitare in nuovi file)
- `docs/legacy/historical/redundancy-fixes.md`
- `docs/legacy/historical/redundancy-fixes-january.md`
- `docs/legacy/historical/redundancy-fixes-january-2026.md`

Cluster **phpstan dry kiss improvements** quasi identici nel corpo (`docs/legacy/phpstan-dry-kiss-improvements*.md` + variant con suffissi **`-.md`** / **`2025-10-17`).

## Azione suggerita (incrementale)

1. Scegliere **un solo** file “canonical” dentro `legacy/historical/` o trasferire in wiki Xot/User.
2. Convertire gli altri in stub con link nella prima riga usando la forma Markdown `canonical: [titolo](./file-canonical.md)`
3. Rinunciare gradualmente ai nomi con typo (`redundancyes.md`).
4. Coordinamento incrociato globale moduli → **[ridondanze-cross-cutting-codebase.md](../../../../Xot/docs/wiki/concepts/ridondanze-cross-cutting-codebase.md)**.

## Modulo tecnico locale

Specifiche comportamento dominio Utente continuano nei path non duplicati (policies Filament Login, Volt, ecc.); non sono candidate merge solo perché tema simile nei titoli — valutare diff reale prima di fondere.
