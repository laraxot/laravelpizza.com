---
qmd: "phpstan probe model removal"
issues: []
discussions: []
title: "Rimozione probe model PHPStan (GdprPhpstanTraitProbe)"
type: concept
module: Gdpr
tags: [phpstan, trait, probe, no-phpstan-probe-models, quality]
created: 2026-07-16
updated: 2026-07-16
related:
  - ../../../../docs/wiki/rules/no-phpstan-probe-models.md
  - ../../Xot/docs/wiki/concepts/phpstan-partial-scope-false-positives.md
  - ../roadmap/quality-fixes-log.md
---

# Rimozione probe model PHPStan — GdprPhpstanTraitProbe

## Cosa

Eliminato `app/Models/GdprPhpstanTraitProbe.php`, un modello Eloquent finto il
cui unico scopo era ospitare il trait `HasGdpr` affinché PHPStan lo analizzasse
in contesto app (`/** Probe host so PHPStan analyses HasGdpr trait ... */`).

## Perché (root cause, non solo il sintomo)

1. **Viola una regola esplicita del progetto.** I file `*PhpstanTraitProbe.php`
   sono vietati dalla regola
   [no-phpstan-probe-models](../../../../docs/wiki/rules/no-phpstan-probe-models.md):
   non si creano classi finte solo per far passare PHPStan.
2. **Era ridondante.** Il trait `HasGdpr` è realmente consumato da
   `Modules/Employee/app/Models/User.php` (`use HasGdpr;`) ed è già esercitato
   in test dalla fixture `tests/Fixtures/HasGdprDummy.php`. Il probe non copriva
   nulla che non fosse già coperto.
3. **Nessuna regressione.** Dopo la rimozione, `phpstan analyse Modules/Gdpr`
   NON segnala `trait.unused` su `HasGdpr`, perché la fixture di test lo tiene
   in scope. Il probe era quindi puro peso morto in `app/`.

## L'errore residuo del report NON è un bug di codice

Il report `build/phpstan/Gdpr.txt` mostra 1 "errore":

```
Ignored error pattern #PHPDoc tag @mixin contains unknown class # was not
matched in reported errors.
```

È un **falso positivo da scope parziale**: il pattern in `ignoreErrors` di
`laravel/phpstan.neon` è pensato per l'albero completo `Modules/`, dove matcha
`@mixin` non risolti; analizzando il solo `Modules/Gdpr` (dove `\Eloquent` è
risolvibile via ide-helper) non matcha nulla e PHPStan lo segnala come inutile.
La `phpstan.neon` è immutabile (una sola config per l'intero repo) e non si
tocca. La baseline affidabile è `phpstan analyse Modules` sull'intero albero.
Vedi `Modules/Xot/docs/wiki/concepts/phpstan-partial-scope-false-positives.md`.

## Nota collaterale

Il test del trait `tests/Unit/Traits/HasGdprTraitTest.php` usava assert statici
`PHPUnit\Framework\Assert::` dentro funzioni Pest: convertito allo stile Pest
idiomatico (`expect()->toBeTrue()` / `->toContain()`). Altri file di test del
modulo usano ancora la facade `Assert::` (convenzione diffusa): candidato a
un refactor separato, non incluso qui per non allargare lo scope.
