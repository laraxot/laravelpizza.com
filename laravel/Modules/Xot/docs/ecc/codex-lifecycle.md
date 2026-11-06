---
title: "Ciclo di vita del plugin ECC per Codex"
type: runbook
module: Xot
status: active
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, codex, installation, runbook]
qmd: "ECC installare verificare aggiornare disabilitare rimuovere plugin Codex"
related:
  - ./00-index.md
  - ./security-and-hooks.md
---

# Ciclo di vita del plugin ECC per Codex

Usare il marketplace/plugin nativo. I comandi agiscono sul `CODEX_HOME` attivo,
normalmente `~/.codex`; non sono limitati a un singolo repository.

## Installazione e verifica

La procedura verificata è:

```bash
codex plugin marketplace add affaan-m/ECC
codex plugin add ecc@ecc --json
codex plugin list --json
node /path/to/ECC/scripts/codex/check-plugin-cache.js
```

Per questo host il marketplace è `/home/zorin/.codex/.tmp/marketplaces/ecc` e il
plugin è `/home/zorin/.codex/plugins/cache/ecc/ecc/2.2.3`. La verifica ha confermato
che skills, MCP, icona e logo dichiarati nel manifest sono presenti nella cache.
Riavviare Codex per rendere disponibili le skill nel composer.

La simulazione guidata è stata eseguita con:

```bash
npx --yes ecc-universal@2.2.3 install --guided --harness codex --dry-run
```

Il piano ha indicato il lifecycle plugin nativo in `~/.codex`; non ha modificato
file. Per installazioni future, leggere il dry-run e la versione upstream prima di
applicare modifiche. Il comando `codex plugin add` usa la versione pubblicata dal
marketplace configurato, perciò controllare sempre `version` nell'output JSON.

## Aggiornamento

Prima di aggiornare leggere il changelog upstream e verificare le modifiche a skill,
manifest, hook e MCP. Poi usare il lifecycle ufficiale:

```bash
codex plugin marketplace upgrade ecc
codex plugin add ecc@ecc --json
codex plugin list --json
node /path/to/ECC/scripts/codex/check-plugin-cache.js
```

La cache cambia per versione. Dopo l'aggiornamento riavviare Codex e riesaminare
eventuali hook modificate: Codex associa il trust all'hash della definizione.

## Disattivazione e rimozione

Per disabilitare temporaneamente il plugin usare `/plugins` nella sessione Codex.
Per rimuoverlo dalla home Codex:

```bash
codex plugin remove ecc@ecc
```

Rimuovere anche il marketplace solo se non serve ad altri plugin:

```bash
codex plugin marketplace remove ecc
```

Il cleanup legacy `ecc uninstall --legacy-codex-sync` non serve per il plugin
nativo e non deve essere usato per pulire la sua cache.
