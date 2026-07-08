---
title: "AI Module Documentation"
type: documentation
tags: [module, documentation]
created: 2026-06-05
updated: 2026-06-05
---

# 🤖 AI Module - Integrazione MCP

## 📋 Quick Reference
| Categoria | Guida | File |
|-----------|-------| ---- |
| **Setup** | MCP Server Setup | [mcp/01_installazione.md](mcp/01_installazione.md) |
| **Config** | Configurazione | [mcp/02_configurazione.md](mcp/02_configurazione.md) |
| **Usage** | Utilizzo pratico | [mcp/03_utilizzo.md](mcp/03_utilizzo.md) |
| **Integration** | Chat System | [chat.md](chat.md) |
| **Training** | Fine Tuning | [fine_tuning.md](fine_tuning.md) |
| **Tools** | Ollama, CLI Tools | [ollama.md](ollama.md), [tools.md](tools.md) |
| **Troubleshooting** | Errori comuni | [mcp/06_troubleshooting.md](mcp/06_troubleshooting.md) |

## 🎯 Core Features
- **MCP Protocol**: Database integration, external services, custom tools
- **AI Chat**: Multi-user interface, context management, memory persistence
- **Model Training**: Fine tuning, data preparation, deployment

## 📁 Documentation Structure
- `/mcp/` - Documentazione completa MCP (00-11)
- `/tutorials/` - Tutorial pratici Laravel+MCP
- `/phpstan/` - Configurazioni PHPStan

## Panoramica

Il modulo AI fornisce funzionalità di integrazione con il Model Context Protocol (MCP) per consentire alle applicazioni Laravel di comunicare efficacemente con modelli di linguaggio (LLM) e implementare agenti AI avanzati.

## Documentazione

Questa directory contiene la documentazione completa sull'integrazione MCP in Laravel, con particolare attenzione ai casi d'uso, all'implementazione e alle best practices.

### Indice della Documentazione

1. [Guida all'Integrazione MCP](./MCP_INTEGRATION_GUIDE.md)
   - Panoramica completa del protocollo MCP
   - Vantaggi dell'integrazione in Laravel
   - Architettura e componenti principali
   - Casi d'uso generali e implementazione base

2. [Casi d'Uso di MCP in Laravel](./MCP_CASI_USO.md)
   - Esempi dettagliati di casi d'uso specifici
   - Automazione dei processi di business
   - Assistenza utente e supporto
   - Analisi e gestione dei dati
   - Sviluppo e debugging

3. [Implementazione MCP in Laravel](./MCP_IMPLEMENTAZIONE_LARAVEL.md)
   - Guida dettagliata all'implementazione
   - Sviluppo di strumenti MCP
   - Integrazione con l'architettura esistente
   - Testing e debugging
   - Conformità con PHPStan Livello 9

## Risorse Esterne

La documentazione fa riferimento alle seguenti risorse esterne:

- [Documentazione Ufficiale MCP](../../../../docs/project/references/mcp_documentation.md)
- [Laravel MCP SDK](../../../../docs/project/references/laravel_mcp_sdk.md)
- [Neuron AI Documentation](../../../../docs/project/references/neuron_ai_docs.md)
- [AI Agents in PHP with MCP](../../../../docs/project/references/ai_agents_php_mcp.md)
- [Laravel Helper Tools MCP server](../../../../docs/project/references/laravel_helper_tools.md)

## Implementazioni Open Source

Queste implementazioni open source possono essere utilizzate come riferimento:

- [InnoGE/laravel-mcp](../../../../docs/project/references/innoge_laravel_mcp.md)
- [OPGG/laravel-mcp-server](../../../../docs/project/references/opgg_laravel_mcp_server.md)

## Contribuire

Se desideri contribuire a questa documentazione o all'implementazione del modulo AI, segui le linee guida del progetto e assicurati che il codice sia conforme agli standard di PHPStan livello 9.

---

> ℹ️ **Per l'installazione e la gestione centralizzata degli MCP servers, consulta la guida [INSTALLAZIONE_MCP_SERVERS.md](./INSTALLAZIONE_MCP_SERVERS.md).**

🔗 **Guida installazione MCP servers:** [INSTALLAZIONE_MCP_SERVERS.md](./INSTALLAZIONE_MCP_SERVERS.md)

---

*Ultimo aggiornamento: Maggio 2025*
*Principio DRY: Una funzionalità = Una documentazione. Collegamenti logici e struttura pulita.*

## AI Workflows
- [AI Methodologies](./ai-methodologies.md)
- [OpenViking Integration Guide](../../../../docs/openviking-integration.md)

## LLM Wiki Workflow

- Local compiled wiki: [./wiki/README.md](./wiki/README.md)
- Local compiled index: [./wiki/index.md](./wiki/index.md)
- Project wiki layer: [../../../../docs/wiki/README.md](../../../../docs/wiki/README.md)
- Project compiled index: [../../../../docs/wiki/index.md](../../../../docs/wiki/index.md)
- Adoption notes and QMD: [../../../../docs/project/karpathy-llm-wiki-adoption.md](../../../../docs/project/karpathy-llm-wiki-adoption.md), [../../../../docs/project/qmd-local-docs-search.md](../../../../docs/project/qmd-local-docs-search.md)
- [AI LLM Wiki](./llm-wiki.md)


## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

## Documentation

- [On-Demand Pattern](./ON-DEMAND-PATTERN.md) — Pattern per caricamento efficiente
- [QMD Setup](./QMD-SETUP.md) — Configurazione ricerca locale
- [Performance](./PERFORMANCE-OPTIMIZATION.md) — Metriche e best practice
- [Project Structure](./PROJECT-STRUCTURE.md) — Directory layout