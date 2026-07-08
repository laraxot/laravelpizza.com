# AI Agent Coordination Hub with BMAD-METHOD

> **Central Coordination Document for Multiple AI Agents**
>
> **Purpose:** Coordinare BMAD-METHOD agents con AI agents esistenti (Qwen, Gemini, Claude) per evitare duplicazioni e conflitti
>
> **Status:** Active
>
> **BMAD Version:** v6.2.0

---

## 🎯 Panoramica

Questo progetto utilizza **BMAD-METHOD v6.2.0** per lo sviluppo agile guidato da AI, integrato con AI agents esistenti (Qwen, Gemini, Claude).

### Agenti AI Attivi

#### BMAD-METHOD Agents (Specialists)

| Agent | Name | Role | Expertise | Status |
|-------|------|------|-----------|--------|
| **analyst** | Mary 📊 | Business Analyst | Requirements, market research | ✅ Active |
| **architect** | Winston 🏗️ | System Architect | Distributed systems, Laravel | ✅ Active |
| **dev** | Amelia 💻 | Senior Developer | TDD, clean code | ✅ Active |
| **pm** | John 📋 | Product Manager | PRDs, user stories | ✅ Active |
| **qa** | Quinn 🧪 | QA Engineer | Test automation, Pest | ✅ Active |
| **ux-designer** | Sally 🎨 | UX Designer | User research, UI | ✅ Active |
| **sm** | Bob 🏃 | Scrum Master | Sprint planning, agile | ✅ Active |
| **tech-writer** | Paige 📚 | Technical Writer | Documentation | ✅ Active |

#### General AI Agents (Generalists)

| Agent | Role | Status | Notes |
|-------|------|--------|-------|
| **Qwen** | Primary AI | ✅ Active | Main development agent |
| **Gemini** | Secondary AI | ✅ Active | Support, research |
| **Claude** | Tertiary AI | ✅ Active | Code review, docs |

---

## 🔄 Workflow di Coordinamento

### 1. Prima di Agire

**TUTTI gli agenti DEVONO:**

```bash
# 1. Leggere questo documento
cat docs/ai-agent-coordination.md

# 2. Verificare task in corso
git status
git log --oneline -10

# 3. Controllare GitHub Issues
gh issue list

# 4. Controllare BMAD workflows attivi
cat _bmad/bmm/workflows/*/workflow.md
```

### 2. Scegliere il Workflow Appropriato

| Scenario | Workflow BMAD | Agente Responsabile |
|----------|---------------|---------------------|
| **Nuovo modulo** | `bmad-laravel-module-dev` | Mary → Winston → Amelia → Quinn → Paige |
| **Nuova feature** | `bmad-create-architecture` + `bmad-dev` | Winston → Amelia |
| **Bug fix** | `bmad-dev` (bug mode) | Amelia |
| **Code review** | `bmad-code-review` | Amelia + Quinn |
| **Test** | `bmad-qa-generate-e2e-tests` | Quinn |
| **Documentazione** | `bmad-document-project` | Paige |
| **Sprint planning** | `bmad-sprint-planning` | Bob + John |
| **Retrospettiva** | `bmad-retrospective` | Bob + Team |

### 3. Durante il Lavoro

**Regole per Tutti gli Agenti:**

1. **Lavorare in piccoli incrementi**
   - Commit atomici e frequenti
   - Push ogni 5-10 minuti
   - Documentare ogni cambiamento

2. **Evitare conflitti**
   - Controllare file lock
   - Verificare file modificati di recente
   - Comunicare su GitHub Issues

3. **Seguire le convenzioni**
   - Laraxot patterns
   - PHPStan Level 10
   - Pest per testing
   - XotBase wrappers

### 4. Dopo il Lavoro

**TUTTI gli agenti DEVONO:**

```bash
# 1. Eseguire quality gates
php -d memory_limit=2G ./vendor/bin/phpstan analyse
./vendor/bin/pint
./vendor/bin/pest

# 2. Commit con messaggio chiaro
git add -A
git commit -m "type: clear description"

# 3. Push immediato
git push origin dev

# 4. Aggiornare questo documento
# Edit docs/ai-agent-coordination.md

# 5. Aggiornare GitHub Issues
gh issue comment <number> --body "Completed: <description>"
```

---

## 📋 Task Attivi

### Task #1: BMAD Integration ✅

**Status:** COMPLETED

**Agent:** Qwen (Primary)

**Descrizione:**
Integrazione BMAD-METHOD v6.2.0 nel progetto PTVX Fila5 Mono

**Azioni Intraprese:**
```markdown
- ✅ Installato BMAD-METHOD v6.2.0
- ✅ Creato project context: project-context-ptvx.md
- ✅ Creati custom skills:
  - bmad-laravel-module-dev.md
  - bmad-filament-page-dev.md
- ✅ Integrato con AI agent coordination esistente
- ✅ Creato documentazione BMAD in docs/bmad/
- ✅ Configurato MCP servers
```

**Risultato:**
BMAD-METHOD completamente integrato e operativo

---

### Task #2: Module Documentation Update 🟡

**Status:** IN PROGRESS

**Agent:** Paige (Tech Writer) + Qwen

**Descrizione:**
Aggiornare documentazione in tutti i 42+ moduli seguendo standard BMAD

**Azioni Richieste:**
- [x] Creare template documentazione BMAD
- [ ] Verificare modulo Xot
- [ ] Verificare modulo User
- [ ] Verificare modulo Performance
- [ ] Verificare modulo Ptv
- [ ] Verificare restanti 38 moduli

---

### Task #3: Test Coverage Improvement ⏳

**Status:** PENDING

**Agent:** Quinn (QA) + Amelia (Developer)

**Descrizione:**
Migliorare test coverage dall'82% al 100%

**Azioni Richieste:**
- [ ] Analizzare coverage attuale
- [ ] Identificare moduli critici
- [ ] Generare test con BMAD workflow
- [ ] Eseguire test e verificare
- [ ] Documentare test patterns

---

### Task #4: BMAD Workflow Testing ⏳

**Status:** PENDING

**Agent:** Amelia (Developer) + Quinn (QA)

**Descrizione:**
Testare tutti i workflow BMAD su moduli reali

**Workflow da Testare:**
- [ ] bmad-laravel-module-dev
- [ ] bmad-create-architecture
- [ ] bmad-dev
- [ ] bmad-code-review
- [ ] bmad-qa-generate-e2e-tests
- [ ] bmad-document-project

---

## 🚨 Conflitti Evitati

### Conflitto #1: Duplicazione Agenti

**Potenziale Conflitto:**
BMAD agents e Qwen/Gemini potrebbero lavorare sugli stessi file

**Soluzione:**
```markdown
REGOLA DI COORDINAMENTO:

1. BMAD agents (specialists) gestiscono:
   - Architecture decisions (Winston)
   - Code implementation (Amelia)
   - Testing (Quinn)
   - Documentation (Paige)

2. Qwen/Gemini (generalists) gestiscono:
   - Task generali
   - Research
   - Fix rapidi
   - Integrazione

3. Comunicazione:
   - GitHub Issues per task specifici
   - Questo documento per coordinamento
   - Commit messages chiari
```

### Conflitto #2: File Lock

**Potenziale Conflitto:**
Multipli agenti modificano lo stesso file

**Soluzione:**
```bash
#!/bin/bash
# Lock file per operazioni critiche
LOCKFILE="/tmp/ai-agent-$(basename $FILE).lock"

if [ -f "$LOCKFILE" ]; then
    echo "⚠️  File $FILE locked by another agent"
    echo "Waiting..."
    sleep 5
fi

touch $LOCKFILE
# Esegui operazione
rm $LOCKFILE
```

---

## 📊 Stato workflow BMAD

Per evitare "date rot" e duplicazioni di tracking, lo stato operativo dei workflow va tracciato in **GitHub Issues** usando i template BMAD già presenti in `.github/ISSUE_TEMPLATE/`.

---

## 🔴 Task Correnti: Refactoring Accessor Sigma

### Panoramica

**Task**: Refactoring accessor per seguire pattern di delega con metodo puro vicino  
**Modulo**: Sigma  
**File**: `laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php`, `SchedaMutator.php`  
**Stato**: 🟡 In Progress  
**AI Agent Lead**: @qwen  
**Started**: 2026-04-01

### Documentazione

- [Accessor Delegation Pattern](laravel/Modules/Sigma/docs/accessor-delegation-pattern.md)
- [Accessor Delegation Audit](laravel/Modules/Sigma/docs/accessor-delegation-audit.md)
- [Accessor/Mutator Philosophy](laravel/Modules/Sigma/docs/accessor-mutator-philosophy.md)

### Numeri

- **Totale Accessor**: ~83
- **Conformi**: ~50 (60%)
- **Da Correggere**: ~33 (40%)

### Fasi

#### Fase 1: Priorità Alta (🔴) - 5 accessor critici

- [ ] `getGgFuoriSedeNoAszAttribute` → Creare `getGgFuoriSedeNoAsz()`
- [ ] `getPosizioneAttribute` → Creare `getPosizione()`
- [ ] `getAventiDirittoAttribute` → Creare `getAventiDiritto()` + cleanup debug
- [ ] `getAventiDirittoEffAttribute` → Creare `getAventiDirittoEff()` + cleanup debug
- [ ] `getGgAszCatecoPosfunAttribute` → Creare `getGgAszCatecoPosfun()`

**GitHub Issue**: #XXX (da creare)

#### Fase 2: Priorità Media (🟡) - 15 accessor

- [ ] Tutti i `getGgCateco*` senza metodo puro
- [ ] Tutti i `get*Attribute` in SchedaMutator

**GitHub Issue**: #YYY (da creare)

#### Fase 3: Priorità Bassa (🟢) - Cleanup

- [ ] `getGgAszTipCodEsclusoSubitoAttribute` → Rimuovere o documentare
- [ ] Documentare pattern `funcYear()` per performance indicator
- [ ] Aggiornare documentazione

**GitHub Issue**: #ZZZ (da creare)

### Regole per AI Agent

**QUANDO lavori su questo refactoring:**

1. **LEGGI** prima la documentazione:
   - `laravel/Modules/Sigma/docs/accessor-delegation-pattern.md`
   - `laravel/Modules/Sigma/docs/accessor-delegation-audit.md`

2. **SCEGLI** un accessor dalla lista (inizia da Fase 1)

3. **APPLICA** il template:
   ```php
   // Metodo puro (entro 50 righe dall'accessor)
   protected function get<Nome>(): [Tipo] { ... }
   
   // Accessor con cache/guard/delega/persist
   protected function get<Nome>Attribute([Tipo] $value): [Tipo] {
       if (is_float($value)) return $value;  // Cache
       if (null == $this->getKey()) return null;  // Guard
       $value = $this->get<Nome>();  // Delega
       $this->update([...]);  // Persist
       return $value;
   }
   ```

4. **VERIFICA**:
   - PHPStan Level 10: nessun errore
   - PHPMD: nessun warning
   - PHPInsights: score > 90

5. **COMMITTA** con messaggio:
   ```
   [REFACTOR] Sigma: Extract pure method for get<Nome>Attribute
   
   - Create get<Nome>() pure method
   - Delegate from get<Nome>Attribute()
   - Follow accessor delegation pattern
   
   Ref: Sigma/docs/accessor-delegation-audit.md
   Issue: #XXX
   ```

6. **AGGIORNA** questo documento e l'audit

**NON FARE:**
- ❌ Non modificare più di 5 accessor per commit
- ❌ Non cambiare logica business, solo refactoring
- ❌ Non rimuovere metodi helper esistenti senza check
- ❌ Non lavorare sugli stessi file contemporaneamente (usare lock)

### Coordination Lock

```bash
# Prima di iniziare, crea lock file
touch /tmp/sigma-accessor-refactor.lock

# Dopo aver finito, rimuovi lock
rm /tmp/sigma-accessor-refactor.lock
```

### GitHub Issues

Crea issue separate per ogni fase:
- Issue #XXX: Fase 1 - Priorità Alta (5 accessor)
- Issue #YYY: Fase 2 - Priorità Media (15 accessor)
- Issue #ZZZ: Fase 3 - Priorità Bassa (cleanup)

---

## 🎯 Linee Guida per AI Agents

### BMAD Agents

**Quando Attivare:**

1. **Task Specializzati**
   - Architecture: `bmad-create-architecture`
   - Development: `bmad-dev`
   - Testing: `bmad-qa-generate-e2e-tests`
   - Documentation: `bmad-document-project`

2. **Workflow Strutturati**
   - Sprint planning: `bmad-sprint-planning`
   - Code review: `bmad-code-review`
   - Retrospettiva: `bmad-retrospective`

**Come Attivare:**
```bash
# Tramite comando
bmad-<workflow-name>

# Tramite skill
@agent Use bmad-<skill-name>
```

### Qwen/Gemini/Claude

**Quando Attivare:**

1. **Task Generali**
   - Research veloce
   - Fix rapidi
   - Code review informale
   - Domande generali

2. **Integrazione**
   - Coordinare BMAD workflows
   - Verificare quality gates
   - Aggiornare documentazione

**Come Attivare:**
```bash
# Tramite chat
"Qwen, verifica PHPStan su modulo Xot"

# Tramite comando
./vendor/bin/phpstan analyse Modules/Xot
```

---

## 🔧 Script e Tool per AI Agents

### BMAD Workflow Check

```bash
#!/bin/bash
# check-bmad-workflows.sh

echo "=== BMAD Workflow Status ==="
echo ""

echo "1. Active Workflows:"
find _bmad/bmm/workflows -name "workflow.md" -exec grep -l "status: active" {} \;

echo ""
echo "2. Recent BMAD Commits:"
git log --oneline -10 --grep="bmad\|BMAD"

echo ""
echo "3. BMAD Files Created Today:"
find _bmad -type f -mtime -1

echo ""
echo "4. Project Context:"
cat _bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md | head -30
```

### Coordination Check

```bash
#!/bin/bash
# check-coordination.sh

echo "=== AI Agent Coordination Check ==="
echo ""

echo "1. Checking for other running agents..."
ps aux | grep -i "agent\|ai\|copilot" | grep -v grep

echo ""
echo "2. Recent git activity..."
git log --oneline -10

echo ""
echo "3. Open GitHub Issues..."
gh issue list --state open

echo ""
echo "4. BMAD Workflows attivi..."
cat docs/ai-agent-coordination.md | grep -A 5 "Workflow in Esecuzione"

echo ""
echo "5. Task in corso..."
cat docs/ai-agent-coordination.md | grep -A 10 "Task Attivi"
```

### Auto-Documentation

```bash
#!/bin/bash
# auto-document-bmad-task.sh

TASK_NAME=$1
AGENT_NAME=$2

echo "Generating BMAD task documentation..."

# Create task report
cat >> docs/bmad/task-reports/$(date +%Y-%m-%d)-$TASK_NAME.md << EOF
# BMAD Task Report

**Task**: $TASK_NAME
**Agent**: $AGENT_NAME
**Date**: $(date +%Y-%m-%d)
**Workflow**: bmad-$TASK_NAME

## Files Modified

$(git diff --name-only HEAD~1..HEAD | sed 's/^/- /')

## Changes Summary

$(git diff --stat HEAD~1..HEAD)

## Quality Gates

- PHPStan: $(php -d memory_limit=2G ./vendor/bin/phpstan analyse --error-format=json | jq '.totals.errors')
- Tests: $(./vendor/bin/pest --colors=never | grep -E 'Tests:|Passed:' | head -2)

## Next Steps

[ ] Review changes
[ ] Update documentation
[ ] Create GitHub issue if needed

---
EOF

echo "Task documented in docs/bmad/task-reports/"
```

---

## 📚 GitHub Integration

### Issue Template per BMAD Workflows

```markdown
---
name: BMAD Workflow
title: '[BMAD] Workflow name'
labels: ['bmad', 'workflow']
assignees: ''
---

## Workflow Information

- **Workflow**: bmad-<workflow-name>
- **Agent**: <agent-name>
- **Start Time**: <timestamp>
- **Expected Duration**: <time>

## Input

[Describe input: requirements, user story, etc.]

## Output

[Describe expected output: code, tests, docs]

## Progress

- [ ] Step 1: <step-name>
- [ ] Step 2: <step-name>
- [ ] Step 3: <step-name>
- [ ] Quality gates passed
- [ ] Documentation updated
- [ ] Tests passing

## Completion

- [ ] Workflow completed
- [ ] Output saved to: <path>
- [ ] Coordination doc updated
- [ ] GitHub discussion created (if needed)

## Notes

[Any additional notes, decisions, or follow-ups]
```

### Discussion Template

```markdown
---
title: BMAD Architecture Decision
category: Architecture
labels: ['bmad', 'architecture', 'decision']
---

## Proposal

[Describe the architectural decision from BMAD workflow]

## BMAD Workflow Output

**Workflow**: bmad-create-architecture
**Agent**: Winston (Architect)
**Date**: <date>

## Impact

[List affected modules, components]

## Coordination Required

- [ ] BMAD Architect (Winston) approval
- [ ] BMAD Developer (Amelia) feedback
- [ ] Human review
- [ ] Other AI agents alignment

## Decision

[Final decision and rationale]

## Next Steps

- [ ] Create ADR
- [ ] Update documentation
- [ ] Implement changes
```

---

## 📊 Metrics & Monitoring

### Workflow Metrics

| Metric | Target | Current | Status |
|--------|--------|---------|--------|
| Workflow Completion Rate | 100% | - | 🟡 |
| Agent Response Time | < 30s | - | 🟡 |
| Documentation Coverage | 100% | 75% | 🟡 |
| Test Coverage | 100% | 82% | 🟡 |
| Quality Gate Pass Rate | 100% | 95% | 🟢 |

### Agent Activity

Tracked in: `_bmad/_memory/agent-activity.yaml`

Nota: evitare timestamp dentro i `.md`. I dettagli di attività vivono nei file macchina sotto `_bmad/_memory/`.

---

## 📜 Regole Fondamentali

### 🚫 Bashscripts è SACRO

> **REGOLA COSTITUZIONALE**: `bashscripts/` DEVE rimanere nel `.gitignore`

**Perché**:
- bashscripts/ = Strumenti locali dell'operatore
- Non sono codice di produzione
- Sperimentazione libera senza review
- Ogni agente può ottimizzare il proprio workflow

**Cosa fare**:
- ✅ Creare script in bashscripts/ per automazione personale
- ✅ Sperimentare liberamente (v1, v2, v3...)
- ✅ Modificare senza commit

**Cosa NON fare**:
- ❌ `git add bashscripts/` (incostituzionale)
- ❌ Commitare script "temporanei"
- ❌ Confondere strumenti con codice

**Promozione a codice**:
Se uno script diventa produzione:
1. Riscrivi come Action PHP o Workflow CI
2. Sposta in `laravel/` o `.github/workflows/`
3. Crea PR con review e test

📖 Vedi: [docs/bashscripts-philosophy.md](bashscripts-philosophy.md)

---

## 🔗 Risorse

### Documenti Correlati

- [BMAD Guide](bmad/README.md)
- [BMAD integration summary](bmad/bmad-integration-summary.md)
- [BMAD project context](../_bmad/bmm/workflows/bmad-generate-project-context/project-context-ptvx.md)
- [Laravel module skill](../_bmad/core/skills/bmad-laravel-module-dev.md)
- [Filament page skill](../_bmad/core/skills/bmad-filament-page-dev.md)
- [AGENTS.md](../AGENTS.md)
- [QWEN.md](../QWEN.md)
- [Bashscripts Philosophy](bashscripts-philosophy.md) ⭐ **NUOVO**

### BMAD Resources

- [BMAD-METHOD Docs](https://docs.bmad-method.org)
- [BMAD GitHub](https://github.com/bmad-code-org/BMAD-METHOD)
- [BMAD Discord](https://discord.gg/bmad)
- [Full Text Docs](https://docs.bmad-method.org/llms-full.txt)

### GitHub Resources

- [Issues](https://github.com/provtv/base_ptv_fila5_mono/issues)
- [Discussions](https://github.com/provtv/base_ptv_fila5_mono/discussions)
- [Pull requests](https://github.com/provtv/base_ptv_fila5_mono/pulls)

---

*Documento di coordinamento: lo storico dettagliato vive in Git e nelle Issues.*
