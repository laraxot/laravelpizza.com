---
title: "Merge: i residui che riesumano codice rimosso e silenziatori senza parametro"
type: memory
tags: [merge, phpstan, residui, services-to-actions, test]
created: 2026-10-28
updated: 2026-10-28
qmd: "merge residui silenziatore parametro Assert undefined variable classe rimossa test riesumati ModuleService FileAction"
related:
  - ../../stories/phpstan-zero-errors-xot.story.md
  - ./merge-marker-spazzatura-worktree.md
status: draft
---

# Merge: residui che riesumano codice rimosso

> **SUMMARY**: unendo due rami che hanno risolto lo stesso errore in modo diverso, il merge senza marker puo' produrre codice che non compila in PHPStan. Due forme ricorrenti.

## 1. Silenziatore senza parametro
Un ramo toglie il parametro inutile (`getAs(array $v)`), l'altro lo zittisce (`Assert::nullOrString($_namespace)`). Il merge tiene la riga dell'altro: `Undefined variable: $_namespace`. Fix: togliere la riga. Mai ripristinare il parametro.
Stesso schema per `Assert::string($method)` in `recordRequest()` e `Assert::isInstanceOf($response, ...)` in `isSuspiciousRequest()`.

## 2. Test di classi rimosse di proposito
`Services\ModuleService` (`5acb43ea2`), `Actions\File\FileAction` (`139ff7294`), handler Artisan (`84a826ab8`) sono stati rimossi con una story che dice dove e' finito il compito. Il merge riporta i vecchi test. Prima di toccarli: `git log -S"<Classe>" --oneline` e la story di rimozione (`module-service-test-decision.story.md`, `services-to-actions-xot-*.story.md`). Si riscrivono sul contratto dell'Action che ha assorbito il compito, oppure si tolgono se l'Action ha gia' i suoi test.

## Regola
Dopo ogni merge in Xot: `phpstan analyse Modules/Xot`, poi `git log -p -S` sul simbolo mancante prima di decidere. Un file riaggiunto da una risoluzione (`DU` -> `A`) puo' essere un trait senza utilizzatori (`TypedHasRecursiveRelationships`).
