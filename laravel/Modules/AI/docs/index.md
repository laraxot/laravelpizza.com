---
created: 2026-09-26
qmd: "index"
issues: []
discussions: []
title: "AI Module - Documentation Index"
description: "Indice organizzato per argomento di tutta la documentazione in Modules/AI/docs"
module: AI
type: index
tags: [ai, documentazione, indice, modulo]
status: active
updated: 2026-09-03
---

# AI Module - Documentation Index

Indice unico e navigabile di `laravel/Modules/AI/docs/`. Organizzato per argomento, non per ordine alfabetico. Nessun file esistente e' stato rinominato o cancellato per produrre questo indice: dove esistono doc duplicati o superati, sono raggruppati nella sezione [Storico / da consolidare](#storico--da-consolidare) invece di essere rimossi.

Altri indici presenti nella cartella (`00-index.md`, `INDEX.md`) sono tentativi precedenti/parziali: restano al loro posto ma questo `index.md` e' il riferimento aggiornato e completo.

## Start here

| Doc | Contenuto |
|---|---|
| [README.md](./README.md) | Overview del modulo, ownership Actions, quick reference |
| [readme-en.md](./readme-en.md) | Presentazione in inglese |
| [philosophy.md](./philosophy.md) | Finalita', responsabilita' e principi di design del modulo |
| [ai-methodologies.md](./ai-methodologies.md) | Indice locale DRY dei workflow AI, rimanda alle fonti canoniche |

## Prodotto e pianificazione

| Doc | Contenuto |
|---|---|
| [prd.md](./prd.md) | Product Requirements Document |
| [roadmap.md](./roadmap.md) | Roadmap corrente (mission, milestone, stato PHPStan) |
| [roadmap/README.md](./roadmap/README.md) | Visione roadmap AI toolkit (formulazione estesa) |
| [roadmap-and-issues.md](./roadmap-and-issues.md) | Snapshot datato (ottobre 2025) di roadmap e problemi aperti |
| [product-strategy.md](./product-strategy.md) | Strategia prodotto con stima di allineamento |
| [strategy.md](./strategy.md) | Pilastri strategici sintetici (modularita', affidabilita', scalabilita') |
| [sprint.md](./sprint.md) | Definition of done dello sprint corrente |
| [research.md](./research.md) | Insight di user research |
| [launch.md](./launch.md) | Checklist di lancio |

## Architettura e struttura del modulo

| Doc | Contenuto |
|---|---|
| [project-structure.md](./project-structure.md) | Layout directory del modulo (versione aggiornata) |
| [concepts/xotbase-never-extend-filament.md](./concepts/xotbase-never-extend-filament.md) | Regola: mai `Filament\*` diretto, sempre `XotBase*` |
| [contracts-naming.md](./contracts-naming.md) | Naming e placement dei Contracts in AI |
| [queueable-actions.md](./queueable-actions.md) | Dottrina Queueable Actions del modulo AI |
| [database-factories-seeders.md](./database-factories-seeders.md) | Stato copertura migration/factory/seeder per modello |
| [performance-optimization.md](./performance-optimization.md) | Metriche e best practice di performance |
| [deferred-operator-assistant-agent.md](./deferred-operator-assistant-agent.md) | Nota su tool-calling differito in `OperatorAssistantAgent` (gestionale_commesse) |

### Integrazione con il modulo Predict

| Doc | Contenuto |
|---|---|
| [predict-generation.md](./predict-generation.md) | Come AI deve generare predizioni realistiche per Predict |
| [predict-drafts-contract.md](./predict-drafts-contract.md) | Contratto reale di `GeneratePredictionDraftsAction` |
| [generate_predictions_action.md](./generate_predictions_action.md) | Implementazione di `GeneratePredictionsAction` |

Nota: i tre documenti sopra si sovrappongono parzialmente (stessa famiglia di Actions vista da angolazioni diverse). Non sono duplicati esatti quindi restano tutti attivi, ma un consolidamento futuro in un unico doc "Predict integration" ridurrebbe la ridondanza.

## Integrazione MCP (Model Context Protocol)

| Doc | Contenuto |
|---|---|
| [mcp.md](./mcp.md) | Overview configurazione MCP del modulo |
| [installazione-mcp-servers.md](./installazione-mcp-servers.md) | Installazione e gestione centralizzata MCP servers |
| [cursor-mcp.md](./cursor-mcp.md) | Configurazione MCP per Cursor |
| [mcp/00-indice.md](./mcp/00-indice.md) | Indice della guida MCP numerata (00-11) |
| [mcp/00-introduzione.md](./mcp/00-introduzione.md) | Introduzione ai server MCP per progetti Laravel |
| [mcp/01-installazione.md](./mcp/01-installazione.md) | Installazione dei server MCP |
| [mcp/02-configurazione.md](./mcp/02-configurazione.md) | Configurazione dei server MCP |
| [mcp/03-utilizzo.md](./mcp/03-utilizzo.md) | Utilizzo pratico |
| [mcp/04-integrazione-moduli.md](./mcp/04-integrazione-moduli.md) | Integrazione con i moduli Laravel |
| [mcp/05-implementazione-pratica.md](./mcp/05-implementazione-pratica.md) | Implementazione pratica |
| [mcp/06-troubleshooting.md](./mcp/06-troubleshooting.md) | Risoluzione dei problemi |
| [mcp/07-best-practices.md](./mcp/07-best-practices.md) | Best practice |
| [mcp/08-api-reference.md](./mcp/08-api-reference.md) | Riferimento API |
| [mcp/09-sicurezza.md](./mcp/09-sicurezza.md) | Sicurezza |
| [mcp/10-performance.md](./mcp/10-performance.md) | Ottimizzazione performance |
| [mcp/11-aggiornamenti.md](./mcp/11-aggiornamenti.md) | Aggiornamenti |
| [mcp/mcp-integration-overview.md](./mcp/mcp-integration-overview.md) | Panoramica integrazione MCP nei moduli Laravel |

La guida numerata `mcp/NN-topic.md` e' la versione canonica di ciascun argomento: vedi la nota nello storico per i duplicati.

## Integrazione Ollama

| Doc | Contenuto |
|---|---|
| [ollama-strategy.md](./ollama-strategy.md) | Ollama & Local-First AI Strategy ("Super Mucca" philosophy) |
| [ollama.md](./ollama.md) | Note operative Ollama |
| [ollama-mcp-setup.md](./ollama-mcp-setup.md) | Setup Ollama MCP |
| [ollama-mcp-usage-guide.md](./ollama-mcp-usage-guide.md) | Guida pratica all'utilizzo di Ollama MCP |
| [ollama-mcp-integration-vision.md](./ollama-mcp-integration-vision.md) | Visione e filosofia dell'integrazione Ollama MCP |
| [ollama-actions-moved-from-xot.md](./ollama-actions-moved-from-xot.md) | Storia dello spostamento delle Actions Ollama da Xot ad AI |
| [next-steps.md](./next-steps.md) | Stato attuale e prossimi passi dell'integrazione Ollama MCP |

## Altri provider e training

| Doc | Contenuto |
|---|---|
| [google-gemini.md](./google-gemini.md) | Integrazione Google Gemini |
| [llama.md](./llama.md) | Integrazione Llama |
| [fine-tuning.md](./fine-tuning.md) | Fine tuning dei modelli |
| [create-an-assistant.md](./create-an-assistant.md) | Creazione di un Assistant |

## Tutorial

| Doc | Contenuto |
|---|---|
| [tutorials/ai-agents-in-php-with-mcp.md](./tutorials/ai-agents-in-php-with-mcp.md) | AI Agents in PHP con MCP |
| [tutorials/building-laravel-portfolio-api-with-mcp.md](./tutorials/building-laravel-portfolio-api-with-mcp.md) | Costruire una Laravel Portfolio API con MCP |
| [tutorials/laravel-helper-tools-for-mcp.md](./tutorials/laravel-helper-tools-for-mcp.md) | Laravel Helper Tools per MCP |

## Qualita', PHPStan e report di analisi

| Doc | Contenuto |
|---|---|
| [phpstan-status.md](./phpstan-status.md) | Stato corrente PHPStan |
| [phpstan-fixes.md](./phpstan-fixes.md) | Compliance PHPStan del modulo |
| [phpstan-findings.md](./phpstan-findings.md) | Findings PHPStan |
| [phpstan-errors-analysis.md](./phpstan-errors-analysis.md) | Analisi errori PHPStan |
| [phpstan-fixes-history.md](./phpstan-fixes-history.md) | Storico dei fix PHPStan |
| [phpstan-remediation.md](./phpstan-remediation.md) | Piano di remediation PHPStan (2025-12-23) |
| [code-quality-report.md](./code-quality-report.md) | Report qualita' del codice |
| [code-quality-improvement-report.md](./code-quality-improvement-report.md) | Report miglioramento qualita' del codice |
| [cyclomatic-complexity-report.md](./cyclomatic-complexity-report.md) | Report complessita' ciclomatica |
| [duplicate-methods-analysis.md](./duplicate-methods-analysis.md) | Analisi metodi duplicati (2025-10-15) |
| [dry-kiss-analysis.md](./dry-kiss-analysis.md) | Analisi DRY & KISS |
| [redundancy-audit-2026-05-21.md](./redundancy-audit-2026-05-21.md) | Audit ridondanza 2026-05-21 |
| [copilot-redundancy-audit-2026-05-25.md](./copilot-redundancy-audit-2026-05-25.md) | Audit ridondanza 2026-05-25 |
| [ponytail-audit-2026-07-02.md](./ponytail-audit-2026-07-02.md) | Ponytail audit: SentimentAction driver selection in config |
| [ponytail-audit-over-engineering.md](./ponytail-audit-over-engineering.md) | Ponytail audit su over-engineering |

## Governance, convenzioni e hygiene

| Doc | Contenuto |
|---|---|
| [best_practices.md](./best_practices.md) | Best practices del modulo |
| [bad_practices.md](./bad_practices.md) | Pratiche da evitare |
| [false_friends.md](./false_friends.md) | False friends terminologici |
| [file-naming-rules.md](./file-naming-rules.md) | Regole di naming per i file |
| [on-demand-pattern.md](./on-demand-pattern.md) | Pattern on-demand del modulo |
| [qmd-setup.md](./qmd-setup.md) | Setup QMD per il modulo |
| [module-root-hygiene.md](./module-root-hygiene.md) | Perche' la root del modulo resta pulita |
| [root-file-policy.md](./root-file-policy.md) | Policy sui file in root |
| [root-files-hygiene.md](./root-files-hygiene.md) | Log hygiene dei file root |
| [no-ai-tool-scaffold-dirs.md](./no-ai-tool-scaffold-dirs.md) | Perche' certe cartelle scaffold non devono esistere qui |
| [gsd_workflow.md](./gsd_workflow.md) | Workflow GSD locale al modulo |

## Troubleshooting e fix

| Doc | Contenuto |
|---|---|
| [errors.md](./errors.md) | Errori comuni e soluzioni |
| [codex-error-fix.md](./codex-error-fix.md) | Fix errori di configurazione Codex |
| [boost_skill_fix_summary.md](./boost_skill_fix_summary.md) | Riepilogo fix Boost skill |
| [laravel-specialist-skill-installation.md](./laravel-specialist-skill-installation.md) | Installazione skill laravel-specialist |

## Note e link dump

| Doc | Contenuto |
|---|---|
| [chat.md](./chat.md) | Link di riferimento (Perplexity, HuggingFace playground) |
| [tools.md](./tools.md) | Link di riferimento su tool Copilot/Ollama |
| [repositories.md](./repositories.md) | Elenco repository PHP/AI di riferimento |
| [video-tutorial.md](./video-tutorial.md) | Link a video tutorial Ollama + Llama 3 + Laravel |

## Wiki (second brain del modulo)

Layer di conoscenza compilata, separato dai doc sorgente sopra. Punti di ingresso:

| Doc | Contenuto |
|---|---|
| [wiki/README.md](./wiki/README.md) | Cosa contiene e come usare il wiki compilato |
| [wiki/index.md](./wiki/index.md) | Indice del wiki (frontmatter, related, qmd) |
| [wiki/schema.md](./wiki/schema.md) | Schema del wiki |
| [wiki/log.md](./wiki/log.md) | Log del wiki |
| [llm-wiki.md](./llm-wiki.md) | Mapping del pattern Karpathy applicato a questo modulo |
| [llm-wiki/agents.md](./llm-wiki/agents.md) | Istruzioni per gli agenti che alimentano il wiki (canonica) |

### Concetti (wiki/concepts/)

| Doc | Contenuto |
|---|---|
| [wiki/concepts/index.md](./wiki/concepts/index.md) | Indice dei concetti |
| [wiki/concepts/ai-mcp-governance.md](./wiki/concepts/ai-mcp-governance.md) | Governance AI/MCP |
| [wiki/concepts/ai-services-support-to-actions.md](./wiki/concepts/ai-services-support-to-actions.md) | Migrazione Services/Support -> Queueable Actions |
| [wiki/concepts/bmad-v66-codex-laravel13-upgrade.md](./wiki/concepts/bmad-v66-codex-laravel13-upgrade.md) | Setup BMAD v6.6 Codex per upgrade Laravel 13 |
| [wiki/concepts/claude-audit-static.md](./wiki/concepts/claude-audit-static.md) | Claude audit static |
| [wiki/concepts/composer-root-minimal-nwidart.md](./wiki/concepts/composer-root-minimal-nwidart.md) | AI e composer root minimale |
| [wiki/concepts/context-compression-plugin.md](./wiki/concepts/context-compression-plugin.md) | Context Compression Plugin |
| [wiki/concepts/local-first-ollama-strategy.md](./wiki/concepts/local-first-ollama-strategy.md) | Strategia local-first Ollama |
| [wiki/concepts/no-app-support-queueable-actions.md](./wiki/concepts/no-app-support-queueable-actions.md) | `app/Support/` eliminato |
| [wiki/concepts/no-services-no-support-queueable-actions.md](./wiki/concepts/no-services-no-support-queueable-actions.md) | Services/Support vietati: solo Actions |
| [wiki/concepts/ollama-actions-ownership.md](./wiki/concepts/ollama-actions-ownership.md) | Ownership delle Actions Ollama (vivono in AI, non in Xot) |
| [wiki/concepts/openrouter-context-compression.md](./wiki/concepts/openrouter-context-compression.md) | OpenRouter Context Compression Plugin |
| [wiki/concepts/phpstan-compliance.md](./wiki/concepts/phpstan-compliance.md) | PHPStan Type Compliance |
| [wiki/concepts/ponytail-audit.md](./wiki/concepts/ponytail-audit.md) | Ponytail audit (wiki) |
| [wiki/concepts/second-brain-local-discipline.md](./wiki/concepts/second-brain-local-discipline.md) | Contratto wiki locale |
| [wiki/concepts/testing.md](./wiki/concepts/testing.md) | Testing in AI |
| [wiki/concepts/token-efficiency-local.md](./wiki/concepts/token-efficiency-local.md) | Token efficiency locale |

### Altre sezioni del wiki

| Doc | Contenuto |
|---|---|
| [wiki/bmad-method.md](./wiki/bmad-method.md) | BMAD Method v6.3 operativo nel progetto |
| [wiki/commands/index.md](./wiki/commands/index.md) | Indice commands |
| [wiki/comparisons/bashscripts-agents-codex-skill-mirror.md](./wiki/comparisons/bashscripts-agents-codex-skill-mirror.md) | Mirror skill `.agents`/`.codex` |
| [wiki/memories/index.md](./wiki/memories/index.md) | Indice memories |
| [wiki/overviews/ai-module.md](./wiki/overviews/ai-module.md) | Overview del modulo AI |
| [wiki/rules/index.md](./wiki/rules/index.md) | Indice rules |
| [wiki/skills/index.md](./wiki/skills/index.md) | Indice skills |
| [wiki/troubleshooting/index.md](./wiki/troubleshooting/index.md) | Indice troubleshooting |
| [wiki/troubleshooting/pest-test-suite-fixes.md](./wiki/troubleshooting/pest-test-suite-fixes.md) | Fix comuni suite Pest |

Template per nuove pagine (non contenuto, solo scaffolding): [wiki/_templates/concept.md](./wiki/_templates/concept.md), [wiki/_templates/entity.md](./wiki/_templates/entity.md), [wiki/_templates/source.md](./wiki/_templates/source.md).

Le sottocartelle `wiki/decisions/`, `wiki/entities/`, `wiki/glossary/`, `wiki/how-to/`, `wiki/index/`, `wiki/lint/`, `wiki/queries/`, `wiki/reference/`, `wiki/summaries/` contengono solo `.gitkeep`: scaffold predisposto, nessun contenuto da indicizzare ancora.

## Raw sources, sources esterne e outputs

| Doc | Contenuto |
|---|---|
| [raw/README.md](./raw/README.md) | Regole dell'area raw (append-only, pre-sintesi) |
| [raw/index.md](./raw/index.md) | Cosa appartiene al layer raw |
| [raw/root-import/changelog.md](./raw/root-import/changelog.md) | Changelog importato in raw |
| [sources/README.md](./sources/README.md) | Materiale esterno importato per alimentare il wiki |
| [outputs/README.md](./outputs/README.md) | Risposte persistenti e report generati dal wiki |

Le sottocartelle `raw/articles/`, `raw/comparisons/`, `raw/concepts/`, `raw/entities/`, `raw/notes/`, `raw/overviews/`, `raw/papers/`, `raw/summaries/` contengono solo `.gitkeep`: scaffold vuoto.

## Archivio root del modulo

| Doc | Contenuto |
|---|---|
| [root-md-files/changelog.md](./root-md-files/changelog.md) | Nota di rimando: il changelog canonico e' `../../CHANGELOG.md` nella root del modulo |

## Storico / da consolidare

Questi file non sono stati toccati, ma sono duplicati, stub o snapshot superati rispetto ai documenti gia' elencati sopra. Restano al loro posto per non perdere storia; un consolidamento futuro dovrebbe farli confluire nei doc canonici indicati.

### Indici precedenti di questa stessa cartella

- [00-index.md](./00-index.md) - indice precedente centrato sui soli doc "prodotto", con link a `PRD.md`/`PRODUCT_ROADMAP.md` ecc. in maiuscolo che non corrispondono ai file reali (minuscoli). Superato da questo `index.md`.
- [INDEX.md](./INDEX.md) - puntatore molto breve, non aggiornato. Superato da questo `index.md`.

### Stub "module: theme" che rimandano a Themes/docs/shared-components

Frontmatter `module: theme` + una riga "See canonical documentation: ...". Non sono contenuto specifico del modulo AI, ma copie stub di documentazione condivisa a livello Theme. Il contenuto reale, specifico di AI, vive nell'omonimo file senza underscore elencato sopra.

- [create_an_assistant.md](./create_an_assistant.md) -> contenuto reale in [create-an-assistant.md](./create-an-assistant.md)
- [fine_tuning.md](./fine_tuning.md) -> contenuto reale in [fine-tuning.md](./fine-tuning.md)
- [google_gemini.md](./google_gemini.md) -> contenuto reale in [google-gemini.md](./google-gemini.md)
- [cursor_mcp.md](./cursor_mcp.md) -> contenuto reale in [cursor-mcp.md](./cursor-mcp.md)
- [installazione_mcp_servers.md](./installazione_mcp_servers.md) -> contenuto reale in [installazione-mcp-servers.md](./installazione-mcp-servers.md)
- [video_tutorial.md](./video_tutorial.md) -> contenuto reale in [video-tutorial.md](./video-tutorial.md)
- [tutorials/ai_agents_in_php_with_mcp.md](./tutorials/ai_agents_in_php_with_mcp.md) -> [tutorials/ai-agents-in-php-with-mcp.md](./tutorials/ai-agents-in-php-with-mcp.md)
- [tutorials/building_laravel_portfolio_api_with_mcp.md](./tutorials/building_laravel_portfolio_api_with_mcp.md) -> [tutorials/building-laravel-portfolio-api-with-mcp.md](./tutorials/building-laravel-portfolio-api-with-mcp.md)
- [tutorials/laravel_helper_tools_for_mcp.md](./tutorials/laravel_helper_tools_for_mcp.md) -> [tutorials/laravel-helper-tools-for-mcp.md](./tutorials/laravel-helper-tools-for-mcp.md)

### Cluster mcp/ triplicato

Per ogni argomento della guida MCP esistono fino a 3 copie: `mcp/NN-nome.md` (canonica, elencata sopra), `mcp/nome.md` senza numero (duplicato testuale identico, verificato con diff su `00-indice.md`/`indice.md`), e `mcp/NN_nome.md` con underscore (stub `module: theme` che rimanda a `Themes/docs/shared-components/`, contenuto non specifico di AI).

Duplicati senza numero: [mcp/indice.md](./mcp/indice.md), [mcp/introduzione.md](./mcp/introduzione.md), [mcp/installazione.md](./mcp/installazione.md), [mcp/configurazione.md](./mcp/configurazione.md), [mcp/utilizzo.md](./mcp/utilizzo.md), [mcp/integrazione-moduli.md](./mcp/integrazione-moduli.md), [mcp/implementazione-pratica.md](./mcp/implementazione-pratica.md), [mcp/troubleshooting.md](./mcp/troubleshooting.md), [mcp/best-practices.md](./mcp/best-practices.md), [mcp/api-reference.md](./mcp/api-reference.md), [mcp/sicurezza.md](./mcp/sicurezza.md), [mcp/performance.md](./mcp/performance.md), [mcp/aggiornamenti.md](./mcp/aggiornamenti.md)

Stub underscore verso Themes: [mcp/00_indice.md](./mcp/00_indice.md), [mcp/00_introduzione.md](./mcp/00_introduzione.md), [mcp/01_installazione.md](./mcp/01_installazione.md), [mcp/02_configurazione.md](./mcp/02_configurazione.md), [mcp/03_utilizzo.md](./mcp/03_utilizzo.md), [mcp/04_integrazione_moduli.md](./mcp/04_integrazione_moduli.md), [mcp/05_implementazione_pratica.md](./mcp/05_implementazione_pratica.md), [mcp/06_troubleshooting.md](./mcp/06_troubleshooting.md), [mcp/07_best_practices.md](./mcp/07_best_practices.md), [mcp/08_api_reference.md](./mcp/08_api_reference.md), [mcp/09_sicurezza.md](./mcp/09_sicurezza.md), [mcp/10_performance.md](./mcp/10_performance.md), [mcp/11_aggiornamenti.md](./mcp/11_aggiornamenti.md), [mcp/mcp_integration_overview.md](./mcp/mcp_integration_overview.md)

### Boilerplate prodotto mai popolato

Cinque file condividono lo stesso template generico (`**Module:** AI`, `**Version:** 1.0.0`, `**Owner:** Product Team`) mai riempito con contenuto reale, mentre l'omologo piu' corto elencato sopra contiene note effettive del progetto.

- [product_roadmap.md](./product_roadmap.md) -> vedi [roadmap.md](./roadmap.md)
- [product_strategy.md](./product_strategy.md) -> vedi [product-strategy.md](./product-strategy.md) e [strategy.md](./strategy.md)
- [sprint_planning.md](./sprint_planning.md) -> vedi [sprint.md](./sprint.md)
- [user_research.md](./user_research.md) -> vedi [research.md](./research.md)
- [product_launch_plan.md](./product_launch_plan.md) -> vedi [launch.md](./launch.md)

### Altri superati o ridondanti

- [structure.md](./structure.md) - versione del 2025-04-23, superata da [project-structure.md](./project-structure.md) (2026-05-11).
- [metodi_duplicati_analisi.md](./metodi_duplicati_analisi.md) - stessa analisi di [duplicate-methods-analysis.md](./duplicate-methods-analysis.md), stessa data (2025-10-15), rigenerata con formato diverso ("Super Mucca Edition").
- [phpstan-remediation-2025-12-23.md](./phpstan-remediation-2025-12-23.md) - identico byte per byte a [phpstan-remediation.md](./phpstan-remediation.md) (diff vuoto).
- [redundancy_analysis.md](./redundancy_analysis.md) - stub di una riga che rimanda a `docs/analysis/redundancies/summary.md` fuori dal modulo.
- [merge-conflict-files-list.md](./merge-conflict-files-list.md) e [merge-conflicts-list.md](./merge-conflicts-list.md) - due elenchi di file con marker di conflitto da una sessione di merge passata (vedi memoria `project_notify-conflict-remediation-2026-09-03`); presumibilmente risolti, da verificare prima di rimuovere.
- [wiki/agents.md](./wiki/agents.md) - copia del template non compilato (placeholder `{{TYPE^}}`, `YYYY-MM-DD`), superata dalla versione reale in [llm-wiki/agents.md](./llm-wiki/agents.md).
