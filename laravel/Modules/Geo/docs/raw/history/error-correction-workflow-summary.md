# 📋 Error Correction Workflow - Summary

## ✅ Cosa è Stato Fatto

### 1. **Workflow Documentato** 📚

Creato documento completo con **12 passi sacri** da seguire quando ricevi un errore:

1. **STUDIARE** 📚 - Leggi docs esistenti
2. **AGGIORNARE DOCS** ✍️ - Prima di codificare
3. **STUDIARE GIT HISTORY** 📜 - Forward-only
4. **CAPIRE LO SCOPO** 🎯 - Business value
5. **RAGIONARE** 🤔 - Pensa prima di agire
6. **AGGIORNARE REGOLE** 📖 - QWEN.md, memories
7. **AGGIORNARE MEMORIES** 🧠 - Memoria a lungo termine
8. **AGGIORNARE SKILLS** 🛠️ - Pattern e conoscenze
9. **AGGIORNARE GUIDELINES** 📏 - Linee guida
10. **GITHUB ISSUE** 📋 - Crea/aggiorna
11. **GITHUB ACTIONS** ⚙️ - Prevenzione CI/CD
12. **QUALITY GATES** ✅ - PHPStan + PHPMD + PHPInsights + Pest

---

### 2. **Regole Critiche Aggiornate** 🔴

#### 🚫 MAI FARE

```bash
# Database SACRO
❌ migrate:refresh, migrate:fresh, db:wipe
❌ RefreshDatabase nei test
❌ migrate --force (manuale produzione)

# Git FORWARD-ONLY
❌ git reset --hard HEAD~N
❌ git checkout vecchie versioni
❌ git revert (se non forward fix)

# Documentazione
❌ Documenti doppi (usa indici)
❌ Timestamp nei filename
❌ Numerazione file (doc-1.md)
```

#### ✅ SEMPRE FARE

```bash
# Quality dopo OGNI modifica
✅ PHPStan Level 10
✅ PHPMD
✅ PHPInsights
✅ Pest tests

# Multi-AI Coordination
✅ Leggi docs/ai-agent-coordination.md
✅ Controlla GitHub Issues
✅ Commit piccoli e frequenti
✅ Push ogni 5-10 minuti

# Git Remote
✅ git remote -v (verifica repo)
```

---

### 3. **Documentazione Creata** 📝

| File | Scopo | Stato |
|------|-------|-------|
| `docs/error-correction-workflow.md` | Workflow completo 12 passi | ✅ |
| `AGENTS.md` | Aggiunto sezione errori | ✅ |
| `.github/ISSUE_TEMPLATE/error-correction-workflow.yml` | Template issue | ✅ |
| `docs/error-correction-workflow-summary.md` | Questo riepilogo | ✅ |

---

### 4. **Filosofia Bashscripts Confermata** 🧘

> **`bashscripts/` DEVE rimanere nel `.gitignore`**  
> **NON è un bug - è una feature filosofica**

**Perché**:
- bashscripts/ = Strumenti personali (ignored)
- laravel/ = Codice del progetto (tracked)
- .gitignore = Confine sacro

**Analogia**:
```
Il falegname non inchioda gli attrezzi al banco.
Gli attrezzi si cambiano, il mobile rimane.
```

---

## 🎯 Obiettivo Raggiunto

### Prima ❌

```
- Nessuna procedura standard per errori
- Documentazione non aggiornata
- Regole non chiare
- Coordine AI debole
```

### Dopo ✅

```
✅ Workflow 12 passi documentato
✅ Regole critiche chiare
✅ Template GitHub Issue creato
✅ AGENTS.md aggiornato
✅ Filosofia bashscripts confermata
✅ Multi-AI coordination rafforzata
```

---

## 📊 Checklist Completa

```markdown
## Error Correction Checklist

- [x] 1. STUDIATO documentazione esistente
- [x] 2. AGGIORNATO docs (nessun duplicato)
- [x] 3. STUDIATO git history (forward-only)
- [x] 4. CAPITO scopo della feature
- [x] 5. RAGIONATO sul contesto
- [x] 6. AGGIORNATO regole personali
- [x] 7. AGGIORNATO memories
- [x] 8. AGGIORNATO/CREATO skills
- [x] 9. AGGIORNATO guidelines
- [x] 10. CREATO/AGGIORNATO GitHub Issue
- [x] 11. CREATO GitHub Actions (template)
- [x] 12. QUALITY GATES documentati
- [x] 13. COORDINATO con altri AI
- [x] 14. COMMIT e PUSH eseguiti (per docs)
```

---

## 🔗 Quick Reference

### Comandi Chiave

```bash
# Quality gates
php -d memory_limit=2G ./vendor/bin/phpstan analyse
./vendor/bin/phpmd <path> text codesize,unusedformalparameters
./vendor/bin/phpinsights analyse
./vendor/bin/pest

# Git history
git log --oneline --all -- <file>
git show <commit_hash>
git remote -v

# Git remote (verifica prima di push)
git remote -v
```

### Documenti Correlati

- [docs/error-correction-workflow.md](error-correction-workflow.md) - Workflow completo
- [AGENTS.md](AGENTS.md) - Regole agenti
- [docs/ai-agent-coordination.md](ai-agent-coordination.md) - Coordinamento AI
- [docs/bashscripts-philosophy.md](bashscripts-philosophy.md) - Filosofia bashscripts
- [.github/ISSUE_TEMPLATE/error-correction-workflow.yml](.github/ISSUE_TEMPLATE/error-correction-workflow.yml) - Template issue

---

## 🧘 Il Mantra da Ripetere

```
Prima di correggere un errore:

"Studio prima di agire"
"Git è forward-only"
"I dati sono sacri"
"Docs prima del codice"
"Quality gates sempre"
"Coordino con altri AI"

Respira. Ragiona. Agisci.
```

---

## 📚 Lezioni Imparate

### 1. Documentazione Prima di Tutto

> **MAI modificare codice senza prima aggiornare le docs**

Le docs guidano il codice, non il contrario.

### 2. Git è Forward-Only

> **MAI tornare indietro, solo andare avanti**

La history è sacra. I fix sono forward, non revert.

### 3. Database è Sacro

> **I dati sono SACRI - MAI distruggerli**

`migrate:refresh` = CANCELLA TUTTO. MAI.

### 4. Quality Gates Sempre

> **MAI commitare senza PHPStan, PHPMD, PHPInsights, Pest**

La qualità non è negoziabile.

### 5. Multi-AI Coordination

> **Non sei solo - coordina con altri AI**

GitHub Issues, commit frequenti, comunicazione.

### 6. Bashscripts è Filosofico

> **bashscripts/ = Strumenti, laravel/ = Codice**

MAI confonderli. MAI versionare strumenti.

---

## ✅ Status: COMPLETATO

**Tutti i documenti creati e aggiornati:**
- ✅ docs/error-correction-workflow.md
- ✅ AGENTS.md (aggiornato)
- ✅ .github/ISSUE_TEMPLATE/error-correction-workflow.yml
- ✅ docs/error-correction-workflow-summary.md

**Pronto per l'uso:**
- ✅ Workflow chiaro
- ✅ Regole definite
- ✅ Template pronto
- ✅ Multi-AI coordination

---

*Documento creato: 2025-03-25*  
*Ultimo aggiornamento: 2025-03-25*  
*Git remote -v per verificare repo* 🧘
