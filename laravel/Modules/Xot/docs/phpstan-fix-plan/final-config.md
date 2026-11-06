---
title: "PHPStan: un solo neon, solo umano"
type: decision
module: Xot
status: active
updated: 2026-10-20
qmd: "phpstan single neon immutabile perche senso no altri neon no ignore unmatched"
related:
  - ../wiki/memories/phpstan-single-neon-config.md
  - ../bmad/phpstan-status.md
  - ../../../../../bashscripts/docs/prompts/11-phpstan.md
  - ../bmad/livewire-to-filament-widgets-filament-blueprint.md
tags: [docs, xot, phpstan-fix-plan]
---

<!--
GateGuard facts:
1. Supersedes prior stale body of THIS file (wrong: reportUnmatched false + ignore constantTypeCoverage).
2. Linked from memories/phpstan-single-neon-config, phpstan-status, 11-phpstan.
3. Edit existing same-topic file: not a new topic.
4. User: "devi utilizzare laravel/phpstan.neon e solo io posso modificarlo, non puoi creare altri .neon..."
-->

# PHPStan: un solo neon

## Perche' (religione)

Il gate misura **tutto** `Modules/` con le stesse regole. Un secondo `.neon`
(modulo, temp, `-c`, level abbassato) crea un verde locale che mente al CI e
allo swarm: due agenti “verdi” su config diverse, debito nascosto, merge che
rompe il coordinatore.

**Senso:** il codice si adatta al misuratore; il misuratore non si spezza per
il codice. Solo l'**utente umano** modifica `laravel/phpstan.neon`. Gli agenti
non editano, non creano, non ripristinano altri `.neon`.

## Comando canonico

```bash
cd laravel
./vendor/bin/phpstan analyse Modules
# deve citare: .../laravel/phpstan.neon
```

Vietato: `-c`, `--level`, neon in `Modules/*/`, neon in `docs/`, baseline
attive, `scanFiles` chiesti all'agente per Pest helpers.

## Legacy sul disco (non usare, non moltiplicare)

Esistono ancora file storici (`Modules/*/phpstan.neon`, `*.neon.dist`,
`Geo/docs/phpstan-temp.neon`, …). Sono **archivio**. Gate e lane usano solo
il neon root. Non crearne di nuovi.

## Correzione 2026-10-20 (stale claims rimossi)

- **Non** spegnere `reportUnmatchedIgnoredErrors` per far sparire ignore
  unmatched: togliere l'ignore stale (umano).
- **Non** ignorare `constantTypeCoverage`: tipizzare le costanti; l'ignore
  `#typeCoverage\.constantTypeCoverage#` e' gia' stato rimosso (`606a380b`).

## Filament blueprint

Widget `XotBase*` e Resource/Page passano dallo stesso gate. Nessun neon
Filament dedicato: vedi
[livewire-to-filament-widgets-filament-blueprint.md](../bmad/livewire-to-filament-widgets-filament-blueprint.md).
