# 🤖 Multi-Agent Collaboration Guide

**Version**: 1.0  
**Created**: 2026-03-30  
**Status**: ✅ Active  
**Owner**: Multi-Agent Team

---

## 🎯 Overview

Questo codebase è progettato per **collaborazione multi-agente AI**. Non è un bug, è una feature.

### Perché Multi-Agent?

- **Specializzazione**: Ogni agente ha skills specifiche
- **Parallelismo**: Multipli task in parallelo
- **Quality**: Cross-validation tra agenti
- **Scalability**: 10x productivity vs single agent

### Agenti Attivi

| Agente | Tipo | Specializzazione |
|--------|------|------------------|
| **John** | BMAD PM | Requirements, user stories |
| **Winston** | BMAD Architect | Technical design |
| **Sally** | BMAD UX | User experience |
| **Paige** | BMAD Tech Writer | Documentation quality |
| **Amelia** | BMAD Dev | Implementation |
| **gsd-codebase-mapper** | GSD | Structure analysis |
| **gsd-planner** | GSD | Phase planning |
| **gsd-executor** | GSD | Phase execution |
| **gsd-verifier** | GSD | Quality validation |
| **Ralph Loop** | Autonomous | Repetitive tasks |
| **NotebookLM** | Research | Source-grounded Q&A |

---

## 🏗️ Architecture di Coordinamento

### 1. OpenViking (Context Layer)

**Scopo**: Preservare contesto tra sessioni e agenti

```bash
# Agente A aggiunge contesto
openviking add-memory \
  --title="Documentation Philosophy" \
  --content="Zen principles: SSOT, no temporal strings, bidirectional indexing"

# Agente B recupera contesto
openviking get-context --query="documentation"
```

**Context File Globale**: `.qwen/openviking-context.md`

### 2. BMAD Threads (Coordination Layer)

**Scopo**: Coordinamento decisionale tra agenti

```
_bmad/threads/zen-documentation.md
├── Agent Coordination Log
├── Architecture Decisions
├── Metrics & KPIs
└── Implementation Plan
```

**PRD**: `_bmad/prd/documentation-system.md`

### 3. GSD Phases (Execution Layer)

**Scopo**: Execution tracking con atomic commits

```
.planning/phases/
├── 01-doc-audit/
│   ├── PLAN.md
│   ├── EXECUTION_LOG.md
│   └── VERIFICATION.md
├── 02-deduplication/
├── 03-indexing/
└── 04-multi-block-json/
```

### 4. GitHub Issues (Communication Layer)

**Scopo**: Comunicazione asincrona e tracking

- Dichiarare intenzioni PRIMA di iniziare
- Aggiornare progresso ogni 10-15 minuti
- Mark complete con evidenza

---

## 📋 Protocollo di Coordinamento

### Prima di Iniziare un Task

1. **Check Context** (OpenViking)
   ```bash
   openviking get-context --query="active tasks"
   ```

2. **Check Coordination** (BMAD Threads)
   ```bash
   cat _bmad/threads/zen-documentation.md
   ```

3. **Check Execution** (GSD Phases)
   ```bash
   ls -la .planning/phases/
   ```

4. **Declare Intention** (GitHub Issue)
   ```markdown
   ## Starting: Documentation Audit
   **Agent**: gsd-codebase-mapper
   **ETA**: 2 hours
   **Scope**: Run check-duplicates.sh
   ```

### Durante l'Esecuzione

1. **Update Progress** (ogni 10-15 minuti)
   ```markdown
   **Update 1**: Scanned 5,000/14,000 files
   **Update 2**: Found 200 duplicate sets
   **Update 3**: Generating report...
   ```

2. **Add Context** (OpenViking)
   ```bash
   openviking add-memory \
     --title="Duplicate Check Progress" \
     --content="Found 200 duplicate sets, mostly in Cms and Xot modules"
   ```

3. **Log Decisions** (BMAD Thread)
   ```markdown
   ### Decision: Archive Strategy
   **Agent**: gsd-executor
   **Decision**: Move historical docs to archive/ instead of deleting
   **Rationale**: Preserve git history, allow recovery
   ```

### Dopo il Completamento

1. **Update GSD Phase**
   ```bash
   echo "✅ Complete" >> .planning/phases/01-doc-audit/EXECUTION_LOG.md
   ```

2. **Run Quality Gates**
   ```bash
   ./bashscripts/docs/check-duplicates.sh
   ./bashscripts/docs/validate-links.sh
   ```

3. **Commit with Evidence**
   ```bash
   git commit -m "feat: Documentation audit complete
   
   - Scanned 14,000 files
   - Found 200 duplicate sets
   - Report: docs/reports/duplicate-report.md
   
   GSD Phase: 01-doc-audit
   Agent: gsd-codebase-mapper"
   ```

4. **Update GitHub Issue**
   ```markdown
   ✅ Complete: Documentation Audit
   
   **Results**:
   - 14,000 files scanned
   - 200 duplicate sets found
   - Report: docs/reports/duplicate-report.md
   
   **Next**: Phase 2 - Deduplication
   ```

---

## 🚦 Conflict Resolution

### Scenario 1: Due Agenti Stesso File

**Problema**: Amelia e gsd-executor modificano lo stesso file

**Soluzione**:
1. **Lock File**:
   ```bash
   echo "Amelia" > /tmp/lock_filename.md
   ```

2. **Check Lock**:
   ```bash
   if [ -f /tmp/lock_filename.md ]; then
     echo "File locked by $(cat /tmp/lock_filename.md)"
   fi
   ```

3. **Coordinate via BMAD**:
   ```markdown
   ### Conflict Resolution
   **File**: documentation-system.md
   **Agents**: Amelia vs gsd-executor
   **Resolution**: Amelia completes edits, then gsd-executor validates
   ```

### Scenario 2: Decisioni Conflittuali

**Problema**: John (PM) e Winston (Architect) hanno priorità diverse

**Soluzione**:
1. **BMAD Thread Discussion**:
   ```markdown
   ### Priority Conflict
   **John**: User stories first (business value)
   **Winston**: Architecture first (technical foundation)
   
   **Resolution**: Architecture foundation → User stories
   **Rationale**: Technical debt slows down feature delivery
   ```

2. **Document Decision**:
   ```bash
   openviking add-memory \
     --title="Priority Decision" \
     --content="Architecture before features for documentation system"
   ```

### Scenario 3: Context Loss

**Problema**: Agente perde contesto tra sessioni

**Soluzione**:
1. **OpenViking Recovery**:
   ```bash
   openviking get-context --query="last session"
   ```

2. **BMAD Thread Review**:
   ```bash
   tail -100 _bmad/threads/zen-documentation.md
   ```

3. **GSD Phase Status**:
   ```bash
   cat .planning/phases/01-doc-audit/EXECUTION_LOG.md
   ```

---

## 🛠️ Tooling

### OpenViking Commands

```bash
# Add context
openviking add-memory \
  --title="Title" \
  --content="Content" \
  --tags="tag1,tag2"

# Get context
openviking get-context \
  --query="search query" \
  --limit=10

# List memories
openviking list-memories \
  --tag="documentation"

# Delete memory
openviking delete-memory --id=123
```

### BMAD Commands

```bash
# Create thread
bmad-thread create \
  --name="zen-documentation" \
  --description="Documentation system coordination"

# Add log entry
bmad-thread log \
  --thread="zen-documentation" \
  --message="Phase 1 complete"

# Get thread status
bmad-thread status \
  --thread="zen-documentation"
```

### GSD Commands

```bash
# Create phase
gsd-phase create \
  --name="01-doc-audit" \
  --goal="Audit documentation for duplicates"

# Start phase
gsd-phase start \
  --name="01-doc-audit"

# Log progress
gsd-phase log \
  --name="01-doc-audit" \
  --message="Scanned 5,000 files"

# Complete phase
gsd-phase complete \
  --name="01-doc-audit" \
  --verification="All files scanned"
```

### Ralph Loop Commands

```bash
# Start autonomous task
ralph-loop run \
  --task="Find and merge duplicate documentation" \
  --until="No duplicates remain" \
  --check-interval=5m

# Monitor progress
ralph-loop status \
  --task="duplicate-merge"

# Stop task
ralph-loop stop \
  --task="duplicate-merge"
```

---

## 📊 Monitoring & Metrics

### Agent Activity Dashboard

| Agent | Active Tasks | Completed | Last Activity |
|-------|-------------|-----------|---------------|
| John | 1 | 5 | 2026-03-30 15:00 |
| Winston | 2 | 8 | 2026-03-30 14:45 |
| Amelia | 3 | 12 | 2026-03-30 15:10 |
| gsd-executor | 2 | 15 | 2026-03-30 15:05 |

### Phase Progress

| Phase | Status | Progress | Owner |
|-------|--------|----------|-------|
| 01-doc-audit | 🟡 In Progress | 80% | Ralph Loop |
| 02-deduplication | ⏳ Planned | 0% | - |
| 03-indexing | ⏳ Planned | 0% | - |
| 04-multi-block-json | ⏳ Planned | 0% | - |

### Quality Metrics

| Metric | Current | Target | Status |
|--------|---------|--------|--------|
| Duplicate Content | 43-57% | <1% | 🔴 |
| Index Files | 5-10/mod | 1-2/mod | 🟡 |
| Orphaned Files | 43-57% | <5% | 🔴 |
| Temporal Filenames | 500+ | 0 | 🟡 |

---

## 🎓 Best Practices

### Do's ✅

- **Dichiarare intenzioni** PRIMA di iniziare
- **Aggiornare progresso** ogni 10-15 minuti
- **Aggiungere contesto** a OpenViking
- **Loggare decisioni** in BMAD threads
- **Run quality gates** prima di commit
- **Coordinare via GitHub** issues

### Don'ts ❌

- **Non lavorare in silenzio** - comunica sempre
- **Non saltare quality gates** - valida sempre
- **Non modificare senza lock** - check locks
- **Non perdere contesto** - usa OpenViking
- **Non ignorare conflitti** - risolvi subito
- **Non commitare senza evidenza** - documenta

---

## 📚 Case Studies

### Case Study 1: Documentation Deduplication

**Challenge**: 6,000+ file duplicati

**Approach**:
1. Ralph Loop esegue `check-duplicates.sh`
2. gsd-codebase-mapper analizza risultati
3. John priorizza duplicati da rimuovere
4. gsd-executor merge e crea cross-reference
5. Amelia scrive test per validazione
6. Winston valida architettura
7. Paige verifica qualità documentazione

**Result**: 43-57% → <1% duplicate content

### Case Study 2: Multi-Block JSON Conversion

**Challenge**: 38 JSON pages da convertire a multi-block

**Approach**:
1. Sally definisce UX patterns per blocchi
2. Winston progetta architettura Filament
3. Amelia implementa block classes
4. gsd-executor converte JSON files
5. John valida user stories
6. Paige documenta pattern
7. Ralph Loop testa rendering

**Result**: 38 pages converted, 100% test coverage

---

## 🔗 Related Documents

- [Zen of Documentation](docs/ZEN_OF_DOCUMENTATION.md)
- [Documentation Governance](docs/DOCUMENTATION_GOVERNANCE.md)
- [OpenViking Context](.qwen/openviking-context.md)
- [BMAD Thread]( _bmad/threads/zen-documentation.md)
- [GSD Phases](.planning/phases/)

---

**Last Updated**: 2026-03-30  
**Maintained By**: Multi-Agent Team  
**Status**: ✅ Active
