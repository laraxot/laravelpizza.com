---
title: "Case-collision cleanup — file che differiscono solo per case"
type: story
status: in-progress
tags: [collisions, case-sensitivity, git-hygiene, cross-module]
related: [no-case-only-differences-rule]
---

# Case-collision cleanup in base_roosko_fila5

## Why

Repo con collusioni di filename che differiscono **solo per maiuscolo/minuscolo**
(984 gruppi rilevati da scan case-insensitive). Su filesystem case-insensitive
(macOS/Windows) o su checkout alternativi questi file collidono: Pest non
raccoglie i test minuscoli, Blade `@include` può risolvere il file sbagliato,
`.up`/`.wip`/`.test` backup doppioni confondono l'autoload PSR-4.

Regola: `docs/wiki/rules/no-case-only-differences-rule.md` (stub) — da rafforzare.

## Inventario (scan `/tmp/collisions.txt`, 984 gruppi)

- **Codice/test (~43+ php, blade, js)**: Notify (backup `.up`/`.test`/`.wip` +
  template email blade con case doppio), Cms (`tests/Pest.php` vs `pest.php`,
  test Auth/Unit minuscoli), Geo (js/css + `comunetest.php`), Gdpr
  (`conflictresolutiontest.php`), Blog (`database/Factories/` vs `factories/`).
- **Docs (~940 gruppi .md)**: concentrati in Notify/docs (283+183+...),
  User/docs, Lang/docs `_da-riconciliare`, Media/Rating/Geo/Tenant/UI/Meetup.

## Scope agenti (swarm)

- Agent A: Notify + Cms (codice/test/blade/backup).
- Agent B: Geo + Gdpr + Blog + moduli minori (codice).
- Agent C: docs .md collisions — solo duplicati byte-identici o chiaramente
  superseded; ambiguo → report, no delete.

## Regole operative

- Ogni modulo è repo git separato: commit dentro `laravel/Modules/<M>`.
- Backup `.up`/`.wip`/`.test`/`.old*`: `git rm` (mai conservare).
- Test minuscoli duplicati di un `*Test.php` canonico: verificare che il
  canonico sia quello raccolto da Pest, poi `git rm` il minuscolo.
- Blade: determinare quale casing è referenziato dagli `@include`/`view()`;
  tenere quello referenziato, merge se necessario, `git rm` l'altro.
- Directory case-dup (`Factories` vs `factories`): consolidare nel casing
  canonico del modulo e verificare `composer.json`/autoload.
- MAI cancellare file live referenziati senza aver spostato i riferimenti.
- Git forward-only: niente restore/reset/revert.
- Gate: `php -l` sui file toccati, Pest scope modulo quando eseguibile,
  PHPStan `Modules/<M>` se il modulo ha php toccato.

## Dev Agent Record

- 2026-11-05 lead: inventario completato; quick win root — rimosse directory
  spurie `${HOME}` e `${CLAUDE_PROJECT_DIR:-.}` (cache token-optimizer
  accidentali), commit gitlink Xot `26347a7` nel parent (era `62f3ea9`).
- In corso: swarm 3 agenti.
