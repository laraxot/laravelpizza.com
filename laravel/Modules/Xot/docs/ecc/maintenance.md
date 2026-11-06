---
title: "Manutenzione della documentazione e installazione ECC"
type: runbook
module: Xot
status: active
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, codex, maintenance]
qmd: "ECC manutenzione aggiornamenti versioni cache documentazione Codex"
related:
  - ./00-index.md
  - ./codex-lifecycle.md
---

# Manutenzione di ECC in PTVX

## Quando aggiornare questa documentazione

Rivedere le guide quando cambia uno di questi elementi: release installata, forma
del manifest plugin, skill disponibili, MCP, hook Codex, processo di installazione
o vincoli locali di `AGENTS.md`. Evitare di riscrivere qui il manuale upstream:
conservare procedure locali e decisioni che non si ricavano dalla documentazione
ECC.

## Controllo periodico

- Verificare release e provenienza con `codex plugin list --json` e la sorgente del
  marketplace `codex plugin marketplace list --json`.
- Controllare gli asset con `scripts/codex/check-plugin-cache.js` dall'upstream
  corrispondente alla versione in cache.
- Leggere changelog e diff upstream per manifest, hook, MCP e script di bootstrap.
- Aggiornare [ciclo di vita](codex-lifecycle.md) e [sicurezza](security-and-hooks.md)
  se cambia il comportamento osservabile.
- Aggiornare `qmd` dopo i cambiamenti ai documenti.

## Verifica e limiti

La presenza del plugin, la validità dei link nella cache e la verifica funzionale
delle skill sono controlli distinti. Registrare quale controllo è stato eseguito;
non dichiarare verificata una skill che non è stata invocata. Se il plugin non
compare dopo un upgrade, usare `/plugins` o rimuovere e aggiungere nuovamente la
registrazione seguendo il lifecycle ufficiale, senza pulire manualmente cache
Codex o cronologia.
