# BMAD Method Integration — V6.2.0

## Overview

Questo progetto usa **BMAD Method V6** (Build More Architect Dreams) — un framework di sviluppo AI-driven con agenti specializzati, workflow guidati e pianificazione intelligente che si adatta alla complessità del progetto.

**100% free and open source. No paywalls. No gated content.**

### Risorse

- **Repo**: [github.com/bmad-code-org/BMAD-METHOD](https://github.com/bmad-code-org/BMAD-METHOD)
- **Docs**: [docs.bmad-method.org](https://docs.bmad-method.org)
- **Workflow Map**: [docs.bmad-method.org/reference/workflow-map/](https://docs.bmad-method.org/reference/workflow-map/)
- **Discord**: [discord.gg/gk8jAdXWmj](https://discord.gg/gk8jAdXWmj)
- **YouTube**: [youtube.com/@BMadCode](https://www.youtube.com/@BMadCode)

---

## Installazione Attuale

Due layer complementari:

| Layer | Versione | Percorso | Uso |
|-------|----------|----------|-----|
| BMAD-METHOD ufficiale | 6.2.0 | `_bmad/`, `_bmad-output/` | Workflow completi, `bmad-help`, artefatti planning |
| Claude Code native (aj-geddes) | 6.0.2 | `.claude/skills/bmad/`, `.claude/commands/bmad/` | Slash command e skill in sessione Claude/Cursor |

Reinstallazione layer Claude (progetto, **stub on-demand**):

```bash
bashscripts/tools/install-bmad-v6-project.sh
```

- Stub: `.claude/skills/bmad/*/SKILL.md` (router wiki, non corpo completo)
- Full skill: `bmad-skills/bmad-v6/skills/` (caricare solo se serve)
- Router second brain: `docs/wiki/skills/bmad-on-demand-routing.md`

Fonte vendored: `bmad-skills/` ([aj-geddes/claude-code-bmad-skills](https://github.com/aj-geddes/claude-code-bmad-skills)).

Config progetto: `bmad/config.yaml`, contesto in `bmad/context/`, output agenti in `bmad/outputs/`.

### Struttura Directory

```
_bmad/                          # Configurazione BMAD
├── _config/
│   ├── manifest.yaml           # Versione e moduli installati
│   ├── bmad-help.csv           # Catalogo completo workflow (42 entry)
│   ├── agent-manifest.csv      # Manifesto agenti
│   ├── skill-manifest.csv      # Manifesto skill
│   ├── agents/                 # Configurazione personalizzata agenti
│   └── ides/
│       └── claude-code.yaml    # Config IDE
├── _memory/
│   ├── config.yaml             # Preferenze utente
│   └── tech-writer-sidecar/    # Memoria tech writer
├── bmm/                        # Modulo BMad Method
│   ├── agents/                 # 9 agenti specializzati
│   ├── workflows/              # 8 categorie di workflow (243 file)
│   ├── teams/                  # Team configurations
│   └── data/                   # Template e dati
└── core/                       # Modulo Core
    ├── skills/                 # Skill condivise
    └── tasks/                  # Task riutilizzabili

_bmad-output/                   # Artefatti generati
├── project-context.md          # Regole implementazione per AI (Laraxot)
├── planning-artifacts/         # PRD, architecture, epics, stories
└── implementation-artifacts/   # Sprint status, story files
```

---

## Le 4 Fasi BMAD

### Phase 1: Analysis (Opzionale)

Esplora il problem space prima di pianificare.

| Workflow | Comando | Agente | Output |
|----------|---------|--------|--------|
| Brainstorming | `bmad-brainstorming` | Mary (Analyst) | brainstorming-report.md |
| Market Research | `bmad-market-research` | Mary (Analyst) | research docs |
| Domain Research | `bmad-domain-research` | Mary (Analyst) | research docs |
| Technical Research | `bmad-technical-research` | Mary (Analyst) | research docs |
| Create Brief | `bmad-create-product-brief` | Mary (Analyst) | product-brief.md |

### Phase 2: Planning (Required)

Definisci COSA costruire e per CHI.

| Workflow | Comando | Agente | Output |
|----------|---------|--------|--------|
| **Create PRD** | `bmad-create-prd` | John (PM) | PRD.md |
| Validate PRD | `bmad-validate-prd` | John (PM) | validation report |
| Edit PRD | `bmad-edit-prd` | John (PM) | updated PRD |
| Create UX | `bmad-create-ux-design` | Sally (UX) | ux-spec.md |

### Phase 3: Solutioning (Required per BMad Method/Enterprise)

Decidi COME costruirlo e dividi il lavoro in stories.

| Workflow | Comando | Agente | Output |
|----------|---------|--------|--------|
| **Create Architecture** | `bmad-create-architecture` | Winston (Architect) | architecture.md |
| **Create Epics & Stories** | `bmad-create-epics-and-stories` | John (PM) | epics/ |
| **Check Readiness** | `bmad-check-implementation-readiness` | Winston (Architect) | readiness report |

### Phase 4: Implementation

Costruisci, una story alla volta.

| Workflow | Comando | Agente | Output |
|----------|---------|--------|--------|
| **Sprint Planning** | `bmad-sprint-planning` | Bob (SM) | sprint-status.yaml |
| Sprint Status | `bmad-sprint-status` | Bob (SM) | status summary |
| **Create Story** | `bmad-create-story` | Bob (SM) | story-{slug}.md |
| Validate Story | `bmad-create-story` (validate) | Bob (SM) | validation |
| **Dev Story** | `bmad-dev-story` | Amelia (Dev) | implementation |
| QA Tests | `bmad-qa-generate-e2e-tests` | Quinn (QA) | test suite |
| Code Review | `bmad-code-review` | Amelia (Dev) | review |
| Retrospective | `bmad-retrospective` | Bob (SM) | retrospective |
| Correct Course | `bmad-correct-course` | Bob (SM) | change proposal |

---

## Quick Flow (Track Parallelo)

Per task piccoli e ben compresi — salta le fasi 1-3:

| Workflow | Comando | Descrizione |
|----------|---------|-------------|
| Quick Spec | `bmad-quick-spec` | Crea tech spec veloce |
| Quick Dev | `bmad-quick-dev` | Spec + implementazione |
| Quick Dev New | `bmad-quick-dev-new-preview` | Workflow unificato (sperimentale) |

---

## Agenti Specializzati (9)

| Agente | Nome | Ruolo | Comando Diretto |
|--------|------|-------|-----------------|
| 📊 Analyst | Mary | Market/domain/technical research | `bmad-analyst` |
| 📋 PM | John | PRD, requisiti, stakeholder | `bmad-pm` |
| 🎨 UX Designer | Sally | User research, interaction design | `bmad-ux-designer` |
| 🏗️ Architect | Winston | Architecture, tech decisions | `bmad-architect` |
| 💻 Developer | Amelia | Story execution, TDD, code | `bmad-dev` |
| 🧪 QA | Quinn | Test automation, E2E | `bmad-qa` |
| 🏃 Scrum Master | Bob | Sprint planning, ceremonies | `bmad-sm` |
| 📚 Tech Writer | Paige | Documentation, diagrams | `bmad-tech-writer` |
| 🚀 Quick Flow | Barry | Rapid spec + implementation | `bmad-quick-flow-solo-dev` |

---

## Utility Workflows (Anytime)

| Workflow | Comando | Descrizione |
|----------|---------|-------------|
| **bmad-help** | `bmad-help` | Guida intelligente — cosa fare dopo |
| Document Project | `bmad-document-project` | Analizza progetto esistente |
| Generate Context | `bmad-generate-project-context` | Genera project-context.md |
| Party Mode | `bmad-party-mode` | Multi-agent discussion |
| Index Docs | `bmad-index-docs` | Crea indice docs per LLM |
| Shard Document | `bmad-shard-doc` | Splitta documenti grandi |
| Editorial Prose | `bmad-editorial-review-prose` | Review prosa |
| Editorial Structure | `bmad-editorial-review-structure` | Review struttura |
| Adversarial Review | `bmad-review-adversarial-general` | Review critico |
| Edge Case Hunter | `bmad-review-edge-case-hunter` | Trova edge case |
| Distillator | `bmad-distillator` | Compressione lossless per LLM |

---

## Context Management

Ogni documento diventa contesto per la fase successiva:

```
product-brief.md → PRD.md → architecture.md → epics/ → story-*.md → implementation
                                    ↓
                          project-context.md (regole implementazione)
```

Il file `_bmad-output/project-context.md` è la "costituzione" del progetto — guida le decisioni di implementazione in tutti i workflow.

---

## Planning Tracks

BMAD offre tre track basati sulla complessità:

| Track | Quando | Fasi | Esempio |
|-------|--------|------|---------|
| **Quick Flow** | Bug fix, small tasks | Skip 1-3, usa `bmad-quick-dev` | Fix PHPStan errors |
| **BMad Method** | Feature medie | 2+3+4 (skip analysis) | Nuovo Filament resource |
| **Enterprise** | Moduli completi | Tutte 4 le fasi | Nuovo modulo HR |

---

## Regole Importanti

1. **Sempre fresh chat** per ogni workflow — previene problemi di context
2. **`bmad-help` first** — se non sai cosa fare, chiedi
3. **PRD prima di architecture** — non progettare senza requisiti
4. **Architecture prima di stories** — V6 miglioramento: stories più informate
5. **`project-context.md`** — essenziale per brownfield come Laraxot
6. **Build cycle**: `create-story → dev-story → code-review → next story`

---

## Integrazione con GSD

BMAD e GSD coesistono in questo progetto:

| Scenario | Framework |
|----------|-----------|
| Feature singola, refactoring, bug fix | **GSD** (spec-driven, context engineering) |
| Nuovo modulo completo | **BMAD** (agents, structured workflows) |
| Architettura, stakeholder alignment | **BMAD** (architect + PM agents) |
| Sprint planning, epics, stories | **BMAD** (SM + PM agents) |
| Quick ad-hoc task | **GSD quick** o **BMAD quick-dev** |
| Brainstorming, research | **BMAD** (analyst agent) |
| Code review strutturato | **BMAD** (adversarial + edge case review) |

---

## Aggiornamento

```bash
# Aggiorna BMAD all'ultima versione
npx bmad-method install

# Per prerelease
npx bmad-method@next install
```

---

## Collegamenti

- [AGENTS.md](../../AGENTS.md)
- [GSD Methodology](./gsd-methodology.md)
- [Laraxot Methodology](./laraxot-methodology.md)
- [Project Context](_bmad-output/project-context.md)
- [Workflow Map (online)](https://docs.bmad-method.org/reference/workflow-map/)
