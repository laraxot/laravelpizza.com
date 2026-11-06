---
title: "Gdpr — PHPStan wave2 rector config"
type: story
module: Gdpr
status: done
created: 2026-10-20
updated: 2026-10-20
tags: [phpstan, rector, wave2]
qmd: "gdpr phpstan wave2 rector phpunit level set laravel100"
related:
  - ./phpstan-wave-coord.story.md
  - ../wiki/scopo.md
---

# Gdpr — wave2: rector.php analizzabile

## Scopo (prima dell'errore)

Gdpr centralizza consensi e cookie banner. Il `rector.php` del modulo non e' business
logic privacy, ma fa parte del tree analizzato: riferimenti a set assenti/deprecati
rompevano PHPStan sul modulo senza toccare consenso o banner.

## Inventario wave2

`/tmp/phpstan_by_module_w2/Gdpr.txt` — 3 errori su `rector.php`:

| Famiglia | Causa | Fix |
|---|---|---|
| `class.notFound` | `PHPUnitLevelSetList` (pacchetto assente) | rimosso |
| `classConstant.deprecated` | `LaravelSetList::LARAVEL_100` | rimosso; Laravel via `withComposerBased` in run rector dedicate |
| `argument.type` | `sets()` con `mixed` da costanti rotte | `list<string> $sets` con soli set installati |

Set residui: `LevelSetList::UP_TO_PHP_81`, `SetList::TYPE_DECLARATION`.

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Gdpr --memory-limit=2G
# [OK] No errors
```
