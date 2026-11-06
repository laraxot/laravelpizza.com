---
title: "Pi: ripristino settings e migrazione hooks"
type: story
status: done
epic: "PROJECT-TOOLING"
module: Xot
created: 2026-09-29
updated: 2026-09-29
tags: [docs, xot, bmad]
qmd: "pi   ripristino settings e migrazione hooks xot"
---

# Pi: ripristino settings e migrazione hooks

## Problema

L'avvio di `pi` falliva perché `.pi/settings.json` conteneva marker di conflitto
Git e non era JSON valido. Inoltre `.pi/hooks/` era una directory legacy: Pi dalla
versione 0.87 considera le estensioni soltanto sotto `extensions/`.

## Decisione

`.pi` è un symlink verso `bashscripts/ai/.agents`, quindi non si è modificata una
copia locale divergente. Il settings project è stato ridotto al contratto Pi
minimo (`packages` ed `extensions`), mentre gli script legacy sono stati conservati
intatti in `legacy-hooks/`. Non vengono caricati come estensioni Pi perché sono
hook shell/Claude/OpenCode, non moduli Pi TypeScript.

## Verifica

- `python3 -m json.tool bashscripts/ai/.agents/settings.json`: verde;
- `pi --version`: `0.87.1`;
- `pi --offline --help`: nessun warning settings, hooks o load extension;
- enforcement condiviso ancora in `bashscripts/ai/hooks/`.
