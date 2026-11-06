---
title: "Sicurezza, hook e MCP di ECC su Codex"
type: reference
module: Xot
status: active
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, codex, security, hooks, mcp]
qmd: "ECC Codex sicurezza hook SessionStart trust MCP chrome devtools"
related:
  - ./00-index.md
  - ./codex-lifecycle.md
---

# Sicurezza, hook e MCP di ECC su Codex

## Provenienza

Il plugin è stato scaricato dal marketplace Git ufficiale
`https://github.com/affaan-m/ECC.git`. Il checkout esaminato dichiara licenza MIT.
La versione installata è `2.2.3`. Per ogni aggiornamento controllare la sorgente,
il manifest e le modifiche al codice eseguibile prima di considerare affidabile una
nuova release.

## Hook `SessionStart`

La proiezione Codex upstream contiene una hook sincrona `SessionStart` che esegue
JavaScript/Node e avvia `scripts/hooks/session-start-bootstrap.js`. La hook dichiara
di caricare contesto precedente e rilevare il package manager.

Codex separa lo stato del plugin dal trust delle hook. Dopo `codex plugin add`,
`~/.codex/config.toml` contiene `trusted_hash` e `trusted_content_hash` per
`ecc@ecc:hooks/codex-hooks.json:session_start`: la definizione installata risulta
trusted e può essere eseguita nelle sessioni future. Non è stata aperta una sessione
interattiva `/hooks`; gli hash sono stati verificati direttamente nel file di stato.

La revisione del codice installato mostra che la hook crea cartelle sotto la home
Claude/ECC, scrive un lease progetto in `~/.local/share/ecc-homunculus`, legge
riepiloghi locali e limita il contesto iniettato (8.000 caratteri predefiniti).
Può eliminare solo file `*-session.tmp` più vecchi della retention predefinita di 30
giorni nelle directory sessioni ECC/legacy. Il percorso usa anche `git` per
identificare il progetto. Se la hook cambia in un aggiornamento, rivedere gli hash e
la nuova implementazione prima di continuare a considerarla affidabile.

## MCP `chrome-devtools`

Il manifest `.mcp.json` include `chrome-devtools` come processo configurato tramite
`npx -y chrome-devtools-mcp@1.10.1`. Serve per interagire con il browser via Chrome
DevTools Protocol. Il server può osservare stato browser, console e rete della
sessione collegata; usarlo solo quando il task richiede debugging browser e non
collegare sessioni con dati sensibili non necessari. Se il pacchetto non è in cache,
`npx` può scaricarlo dal registry.

L'installazione del plugin non ha avviato una sessione browser e non sono state
fornite credenziali aggiuntive. La configurazione MCP fornita dal plugin è presente
nel manifest installato; la verifica cache ne ha controllato il percorso, non
l'avvio effettivo del server né il funzionamento end-to-end del browser.

## Confini non verificati

Il controllo di cache dimostra che i riferimenti manifest risolvono, non che ogni
skill sia priva di errori o sicura in ogni contesto. Le skill non eseguite non sono
state auditate singolarmente. Prima di invocare script che fanno rete, modificano
file o inviano dati, leggere istruzioni, argomenti e destinazione. Non usare hook
globali per aggirare i limiti o i gate PTVX.
