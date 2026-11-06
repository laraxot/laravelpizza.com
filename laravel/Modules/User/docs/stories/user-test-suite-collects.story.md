---
title: "User: la suite di test torna a essere raccolta"
type: story
status: done
created: 2026-10-26
updated: 2026-10-26
module: User
related:
  - ../../../Xot/docs/stories/xot-test-harness-truth.story.md
  - ../../../Activity/docs/stories/activity-tests-bound-to-testcase.story.md
tags: [user, pest, helpers, testcase, bootstrap]
---

# User: la suite di test torna a essere raccolta

Fase BMAD: Dev, poi Verify.

## Problema

Con `--test-directory=Modules/User/tests` Pest carica da solo `tests/Helpers.php` (bootstrapper `BootFiles`). Composer carica sempre `tests/Support/helpers.php` (`autoload.files` del `composer.json` del modulo). `Helpers.php` ridichiarava 64 funzioni già presenti in `Support/helpers.php` e in `Support/team-management*-helpers.php`. Risultato: `Cannot redeclare function createUser` e nessun test eseguito.

Dopo, un secondo blocco: `pest()->extend(TestCase::class)->in('Feature', 'Unit')` in `Pest.php` mentre 136 file su 156 dichiarano già `uses(TestCase::class)`, 12 con `->group('no-user-db')`. Risultato: `TestCaseAlreadyInUse`.

## Correzioni

- `tests/Helpers.php` ora contiene solo `mockeryExpect`, l'unica funzione che non esiste altrove. Le 6 funzioni con corpo diverso (`enableTwoFactorForUser`, `permissionPivotTable`, `permissionRolePivotTable`, `readStoredRecoveryCodes`, `verifyTwoFactorCode`, `verifyTwoFactorRecoveryCode`) restano nella versione di `Support/helpers.php`. È compatibile: `enableTwoFactorForUser` accetta `$attributes`, e `verifyTwoFactorRecoveryCode` rifiuta i codici sconosciuti senza consumarli.
- `tests/Pest.php`: tolto il binding per cartella, con un commento che spiega perché.
- Aggiunto `uses(TestCase::class)` ai 20 file che non lo avevano.

## Verifica

Dalla root: `PEST_OUT=<file> bash bashscripts/tools/pest-scratch-db.sh --test-directory=Modules/User/tests Modules/User/tests`.
Prima: raccolta interrotta, 0 test. Dopo: 1073 superati, 148 falliti, 73 risky, 53 skipped, 6 todo. PHPStan su `Modules/User/tests`: 0 errori.

## Aperto

- Deriva di schema nel DB di origine dello scratch: colonne `role` e `user_id` mancanti, tabella `teams` assente, chiave duplicata su `profiles.PRIMARY`.
- 22 confronti di stringhe e 12 `false is true`: da classificare (test o codice).
- `No query results for model [Modules\Fixcity\Models\User]` (10): i test di User dipendono dal modello del progetto. Da verificare con la regola dell'agnosticismo dei moduli.
- `tests/Support/helpers-core.php` (17 funzioni) non lo carica nessuno: è codice morto, da valutare.
- 73 test risky (senza asserzioni).
