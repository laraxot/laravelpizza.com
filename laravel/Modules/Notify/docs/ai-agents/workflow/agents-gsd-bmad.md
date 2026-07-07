# 🚀 GSD + BMAD Workflow

**File**: `.agents/docs/workflow/agents-gsd-bmad.md`  
**Ultimo Aggiornamento**: 2026-03-20  
**Stato**: ✅ IMPLEMENTATO

---

## 🎯 GSD (Get Shit Done)

### Comandi Principali

#### Inizializzazione
```bash
/gsd-new-project             # Inizializza progetto
```

#### Fasi Workflow
```bash
/gsd-discuss-phase [N]       # Cattura decisioni (Fase N)
/gsd-plan-phase [N]          # Crea piano eseguibile
/gsd-execute-phase [N]       # Esegue piani in onde
/gsd-verify-work [N]         # UAT conversazionale
/gsd-complete-milestone      # Archivia milestone
```

#### Utils
```bash
/gsd-progress                # Dove sono? Cosa next?
/gsd-settings                # Configura workflow
/gsd-set-profile <profile>   # quality/balanced/budget
/gsd-quick "task"            # Task ad-hoc veloce
```

### Flusso Tipico

```bash
# 1. Discuti architettura
/gsd-discuss-phase 1
# Output: docs/get-shit-done/phase-1-discussion.md

# 2. Crea piano
/gsd-plan-phase 1
# Output: docs/get-shit-done/phase-1-plan.md

# 3. Esegui
/gsd-execute-phase 1
# Output: Commit atomici, verificati

# 4. Verifica
/gsd-verify-work 1
# Output: docs/get-shit-done/phase-1-verification.md

# 5. Completa
/gsd-complete-milestone
```

---

## 🧠 BMAD (Build Measure Analyze Decide)

### Agent Roles

| Agente | Scopo | Quando Usare |
|--------|-------|--------------|
| **PM** | Requirements, prioritization | Inizio progetto |
| **Architect** | Architecture decisions | Design tecnico |
| **Developer** | Implementation | Code implementation |
| **UX Designer** | UI/UX design | User experience |
| **QA** | Testing, verification | Quality gate |
| **Analyst** | Research, benchmarking | Analysis |

### Flusso BMAD

```
1. PM → Definisce requirements
   ↓
2. Architect → Decide architettura
   ↓
3. Developer → Implementa
   ↓
4. QA → Verifica qualità
   ↓
5. Analyst → Misura risultati
   ↓
6. Decide → Prossima iterazione
```

---

## 📁 Documentazione

### GSD Directory
```
.github/get-shit-done/
├── workflows/           # 33 workflow automatizzati
├── agents/              # Agenti AI (gsd-*.agent.md)
├── templates/           # Template (project.md, state.md)
└── bin/                 # Strumenti CLI
```

### BMAD Directory
```
_bmad-output/
├── planning-artifacts/   # Decisioni architetturali
├── implementation-artifacts/ # Codice, test
└── bmad-roadmap.md       # Roadmap completa
```

### Project Docs
```
docs/project/
├── gsd-and-bmad-workflow.md       # Workflow completo
├── gsd-agent-coordination.md      # Coordinamento multi-agente
└── website-checklist.md           # Checklist qualità sito
```

---

## ✅ CHECKLIST PRE-MODIFICA

### Prima di Modificare File Critici

- [ ] **1. Leggi Documentazione Esistente**
  - [ ] `docs/project/` per architettura
  - [ ] `.agents/docs/` per regole AI
  - [ ] `QWEN.md`, `AGENTS.md` per contesto

- [ ] **2. Apri GitHub Issue**
  - [ ] Descrivi problema/feature
  - [ ] Root cause analysis (se bug)
  - [ ] Soluzione proposta
  - [ ] Testing plan

- [ ] **3. Apri GitHub Discussion**
  - [ ] Condividi approccio con community
  - [ ] Chiedi feedback
  - [ ] Documenta decisioni

- [ ] **4. Usa GSD/BMAD**
  - [ ] `/gsd-discuss-phase N`
  - [ ] `/gsd-plan-phase N`
  - [ ] `/gsd-execute-phase N`

- [ ] **5. Quality Gate**
  - [ ] PHPStan: NO errors
  - [ ] PHPMD: NO warnings
  - [ ] PHPInsights: Quality > 90%
  - [ ] Test: Passing

- [ ] **6. Git Commit**
  - [ ] Messaggio descrittivo
  - [ ] Link a issue/discussion
  - [ ] Push immediato

---

## 🛡️ PREVENZIONE ERRORI

### Git Hooks
```bash
# .git/hooks/pre-commit
#!/bin/bash
echo "🔍 Validazione pre-commit..."

# Composer validate (se modificato composer.json)
if git diff --cached --name-only | grep -q "composer.json"; then
    cd laravel
    composer validate --no-check-all
    if [ $? -ne 0 ]; then
        echo "❌ composer.json non valido!"
        exit 1
    fi
fi

# PHP syntax check
PHP_FILES=$(git diff --cached --name-only --diff-filter=ACM | grep "\.php$")
for file in $PHP_FILES; do
    php -l "$file"
    if [ $? -ne 0 ]; then
        echo "❌ Errore sintassi PHP in $file"
        exit 1
    fi
done

echo "✅ Validazione pre-commit completata!"
exit 0
```

### GitHub Actions
```yaml
# .github/workflows/validate-composer.yml
name: Validate Composer
on:
  push:
    paths:
      - 'laravel/composer.json'
jobs:
  validate:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - run: cd laravel && composer validate --strict
```

---

## 📊 METRICHE DI SUCCESSO

### GSD Metrics
- [ ] Fasi completate: 0/6
- [ ] Task atomici: 0
- [ ] Quality gate pass: 0%
- [ ] Docs aggiornate: 0/6

### BMAD Metrics
- [ ] Decisioni documentate: 0
- [ ] Experiment completati: 0
- [ ] Learnings condivisi: 0

### Project Health
- [ ] PHPStan: NO errors
- [ ] Test: >80% coverage
- [ ] Docs: 100% aggiornate
- [ ] Issues: 0 critical open

---

## 📚 RIFERIMENTI

### Documentazione Interna
- `docs/project/gsd-and-bmad-workflow.md`
- `docs/project/gsd-agent-coordination.md`
- `AGENTS.md`
- `QWEN.md`

### Risorse Esterne
- [GSD GitHub](https://github.com/gsd-build/get-shit-done)
- [GSD Docs](https://gsd-build-get-shit-done.mintlify.app/)
- [BMAD GitHub](https://github.com/bmad-code-org/BMAD-METHOD)
- [BMAD Docs](https://docs.bmad-method.org/)

---

**Ultimo Aggiornamento**: 2026-03-20  
**Stato**: ✅ IMPLEMENTATO  
**Prossima Review**: 2026-03-27
