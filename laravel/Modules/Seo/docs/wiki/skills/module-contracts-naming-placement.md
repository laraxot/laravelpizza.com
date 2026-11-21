---
title: "Skill: contratti modulo — Contract suffix e placement"
type: skill
tags: [contract, module, naming, skill]
created: 2026-07-12
updated: 2026-07-12
qmd: "skill module contracts Contract suffix placement Interfaces forbidden"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/272"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - ../rules/module-contracts-naming-placement.md
  - ../../../../../../docs/wiki/memories/contract-suffix-no-interfaces-folder.md
---

# Skill: module-contracts-naming-placement

## Trigger

- Nuovo `*Interface.php` o cartella `app/Interfaces/`
- Audit segnala contratto non implementato / path sbagliato
- Refactor tipo `MetatagDataInterface`

## Checklist (60s)

1. Rinomina `*Interface` → `*Contract`
2. Sposta in `app/Contracts/` (DTO/servizio) o `Models/Contracts/` (solo Eloquent)
3. `implements *Contract` sulla classe concreta
4. Servizi/Facade: return type sul contratto
5. Test: `toBeInstanceOf(*Contract::class)`
6. Doc modulo: `docs/wiki/concepts/{name}-contract.md` se non esiste pagina equivalente

## Vietato

- `app/Interfaces/`
- Suffisso `Interface` su nuovi artefatti

## Canon

- [module-contracts-naming-placement.md](../rules/module-contracts-naming-placement.md)
- Esempio: [metatag-data-contract.md](../concepts/metatag-data-contract.md)
