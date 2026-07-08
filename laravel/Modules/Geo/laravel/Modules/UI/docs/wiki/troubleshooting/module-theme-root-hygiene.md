---
title: "Root modulo/tema — zero .txt, max 4 .md"
type: rule
module: UI
tags: [hygiene, modules, themes, txt, markdown]
created: 2026-07-08
updated: 2026-07-08
qmd: "module theme root txt md hygiene audit fix"
related:
  - ../../../../../../docs/wiki/rules/module-theme-root-no-txt-files.md
  - ../../../../../../docs/wiki/rules/module-theme-root-md-files-limit.md
---

# Root modulo/tema — igiene

## Regola

| Root `Modules/*` e `Themes/*` | Consentito |
|---------------------------------|------------|
| `*.txt` | **0** |
| `*.md` | **max 4**: `README.md`, `CHANGELOG.md`, `LICENSE.md`, `AGENTS.md` |
| Cartelle | solo **lowercase** (`app`, `config`, `docs`, …) |

## Perché

La root è la **superficie tecnica** del package (manifest nwidart, autoload, README). Appunti `.txt` e report `.md` sporcano audit, QMD e push submodule.

## Audit

```bash
# da root monorepo
bash bashscripts/tools/audit-module-root-hygiene.sh

# solo moduli o un owner
bash bashscripts/tools/audit-module-root-hygiene.sh UI modules

# zero .txt in root
find laravel/Modules laravel/Themes -mindepth 2 -maxdepth 2 -type f -name '*.txt' | wc -l
# atteso: 0
```

## Fix automatico

```bash
bash bashscripts/tools/fix-module-root-hygiene.sh
bash bashscripts/tools/audit-module-root-hygiene.sh
```

Sposta:

- `.txt` → `docs/root-txt-files/`
- `.md` non ammessi → `docs/root-md-files/` (nome minuscolo kebab-case)

## Fix manuale (casi frequenti)

| Violazione | Azione |
|------------|--------|
| `api.md`, `blocks.md`, `QWEN.md` in root | `mv` → `docs/root-md-files/` |
| `changelog.md` + `CHANGELOG.md` | Tieni `CHANGELOG.md`, sposta duplicato |
| `README.en.md` / `README.it.md` | Sposta in `docs/root-md-files/`; vetrina = solo `README.md` |
| Cartella `Config/` con `config/` presente | `rm -rf Config/` |
| Cartelle maiuscole legacy (es. `Xot/Datas/`) | Archivia in `docs/root-uppercase-folders/` se **non** in PSR-4 `app/` |
| File vuoto `.md` | Elimina |

## Bonifica 2026-07-08 (monorepo)

23 violazioni risolte su moduli/temi (Job, Notify, UI, Xot, Zero, …). Audit finale: **OK**.

## Riferimenti

- Wiki: [module-theme-root-no-txt-files](../../../../../../docs/wiki/rules/module-theme-root-no-txt-files.md)
- Wiki: [module-theme-root-md-files-limit](../../../../../../docs/wiki/rules/module-theme-root-md-files-limit.md)
- Cursor: `.cursor/rules/module-root-hygiene.mdc`
