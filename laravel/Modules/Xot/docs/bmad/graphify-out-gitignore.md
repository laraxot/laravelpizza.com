---
title: graphify-out gitignore in moduli e temi
type: convention
status: active
updated: 2026-10-20
tags: [graphify, gitignore, no-git-lfs, bmad]
qmd: "graphify-out gitignore moduli temi generated never commit no git lfs rm cached"
related:
  - ./decision-log.md
  - ./filament-blueprint.md
  - ../../../../../bashscripts/ai/wiki/rules/no-git-lfs.md
  - ../../../../../AGENTS.md
---

# `graphify-out/` — perche' e' in ogni `.gitignore`

## Scopo

`graphify-out/` e' l'output **generato** di [graphify](../../../../../AGENTS.md) (AST, `graph.json`, report, wiki). Serve agli agenti per query/path/explain. Non e' sorgente di prodotto ne' superficie Filament.

## Perche' ignorarlo (religione)

1. **Rigenerabile** — `graphify update .` lo riscrive intero; versionarlo produce diff enormi e merge inutili.
2. **Locale / sporco atteso** — AGENTS.md: file dirty dopo hook o update incrementali; non e' motivo di commit.
3. **No Git LFS** — non si "risolve" la mole con LFS ([no-git-lfs](../../../../../bashscripts/ai/wiki/rules/no-git-lfs.md)). Blob normali o, meglio, **non tracciare**.
4. **Confini nwidart** — ogni modulo/tema ha `.gitignore` proprio; il root non basta se il modulo e' un repo nested.

## Contratto

In **ogni** `laravel/Modules/*/.gitignore` e `laravel/Themes/*/.gitignore` (e aggregatori `Modules/`, `Themes/`, root):

```gitignore
# graphify-out: generated AST/knowledge graph — never commit (no git-lfs; rebuild with graphify update)
graphify-out/
```

Il pattern senza slash iniziale matcha anche path annidati (`docs/.../graphify-out/`).

## Se la cartella e' presente e era tracciata

```bash
# nested module/theme repo
git -C laravel/Modules/<M> rm --cached -rf graphify-out
# eventuali artefatti annidati gia' in index (solo path che terminano con /graphify-out/, NON le story .md)
git -C laravel/Modules/<M> ls-files | rg '/graphify-out/|^graphify-out/' 
# poi rm --cached file per file
```

Non cancellare il working tree se serve ancora in locale; togliere solo dall'indice.

## Filament Blueprint

Nessun impatto sul panel: Resources/Widgets/Pages non leggono `graphify-out/`. Vedi [filament-blueprint.md](./filament-blueprint.md) — il grafo e' tooling second brain, non schema UI.

## Verifica

```bash
# ogni modulo/tema ha la riga
rg -l '^graphify-out/$' laravel/Modules/*/.gitignore laravel/Themes/*/.gitignore
# nessun artefatto in index
git ls-files | rg '/graphify-out/|^graphify-out/' || echo OK
```
