---
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "2.14.tenant skippedtestexception non esiste piu.story"
issues: []
discussions: []
epic: 2
story: 14
slug: tenant-skippedtestexception-non-esiste-piu
title: "Tenant: dieci skip che non skippano — `SkippedTestException` non esiste più in PHPUnit 13"
status: done
created_at: '2026-08-24'
updated_at: '2026-08-24'
owner: opus5-bmad-46f8406d
scope: module:Tenant
owned_scope:
  - laravel/Modules/Tenant/tests/TestCase.php
  - laravel/Modules/Tenant/tests/Feature/TenantBusinessLogicTest.php
  - laravel/Modules/Tenant/tests/Performance/SushiToJsonPerformanceTest.php
related:
  - "docs/stories/2.11.phpstan-facade-import-root-namespace.story.md"
  - "docs/chat/gate-statico-campagna-bmad-round3.md"
---

# Story 2.14 — Gli skip di Tenant lanciano una classe che non esiste

## Story

Come **manutentore del modulo Tenant**,
voglio che i dieci `throw new \PHPUnit\Framework\SkippedTestException(...)` diventino
`Assert::markTestSkipped(...)`,
così che un test che non può scrivere sul database venga saltato invece di morire con un
`Error: Class not found`, e i 20 errori PHPStan che lo dicevano da settimane spariscano.

## Context

Nella corsa del 2026-08-24 il modulo Tenant ha 73 errori, e i primi 20 sono tutti la stessa
riga ripetuta:

```
class.notFound   Instantiated class PHPUnit\Framework\SkippedTestException not found.
class.notFound   Throwing object of an unknown class PHPUnit\Framework\SkippedTestException.
```

**Non è un falso positivo.** In `vendor/phpunit/phpunit/src/Framework/Exception/Skipped/`
esistono tre classi — `SkippedTest` (interfaccia), `SkippedTestSuiteError`,
`SkippedWithMessageException` — e `SkippedTestException` non è fra queste. Il progetto gira su
**PHPUnit 13.3.0**; quel nome apparteneva a PHPUnit ≤ 9.

Quindi le dieci occorrenze non saltano niente: quando il ramo viene preso, PHP solleva un
`Error: Class "PHPUnit\Framework\SkippedTestException" not found` e il test **fallisce** invece
di essere marcato come skipped. Sono in tre file:

| file | occorrenze |
|---|---:|
| `tests/Feature/TenantBusinessLogicTest.php` | 7 |
| `tests/Performance/SushiToJsonPerformanceTest.php` | 2 |
| `tests/TestCase.php` | 1 |

Tutte dentro un `catch (QueryException)` che intercetta `database is locked` o
`no column named` sullo sqlite condiviso: sono esattamente i rami che si attivano quando la
suite gira in parallelo, cioè quando servono davvero.

## La forma corretta, e perché non è l'altra exception

Si potrebbe sostituire il nome con `SkippedWithMessageException`, che esiste. Non va fatto:
è `final`, vive in `PHPUnit\Framework` come dettaglio interno del framework, e costruirla a
mano è il tipo di accoppiamento che [[AD-5b]] già impedisce altrove (le classi `@internal` di
Pest). La via pubblica è:

```php
use PHPUnit\Framework\Assert;

Assert::markTestSkipped('Tenant DB write blocked: '.$exception->getMessage());
```

`markTestSkipped()` è `final public static … : never`. Essendo **statico** funziona dentro le
funzioni helper dei file Pest, dove `$this` non c'è; ed essendo `never` PHPStan sa che il
flusso finisce lì, quindi le funzioni tipizzate `: Tenant` restano valide senza un `return`
irraggiungibile dopo il `catch`.

## Acceptance Criteria

1. **AC1** — Zero occorrenze di `SkippedTestException` in `Modules/Tenant`.
2. **AC2** — `phpstan analyse Modules/Tenant/tests/TestCase.php
   Modules/Tenant/tests/Feature/TenantBusinessLogicTest.php
   Modules/Tenant/tests/Performance/SushiToJsonPerformanceTest.php --no-progress` non riporta
   più `class.notFound` su quel nome.
3. **AC3** — `Assert` è importato in ognuno dei tre file (nessuna chiamata a nome pieno inline).
4. **AC4** — Nessun `return` aggiunto dopo la chiamata: `markTestSkipped()` è `never`, e
   aggiungere codice irraggiungibile produrrebbe un errore nuovo.
5. **AC5** — Il diff tocca solo le righe del `throw` e, se serve, la riga `use`.

## Tasks / Subtasks

- [x] T1 — Sostituire le 10 occorrenze (AC1, AC5).
- [x] T2 — Verificare l'import di `Assert` nei tre file (AC3).
- [x] T3 — PHPStan sui tre file (AC2, AC4).
- [ ] T4 — Aggiornare `docs/chat/gate-statico-campagna-bmad-round3.md`.

## Dev Notes

Questo è il secondo caso della giornata in cui `class.notFound` non è un problema di tipi ma un
**riferimento a un'API che non esiste più**: il primo erano gli alias di root
([story 2.11](../../../../../docs/stories/2.11.phpstan-facade-import-root-namespace.story.md)). La differenza è che lì il
codice funzionava a runtime e solo l'analisi si lamentava; qui **il codice è rotto** e l'analisi
è l'unica cosa che se ne fosse accorta. Vale la pena dirlo a chi considera il gate statico una
formalità.

## Dev Agent Record

Eseguita il 2026-08-24, sessione `opus5-bmad-46f8406d`.

Dieci `throw new \PHPUnit\Framework\SkippedTestException(...)` → `Assert::markTestSkipped(...)`
nei tre file. `use PHPUnit\Framework\Assert;` aggiunto solo dove mancava
(`SushiToJsonPerformanceTest.php`; gli altri due lo avevano già), nel gruppo degli import di
classe e **prima** della riga vuota che lo separa da `use function Safe\json_decode;` — altrimenti
il gruppo si spezza e `blank_line_between_import_groups` di Pint lo segnala.

```bash
php -d memory_limit=-1 ./vendor/bin/phpstan analyse \
  Modules/Tenant/tests/TestCase.php \
  Modules/Tenant/tests/Feature/TenantBusinessLogicTest.php \
  Modules/Tenant/tests/Performance/SushiToJsonPerformanceTest.php --no-progress
 [OK] No errors
```

- AC1 ✅ zero occorrenze residue (`grep -rn SkippedTestException Modules/Tenant/tests` → 0).
- AC2 ✅ `[OK] No errors` sui tre file.
- AC3 ✅ `Assert` importato in tutti e tre.
- AC4 ✅ nessun `return` aggiunto: `markTestSkipped()` è `never` e le funzioni tipizzate
  `: Tenant` restano valide senza codice dopo il `catch`.
- AC5 ✅ diff di 11 inserimenti / 10 rimozioni su 3 file, tutte righe di `throw` più una `use`.

### Quello che questa story dice al di là di Tenant

I 20 `class.notFound` non erano rumore statico: erano **dieci rami di codice rotto**. Quando il
test incontrava `database is locked` sullo sqlite condiviso — cioè proprio quando la suite gira
in parallelo, che è il caso normale qui — non veniva saltato: moriva con `Error: Class not
found`, e il fallimento veniva letto come un fallimento di Tenant. Il gate statico lo diceva da
settimane in una riga che nessuno aveva collegato al sintomo.
