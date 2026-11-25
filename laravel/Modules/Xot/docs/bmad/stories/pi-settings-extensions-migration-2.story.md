---
title: "Pi — ripristino settings e migrazione hooks"
type: story
status: done
epic: "PROJECT-TOOLING"
module: Xot
created: 2026-09-29
updated: 2026-11-16
tags: [docs, xot, bmad]
qmd: "pi ripristino settings e migrazione hooks xot"
---

# Pi — ripristino settings e migrazione hooks

## Problema

L'avvio di `pi` / `ollama launch pi` falliva perché `.pi/settings.json`
(symlink → `bashscripts/ai/.agents/settings.json`) non era JSON valido
(marker di conflitto Git: errore a line 2 / position 2) e bloccava
`pi-mcp-adapter`. Inoltre `.pi/hooks/` legacy generava warning + "Press any key".

## Decisione

Settings project = contratto Pi minimo valido (`packages`, `extensions`, `$version`).
Script legacy in `legacy-hooks/` (non in `hooks/`). Estensioni Pi solo in
`extensions/`. Enforcement condiviso resta in `bashscripts/ai/hooks/`.

## Regressione 2026-11-16

`hooks/` era ricomparsa sotto `.pi`; ripristinato `mv hooks legacy-hooks`.
Settings project già JSON valido; non ripristinare i `*.bak-corrupt*` /
`settings.json.pi-conflict-backup`.

## Verifica

- `python3 -m json.tool bashscripts/ai/.agents/settings.json`: verde
- `test ! -d bashscripts/ai/.agents/hooks`: ok
- `pi --offline --help` / `pi list`: nessun Invalid settings / Failed to load extension
- enforcement condiviso ancora in `bashscripts/ai/hooks/`

## Riferimenti

- Memoria: [pi-settings-extensions.md](../../../../../../docs/wiki/memories/pi-settings-extensions.md)
- Sprint: `docs/sprint-status.yaml` → `Xot/pi-settings-extensions-migration-20260929`
