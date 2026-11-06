---
title: "[STORY] Adeguamento test dopo rimozione ModuleService"
type: story
status: review
priority: medium
created: 2026-10-09
updated: 2026-10-28
module: Xot
tags: [bmad, xot, module-service, test-cleanup]
qmd: "[story] adeguamento test dopo rimozione moduleservice xot"
---

# [STORY] Adeguamento test dopo rimozione ModuleService

## Decisione

`Modules\\Xot\\Services\\ModuleService` è stato rimosso. Il test unitario
`tests/Unit/ModuleServiceTest.php` importava una classe inesistente e testava
solo dettagli strutturali del vecchio Service tramite reflection, oltre a contenere
chiamate senza asserzioni.

## Analisi dei caller

- Nessun caller di produzione di `ModuleService` è stato trovato in `laravel/Modules`
  o `laravel/Themes`.
- Lo scopo funzionale di `getModels()` è già implementato da
  `Actions\\Model\\GetAllModelsByModuleNameAction`.
- L'Action è usata da `GetAllModelsAction`, da `Tenant\\Actions\\Models\\ResolveTenantModelClassAction`
  e dalla `ModuleServiceIntegrationTest`.
- La Feature test verifica il contratto attuale: modulo inesistente, moduli reali,
  classi concrete, esclusione delle astratte, namespace, chiavi snake_case e
  risoluzione dal container.

## Esito

Il file `tests/Unit/ModuleServiceTest.php` è stato riscritto sul contratto attuale
dell'Action, senza ripristinare il Service né duplicare la logica.

## Verifica

- Caller legacy: nessuno, esclusi i riferimenti documentali storici.
- Action equivalente: `GetAllModelsByModuleNameAction`, già coperta dalla Feature test.
- `php -l Modules/Xot/app/Actions/Model/GetAllModelsByModuleNameAction.php`: OK.
- PHPStan mirato su Action e Feature test: `[OK] No errors`.
- Pest mirato su `ModuleServiceTest.php`: timeout di 60 secondi senza output; il DB
  configurato (`10.100.200.53`) non risponde. Da rilanciare quando il database di test
  è disponibile.

## Aggiornamento 2026-10-28

Il merge `ae2239de0`/`3bfdfff16` ha riportato la vecchia versione del test (riflessione su `Services\ModuleService`, classe inesistente: 27 errori PHPStan). Riscritto di nuovo sul contratto di `GetAllModelsByModuleNameAction` (modulo inesistente -> `[]`; chiave = snake_case del basename; classi astratte escluse). Il nome del file resta `ModuleServiceTest.php` (rinominarlo in `GetAllModelsByModuleNameActionTest.php` e' un `git mv` che il brief dello swarm non permetteva). Vedi `../../stories/phpstan-zero-errors-xot.story.md`.
