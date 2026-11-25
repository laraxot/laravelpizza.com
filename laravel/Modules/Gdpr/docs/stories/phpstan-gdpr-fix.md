---
title: "phpstan Gdpr fix"
type: note
tags: [documentation]
updated: 2026-09-26
qmd: "phpstan Gdpr fix"
issues: []
discussions: []
id: phpstan-Gdpr-fix
slug: phpstan-Gdpr
scope: [module:Gdpr, project:base_workorder_fila5]
status: Pending
priority: High
created: 2026-09-06
---

## Problema
PHPStan errors in Modules/Gdpr

## Solution
1. Analyze with phpstan
2. Fix pattern errors
3. Verify with phpmd + phpinsights + pest
4. Git sync

## Fix applicato — subagent-ai-gdpr-cms (2026-09-10)

- File: `Modules/Gdpr/tests/TestCase.php`
- Errore: `method.notFound` — `setUp()` chiamava `$this->prepareSharedFixcitySqliteForTesting()`,
  metodo mai esistito nel repo (typo/drift rispetto al metodo reale ereditato da
  `Xot\Tests\XotBaseTestCase`).
- Fix: rinominata la call site in `$this->prepareSharedSqliteForTesting()` (metodo reale
  definito in `Modules/Xot/tests/XotBaseTestCase.php:288`), aggiornato anche il commento
  di classe che citava il nome sbagliato.
- Verifica: `cd laravel && ./vendor/bin/phpstan analyse Modules/Gdpr/tests/TestCase.php --no-progress --memory-limit=-1` → `[OK] No errors`.
- Scope di questa sessione era limitato a `Modules/Gdpr/tests/TestCase.php`; il resto del
  modulo Gdpr non è stato toccato (fuori scope).

## Verifica indipendente — claude-sonnet5-qgates-swarm-Gdpr (2026-09-10)

- Task ricevuto in parallelo per lo stesso errore (`method.notFound` su
  `prepareSharedFixcitySqliteForTesting()`). Al momento della lettura del file, il fix
  sopra descritto era già presente (race con `subagent-ai-gdpr-cms`): call site già
  `$this->prepareSharedSqliteForTesting()`, commento di classe già corretto.
- Nessuna modifica di sostanza necessaria. Ri-verificato da zero, indipendentemente:
  - `php -l Modules/Gdpr/tests/TestCase.php` → `No syntax errors detected`.
  - `vendor/bin/pint --test Modules/Gdpr/tests/TestCase.php` → rosso su `yoda_style` e
    `phpdoc_align` (debito preesistente, non legato al fix del nome metodo); applicato
    `vendor/bin/pint Modules/Gdpr/tests/TestCase.php` → verde.
  - `./vendor/bin/phpstan analyse Modules/Gdpr/tests/TestCase.php --no-progress --memory-limit=-1`
    → `[OK] No errors`.
- Lock preso/rilasciato su `laravel/Modules/Gdpr/tests/TestCase.php` via
  `bashscripts/lock/{check,lock,unlock}.sh` (percorso completo da repo root — il percorso
  senza prefisso `laravel/` passato nel task iniziale non corrisponde a un file reale e
  fa fallire `lock.sh` con un `ALREADY LOCKED` fuorviante per directory mancante, non per
  lock altrui: attenzione nelle prossime sessioni).
- Nessun altro file toccato. Story non duplicata, solo estesa (regola second-brain: non
  creare story ridondanti, collegare/estendere quella esistente).
