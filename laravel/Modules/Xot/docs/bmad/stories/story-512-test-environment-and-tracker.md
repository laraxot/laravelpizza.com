---
qmd: "STORY 512 test environment and tracker"
title: "STORY-512 — Ambiente test e tracker verificabili"
type: story
status: in_progress
module: Xot
created: 2026-09-26
updated: 2026-09-26
tags: [bmad, xot, testing, security, tracker]
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/383"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/392"
related:
  - ../../testing-database-strategy.md
  - ../../wiki/concepts/env-testing-parity-copy-env.md
  - ../../../../../../docs/sprint-status.yaml
---

# STORY-512 — Ambiente test e tracker verificabili

## User story

Come maintainer, voglio che il bootstrap dei test usi solo credenziali esterne dedicate e
database `_test`, e che il tracker punti ai documenti reali, così posso eseguire Pest senza
esporre credenziali né confondere il completamento con l'implementazione.

## Criteri di accettazione

- [x] Il bootstrap realmente carica `.env.testing`; il riferimento a `.env.sqlite` è rimosso.
- [x] Il file test non contiene password/token copiati da `.env`; le credenziali sono placeholder `FIXCITY_TEST_*` risolti dall'ambiente.
- [x] Normalizzatore fail-closed deduplica chiavi, impone `APP_ENV=testing` e suffix `_test`, senza leggere `.env` o stampare valori.
- [x] Test fixture verifica idempotenza, duplicati, rifiuto di segreti letterali e parsing Laravel con credenziali sentinel.
- [x] Tracker aggiorna i link dei documenti owner e registra gli item Fixcity/Xot aperti senza inventare story point o stati sprint.
- [ ] Pest su MariaDB e smoke browser passano dopo grant dedicato sui soli database `_test`.
- [ ] Migrazione follower e schema esistenti sono verificati contro l'istanza di test.

## Rischio e confine operativo

Il normalizzatore non esegue `CREATE DATABASE`, `GRANT`, migrazioni né query. Il test account
e i suoi privilegi devono essere predisposti dal DBA; nessun privilegio viene concesso
all'account di sviluppo.

## Verifiche eseguite

- `bash bashscripts/tests/test-sync-env-testing.sh`: pass.
- `bash bashscripts/tools/sync-env-testing.sh --check`: pass, output senza valori.
- `APP_ENV=testing php artisan tinker ...`: sentinel credential risolte nel config senza connessione DB.
- Pest applicativo: ancora SQLSTATE 1044, access denied su `fixcity_data_test`; 0 assertion.
- `phpstan analyse Modules`: 0 errori nel controllo più recente della tranche Fixcity.
