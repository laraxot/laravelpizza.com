---
tags: [documentation]
qmd: "quality gates"
issues: []
discussions: []
title: "Quality gates — Modules/Tenant"
type: report
created: 2026-07-28
updated: 2026-07-28
---

# Quality gates — Modules/Tenant

Verifica completa richiesta dopo il fix dell'incidente Git LFS (vedi
`git-push-lfs-incident.md`), su **tutta** la cartella
`laravel/Modules/Tenant`, non solo sui file toccati.

## PHPStan

```
cd laravel && php -d memory_limit=-1 ./vendor/bin/phpstan analyse Modules/Tenant --memory-limit=-1 --no-progress
```

**Risultato: `[OK] No errors`**

## PHPMD

```
cd laravel && bash tools/phpmd.sh Modules/Tenant/app text Modules/Tenant/phpmd.ruleset.xml
```

**Risultato: 0 violazioni, exit code 0**

## PHP Insights

```
cd laravel && bash tools/phpinsights.sh analyse Modules/Tenant --no-interaction --composer="$(pwd)/composer.lock"
```

**Risultato: exit code 0**

| Categoria | Punteggio |
|---|---|
| Code | 94.1% |
| Complexity | 100% |
| Architecture | 85.7% |
| Style | 92.6% |

Nessun errore bloccante — solo suggerimenti di stile minori (ordine import,
graffe). Non richiesto intervento per rientrare nella soglia qualità.

## Sintassi PHP — intera cartella (non solo `app/`)

`find Modules/Tenant -name "*.php" | xargs php -l` ha rilevato 3 errori di
sintassi reali in file **fuori** dal path scansionato da PHPStan/PHPMD
(dotfile di configurazione alla radice del modulo, non sotto `app/`):

- `.php-cs-fixer.dist.php` — mancava `;` dopo `->setFinder($finder)`
- `.php-cs-fixer.php` — stesso bug (file duplicato)
- `.php_cs.dist.php` — virgola orfana che creava un elemento vuoto in un array

Corretti (commit `3e9c4c5`). Dopo il fix: **0 errori di sintassi in tutta la
cartella `Modules/Tenant`**.

## Esito complessivo

Tutti i gate richiesti (PHPStan, PHPMD, PHP Insights) passano puliti su tutta
la cartella `laravel/Modules/Tenant`. Il push verso `laraxot` funziona
(già sincronizzato); il push verso `provtv` resta bloccato solo dall'oggetto
Git LFS storico irrecuperabile documentato in
`git-push-lfs-incident.md` — non un problema di qualità del
codice.
