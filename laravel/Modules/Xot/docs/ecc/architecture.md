---
title: "Architettura ECC nell'ambiente Codex"
type: guide
module: Xot
status: active
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, codex, architecture]
qmd: "ECC Codex marketplace plugin skills MCP hook architettura"
related:
  - ./00-index.md
  - ./security-and-hooks.md
---

# Architettura ECC nell'ambiente Codex

ECC (Everything Claude Code) è un insieme multipiattaforma di workflow, skill,
configurazioni MCP e hook. Il nome nasce da Claude Code, ma il repository include
percorsi plugin nativi per più harness. In questo host ECC è attivo sia in Claude
Code sia in Codex; ciascun harness mantiene cache, hook, skill e configurazione
indipendenti. Per Codex PTVX usa il plugin nativo e non importa tutta la
configurazione Claude né adotta lo script legacy di sync.

## Componenti installati

Il marketplace Codex `ecc` punta al repository upstream ufficiale. Il plugin
`ecc@ecc` scarica il manifest e gli asset nella cache del `CODEX_HOME` attivo, qui
`/home/zorin/.codex/plugins/cache/ecc/ecc/2.2.3`.

Il manifest `plugin.json` collega:

- `skills/`: workflow riutilizzabili; ECC ne dichiara 281 per la superficie Codex
  della release ispezionata;
- `.mcp.json`: server MCP opzionali esposti dal plugin;
- `hooks/codex-hooks.json`: adattamento nativo e ristretto degli eventi supportati
  da Codex;
- asset grafici e metadati di presentazione.

La registrazione del plugin è abilitata a livello di `CODEX_HOME`, quindi vale per
le sessioni Codex che usano quell'home. Le skill diventano disponibili al runtime
Codex dopo il riavvio o il caricamento di una nuova sessione.

## Cosa non viene portato nel progetto

Il plugin Codex non copia le proprie istruzioni root `AGENTS.md`, `.codex/config.toml` o i
file ruolo del checkout ECC dentro PTVX. Questi file sono esempi di configurazione
upstream e possono impostare convenzioni o gate non compatibili con il repository.
La configurazione di progetto resta quella già presente in `AGENTS.md` e nei file
Codex locali eventualmente tracciati da PTVX.

Non viene installato il layer legacy `sync-ecc-to-codex.sh`: esso fonde file nella
home Codex e duplicherebbe la superficie fornita dal plugin nativo.

## Fonti e versione

La documentazione è una mappa operativa, non una copia del manuale upstream. In caso
di differenza, fare riferimento alla release installata e alla documentazione ECC:

- [Repository ECC](https://github.com/affaan-m/ECC)
- [`README.md`, supporto multi-harness](https://github.com/affaan-m/ECC/blob/main/README.md)
- [Note del plugin nativo](https://github.com/affaan-m/ECC/blob/main/.codex-plugin/README.md)
- [Licenza MIT](https://github.com/affaan-m/ECC/blob/main/LICENSE)

Registrazione, cache e release sono stati verificati il 28 ottobre 2026. Il checkout
di studio era al commit `25278e7d7b6cf6e6a4e7a6c8e10f14ff22f0eb5b`; la versione
installata è `2.2.3`.
