---
id: geo-phpstan-swarm-bucket-grandi
title: PHPStan swarm bucket grandi — Geo
status: done
end_errors: 0
start_errors: 59
module: Geo
updated: 2026-10-20
qmd: "geo phpstan variable.unused assertCount impossibleType swarm bucket"
type: story
tags: [docs, geo, bmad]
---

# Geo — PHPStan swarm (bucket grandi)

## Scopo del modulo
Geolocalizzazione e indirizzi: Actions (Google/Bing/Mapbox), DTO Spatie Data, modelli territoriali e policy Gate/Filament.

## Inventario TSV (start)
| identifier | count |
|---|---|
| variable.unused | 53 |
| staticMethod.impossibleType | 2 |
| staticMethod.alreadyNarrowedType | 2 |
| phpunit.assertCount | 2 |
| **totale** | **59** |

## Famiglie → scopo → causa → fix

1. **variable.unused** — smoke test “can be instantiated” lasciavano `$x = new Foo` / `::from([...])` senza assert.  
   Causa: scheletri post-merge.  
   Fix: assert su proprietà DTO reali, oppure `class_exists` / costruzione senza assegnazione morta dove lo scopo è solo “non esplode”.

2. **phpunit.assertCount** — già allineato a `assertCount` su errori action (TSV stale su alcuni path).

3. **staticMethod.impossibleType / alreadyNarrowedType** — assert su tipi Action/DTO già noti o CAP int vs string; allineati al tipo reale (es. `postal_code` int).

4. **PoliciesTest** — loop `is_object` su istanze tipizzate → `alreadyNarrowed`/`argument.type`; sostituito con `class_exists` + `new $class` su lista di FQCN.

## Verifica
```bash
cd laravel && flock -w 1800 /tmp/phpstan-gate.lock \
  php -d memory_limit=2G ./vendor/bin/phpstan analyse --no-progress \
  Modules/Geo/tests/Unit/...  # path TSV a chunk ≤10
```

## Note
- Nessun ignore/baseline/neon.
- File HOT (mtime &lt; 120s) saltati se writer concorrente.
- Link: [bmad-variable-unused](../../bmad-variable-unused.md), [phpstan.md](../../phpstan.md)
