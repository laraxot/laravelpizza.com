---
title: "Remediation PHPStan globale dei moduli"
status: done
qmd: "phpstan Modules errori 23 source-first swarm BMAD"
---

# Story: remediation PHPStan globale dei moduli

## Obiettivo

Portare `cd laravel && ./vendor/bin/phpstan analyse Modules` a zero errori,
correggendo i contratti alla sorgente e preservando il comportamento di dominio.

## Acceptance criteria

- [x] Gate globale PHPStan eseguito in una sola lane isolata, exit 0.
- [x] Errori raggruppati per causa e corretti senza baseline o cast cosmetici.
- [x] Test/gate Pest dello scope modificato tentato; blocco DB remoto documentato.
- [x] QMD/second brain aggiornato e diff controllato.
- [x] Commit tracciabile con soli file di questa story; sincronizzazione Git verificata.

## Evidenza iniziale

Il gate esclusivo del 2026-11-23 ha rilevato 23 errori su 8 file: numerici,
deprecated PhpSpreadsheet, chiavi array nullable, confronto nullo in mutator,
ritorno nullable nel mixin e assert già ristrette nel test FeatureFlags.

## Piano swarm

- Cluster Performance: assegnazione numerica di `importo_totale`.
- Cluster Ptv: foglio deprecated, chiavi array e confronto nullo nel mutator.
- Cluster Xot: export PhpSpreadsheet e ritorno nullable del PanelMixin.
- Cluster test Xot: assert ridondanti, preservando le verifiche comportamentali.

## Verifica

Fix swarm completati sui cluster Performance, Ptv, Xot e test Xot. Il gate finale esclusivo ha restituito
`/tmp/phpstan-current-final4/result.json` con `errors=0`, `file_errors=0`, exit 0. Il risultato iniziale è stato salvato in
`/tmp/phpstan-current-unique/result.json`; nessun processo concorrente deve
essere usato come evidenza del gate.

## Riferimenti

- `laravel/phpstan.neon`
- `bashscripts/lock/`
- `laravel/Modules/Xot/docs/ecc/00-index.md`
- `bashscripts/ai/wiki/memories/source-first-before-fix.md`
