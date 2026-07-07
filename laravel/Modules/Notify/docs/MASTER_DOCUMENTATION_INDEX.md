# 📚 Master Documentation Index

**Ultimo Aggiornamento**: 2026-03-30  
**Stato**: ✅ Vivo e Mantenuto  
**Owner**: Multi-Agent Team

---

## 🎯 Quick Navigation

### Per Nuovi Arrivati
1. [Zen of Documentation](./ZEN_OF_DOCUMENTATION.md) - Filosofia e principi
2. [Documentation Governance](./DOCUMENTATION_GOVERNANCE.md) - Regole e standard
3. [Multi-Agent Collaboration](./MULTI_AGENT_COLLABORATION.md) - Come lavorare con AI agents

### Per Sviluppatori
- [Architecture Overview](./architecture/README.md)
- [Getting Started](./GETTING_STARTED.md)
- [Coding Standards](./conventions/README.md)

### Per AI Agents
- [Project Context](./project/PROJECT.md)
- [Agent Coordination](./MULTI_AGENT_COLLABORATION.md)
- [OpenViking Context](../bashscripts/ai/openviking.md)

---

## 📁 Document Categories

### 🏗️ Architecture
- [System Architecture](./architecture/README.md)
- [Module Architecture](./architecture/modules.md)
- [Theme Architecture](./architecture/themes.md)
- [Database Schema](./architecture/database.md)

### 📖 Guides
- [Development Guide](./guides/development.md)
- [Testing Guide](./guides/testing.md)
- [Deployment Guide](./guides/deployment.md)
- [Debugging Guide](./guides/debugging.md)

### 📋 Standards
- [Coding Conventions](./conventions/README.md)
- [Documentation Standards](./DOCUMENTATION_GOVERNANCE.md)
- [Git Workflow](./conventions/git-workflow.md)
- [Naming Conventions](./conventions/naming.md)

### 🤖 AI Tools
- [Multi-Agent Guide](./MULTI_AGENT_COLLABORATION.md)
- [BMAD Framework](./bmad/README.md)
- [GSD Workflow](./gsd/README.md)
- [NotebookLM](./notebooklm/README.md)
- [OpenViking](../bashscripts/ai/openviking.md)

### 📊 Reports
- [Status Reports](./reports/README.md)
- [Quality Reports](./reports/quality.md)
- [Performance Reports](./reports/performance.md)

---

## 🔗 Module Documentation

| Module | Docs | Status |
|--------|------|--------|
| **Xot** | [Modules/Xot/docs/](../laravel/Modules/Xot/docs/) | ⚠️ Needs cleanup |
| **Cms** | [Modules/Cms/docs/](../laravel/Modules/Cms/docs/) | ⚠️ Needs cleanup |
| **UI** | [Modules/UI/docs/](../laravel/Modules/UI/docs/) | ⚠️ Needs cleanup |
| **Media** | [Modules/Media/docs/](../laravel/Modules/Media/docs/) | ✅ Good |
| **Notify** | [Modules/Notify/docs/](../laravel/Modules/Notify/docs/) | ⚠️ Needs cleanup |
| **Blog** | [Modules/Blog/docs/](../laravel/Modules/Blog/docs/) | ✅ Good |
| **User** | [Modules/User/docs/](../laravel/Modules/User/docs/) | ⚠️ Needs cleanup |
| **Geo** | [Modules/Geo/docs/](../laravel/Modules/Geo/docs/) | ✅ Good |
| **AI** | [Modules/AI/docs/](../laravel/Modules/AI/docs/) | ✅ Good |
| **Fixcity** | [Modules/Fixcity/docs/](../laravel/Modules/Fixcity/docs/) | ✅ Good |

---

## 🎨 Theme Documentation

| Theme | Docs | Status |
|-------|------|--------|
| **Sixteen** | [Themes/Sixteen/docs/](../laravel/Themes/Sixteen/docs/) | ✅ AGID Compliant |
| **TwentyOne** | [Themes/TwentyOne/docs/](../laravel/Themes/TwentyOne/docs/) | ✅ Filament 5 |
| **One** | [Themes/One/docs/](../laravel/Themes/One/docs/) | ✅ Base Theme |

---

## 🔍 Search & Discovery

### Trovare Documentazione

```bash
# Cerca per parola chiave
find docs -name "*.md" | xargs grep -l "keyword"

# Trovare duplicati
./bashscripts/docs/check-duplicates.sh

# Trovare file orfani (non linkati da nessun indice)
./bashscripts/docs/find-orphans.sh
```

### Indici per Categoria

- [Architecture Index](./architecture/INDEX.md)
- [Guides Index](./guides/INDEX.md)
- [Reports Index](./reports/INDEX.md)
- [Conventions Index](./conventions/INDEX.md)

---

## 📊 Documentation Metrics

| Metric | Current | Target | Status |
|--------|---------|--------|--------|
| Total MD Files | ~14,000 | ~5,000 | ⚠️ In Progress |
| Duplicate Content | 43-57% | <1% | ⚠️ Critical |
| Index Files | 5-10/mod | 1-2/mod | ⚠️ In Progress |
| Orphaned Files | 43-57% | <5% | ⚠️ Critical |
| Temporal Filenames | 500+ | 0 | ⚠️ In Progress |

---

## 🚀 Active Initiatives

### 1. Zen of Documentation
- **Goal**: Ridurre duplicazione e migliorare qualità
- **Status**: 🟡 In Progress
- **Docs**: [ZEN_OF_DOCUMENTATION.md](./ZEN_OF_DOCUMENTATION.md)
- **Owner**: Multi-Agent Team

### 2. Multi-Block JSON Conversion
- **Goal**: Convertire pagine JSON da single-block a multi-block Filament
- **Status**: 🟡 Planned
- **Docs**: [Multi-Block Pattern](../laravel/Modules/Cms/docs/blocks/multi-block-pattern.md)
- **Owner**: GSD Phase

### 3. Documentation Cleanup
- **Goal**: Rimuovere 60%+ di documentazione duplicata
- **Status**: 🟡 In Progress
- **Script**: `./bashscripts/docs/check-duplicates.sh`
- **Owner**: Ralph Loop

---

## 🤖 AI Agent Coordination

### OpenViking Context
```bash
# Aggiungi contesto
openviking add-memory \
  --title="Documentation System" \
  --content="Zen principles, SSOT, no temporal strings"

# Recupera contesto
openviking get-context --query="documentation"
```

### BMAD Threads
- **Thread Principale**: `_bmad/threads/zen-documentation.md`
- **PRD**: `_bmad/prd/documentation-system.md`
- **Architecture**: `_bmad/architecture/documentation.md`

### GSD Phases
- **Phase 1**: `.planning/phases/01-doc-audit/`
- **Phase 2**: `.planning/phases/02-deduplication/`
- **Phase 3**: `.planning/phases/03-indexing/`
- **Phase 4**: `.planning/phases/04-multi-block-json/`

---

## 📞 Contact & Support

### Per Domande sulla Documentazione
1. Cerca in questo indice
2. Chiedi a NotebookLM: `python scripts/run.py ask_question.py --question="..."`
3. Crea issue su GitHub
4. Coordina tramite BMAD threads

### Per Contribuire
1. Leggi [Documentation Governance](./DOCUMENTATION_GOVERNANCE.md)
2. Segui [Zen of Documentation](./ZEN_OF_DOCUMENTATION.md)
3. Aggiorna questo indice
4. Esegui quality checks

---

**Nota**: Questo indice è vivo. Aggiornalo quando aggiungi/rimuovi documentazione.
