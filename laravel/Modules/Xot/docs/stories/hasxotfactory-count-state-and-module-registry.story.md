---
title: "HasXotFactory count/state + Module registry Sushi"
type: story
module: Xot
status: in_progress
created: 2026-10-15
updated: 2026-10-15
tags: [phpstan, hasxotfactory, module, sushi, swarm]
qmd: "hasxotfactory count state module factory mixed phpstan module slug registry"
related:
  - ../../../../docs/wiki/second-brain/phpstan-journey.md
  - ../../../../docs/wiki/patterns/phpstan-eloquent-typing-without-baseline.md
  - ../../../../docs/wiki/memories/phpstan-quality-docs-bmad-standing-order.md
issues: []
discussions: []
---

# HasXotFactory count/state + Module registry

## Scopo

`HasXotFactory` e' il contratto unico di `Model::factory()` per i model Xot: risolve la factory a runtime via `GetFactoryAction`. Senza `$count`/`$state` (firma Laravel), `User::factory(5)` crea 1 record in silenzio. Il model `Module` e' un registry Sushi dei moduli nwidart: superficie pubblica `name`/`slug`/`enabled`, non `alias`.

## Causa radice (PHPStan)

`GetFactoryAction::execute()` e' dinamico → `Model::factory()` perde il generico (`mixed` → `method.nonObject` a catena nei test). Pattern confermato nel second brain: nei test usare `ModelFactory::new()`, non `Model::factory()`.

## Fix eseguiti (2026-10-15)

1. `HasXotFactory::factory($count, $state)` pubblico, allineato a Laravel `HasFactory` (count + state).
2. `Module` phpdoc: `slug`, `created_at`/`updated_at`; test allineati (niente `alias`).
3. `ModuleTest` / `GetAllModelsActionTest`: tipizzazione vera, niente assert ridondanti su `array`.
4. Verifica: `phpstan analyse` sui path toccati → `file_errors=0`.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse \
  Modules/Xot/app/Models/Traits/HasXotFactory.php \
  Modules/Xot/app/Actions/Factory/GetFactoryAction.php \
  Modules/Xot/app/Models/Module.php \
  Modules/Xot/tests/Unit/Models/ModuleTest.php \
  Modules/Xot/tests/Unit/Actions/GetAllModelsActionTest.php \
  --no-progress
```

## GitHub (tracciamento)

DA CREARE (gh non invocato in questa sessione):

```bash
gh issue create --repo laraxot/module_xot --title "HasXotFactory count/state + Module slug registry" --body "Vedi laravel/Modules/Xot/docs/stories/hasxotfactory-count-state-and-module-registry.story.md"
```
