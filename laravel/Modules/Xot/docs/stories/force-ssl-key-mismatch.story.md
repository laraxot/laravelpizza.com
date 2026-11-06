---
title: "Chiave force_ssl del tenant ignorata"
status: ready-for-dev
module: Xot (owner)
created: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
related:
  - ../../../Progressioni/docs/stories/progressioni-audit.epic.md
---

# Chiave force_ssl del tenant ignorata

## Fase BMAD

Build (bugfix). Nata dall'audit del 2026-10-28 (epic `progressioni-audit`).

## Problema (verificato)

Il file del tenant scrive `'forcessl' => false` (`config/local/tv/prov/personale2022/xra.php:8`), ma `XotData` legge `force_ssl` (`XotData.php:55,491`). L'impostazione del tenant non ha effetto.

## Requisiti

- Uniformare il nome (preferire `force_ssl`, quello del codice) leggendo anche `forcessl` come alias per i tenant esistenti.

## Criteri di accettazione

- [ ] Il valore del tenant viene applicato.
- [ ] Nessun tenant cambia comportamento senza volerlo (oggi entrambi false).

## File coinvolti

- `app/Datas/XotData.php`

## Verifica

PHPStan livello 10 sui file toccati, Pint; Pest su ambiente di sviluppo (non su 10.100.200.15).
