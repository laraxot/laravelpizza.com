---
title: "Contratto di integrazione ECC e PTVX"
type: guide
module: Xot
status: active
created: 2026-10-28
updated: 2026-10-28
tags: [ecc, codex, bmad, second-brain, quality]
qmd: "ECC PTVX precedenza AGENTS BMAD second brain swarm lock qualità"
related:
  - ./00-index.md
  - ../wiki/memories/agent-standing-order.md
---

# Contratto di integrazione ECC e PTVX

ECC aggiunge workflow e conoscenza operativa; non sostituisce il processo del
repository. La configurazione locale di PTVX ha precedenza per ogni lavoro svolto
qui. Quando una skill ECC suggerisce un flusso diverso, adattare la tecnica utile e
conservare gli acceptance criteria e i gate PTVX.

## Configurazione Codex di progetto

La directory `.codex` è un symlink a `bashscripts/ai/.agents`; quindi il file
caricato come `.codex/config.toml` vive in `bashscripts/ai/.agents/config.toml`.
Mantenere valido il TOML e `features.codex_hooks = true`, necessario per la
superficie hook Codex. I callback di progetto devono riferirsi a script presenti
nel checkout e portabili; non copiare hook con percorsi assoluti provenienti da
altri workspace. La configurazione utente `/home/zorin/.codex/config.toml` mantiene
separati stato del plugin e hash di trust.

## Precedenza delle istruzioni

1. Richiesta esplicita dell'utente e istruzioni di sistema.
2. `AGENTS.md` del repository e istruzioni locali dei moduli.
3. Story BMAD attiva, criteri di accettazione e lock del lavoro.
4. Skill ECC scelta per la singola attività.
5. Suggerimenti generici o predefiniti del plugin.

Gli esempi `defaultPrompt` del manifest ECC invitano a usare TDD, security review e
verification loop. Sono punti d'ingresso, non autorizzazioni a saltare la story,
second brain, lock, source-first o il gate Pest. I gate e i divieti sui dati definiti
da PTVX rimangono invariati.

## Uso nei flussi di lavoro

- **Feature o bug Laravel:** partire dal workflow BMAD attivo; usare skill ECC di
  analisi, Laravel/PHP, TDD o review come supporto, con i contratti e le Action Xot.
- **PHPStan:** prima leggere il comportamento di dominio; correggere la causa e
  mantenere `mixed` come ultima risorsa. La skill di code review verifica il diff,
  non sostituisce l'analisi del tipo a livello massimo.
- **Sicurezza:** usare la revisione ECC insieme a policy, autorizzazioni e confini
  multi-tenant già documentati. Le segnalazioni vanno riprodotte e corrette alla
  sorgente.
- **UI o browser:** selezionare skill frontend/browser solo per attività che le
  richiedono; MCP Chrome DevTools può essere avviato solo quando usato.
- **Lavoro parallelo:** la delega segue story, scope disgiunti e lock PTVX; non
  avviare swarm autonomi solo perché ECC offre agenti o workflow di orchestrazione.

## Memoria e apprendimento

La memoria canonica resta il second brain PTVX: `qmd`, wiki e `graphify` quando il
grafo è disponibile. L'eventuale skill ECC di unified memory è una capacità distinta
e non sincronizza automaticamente la memoria PTVX. Non creare un secondo archivio
come SSoT e non copiare contesto privato in un vault ECC senza una necessità esplicita.

Ogni modifica al progetto aggiorna la story con l'esito reale. Le conoscenze
riutilizzabili vanno consolidate nella memoria o nelle regole esistenti e
reindicizzate con `qmd update`.
