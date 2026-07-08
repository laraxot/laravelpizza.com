---
title: "Module root cleanup rules"
type: rule
tags: [module, theme, structure, cleanup, naming, root-hygiene]
created: 2026-01-21
updated: 2026-07-08
qmd: "module theme root no txt max four md readme changelog license agents nwidart"
issues:
  - "https://github.com/laraxot/base_ptvx_fila5/issues/124"
discussions:
  - "https://github.com/laraxot/base_ptvx_fila5/discussions/273"
related:
  - ../../../../../../docs/wiki/memories/module-theme-root-hygiene.md
  - ../../../../../../docs/wiki/concepts/nwidart-module-skeleton-contract.md
  - ../../../../../../.cursor/rules/module-root-hygiene.mdc
---

# Module & theme root cleanup rules

## Perché

La root di modulo/tema è il **contratto nwidart** visibile a CI, Dependabot e agenti. File spuri (.txt, decine di .md) creano rumore, collisioni Git e preload contesto inutile. La conoscenza va in `docs/`.

## Regole obbligatorie

### File `.txt`

- **VIETATO** nella root
- Spostare in `docs/raw/root-import/` (note grezze) o convertire in `.md` in `docs/wiki/`

### File `.md` — max 4

Ammessi **solo** questi nomi in root:

| File | Ruolo |
|------|--------|
| `README.md` | Vetrina modulo/tema |
| `CHANGELOG.md` | Release notes |
| `LICENSE.md` | Licenza (se serve) |
| `AGENTS.md` | Stub agente on-demand (≤25 righe) |

Tutto il resto → `docs/raw/root-import/` o `docs/wiki/`. Duplicati `changelog.md` / `CHANGELOG.MD` → un solo `CHANGELOG.md`.

### Cartelle maiuscole

- **VIETATO** nella root (`Config/`, `Helpers/`, …)
- Canonico: `app/`, `config/`, `helpers/` lowercase sotto root o sotto `app/`

### File `.code-workspace` — esattamente 1

- **OBBLIGATORIO**: esattamente 1 file `.code-workspace` per modulo/tema
- Nome: `_<nome>.code-workspace` in minuscolo (es. `_geo.code-workspace`, `_ui.code-workspace`)
- **VIETATO**: file `.code-workspace` di altri moduli/temi nella root (es. `_activity.code-workspace` in UI)

## Mai toccare (nwidart)

`composer.json`, `module.json`, `package.json`, `vite.config.js`, `.github/` — vedi [nwidart-module-skeleton-contract.md](../../../../../../docs/wiki/concepts/nwidart-module-skeleton-contract.md).

## Comandi

```bash
bash bashscripts/tools/audit-module-root-hygiene.sh
bash bashscripts/tools/fix-module-root-hygiene.sh
bash bashscripts/tools/guard-nwidart-module-skeleton.sh
```

## Scope

Moduli: `laravel/Modules/<Modulo>/` · Temi: `laravel/Themes/<Tema>/` — **solo root**, non sottocartelle.
