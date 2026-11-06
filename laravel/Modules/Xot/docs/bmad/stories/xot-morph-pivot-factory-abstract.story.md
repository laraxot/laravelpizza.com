---
id: xot-morph-pivot-factory-abstract
title: XotBaseMorphPivotFactory abstract, PHPStan Xot zero errori
type: story
module: Xot
epic: quality/phpstan
status: done
created: 2026-10-21
updated: 2026-10-21
related:
  - ./2026-10-09-phpstan-modules-remediation.story.md
  - ../../../UI/docs/bmad/stories/phpstan-clusterB.story.md
tags: [docs, xot, bmad]
qmd: "scopo xot"
---

# Scopo

Chiudere l'errore PHPStan level max su `Modules/Xot/database/factories/XotBaseMorphPivotFactory.php`:
una classe non abstract dichiarava il metodo abstract `definition()` di `Factory`.

## Decisione

La classe resta `abstract` e non implementa `definition()`.

- Il model dichiarato, `Modules\Xot\Models\XotBaseMorphPivot`, e' a sua volta `abstract`: una factory
  concreta non potrebbe produrre istanze valide.
- Il docblock la descrive come base per le factory dei singoli moduli.
- Nessuna sottoclasse nel repo e nessun chiamante di `XotBaseMorphPivotFactory` (`rg` su `Modules` e `app`).
- Precedente nello stesso modulo: `BaseExtraFactory` e' `abstract` per lo stesso motivo (il leaf dichiara il `$model`).

La versione in `HEAD` (non abstract, con `definition()` che genera `morph_type`/`morph_id` fittizi)
non e' ripristinata: per una base astratta quei dati sarebbero inventati e non usabili.

## Stato verificato

- `git log -S 'XotBaseMorphPivotFactory'`: la classe nasce in `4fe1429ec8` (feat xot, factory mancanti per
  `XotBaseMorphPivot` e `XotBasePivot`).
- Working tree: `abstract class XotBaseMorphPivotFactory` senza `definition()`. La modifica non e' committata
  e non e' stata fatta in questa story: la story la adotta come decisione. Nessun lock presente sul file.
- Nessun file del repo estende la factory: la rimozione di `definition()` non rompe chiamanti.

## Acceptance criteria

- [x] Decisione documentata con motivo e precedente.
- [x] Nessuna sottoclasse o chiamante dipende dall'istanziazione della base.
- [x] `phpstan analyse Modules/Xot` senza errori sul file (verifica sotto).

## Verifica

Comando: `cd laravel && ./vendor/bin/phpstan clear-result-cache && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/UI Modules/Xot --no-progress --no-ansi`

Esito: `[OK] No errors` (exit 0), eseguito il 2026-10-21 sullo stato del working tree descritto sopra.

## Note

- Nessun file di codice modificato in questa passata: la decisione era gia' nel working tree.
- `laravel/phpstan.neon` non toccato.

## Re-verifica 2026-10-21 (php-backend-agent)

`analyse Modules/Xot` → **0** errori. `XotBaseMorphPivotFactory` resta `abstract`
senza `definition()` (reflection: `isAbstract=yes`, method abstract `definition`).
