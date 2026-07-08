# GSD (Get Shit Done) - Metodologia Spec-Driven per AI Agents

## Cos'è GSD

GSD è un sistema leggero e potente di **meta-prompting**, **context engineering** e **sviluppo spec-driven** per AI code assistants. Risolve il problema del **context rot** — il degrado qualitativo che avviene quando il contesto dell'AI si riempie.

### Principi Chiave

1. **Context Engineering** — Ogni task riceve un contesto fresco e ottimale
2. **XML Prompt Formatting** — Piani strutturati in XML per massima precisione
3. **Multi-Agent Orchestration** — Orchestratore leggero che spawna agenti specializzati
4. **Atomic Git Commits** — Ogni task = un commit tracciabile
5. **Modular by Design** — Fasi aggiungibili, inseribili, rimovibili senza ricostruire tutto

### Fonti

- [GitHub: gsd-build/get-shit-done](https://github.com/gsd-build/get-shit-done)
- [Documentazione ufficiale Mintlify](https://gsd-build-get-shit-done.mintlify.app/)
- [OpenCode Port: rokicool/gsd-opencode](https://github.com/rokicool/gsd-opencode)
- [Antigravity Port: toonight/get-shit-done-for-antigravity](https://github.com/toonight/get-shit-done-for-antigravity)

---

## Workflow GSD (6 Step)

```
New Project → Discuss Phase → Plan Phase → Execute Phase → Verify Work → Complete Milestone
```

### Step 1: Initialize Project (`/gsd:new-project`)

Il sistema:
1. **Intervista** — Pone domande fino a comprendere completamente l'idea
2. **Ricerca** — Spawna agenti paralleli per investigare il dominio
3. **Requisiti** — Estrae cosa è v1, v2 e fuori scope
4. **Roadmap** — Crea fasi mappate ai requisiti

**File generati** (in questo repo): `.planning/PROJECT.md`, `.planning/REQUIREMENTS.md`, `.planning/ROADMAP.md`, `.planning/STATE.md`, `.planning/research/`

### Step 2: Discuss Phase (`/gsd:discuss-phase N`)

Cattura le preferenze dell'utente prima della pianificazione:
- Feature visive → Layout, densità, interazioni, stati vuoti
- API/CLI → Formato risposte, flag, gestione errori
- Sistemi contenuti → Struttura, tono, profondità

**File generato**: `.planning/phases/{phase_num}-CONTEXT.md`

### Step 3: Plan Phase (`/gsd:plan-phase N`)

1. **Ricerca** — Come implementare la fase (guidata dal CONTEXT.md)
2. **Pianificazione** — Crea 2-3 piani atomici in struttura XML
3. **Verifica** — Controlla i piani contro i requisiti

Ogni piano è abbastanza piccolo da eseguire in un context window fresco.

**File generati**: `.planning/phases/{phase_num}-RESEARCH.md`, `.planning/phases/{phase_num}-{N}-PLAN.md`

### Step 4: Execute Phase (`/gsd:execute-phase N`)

1. **Wave execution** — Piani paralleli dove possibile, sequenziali dove dipendenti
2. **Fresh context per piano** — 200k token puramente per implementazione
3. **Commit per task** — Ogni task ottiene il suo commit atomico
4. **Verifica contro obiettivi** — Controlla che il codice rispetti le promesse

**File generati**: `.planning/phases/{phase_num}-{N}-SUMMARY.md`, `.planning/phases/{phase_num}-VERIFICATION.md`

### Step 5: Verify Work (`/gsd:verify-work N`)

1. Estrae deliverable testabili
2. Guida la verifica uno alla volta
3. Diagnostica i fallimenti automaticamente
4. Crea piani di fix pronti per riesecuzione

**File generato**: `.planning/phases/{phase_num}-UAT.md`

### Step 6: Complete Milestone (`/gsd:complete-milestone`)

Archivia il milestone e tagga la release. Poi `/gsd:new-milestone` per il prossimo ciclo.

---

## Quick Mode

Per task ad-hoc che non necessitano pianificazione completa:

```
/gsd:quick "Descrizione task"
```

Flag composabili:
- `--discuss` — Raccoglie preferenze
- `--research` — Investiga approcci prima della pianificazione
- `--full` — Abilita plan-checking e verifica post-esecuzione

---

## Wave Execution

I piani sono raggruppati in "wave" basate sulle dipendenze:

```
WAVE 1 (parallel)     WAVE 2 (parallel)     WAVE 3
┌─────────┐ ┌─────────┐  ┌─────────┐ ┌─────────┐  ┌─────────┐
│ Plan 01 │ │ Plan 02 │→ │ Plan 03 │ │ Plan 04 │→ │ Plan 05 │
│ Model A │ │ Model B │  │  API A  │ │  API B  │  │   UI    │
└─────────┘ └─────────┘  └─────────┘ └─────────┘  └─────────┘
```

- Piani indipendenti → Stessa wave → Paralleli
- Piani dipendenti → Wave successiva → Attendono dipendenze
- Conflitti file → Piani sequenziali o stesso piano

---

## XML Task Format

```xml
<task type="auto">
  <name>Create login endpoint</name>
  <files>src/app/api/auth/login/route.ts</files>
  <action>
    Use jose for JWT (not jsonwebtoken).
    Validate credentials against users table.
    Return httpOnly cookie on success.
  </action>
  <verify>curl -X POST localhost:3000/api/auth/login returns 200</verify>
  <done>Valid credentials return cookie, invalid return 401</done>
</task>
```

---

## Adattamento per Laraxot PTVX

### Mapping GSD → Laraxot

| GSD Concept | Laraxot Equivalent |
|------------|-------------------|
| `PROJECT.md` | `.planning/PROJECT.md` |
| `REQUIREMENTS.md` | `.planning/REQUIREMENTS.md` |
| `ROADMAP.md` | `.planning/ROADMAP.md` |
| `STATE.md` | `.planning/STATE.md` |
| Research | `.planning/research/` |
| Phase plans | `.planning/phases/` |
| Quick tasks | `.planning/quick/` |
| Config | `.planning/config.json` |

### Brownfield: Map Codebase

Per progetti esistenti come il nostro, eseguire prima la mappatura:
- Analizza stack, architettura, convenzioni, preoccupazioni
- Genera `.planning/codebase/ARCHITECTURE.md`, `STACK.md`, `MODULES.md`, `DOMAIN.md`

### Integrazione con BMAD

GSD e BMAD coesistono:
- **BMAD**: Workflow strutturati enterprise (PRD, epics, stories, sprint planning)
- **GSD**: Workflow snelli spec-driven (discuss → plan → execute → verify)
- **Quando usare GSD**: Feature singole, bugfix complessi, refactoring
- **Quando usare BMAD**: Nuovi moduli, architettura, stakeholder alignment

---

## Comandi Principali

### Core Workflow
| Comando | Descrizione |
|---------|-------------|
| `new-project` | Inizializza progetto con intervista, ricerca, requisiti, roadmap |
| `discuss-phase N` | Cattura preferenze per la fase N |
| `plan-phase N` | Pianifica la fase N con ricerca e verifica |
| `execute-phase N` | Esegue la fase N con wave execution |
| `verify-work N` | Verifica manuale + automatica della fase N |
| `complete-milestone` | Archivia milestone, tagga release |
| `new-milestone` | Inizia nuovo ciclo di sviluppo |

### Utilities
| Comando | Descrizione |
|---------|-------------|
| `quick` | Task ad-hoc con garanzie GSD |
| `map-codebase` | Analizza codebase brownfield |
| `progress` | Mostra stato corrente |
| `pause-work` | Salva stato per ripresa |
| `resume-work` | Riprende da stato salvato |
| `debug` | Debug assistito |
| `add-todo` | Cattura idea senza deragliare |
| `health` | Verifica integrità `.planning/` |

---

## Configurazione

File: `.planning/config.json`

```json
{
  "mode": "yolo",
  "granularity": "fine",
  "parallelization": true,
  "commit_docs": true,
  "model_profile": "quality",
  "workflow": {
    "research": true,
    "plan_check": true,
    "verifier": true,
    "auto_advance": false
  },
  "git": {
    "branching_strategy": "none",
    "phase_branch_template": "gsd/phase-{phase}-{slug}",
    "milestone_branch_template": "gsd/{milestone}-{slug}"
  }
}
```

### Model Profiles
- **quality** — Modello migliore per ogni agente
- **balanced** — Bilanciamento qualità/token
- **budget** — Minimo costo per fase meno critiche

---

## Installazione (pratica) per questo repository

### Cosa intendiamo per “installare”

Nel contesto Laraxot PTVX, “installare GSD” significa rendere disponibili:
- **template** e convenzioni di documentazione (`.gsd/`),
- **regole operative** per gli agenti (Cursor/Windsurf),
- **struttura viva** degli artefatti di progetto (`.planning/`).

Questa repo include già l’adattamento locale in `.gsd/`.

### Installazione ufficiale (riferimento)

Se vuoi usare il runtime ufficiale multi-tool (Claude Code / OpenCode / Gemini / Codex), la doc upstream propone l’installer:

- `npx get-shit-done-cc@latest`

Usalo quando ti serve la suite completa “da tool”, non solo i template.

### Installazione per Cursor (questa repo)

- Regole agent: `.cursor/rules/gsd.mdc`
- Template: `.gsd/templates/`
- Adapter: `.gsd/adapters/CURSOR.md`

### Installazione per Windsurf/Cascade (questa repo)

- Adapter: `.gsd/adapters/WINDSURF.md`

---

## Collegamenti (interni)

- [GSD templates](../../.gsd/README.md)
- [AGENTS.md](../../AGENTS.md)

---

## Quando Usare GSD vs Quando Saltarlo

### Usa GSD Quando:
- Feature multi-file o complesse
- Progetti che durano più sessioni
- Serve qualità consistente su decine di task
- Refactoring di codebase esistenti
- Serve git history pulita e tracciabile

### Salta GSD Quando:
- Bug fix veloci o one-liner
- Prototipazione/esplorazione iniziale
- Task semplici risolvibili con un singolo prompt

---

## Best Practice

1. **Prepara una descrizione dettagliata** prima di `new-project`
2. **Non saltare la discussion phase** — 5-10 minuti qui risparmiano ore
3. **Per brownfield, sempre `map-codebase` prima**
4. **Usa `add-todo` per idee stray** invece di deragliare
5. **Clear context tra fasi** per mantenere la sessione snella
6. **Usa `quick` per task piccoli** — non tutto ha bisogno del workflow completo

---

## Collegamenti

- [AGENTS.md](../../AGENTS.md)
- [BMAD Integration](./bmad-method-integration.md)
- [Laraxot Methodology](./laraxot-methodology.md)
- [.planning/STATE.md](../../.planning/STATE.md)
- [.planning/config.json](../../.planning/config.json)
