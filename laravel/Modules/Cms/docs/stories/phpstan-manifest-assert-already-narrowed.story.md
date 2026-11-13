---
title: PHPStan Cms — asserzione ridondante sul manifest in ContentIntegrityGuardTest (alreadyNarrowedType)
type: story
module: Cms
status: done
created: 2026-11-10
updated: 2026-11-10
qmd: "phpstan cms alreadyNarrowedType assertNotEmpty manifest design-comuni ContentIntegrityGuardTest techplanner"
related:
  - ./phpstan-test-wave-cms.story.md
---

# PHPStan Cms: asserzione ridondante sul manifest

## Scopo

Il test `has a tests JSON in tenant and module for every manifest row` verifica che ogni riga del manifest Design Comuni (`Themes/Sixteen/scripts/design-comuni-pages.txt`) abbia il JSON `tests.*` sia nel tenant sia nel modulo.

## Causa

Errore emerso dopo il pull dei moduli (2026-11-10):

| Riga | Identifier | Messaggio |
|---|---|---|
| `ContentIntegrityGuardTest.php:311` | `staticMethod.alreadyNarrowedType` | `assertNotEmpty()` con `non-empty-array` sarà sempre vero. |

In apertura il test chiama `markTestSkipped` se `contentGuardManifest() === []`. Da lì in poi il manifest non è vuoto, quindi l'`assertNotEmpty` finale non poteva mai fallire.

## Modifica

- Rimosso `Assert::assertNotEmpty(contentGuardManifest(), 'Manifest vuoto.')`. Il caso "manifest vuoto" resta coperto dallo skip, il controllo vero resta `contentGuardAssertNone($missing, ...)`.
- Pint (preset `laravel` del modulo) applicato al file: solo stile, da Yoda a confronto diretto, `$checked++`, allineamento PHPDoc.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Cms   # [OK] No errors
vendor/bin/pest Modules/Cms/tests/Unit/Content/ContentIntegrityGuardTest.php
# 11 passed, 2 skipped, 3 failed: i fallimenti non toccano la riga modificata (vedi sotto)
```

## Aperto

- `finds the TechPlanner tenant and module page folders` e il test sui manifest cercano `config/local/techplanner/...` e `Modules/TechPlanner/...`. In questo progetto il tenant è `fixcity`, come già usano i dataset degli altri test dello stesso file, quindi il test fallisce. Il percorso andrebbe ricavato dal tenant attivo, non scritto a mano. Il Cms è condiviso fra progetti, quindi la scelta va presa qui.
- Due casi `points every pub_theme component view to an existing Blade file` falliscono con `BindingResolutionException`. Da indagare, non dipendono da questa modifica.
- 43 file di test Cms su 174 non rispettano ancora Pint (`pint --test Modules/Cms/tests`).
