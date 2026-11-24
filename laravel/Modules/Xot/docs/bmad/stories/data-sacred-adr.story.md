---
title: "Formalizza ADR dati sacri e test isolati"
status: review
qmd: "BMAD story ADR dati sacri env testing migrate fresh RefreshDatabase"
---

# Story: formalizza ADR dati sacri e test isolati

## Obiettivo

Rendere esplicita nel modulo owner Xot la policy trasversale che protegge i
dati persistenti e obbliga l'isolamento dei test.

## Acceptance criteria

- [x] ADR MADR breve creato senza data nel nome file.
- [x] Divieti su migrazioni distruttive, rollback dello schema, `--force` e
  `RefreshDatabase` esplicitati.
- [x] `.env.testing` e `APP_ENV=testing` definiti come prerequisiti obbligatori
      per i test applicativi/integrativi.
- [x] `TestDatabaseGuard` e il comportamento forward-only citati come conferma.
- [x] Indice ADR Xot aggiornato.
- [ ] Debito `migrate --force` nel deploy classificato e risolto in una story
      separata senza confonderlo con i test.

## Riferimenti

- `laravel/Modules/Xot/docs/adr/0013-data-sacred-testing.md`
- `laravel/Modules/Xot/tests/Support/TestDatabaseGuard.php`
- `laravel/Modules/Xot/tests/XotBaseTestCase.php`
- `bashscripts/lib/deploy.sh` (debito di conformità `migrate --force`)
