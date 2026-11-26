---
title: "Topic ollama-mcp"
type: digest
status: active
qmd: "digest ceiling 100 ollama-mcp"
---

# Topic ollama-mcp

Sintesi automatica di 4 documenti (chiave `ollama-mcp`).

## 🧘 Ollama MCP Integration - Visione e Filosofia

_Fonte: `ollama-mcp-integration-vision.md`_

# 🧘 Ollama MCP Integration - Visione e Filosofia

**Data Creazione**: 2026-03-11  
**Ultimo Aggiornamento**: 2026-03-11  
**Autore**: AI Agent (con supporto altri agenti AI)  
**Versione**: 1.0.0

---

title: "ollama mcp integration vision"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ollama mcp integration vision"
issues: []
discussions: []
## 📖 Il Perché - The Why

### Perché Ollama tramite MCP?

**1. Efficienza Token e Costi**
- Riduzione fino al 70% dei costi token rispetto a API cloud
- Operazioni locali delegate ad agenti MCP riducono il carico sul modello principale
- Caching intelligente delle risposte Ollama per query ripetute

**2. Privacy e Sicurezza**
- Dati sensibili rimangono in locale
- Nessuna trasmissione di informazioni aziendali a servizi terzi

## Ollama MCP Setup

_Fonte: `ollama-mcp-setup.md`_

# Ollama MCP Setup

## Perche'

Questa configurazione esiste per rendere disponibile un LLM locale via MCP agli agenti AI che lavorano sul progetto. Lo scopo non e' solo "far funzionare Ollama", ma ridurre attrito operativo, costi di token e dipendenza da servizi remoti per i task che possono essere eseguiti localmente.

## Scopo operativo

- Esporre Ollama come server MCP riusabile da editor e agenti.
- Uniformare la configurazione tra workspace root, Laravel app e configurazioni editor.
- Rendere `docs/` il punto di handoff tra agenti su motivazioni, vincoli e decisioni.

## Politica

- Preferire modelli locali per triage, refactoring semplice, sintesi e generazione boilerplate.
- Tenere i path MCP allineati al repository corrente, non a workspace storici.
- Documentare sempre il contesto della scelta, non solo i parametri tecnici.
- Evitare configurazioni che dipendono da un primo download implicito se il pacchetto puo' essere installato in locale.

## Visione

L'integrazione MCP con Ollama serve a trattare il modello locale come infrastruttura di base del progetto, non come tool occasionale. La documentazione deve permettere a piu' agenti di convergere sulla stessa strategia senza riesplorare da zero.

## Filosofia

- Le `docs/` non sono archivio passivo: sono memoria condivisa tra agenti.
- Il "come" senza il "perche'" degrada rapidamente in configurazione fragile.
- Una configurazione AI e' completa solo se e' verificata e spiegata.

## 📘 Guida Pratica all'Utilizzo di Ollama MCP

_Fonte: `ollama-mcp-usage-guide.md`_

# 📘 Guida Pratica all'Utilizzo di Ollama MCP

**Data Creazione**: 2026-03-11  
**Versione**: 1.0.0  
**Compatibilità**: ollama-mcp v2.1.0+

---

title: "ollama mcp usage guide"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ollama mcp usage guide"
issues: []
discussions: []
## 🚀 Quick Start

### Prerequisiti

1. **Ollama installato e funzionante**
   ```bash
   # Verifica installazione
   ollama --version
   
   # Verifica server attivo
   curl http://127.0.0.1:11434/api/tags
   ```

## Topic ollama-mcp

_Fonte: `wiki/topics/ollama-mcp.md`_

# Topic ollama-mcp

Sintesi automatica di 3 documenti (chiave `ollama-mcp`).

## 🧘 Ollama MCP Integration - Visione e Filosofia

_Fonte: `ollama-mcp-integration-vision.md`_

# 🧘 Ollama MCP Integration - Visione e Filosofia

**Data Creazione**: 2026-03-11  
**Ultimo Aggiornamento**: 2026-03-11  
**Autore**: AI Agent (con supporto altri agenti AI)  
**Versione**: 1.0.0

---

title: "ollama mcp integration vision"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ollama mcp integration vision"
issues: []
discussions: []
## 📖 Il Perché - The Why

### Perché Ollama tramite MCP?
