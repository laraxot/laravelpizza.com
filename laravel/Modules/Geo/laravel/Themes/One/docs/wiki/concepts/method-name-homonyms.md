---
title: "censimento omonimi metodi — tema One"
type: analysis
module: One
updated: 2026-06-15
related:
  - ../../../../docs/wiki/method-name-homonym-census.md
  - ../../../Modules/Xot/docs/wiki/concepts/code-redundancy-philosophy.md
  - ./code-redundancy-theme.md
---

# Censimento omonimi metodi — Theme One

## Esito scan PHP

| Metrica | Valore |
|---------|--------|
| Omonimi cross-class nel tema | **0** |
| Data scan | 2026-06-15 |

## Riflessioni

Il tema **One** è strato **presentazione** (Blade, CSS, view Filament). Le classi PHP nel tema sono poche e non ripetono metodi con lo stesso nome su classi diverse.

La ridondanza di business logic da monitorare sta nei **moduli** Laravel (`Sigma`, `Ptv`, `User`, …), non qui.

### Politica

| OK nel tema | Da evitare |
|-------------|------------|
| Layout, partial Blade, asset | Model, relazioni Eloquent, calcolo `gg`/`giorni` |
| `@livewire` verso widget modulo | Copia metodi dominio da moduli |

### Collegamenti

- [Indice censimento progetto](../../../../docs/wiki/method-name-homonym-census.md)
- [Ridondanza tema](./code-redundancy-theme.md)
- [Sigma — omonimi relazioni](../../../Modules/Sigma/docs/wiki/concepts/method-name-homonyms.md)

## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
