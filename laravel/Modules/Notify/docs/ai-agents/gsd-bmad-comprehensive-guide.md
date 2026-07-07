# GSD & BMAD — Guida Completa per Agenti AI

> **Scopo**: Questa guida è la risorsa definitiva per tutti gli agenti AI che lavorano sul progetto PTVX Fila5.
> 
> **Ultimo aggiornamento**: 2026-03-18  
> **Stato**: ✅ Attivo e verificato  
> **Versione**: 2.0 (GSD v1.26.0 + BMAD v6)

---

## 📖 Indice

1. [Introduzione](#introduzione)
2. [GSD - Get Shit Done](#gsd---get-shit-done)
3. [BMAD Method](#bmad-method)
4. [Coordinamento Multi-Agente](#coordinamento-multi-agente)
5. [Installazione e Setup](#installazione-e-setup)
6. [Best Practices](#best-practices)
7. [Troubleshooting](#troubleshooting)
8. [Risorse](#risorse)

---

## Introduzione

### Perché GSD + BMAD?

Questo progetto usa **due framework complementari** per massimizzare l'efficienza degli agenti AI:

| Framework | Scopo Principale | Punto di Forza |
|-----------|------------------|----------------|
| **GSD** | Esecuzione spec-driven | Affidabilità, context engineering, atomic commits |
| **BMAD** | Design e pianificazione | Visione olistica, agenti specializzati |

### Il Problema: Context Rot

**Context Rot** = degradazione della qualità che accade quando un AI riempie il suo context window durante sessioni lunghe.

**Senza GSD/BMAD**:
```
Sessione 1: Codice eccellente ✅
Sessione 5: Codice decente ⚠️
Sessione 10: Garbage inconsistente ❌
```

**Con GSD/BMAD**:
```
Ogni task: Contesto fresco (200k token) → Qualità costante ✅
```

### Architettura del Sistema

```
┌─────────────────────────────────────────────────────────┐
│                    AI AGENT WORKFLOW                     │
├─────────────────────────────────────────────────────────┤
│                                                          │
│  BMAD (High-Level)          GSD (Execution)             │
│  ┌──────────────┐           ┌──────────────┐            │
│  │ Ideation     │  ─────→   │ Planning     │            │
│  │ Architecture │           │ Execution    │            │
│  │ Strategy     │           │ Verification │            │
│  └──────────────┘           └──────────────┘            │
│         ↓                            ↓                   │
│  Product Requirements      Atomic Tasks + Fresh Context  │
│  User Stories              Wave Execution                │
│  Architecture Design       Git Commits                   │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## GSD - Get Shit Done

### Cos'è GSD?

**GSD (Get Shit Done)** è un framework spec-driven che risolve il context rot attraverso:
- Context engineering intelligente
- Multi-agent orchestration
- XML prompting strutturato
- Wave execution parallela
- Atomic git commits

### Filosofia GSD

| Principio | Descrizione |
|-----------|-------------|
| **No enterprise theater** | Niente sprint ceremonies, story points, Jira |
| **Complexity in system** | Dietro le quinte: context engineering, orchestrazione |
| **Simple workflow** | Cosa vedi: comandi semplici che funzionano |
| **Fresh context** | Ogni task: 200k token, zero garbage accumulato |
| **Atomic commits** | Un task = un commit Git tracciabile |
| **Trust but verify** | Verifica automatica + UAT umano |

### Core Workflow GSD

```bash
# 1. Inizializza progetto
/gsd:new-project

# 2. Discuti fase (opzionale ma consigliato)
/gsd:discuss-phase 1

# 3. Pianifica fase
/gsd:plan-phase 1

# 4. Esegui fase
/gsd:execute-phase 1

# 5. Verifica lavoro
/gsd:verify-work 1

# 6. Completa milestone
/gsd:complete-milestone
```

### Comandi GSD Completi

#### Core Commands

| Comando | Scopo | Quando Usare |
|---------|-------|--------------|
| `/gsd:new-project` | Inizializza progetto | Primo setup |
| `/gsd:discuss-phase [N]` | Cattura decisioni | Prima di pianificare |
| `/gsd:plan-phase [N]` | Crea piano eseguibile | Dopo discussion |
| `/gsd:execute-phase [N]` | Esegue piani | Dopo planning |
| `/gsd:verify-work [N]` | UAT conversazionale | Dopo execution |
| `/gsd:complete-milestone` | Archivia milestone | Fine versione |
| `/gsd:new-milestone` | Avvia nuovo ciclo | Prossima versione |

#### Navigation Commands

| Comando | Scopo |
|---------|-------|
| `/gsd:progress` | Dove sono? Cosa next? |
| `/gsd:help` | Mostra tutti comandi |
| `/gsd:update` | Aggiorna GSD |

#### Phase Management

| Comando | Scopo |
|---------|-------|
| `/gsd:add-phase` | Aggiungi fase a roadmap |
| `/gsd:insert-phase [N]` | Inserisci lavoro urgente |
| `/gsd:remove-phase [N]` | Rimuovi fase futura |
| `/gsd:list-phase-assumptions [N]` | Mostra approccio previsto |
| `/gsd:plan-milestone-gaps` | Crea fasi per colmare gaps |

#### Session Management

| Comando | Scopo |
|---------|-------|
| `/gsd:pause-work` | Crea handoff (metà fase) |
| `/gsd:resume-work` | Ripristina da sessione |

#### Utilities

| Comando | Scopo |
|---------|-------|
| `/gsd:settings` | Configura workflow agents |
| `/gsd:set-profile <profile>` | Cambia model profile |
| `/gsd:add-todo [desc]` | Cattura idea per dopo |
| `/gsd:check-todos` | Lista todo pending |
| `/gsd:debug [desc]` | Debugging sistematico |
| `/gsd:quick [--full]` | Task ad-hoc veloce |
| `/gsd:map-codebase [area]` | Analizza codebase |

### Struttura File GSD

```
.planning/
├── PROJECT.md           # Visione (sempre caricata)
├── REQUIREMENTS.md      # Requisiti v1/v2
├── ROADMAP.md           # Fasi + dipendenze
├── STATE.md             # Decisioni, blocker, memoria
├── research/
│   ├── STACK.md         # Stack tecnologico
│   ├── FEATURES.md      # Feature research
│   ├── ARCHITECTURE.md  # Architettura
│   └── PITFALLS.md      # Pitfalls da evitare
├── phase-1-PLAN.md      # Task atomici XML
├── phase-1-SUMMARY.md   # Cosa è successo
└── phase-1-UAT.md       # UAT report
```

### XML Task Structure

Ogni task in GSD è strutturato XML:

```xml
<task type="auto">
  <name>Create login endpoint</name>
  <files>src/app/api/auth/login/route.ts</files>
  <action>
    Use jose for JWT (not jsonwebtoken - CommonJS issues).
    Validate credentials against users table.
    Return httpOnly cookie on success.
  </action>
  <verify>curl -X POST localhost:3000/api/auth/login returns 200 + Set-Cookie</verify>
  <done>Valid credentials return cookie, invalid return 401</done>
</task>
```

**Perché XML**:
- Strutturato e machine-readable
- Chiaro per AI e umani
- Include verify step esplicito
- Definisce "done" in modo inequivocabile

### Wave Execution

GSD esegue task in **onde parallele** quando possibile:

```
WAVE 1 (parallel)     WAVE 2 (parallel)     WAVE 3
┌─────────┐ ┌──────┐  ┌─────────┐ ┌──────┐  ┌─────────┐
│ Plan 01 │ │ Plan │→ │ Plan 03 │ │ Plan │→ │ Plan 05 │
│ User    │ │ 02   │  │ Orders  │ │ 04   │  │ Checkout│
│ Model   │ │Product│  │ API     │ │ Cart │  │ UI      │
└─────────┘ └──────┘  └─────────┘ └──────┘  └─────────┘
     │          │          ↑          ↑          ↑
     └──────────┴──────────┴──────────┘          │
        Dependencies: Plan 03 needs Plan 01      │
                    Plan 05 needs Plans 03 + 04 ─┘
```

**Vantaggi**:
- 3-5x più veloce di esecuzione sequenziale
- Mantiene dipendenze corrette
- Massimizza parallelismo

### Configuration

#### Model Profiles

```bash
/gsd:set-profile quality    # Opus planning + execution
/gsd:set-profile balanced   # Opus planning, Sonnet execution (default)
/gsd:set-profile budget     # Sonnet planning + execution
/gsd:set-profile inherit    # Segue runtime selection
```

#### Workflow Agents Settings

Modifica via `/gsd:settings`:

| Agent | Default | Descrizione |
|-------|---------|-------------|
| `workflow.research` | `true` | Research before planning |
| `workflow.plan_check` | `true` | Verify plans before exec |
| `workflow.verifier` | `true` | Confirm deliverables |
| `workflow.auto_advance` | `false` | Auto-chain phases |

#### Git Branching

```json
{
  "git": {
    "branching_strategy": "none",
    "phase_branch_template": "gsd/phase-{phase}-{slug}",
    "milestone_branch_template": "gsd/{milestone}-{slug}"
  }
}
```

### Quando Usare GSD

**✅ USA GSD**:
- Implementazione feature concrete
- Task con requisiti chiari
- Vuoi codice verificato e testato
- Vuoi atomic git commits
- Sessioni lunghe (evita context rot)

**❌ NON USARE GSD**:
- Solo ricerca esplorativa
- Brainstorming iniziale
- Enterprise ceremonies necessarie
- Vuoi controllo manuale totale

---

## BMAD Method

### Cos'è BMAD?

**BMAD (Build More Architect Dreams)** è un framework AI-driven che copre l'intero processo:
- Ideation → Planning → Implementation → Review

**Differenza vs GSD**: BMAD è più olistico, GSD è più esecutivo.

### Agent Roles BMAD

| Agente | Scopo | Quando Invocare |
|--------|-------|-----------------|
| **PM** | Product Manager | Requirements, prioritization |
| **Architect** | Technical Architect | Architecture decisions |
| **Developer** | Implementation | Code implementation |
| **UX Designer** | User Experience | UI/UX design |
| **QA** | Quality Assurance | Testing, verification |
| **Scrum Master** | Facilitator | Remove blockers |
| **Analyst** | Research | Competitive analysis |
| **Product Owner** | Vision | Strategy, backlog |

### BMAD Workflow

```
Brainstorming 
    ↓
Product Brief 
    ↓
PRD (Product Requirements Doc)
    ↓
UX Design 
    ↓
Architecture 
    ↓
Epics & Stories 
    ↓
Sprint Planning 
    ↓
Story Cycle (implementation)
```

### BMAD v6 Features

| Feature | Descrizione |
|---------|-------------|
| **Skills Architecture** | Reusable agent capabilities |
| **BMad Builder v1** | Custom extensions framework |
| **Dev Loop Automation** | Automated development cycles |
| **Context Sharding** | Gestione grandi progetti |
| **Party Mode** | Collaborative multi-agent |

### Documentazione BMAD (4 Sezioni)

| Tipo | Scopo | Esempi |
|------|-------|--------|
| **Tutorials** | Learning | "Get Started", "Install" |
| **How-To Guides** | Task-oriented | "Customize agent" |
| **Explanation** | Understanding | "Why Solutioning Matters" |
| **Reference** | Information | "Workflow Map", "Agents" |

### Quando Usare BMAD

**✅ USA BMAD**:
- Definizione vision progetto
- Architecture design alto livello
- Multiple perspectives necessarie
- Creazione PRD o strategy
- Brainstorming feature

**❌ NON USARE BMAD**:
- Task semplice e chiaro
- Requirements già definiti
- Solo esecuzione necessaria

---

## Coordinamento Multi-Agente

### Scenario Tipico

Più agenti AI ricevono lo stesso task (es. da `bashscripts/ai/gsd.txt`).

**Problema**: Rischio di lavoro duplicato, conflitti, incoerenze.

**Soluzione**: Protocollo di coordinamento GSD/BMAD.

### Protocollo di Coordinamento

#### 1. Prima di Iniziare

```bash
# 1. Leggi questo documento
cat docs/project/gsd-and-bmad-workflow.md

# 2. Verifica stato corrente
cat .planning/STATE.md

# 3. Controlla coordinamento
cat docs/project/gsd-agent-coordination.md

# 4. Pull latest
git pull origin dev
```

#### 2. Durante il Lavoro

```bash
# Aggiorna STATE.md con progress
echo "## In Progress\n\nWorking on: [task]\nAgent: [name]\nTime: $(date)" >> .planning/STATE.md

# Commit frequenti e atomici
git add .
git commit -m "feat: [description] (gsd phase N)"
git push origin dev
```

#### 3. Dopo Completamento

```bash
# Aggiorna STATE.md
echo "## Complete\n\nCompleted by: [agent]\nNext: [next step]" >> .planning/STATE.md

# Aggiorna coordinamento
cat docs/project/gsd-agent-coordination.md
# Aggiungi tua azione completata
```

### Divisione del Lavoro (Esempio)

```
Agent 1 (Researcher):
  Task: Research & Architecture
  Output: .planning/research/*.md
  ↓ commit + STATE.md update

Agent 2 (Architect):
  Task: Design architecture
  Output: Architecture decisions in STATE.md
  ↓ commit + STATE.md update

Agent 3 (Planner):
  Task: Create phase plans
  Output: phase-N-PLAN.md files
  ↓ commit + STATE.md update

Agent 4+ (Executors - paralleli):
  Task: Implement plans in waves
  Output: Code changes
  ↓ commit per task atomico

Agent N (Verifier):
  Task: Verify deliverables
  Output: phase-N-UAT.md
  ↓ commit + STATE.md update
```

### Communication via Git

**Git è il medium di comunicazione** tra agenti:

```
Commit Messages:
- "docs: predict detail research"
- "docs: predict detail architecture"
- "feat: add price chart component"
- "test: verify phase 1 complete"

STATE.md:
- Decisioni architetturali
- Blocker identificati
- Next steps chiari

SUMMARY.md:
- Cosa è successo nella fase
- Cosa è cambiato
- Lessons learned
```

### Handoff Between Agents

Quando ti fermi a metà:

```bash
/gsd:pause-work
```

Crea un handoff point con:
- Stato corrente
- Prossimi step
- Eventuali blocker

Quando riprendi:

```bash
/gsd:resume-work
```

Ripristina:
- Ultimo stato salvato
- Context necessario
- Prossima azione

### Avoiding Conflicts

**Regola d'oro**: Mai lavorare su stesso file contemporaneamente.

```bash
# PRIMA di modificare file
git pull origin dev
git diff HEAD  # Vedi cambiamenti recenti

# Se conflitto potenziale
echo "Working on: [file]" >> .planning/STATE.md

# DOPO aver modificato
git add .
git commit -m "feat: [description]"
git push origin dev
```

---

## Installazione e Setup

### Prerequisites

- ✅ Node.js 18+
- ✅ Git
- ✅ AI runtime (Claude Code, OpenCode, Cursor, Copilot)
- ✅ PHP 8.3+ (per questo progetto Laravel)

### Installazione GSD

```bash
# Interactive
npx get-shit-done-cc@latest

# Non-interactive (specific runtime)
npx get-shit-done-cc --claude --global
npx get-shit-done-cc --opencode --global
npx get-shit-done-cc --gemini --global
npx get-shit-done-cc --copilot --global

# All runtimes
npx get-shit-done-cc --all --global
```

### Verifica Installazione

```bash
# Claude Code / Gemini / Copilot
/gsd:help

# OpenCode
/gsd-help

# Codex
$gsd-help
```

### Skip Permissions Mode (Claude Code)

Aggiungi a `.claude/settings.json`:

```json
{
  "permissions": {
    "allow": [
      "Bash(date:*)",
      "Bash(git add:*)",
      "Bash(git commit:*)",
      "Bash(git status:*)"
    ]
  }
}
```

O CLI flag:
```bash
claude --dangerously-skip-permissions
```

### BMAD Setup

BMAD è già integrato in questo progetto tramite:

- `.github/agents/gsd-*.agent.md` - Agent definitions
- `.opencode/skills/bmad/SKILL.md` - BMAD skills
- `docs/project/gsd-and-bmad-workflow.md` - Workflow docs

Per usare BMAD agents:
1. Leggi agent definitions in `.github/agents/`
2. Invoca tramite comandi GSD (es. `/gsd:plan-phase` → planner agent)
3. Per custom agents, modifica `.opencode/skills/bmad/`

---

## Best Practices

### Documentation First

**MAI** scrivere codice prima di:
1. Leggere `gsd-and-bmad-workflow.md`
2. Verificare `.planning/STATE.md`
3. Capire architecture decisions
4. Avere piano chiaro

### Atomic Commits

**SEMPRE** un commit per task:

```bash
# ✅ CORRETTO
abc123f docs: complete user registration plan
def456g feat: add email confirmation flow
hij789k feat: implement password hashing

# ❌ SBAGLIATO
xyz7890 feat: added user registration, email, password, login, etc.
```

### Fresh Context

**SEMPRE** inizia task con contesto fresco:

```bash
# GSD fa questo automaticamente
# Ogni plan esegue in 200k token context

# Ma tu devi:
git pull origin dev  # Latest code
cat .planning/STATE.md  # Current state
cat docs/project/gsd-and-bmad-workflow.md  # Workflow
```

### Verification

**SEMPRE** verifica dopo execution:

```bash
/gsd:verify-work 1

# Manual verification checklist:
- [ ] Tutti i deliverables implementati
- [ ] Test passing
- [ ] PHPStan level 10: no errors
- [ ] Code formatted (Laravel Pint)
- [ ] Docs aggiornate
- [ ] Git commit + push
```

### Multi-Agent Coordination

**SEMPRE**:
1. Leggi coordination docs prima di iniziare
2. Aggiorna STATE.md con tuo progress
3. Non duplicare lavoro di altri agenti
4. Usa Git per comunicare (commit messages chiari)
5. Fai handoff pulito se ti fermi

---

## Troubleshooting

### GSD Non Risponde

```bash
# Verifica installazione
which gsd
npx get-shit-done-cc --version

# Reinstalla
npx get-shit-done-cc --claude --global --force
```

### Context Rot Still Happening

```bash
# Verifica che GSD stia usando fresh context
cat .planning/STATE.md  # Deve essere aggiornato

# Resetta context
rm -rf .planning/
/gsd:new-project  # Re-inizializza
```

### Multi-Agent Conflicts

```bash
# Se conflitto Git
git pull origin dev
git diff HEAD  # Vedi cambiamenti

# Se conflitto di lavoro
cat docs/project/gsd-agent-coordination.md
# Contatta altri agenti (via coordination doc)
```

### BMAD Agents Non Working

```bash
# Verifica agents
ls -la .github/agents/

# Verifica skills
cat .opencode/skills/bmad/SKILL.md

# Reinstalla BMAD
# (vedi docs.bmad-method.org per installazione)
```

---

## Risorse

### Documentazione Ufficiale

| Risorsa | Link |
|---------|------|
| GSD GitHub | https://github.com/gsd-build/get-shit-done |
| GSD Docs | https://gsd-build-get-shit-done.mintlify.app/ |
| BMAD GitHub | https://github.com/bmad-code-org/BMAD-METHOD |
| BMAD Docs | https://docs.bmad-method.org/ |

### Article e Guide

| Articolo | Link |
|----------|------|
| GSD Meta-Prompting | https://agentnativedev.medium.com/get-sh-t-done-meta-prompting-and-spec-driven-development-for-claude-code-and-codex-d1cde082e103 |
| GSD Beginner's Guide | https://dev.to/alikazmidev/the-complete-beginners-guide-to-gsd-get-shit-done-framework-for-claude-code-24h0 |
| BMAD Method Guide | https://medium.com/@visrow/what-is-bmad-method-a-simple-guide-to-the-future-of-ai-driven-development-412274f91419 |

### Risorse Progetto

| File | Scopo |
|------|-------|
| `docs/project/gsd-and-bmad-workflow.md` | Workflow completo |
| `docs/project/gsd-agent-coordination.md` | Coordinamento multi-agente |
| `.github/get-shit-done/` | GSD implementation |
| `.github/agents/` | Agent definitions |
| `.planning/` | GSD state files |

### Community

| Community | Link |
|-----------|------|
| GSD Discord | https://discord.gg/gsd |
| BMAD Discord | https://discord.gg/bmad |

---

## Appendice: Comandi Rapidi

### Nuovo Progetto

```bash
/gsd:map-codebase      # Se codebase esiste
/gsd:new-project       # Inizializza
/gsd:discuss-phase 1   # Discuti
/gsd:plan-phase 1      # Pianifica
/gsd:execute-phase 1   # Esegui
/gsd:verify-work 1     # Verifica
```

### Task Rapido

```bash
/gsd:quick "Add dark mode toggle"
```

### Navigazione

```bash
/gsd:progress          # Dove sono?
/gsd:help              # Tutti comandi
/gsd:settings          # Configurazione
```

### Sessione

```bash
/gsd:pause-work        # Fermati (handoff)
/gsd:resume-work       # Riprendi
```

### Debug

```bash
/gsd:debug "Feature X non funziona"
```

---

**Ultimo aggiornamento**: 2026-03-18  
**Mantenuto da**: AI Agents Team  
**Versione**: 2.0
