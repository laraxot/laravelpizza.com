---
name: bmad-on-demand-routing
description: BMAD skills/rules/commands on-demand routing using LLM Wiki
metadata:
  type: project
---

# BMAD On-Demand Routing

## Integrazione BMAD v6 con Second Brain

BMAD Method v6 è ora integrato con il sistema LLM Wiki on-demand invece che pre-caricato.

## Struttura BMAD Installata

```
/home/zorin/.claude/skills/bmad/           → Skills BMAD
/home/zorin/.claude/commands/bmad/         → Commands BMAD  
/home/zorin/.claude/config/bmad/           → Config BMAD
```

## On-Demand Routing

BMAD non viene caricato all'avvio ma richiesto tramite trigger map:

```yaml
# docs/wiki/rules/00-TRIGGER_MAP.md
- pattern: "BMAD|bmad|workflow|agile|sprint|architecture"
  trigger: "bmad-on-demand"
  route: "docs/wiki/skills/bmad-on-demand-routing.md"
  priority: 80
```

## Macro-BMAD Integration Pattern

```yaml
# docs/wiki/skills/bmad-on-demand-routing.md
---
name: bmad-on-demand-routing
description: On-demand BMAD skills/rules/commands routing
---

# BMAD On-Demand Routing

## Trigger Phrases
- "bmad workflow"
- "bmad sprint planning"
- "bmad architecture"
- "bmad agile"
- "bmad product brief"
- "bmad solutioning"
- "bmad dev story"

## Routing Actions
1. **Search**: Esegui `qmd search "BMAD <topic>"`
2. **Load**: Carica skill specifiche da trigger map
3. **Route**: Manda a BMAD command appropriato
4. **Execute**: Esegui BMAD skill con second brain context

## Integration Rules
- Usa wrapper `bashscripts/docs/llm-wiki-qmd.sh` per BMAD
- Carica solo skills rilevanti per il task
- Mantieni context window ottimizzato
- Usa GitHub Discussions per cross-agent coordination
```

## Comandi BMAD Disponibili

```bash
# Workflow Management
/workflow-init          # Inizializza BMAD nel progetto
/workflow-status         # Status BMAD progetto

# Product Management  
/product-brief          # Product Brief
/prd                    # Product Requirements Document
/tech-spec              # Technical Specifications

# Architecture
/architecture           # Architecture Design
/solutioning-gate-check # Solutioning Gate Check

# Sprint Planning
/sprint-planning        # Sprint Planning
/create-story           # Create User Story
/dev-story              # Developer Story

# Research & Innovation
/brainstorm             # Brainstorming
/research               # Research

# Agent Creation
/create-agent           # Create Custom Agent
/create-workflow        # Create Custom Workflow  
/create-ux-design       # Create UX Design
```

## BMAD + QMD Integration

```bash
# Wrapper per BMAD con QMD
bashscripts/docs/llm-wiki-qmd.sh search "BMAD workflow"

# Cerca skills BMAD specifiche
qmd search "bmad business analyst"
qmd search "bmad system architect"
qmd search "bmad scrum master"

# Carica BMAD rule trigger
qmd search "BMAD rules"
```

## Inter-Agent Coordination

Usa GitHub Discussions per coordinare tra agenti AI:

```markdown
# Template Discussion
**Agent**: [Nome agente]
**Model**: [Modello utilizzato] 
**Task**: [Descrizione task]
**Branch**: [Branch di lavoro]

## Context
[Relevant context from second brain]

## Task Progress
[What I'm working on]

## Blocking Issues  
[Problemi/blockers]

## Request for Help
[What other agents can help with]
```

## Persistent Memory

BMAD integration è salvata in memoria per session future:

```yaml
# MEMORY.md
- [BMAD On-Demand Routing](project_bmad_on_demand_routing.md) — BMAD v6 integrato con LLM Wiki on-demand, trigger map routing, GitHub discussions coordination
```