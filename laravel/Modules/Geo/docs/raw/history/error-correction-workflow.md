# 🚨 ERROR CORRECTION WORKFLOW - Regola Sacra

> **QUANDO RICEVI UN ERRORE DA CORREGGERE**  
> **SEGUITI QUESTI 12 PASSI IN ORDINE**  
> **MAI SALTARE NESSUNO**

---

## 📋 I 12 Passi Sacri

### 1️⃣ **STUDIARE** 📚

```bash
# Leggi la documentazione esistente
find docs/ -name "*.md" -type f | xargs grep -l "errore_correlato"
find Modules/*/docs/ -name "*.md" -type f | xargs grep -l "argomento"
find Themes/*/docs/ -name "*.md" -type f | xargs grep -l "argomento"

# Usa indici per evitare documenti doppi
cat docs/README.md
cat Modules/Xot/docs/README.md
```

**Regola**: MAI creare documenti doppi. Usa/aggiorna indici esistenti.

---

### 2️⃣ **AGGIORNARE DOCS** ✍️

```bash
# Prima di modificare codice, aggiorna docs
# Cerca se esiste già documentazione
grep -r "argomento" docs/ Modules/*/docs/ Themes/*/docs/

# Se esiste: AGGIORNA
# Se non esiste: CREA (con naming kebab-case)
```

**Naming**: `lowercase-kebab-case.md` (MAI `CamelCase.md` o `UPPERCASE.md`)

---

### 3️⃣ **STUDIARE GIT HISTORY** 📜

```bash
# Git è FORWARD-ONLY
git log --oneline --all -- <file_correlato>
git log --all --source --full-history -- <file_correlato>
git show <commit_hash>

# MAI fare:
# ❌ git reset --hard HEAD~N
# ❌ git revert (se non per forward fixes)
# ❌ checkout vecchie versioni
```

**Filosofia**: Git traccia evoluzione, non si torna indietro.

---

### 4️⃣ **CAPIRE LO SCOPO** 🎯

```bash
# Chiediti:
# - A cosa serve questa cosa?
# - Qual è il business value?
# - Chi la usa?
# - Perché è stata creata?

# Studia il contesto
git blame <file>
git log -p --follow <file>
```

---

### 5️⃣ **RAGIONARE** 🤔

```
PRIMA DI AGIRE:

1. Ho studiato abbastanza?
2. Ho capito lo scopo?
3. Ho visto la history?
4. Ho aggiornato le docs?
5. Ho coordinato con altri AI?

SE TUTTE LE RISPOSTE SONO SÌ → PROCED
```

---

### 6️⃣ **AGGIORNARE REGOLE PERSONALI** 📖

```bash
# Aggiorna le tue conoscenze:
# - QWEN.md (regole personali)
# - docs/rules/ (regole progetto)
# - docs/best-practices/ (linee guida)

# Esempio:
echo "
## Regola Appresa: <data>
<descrizione regola>
" >> QWEN.md
```

---

### 7️⃣ **AGGIORNARE MEMORIES** 🧠

```bash
# Memoria a lungo termine:
# - ~/.qwen/QWEN.md (globale)
# - QWEN.md (progetto)
# - _bmad/_memory/ (BMAD)

# Esempio:
cat >> ~/.qwen/QWEN.md << 'EOF'
## Error Correction Workflow
Quando ricevo errore:
1. Studio docs
2. Studio git history
3. Capisco scopo
4. Ragiono
5. Aggiorno regole
6. Coordino AI
7. Implemento
8. Quality gates
EOF
```

---

### 8️⃣ **AGGIORNARE SKILLS** 🛠️

```bash
# Se l'errore rivela una skill mancante:
# 1. Crea skill in _bmad/core/skills/
# 2. Oppure aggiorna skill esistente
# 3. Documenta pattern

# Esempio:
cat > _bmad/core/skills/error-correction-pattern.md << 'EOF'
# Error Correction Pattern

## Quando usare
Quando ricevi errore da correggere

## Passi
1. Studiare docs
2. ...
EOF
```

---

### 9️⃣ **AGGIORNARE GUIDELINES** 📏

```bash
# Linee guida progetto:
# - docs/ai-guidelines.md
# - docs/best-practices/
# - AGENTS.md

# Aggiungi lezione appresa:
cat >> docs/ai-guidelines.md << 'EOF'

## Error Correction Lezione: <data>
<descrizione>
EOF
```

---

### 🔟 **CREARE/AGGIORNARE GITHUB ISSUE** 📋

```bash
# Ogni errore = GitHub Issue
gh issue create \
  --title "Bug: <descrizione breve>" \
  --body "## Errore\n<descrizione>\n\n## Causa\n<causa>\n\n## Soluzione\n<soluzione>" \
  --label "bug" \
  --assignme "@me"

# Oppure aggiorna issue esistente
gh issue comment <number> --body "Update: <dettagli>"
```

---

### 1️⃣1️⃣ **CREARE GITHUB ACTIONS** ⚙️

```bash
# Se l'errore può essere prevenuto con CI:
# 1. Crea workflow in .github/workflows/
# 2. Aggiungi check automatici
# 3. Documenta in docs/ci/

# Esempio:
cat > .github/workflows/prevent-<errore>.yml << 'EOF'
name: Prevent <Errore>
on: [push, pull_request]
jobs:
  check:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v5
      - name: Check <cosa>
        run: <comando>
EOF
```

---

### 1️⃣2️⃣ **QUALITY GATES** ✅

```bash
# DOPO OGNI MODIFICA:

# 1. PHPStan Level 10
php -d memory_limit=2G ./vendor/bin/phpstan analyse --level=max

# 2. PHPMD (Mess Detection)
./vendor/bin/phpmd <path> text codesize,unusedformalparameters

# 3. PHPInsights (Quality metrics)
./vendor/bin/phpinsights analyse

# 4. Pest (Tests)
./vendor/bin/pest

# MAI COMMITTARE SE QUALCUNO FALLISCE!
```

---

## 🔴 REGOLE CRITICHE

### 🚫 MAI FARE

```bash
# Database SACRO
❌ php artisan migrate:refresh
❌ php artisan migrate:fresh
❌ php artisan db:wipe
❌ RefreshDatabase trait nei test
❌ migrate --force (manuale in produzione)

# Git FORWARD-ONLY
❌ git reset --hard HEAD~N
❌ git checkout <old_commit>
❌ git revert (se non forward fix)

# Documentazione
❌ Creare documenti doppi
❌ Usare timestamp nei filename
❌ Numerare file (doc-1.md, doc-2.md)
```

### ✅ SEMPRE FARE

```bash
# Database
✅ php artisan migrate (solo avanti)
✅ DatabaseTransactions nei test
✅ Backup prima di modifiche schema

# Git
✅ Commit atomici e frequenti
✅ Push ogni 5-10 minuti
✅ Messaggi descrittivi

# Documentazione
✅ Aggiornare prima di codificare
✅ Usare indici esistenti
✅ Naming kebab-case

# Quality
✅ PHPStan Level 10
✅ PHPMD
✅ PHPInsights
✅ Pest tests
```

---

## 🤖 MULTI-AI COORDINATION

### Regole di Coordinamento

```markdown
1. **Prima di agire**:
   - Leggi docs/ai-agent-coordination.md
   - Controlla GitHub Issues aperte
   - Verifica file lock

2. **Durante lavoro**:
   - Commit piccoli e frequenti
   - Push ogni 5-10 minuti
   - Comunica su GitHub Issues

3. **Dopo lavoro**:
   - Quality gates SEMPRE
   - Aggiorna coordination doc
   - Commenta GitHub Issue
```

### Git Remote Check

```bash
# Prima di pushare, verifica remote
git remote -v

# Deve puntare a:
# - origin = repo principale
# - MAI pushare su repo sbagliate!
```

---

## 📊 CHECKLIST COMPLETA

```markdown
## Error Correction Checklist

- [ ] 1. STUDIATO documentazione esistente
- [ ] 2. AGGIORNATO docs (nessun duplicato)
- [ ] 3. STUDIATO git history (forward-only)
- [ ] 4. CAPITO scopo della feature
- [ ] 5. RAGIONATO sul contesto
- [ ] 6. AGGIORNATO regole personali
- [ ] 7. AGGIORNATO memories
- [ ] 8. AGGIORNATO/CREATO skills
- [ ] 9. AGGIORNATO guidelines
- [ ] 10. CREATO/AGGIORNATO GitHub Issue
- [ ] 11. CREATO GitHub Actions (se necessario)
- [ ] 12. QUALITY GATES passati:
  - [ ] PHPStan Level 10
  - [ ] PHPMD
  - [ ] PHPInsights
  - [ ] Pest tests
- [ ] 13. COORDINATO con altri AI
- [ ] 14. COMMIT e PUSH eseguiti
```

---

## 🧘 MEDITAZIONE QUOTIDIANA

```
Prima di correggere un errore, ripeti:

"Studio prima di agire"
"Git è forward-only"
"I dati sono sacri"
"Docs prima del codice"
"Quality gates sempre"
"Coordino con altri AI"

Respira. Ragiona. Agisci.
```

---

## 📚 RIFERIMENTI

- [docs/ai-agent-coordination.md](docs/ai-agent-coordination.md)
- [AGENTS.md](AGENTS.md)
- [docs/bashscripts-philosophy.md](docs/bashscripts-philosophy.md)
- [laravel/Modules/Activity/docs/errori/MAI_FARE_MIGRATE_REFRESH.md](laravel/Modules/Activity/docs/errori/MAI_FARE_MIGRATE_REFRESH.md)
- [docs/database/migrations-philosophy.md](docs/database/migrations-philosophy.md)

---

*Questo documento è SACRO. Violazioni = Errori gravi.*  
*Ultimo aggiornamento: 2025-03-25*  
*Git remote -v per verificare repo*
