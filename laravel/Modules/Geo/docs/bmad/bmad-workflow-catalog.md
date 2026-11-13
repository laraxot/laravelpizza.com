# BMAD Workflow Catalog — PTVX Edition

> **Versione**: 6.2.0 | **Progetto**: Laraxot PTVX  
> **Ultimo aggiornamento**: 2026-03-31  
> **Totale Workflow**: 42 (243 file)

---

## 📑 Indice

- [Phase 1: Analysis](#phase-1-analysis)
- [Phase 2: Planning](#phase-2-planning)
- [Phase 3: Solutioning](#phase-3-solutioning)
- [Phase 4: Implementation](#phase-4-implementation)
- [Utility Workflows (Anytime)](#utility-workflows-anytime)
- [Quick Flow](#quick-flow)
- [Core Skills](#core-skills)

---

## Phase 1: Analysis

Esplora il problem space prima di pianificare.

| Code | Workflow | Skill | Agente | Output | PTVX Use Case |
|------|----------|-------|--------|--------|---------------|
| **BP** | [Brainstorming](#brainstorming) | `bmad-brainstorming` | Mary 📊 | `brainstorming-report.md` | Ideazione nuove feature |
| **MR** | [Market Research](#market-research) | `bmad-market-research` | Mary 📊 | `research/` | Analisi competitor HR tech |
| **DR** | [Domain Research](#domain-research) | `bmad-domain-research` | Mary 📊 | `research/` | Studio dominio HR/Performance |
| **TR** | [Technical Research](#technical-research) | `bmad-technical-research` | Mary 📊 | `research/` | Fattibilità tecnica |
| **CB** | [Create Brief](#create-brief) | `bmad-create-product-brief` | Mary 📊 | `product-brief.md` | Definizione idea prodotto |

---

## Phase 2: Planning

Definisci COSA costruire e per CHI.

| Code | Workflow | Skill | Agente | Output | PTVX Use Case |
|------|----------|-------|--------|--------|---------------|
| **CP** | [Create PRD](#create-prd) | `bmad-create-prd` | John 📋 | `PRD.md` | **NUOVI MODULI** |
| **VP** | [Validate PRD](#validate-prd) | `bmad-validate-prd` | John 📋 | `validation-report.md` | Quality gate PRD |
| **EP** | [Edit PRD](#edit-prd) | `bmad-edit-prd` | John 📋 | `PRD.md` | Aggiornamento PRD |
| **CU** | [Create UX](#create-ux) | `bmad-create-ux-design` | Sally 🎨 | `ux-spec.md` | UI Filament, dashboard |

---

## Phase 3: Solutioning

Decidi COME costruirlo e dividi il lavoro.

| Code | Workflow | Skill | Agente | Output | PTVX Use Case |
|------|----------|-------|--------|--------|---------------|
| **CA** | [Create Architecture](#create-architecture) | `bmad-create-architecture` | Winston 🏗️ | `architecture.md` | **DB schema, API** |
| **CE** | [Create Epics & Stories](#create-epics-and-stories) | `bmad-create-epics-and-stories` | John 📋 | `epics/` | Scomposizione lavoro |
| **IR** | [Check Readiness](#check-implementation-readiness) | `bmad-check-implementation-readiness` | Winston 🏗️ | `readiness-report.md` | **Quality gate** |

---

## Phase 4: Implementation

Costruisci, una story alla volta.

| Code | Workflow | Skill | Agente | Output | PTVX Use Case |
|------|----------|-------|--------|--------|---------------|
| **SP** | [Sprint Planning](#sprint-planning) | `bmad-sprint-planning` | Bob 🏃 | `sprint-status.yaml` | **Kickoff sprint** |
| **SS** | [Sprint Status](#sprint-status) | `bmad-sprint-status` | Bob 🏃 | `status-summary` | Check progresso |
| **CS** | [Create Story](#create-story) | `bmad-create-story` | Bob 🏃 | `story-*.md` | **Story cycle start** |
| **VS** | [Validate Story](#validate-story) | `bmad-create-story` (validate) | Bob 🏃 | `validation.md` | Story readiness |
| **DS** | [Dev Story](#dev-story) | `bmad-dev-story` | Amelia 💻 | `implementation/` | **Story execution** |
| **QA** | [QA Automation](#qa-automation) | `bmad-qa-generate-e2e-tests` | Quinn 🧪 | `tests/` | Test E2E |
| **CR** | [Code Review](#code-review) | `bmad-code-review` | Amelia 💻 | `review-report.md` | **Quality gate** |
| **ER** | [Retrospective](#retrospective) | `bmad-retrospective` | Bob 🏃 | `retrospective.md` | Fine epic |
| **CC** | [Correct Course](#correct-course) | `bmad-correct-course` | Bob 🏃 | `change-proposal.md` | Cambio direzione |

---

## Utility Workflows (Anytime)

Disponibili in qualsiasi fase.

| Code | Workflow | Skill | Agente | Output | PTVX Use Case |
|------|----------|-------|--------|--------|---------------|
| **BH** | [bmad-help](#bmad-help) | `bmad-help` | — | `guidance` | **"Cosa faccio?"** |
| **DP** | [Document Project](#document-project) | `bmad-document-project` | Mary 📊 | `project-knowledge/` | Documenta codebase |
| **GPC** | [Generate Project Context](#generate-project-context) | `bmad-generate-project-context` | Mary 📊 | `project-context.md` | Regole per AI |
| **ID** | [Index Docs](#index-docs) | `bmad-index-docs` | — | `index.md` | Indice docs per LLM |
| **SD** | [Shard Document](#shard-document) | `bmad-shard-doc` | — | `sharded/` | Splitta docs grandi |
| **EP** | [Editorial Prose](#editorial-review-prose) | `bmad-editorial-review-prose` | — | `report.md` | Review prosa |
| **ES** | [Editorial Structure](#editorial-review-structure) | `bmad-editorial-review-structure` | — | `report.md` | Review struttura |
| **AR** | [Adversarial Review](#adversarial-review) | `bmad-review-adversarial-general` | — | `findings.md` | Review critico |
| **ECH** | [Edge Case Hunter](#edge-case-hunter) | `bmad-review-edge-case-hunter` | — | `edge-cases.md` | Trova edge case |
| **DG** | [Distillator](#distillator) | `bmad-distillator` | — | `distillate.md` | Compressione LLM |
| **PM** | [Party Mode](#party-mode) | `bmad-party-mode` | Facilitator | `discussion.md` | Multi-agent |

---

## Quick Flow

Per task piccoli e ben compresi.

| Code | Workflow | Skill | Agente | Output | PTVX Use Case |
|------|----------|-------|--------|--------|---------------|
| **QS** | [Quick Spec](#quick-spec) | `bmad-quick-spec` | Barry 🚀 | `tech-spec.md` | Spec veloce |
| **QD** | [Quick Dev](#quick-dev) | `bmad-quick-dev` | Barry 🚀 | `implementation/` | **Task rapidi** |
| **QQ** | [Quick Dev New](#quick-dev-new-preview) | `bmad-quick-dev-new-preview` | Barry 🚀 | `implementation/` | Workflow unificato |

---

## Core Skills

Skill trasversali del modulo Core.

| Code | Workflow | Skill | Agente | Output | PTVX Use Case |
|------|----------|-------|--------|--------|---------------|
| **BSP** | [Brainstorming](#brainstorming-core) | `bmad-brainstorming` | Mary 📊 | `brainstorming.md` | Ideazione |
| **PM** | [Party Mode](#party-mode-core) | `bmad-party-mode` | Facilitator | `discussion.md` | Multi-agent |
| **BH** | [bmad-help](#bmad-help-core) | `bmad-help` | — | `guidance` | Guida |

---

## 📖 Dettagli Workflow

### Phase 1: Analysis

#### Brainstorming

**Comando**: `bmad-brainstorming`  
**Agente**: Mary (Analyst) 📊  
**Output**: `planning-artifacts/brainstorming-report.md`  
**Quando**: Ideazione iniziale, feature complesse, problemi aperti

**Tecniche**:
- SCAMPER
- Six Thinking Hats
- Mind Mapping
- Reverse Brainstorming

---

#### Market Research

**Comando**: `bmad-market-research`  
**Agente**: Mary (Analyst) 📊  
**Output**: `research/market-analysis.md`  
**Quando**: Nuovi prodotti, analisi competitor, positioning

**Include**:
- Analisi competitor
- Trend di mercato
- Customer needs
- Market sizing

---

#### Domain Research

**Comando**: `bmad-domain-research`  
**Agente**: Mary (Analyst) 📊  
**Output**: `research/domain-knowledge.md`  
**Quando**: Nuovi domini business, terminologia specialistica

**Include**:
- Subject matter expertise
- Business processes
- Industry standards
- Regulatory requirements

---

#### Technical Research

**Comando**: `bmad-technical-research`  
**Agente**: Mary (Analyst) 📊  
**Output**: `research/technical-feasibility.md`  
**Quando**: Valutazione stack, architettura, fattibilità

**Include**:
- Technology options
- Implementation approaches
- Risk assessment
- Proof of concept

---

#### Create Brief

**Comando**: `bmad-create-product-brief`  
**Agente**: Mary (Analyst) 📊  
**Output**: `planning-artifacts/product-brief.md`  
**Quando**: Definizione core idea, allineamento stakeholder

**Include**:
- Problem statement
- Target users
- Value proposition
- Success metrics

---

### Phase 2: Planning

#### Create PRD

**Comando**: `bmad-create-prd`  
**Agente**: John (PM) 📋  
**Output**: `planning-artifacts/PRD.md`  
**Quando**: **NUOVI MODULI**, feature complesse

**Struttura PRD**:
1. Executive Summary
2. Target Personas
3. Functional Requirements (P0/P1/P2)
4. Service Interface (Contract)
5. System Architecture
6. Non-Functional Requirements
7. Release Criteria

**PTVX Standard**: Lean PRD 2025-2026

---

#### Validate PRD

**Comando**: `bmad-validate-prd`  
**Agente**: John (PM) 📋  
**Output**: `planning-artifacts/prd-validation.md`  
**Quando**: Quality gate prima di architecture

**Criteri**:
- Completezza requisiti
- Chiarezza problem statement
- KPI misurabili
- Lean e ben organizzato

---

#### Edit PRD

**Comando**: `bmad-edit-prd`  
**Agente**: John (PM) 📋  
**Output**: `planning-artifacts/PRD.md` (updated)  
**Quando**: Aggiornamento PRD esistente

---

#### Create UX

**Comando**: `bmad-create-ux-design`  
**Agente**: Sally (UX Designer) 🎨  
**Output**: `planning-artifacts/ux-spec.md`  
**Quando**: UI Filament, dashboard, user flows

**Include**:
- User research
- Interaction design
- Wireframes
- Accessibility patterns

---

### Phase 3: Solutioning

#### Create Architecture

**Comando**: `bmad-create-architecture`  
**Agente**: Winston (Architect) 🏗️  
**Output**: `planning-artifacts/architecture.md`  
**Quando**: **NUOVI MODULI**, decisioni tecniche importanti

**Struttura**:
1. Architecture Decisions
2. System Context
3. Structure (modules, layers)
4. Patterns & Principles
5. Data Schema
6. Interfaces (API, Events)
7. Quality Attributes

**PTVX**: Modular Monolith + Laraxot

---

#### Create Epics & Stories

**Comando**: `bmad-create-epics-and-stories`  
**Agente**: John (PM) 📋  
**Output**: `planning-artifacts/epics/*.md`  
**Quando**: Scomposizione lavoro dopo architecture

**Output**:
- Epics (macro obiettivi)
- Stories (task atomici)
- Dependencies
- Acceptance criteria

---

#### Check Implementation Readiness

**Comando**: `bmad-check-implementation-readiness`  
**Agente**: Winston (Architect) 🏗️  
**Output**: `planning-artifacts/readiness-report.md`  
**Quando**: **QUALITY GATE** prima di iniziare sprint

**Verifiche**:
- ✅ PRD → UX allineati
- ✅ UX → Architecture coerenti
- ✅ Architecture → Epics copertura
- ✅ Epics → Stories complete

---

### Phase 4: Implementation

#### Sprint Planning

**Comando**: `bmad-sprint-planning`  
**Agente**: Bob (Scrum Master) 🏃  
**Output**: `implementation-artifacts/sprint-status.yaml`  
**Quando**: **KICKOFF** fase implementation

**Include**:
- Sprint goal
- Stories sequenziate
- Dependencies
- Risk assessment

---

#### Sprint Status

**Comando**: `bmad-sprint-status`  
**Agente**: Bob (Scrum Master) 🏃  
**Output**: Status summary  
**Quando**: Check progresso, anytime

---

#### Create Story

**Comando**: `bmad-create-story`  
**Agente**: Bob (Scrum Master) 🏃  
**Output**: `implementation-artifacts/story-XXX.md`  
**Quando**: **STORY CYCLE START**

**Template Story**:
```markdown
# Story XXX: Title

## Context
- Epic: Epic-001
- Sprint: Sprint-1
- Goal: ...

## Requirements
- From PRD: ...
- From Architecture: ...

## Acceptance Criteria
- [ ] ...

## Technical Notes
- ...
```

---

#### Validate Story

**Comando**: `bmad-create-story` (validate mode)  
**Agente**: Bob (Scrum Master) 🏃  
**Output**: `story-validation.md`  
**Quando**: Prima di `dev-story`

---

#### Dev Story

**Comando**: `bmad-dev-story`  
**Agente**: Amelia (Developer) 💻  
**Output**: `implementation/`  
**Quando**: **STORY EXECUTION**

**Story Cycle**:
1. Read story context
2. Plan implementation
3. Write tests (TDD)
4. Implement code
5. Quality checks (PHPStan, Pest)
6. Self-review
7. Mark complete

**PTVX Standards**:
- PHPStan Level 10
- Pest v4 tests
- Laravel Pint
- Forward-only Git

---

#### QA Automation

**Comando**: `bmad-qa-generate-e2e-tests`  
**Agente**: Quinn (QA Engineer) 🧪  
**Output**: `tests/Feature/`  
**Quando**: Dopo implementazione

**Include**:
- E2E tests (Playwright)
- API tests
- Integration tests

---

#### Code Review

**Comando**: `bmad-code-review`  
**Agente**: Amelia (Developer) 💻  
**Output**: `code-review-report.md`  
**Quando**: **QUALITY GATE** post-implementazione

**Review Layers**:
1. Blind Hunter (bugs nascosti)
2. Edge Case Hunter (boundary conditions)
3. Acceptance Auditor (criteria verification)

**Triage**:
- 🔴 Blocker
- 🟠 Critical
- 🟡 Minor
- 🟢 Suggestion

---

#### Retrospective

**Comando**: `bmad-retrospective`  
**Agente**: Bob (Scrum Master) 🏃  
**Output**: `retrospective.md`  
**Quando**: Fine epic

**Include**:
- What went well
- What to improve
- Action items
- Lessons learned

---

#### Correct Course

**Comando**: `bmad-correct-course`  
**Agente**: Bob (Scrum Master) 🏃  
**Output**: `change-proposal.md`  
**Quando**: Cambio direzione significativo

**Recommendations**:
- Start over (update PRD)
- Redo architecture
- Update epics & stories
- Sprint replanning

---

### Utility Workflows

#### bmad-help

**Comando**: `bmad-help`  
**Agente**: Facilitator  
**Output**: Guidance  
**Quando**: **"Cosa devo fare dopo?"**

**Features**:
- Analizza stato progetto
- Suggerisce prossimo workflow
- Risponde domande su BMAD

---

#### Document Project

**Comando**: `bmad-document-project`  
**Agente**: Mary (Analyst) 📊  
**Output**: `project-knowledge/`  
**Quando**: Documenta codebase esistente

**Workflows**:
- Full Scan (panoramica)
- Deep Dive (focus area)

---

#### Generate Project Context

**Comando**: `bmad-generate-project-context`  
**Agente**: Mary (Analyst) 📊  
**Output**: `project-context.md`  
**Quando**: **ESSENZIALE** per brownfield

**Include**:
- Stack tecnologico
- Architecture patterns
- Critical implementation rules
- Coding standards

**PTVX**: `_bmad-output/project-context.md`

---

#### Index Docs

**Comando**: `bmad-index-docs`  
**Agente**: —  
**Output**: `index.md`  
**Quando**: LLM deve capire docs senza caricare tutto

---

#### Shard Document

**Comando**: `bmad-shard-doc`  
**Agente**: —  
**Output**: `sharded/*.md`  
**Quando**: Documento > 500 righe

---

#### Editorial Review - Prose

**Comando**: `bmad-editorial-review-prose`  
**Agente**: —  
**Output**: `report.md`  
**Quando**: Review prosa documenti

---

#### Editorial Review - Structure

**Comando**: `bmad-editorial-review-structure`  
**Agente**: —  
**Output**: `report.md`  
**Quando**: Review struttura documenti

---

#### Adversarial Review

**Comando**: `bmad-review-adversarial-general`  
**Agente**: —  
**Output**: `findings.md`  
**Quando**: Review critico prima di finalizzare

---

#### Edge Case Hunter

**Comando**: `bmad-review-edge-case-hunter`  
**Agente**: —  
**Output**: `edge-cases.md`  
**Quando**: Trova edge case non gestiti

**Ortogonale** a adversarial review — method-driven, non attitude-driven

---

#### Distillator

**Comando**: `bmad-distillator`  
**Agente**: —  
**Output**: `distillate.md`  
**Quando**: Compressione lossless per LLM

**Use case**: Documenti grandi → token-efficient

---

#### Party Mode

**Comando**: `bmad-party-mode`  
**Agente**: Facilitator  
**Output**: `discussion.md`  
**Quando**: Multi-agent collaboration

**Include**: Tutti gli agenti installati

---

### Quick Flow

#### Quick Spec

**Comando**: `bmad-quick-spec`  
**Agente**: Barry (Quick Flow) 🚀  
**Output**: `tech-spec.md`  
**Quando**: Spec veloce per task piccoli

**Steps**:
1. Understand
2. Investigate
3. Generate
4. Review

---

#### Quick Dev

**Comando**: `bmad-quick-dev`  
**Agente**: Barry (Quick Flow) 🚀  
**Output**: `implementation/`  
**Quando**: **TASK RAPIDI** (< 2 ore)

**Steps**:
1. Mode Detection
2. Context Gathering
3. Execute
4. Self Check
5. Adversarial Review
6. Resolve Findings

---

#### Quick Dev New Preview

**Comando**: `bmad-quick-dev-new-preview`  
**Agente**: Barry (Quick Flow) 🚀  
**Output**: `implementation/`  
**Quando**: Workflow unificato (sperimentale)

**Steps**:
1. Clarify & Route
2. Plan
3. Implement
4. Review
5. Present

---

## 🎯 PTVX Use Cases

### Nuovo Modulo (es. "Activity")

```bash
# Phase 1 (opzionale)
bmad-domain-research      # HR domain
bmad-technical-research   # Laravel + Filament

# Phase 2
bmad-create-prd           # PRD modulo Activity

# Phase 3
bmad-create-architecture  # DB schema, API
bmad-create-epics-and-stories  # 5 epics, 20 stories
bmad-check-implementation-readiness  # Quality gate

# Phase 4
bmad-sprint-planning      # Sprint 1
bmad-create-story story-001
bmad-dev-story story-001
bmad-code-review
# ... ripeti
```

---

### Fix PHPStan Errors

```bash
# Quick Flow
bmad-quick-dev "Fix PHPStan level 10 errors in Modules/Xot"
```

---

### Refactoring Filament Resource

```bash
# GSD (consigliato)
gsd quick "Refactor PtvResource form"

# Oppure BMAD
bmad-quick-dev "Refactor PtvResource form"
```

---

### Documentazione Codebase

```bash
bmad-document-project     # Analizza codebase
bmad-generate-project-context  # Genera regole AI
```

---

## 🔗 Link Utili

- [Quick Start Guide](./bmad-quickstart-guide.md)
- [BMAD Method Integration](./bmad-method-integration.md)
- [Project Context](../../_bmad-output/project-context.md)
- [Official Docs](https://docs.bmad-method.org)
- [Workflow Map](https://docs.bmad-method.org/reference/workflow-map/)

---

**Ultimo aggiornamento**: 2026-03-31  
**Mantenuto da**: AI Agent Team  
**Feedback**: GitHub Issues o `bmad-help`
