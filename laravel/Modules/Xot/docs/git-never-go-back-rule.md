# Regola Git: Mai Tornare Indietro

## Principio Fondamentale del Progetto

Nel nostro workflow Git vige una regola assoluta e inviolabile:

> **NON si torna MAI a versioni precedenti del codice.**

## Cosa Significa

### ❌ Operazioni Vietate

Questi comandi/operazioni sono **sempre vietati**:

```bash
# Checkout di commit vecchi
git checkout <commit-hash>
git checkout HEAD~3

# Reset a commit precedenti  
git reset --hard <commit-hash>
git reset --soft HEAD~1

# Revert di commit
git revert <commit-hash>

# Restore da commit vecchi
git restore --source=<old-commit> file.php
```

### ✅ Approccio Corretto: Fix Forward

Qualsiasi errore si risolve **andando avanti**, mai indietro:

```bash
# 1. Identifica l'errore
# 2. Scrivi il fix
# 3. Committa in avanti

git add fixed-file.php
git commit -m "fix: corretto errore X introdotto in commit abc123"
git push
```

## Motivazioni

### 1. Tracciabilità e Audit
- **Storia completa**: Ogni errore e ogni correzione sono documentati
- **Audit trail**: Cronologia immutabile per compliance
- **Responsabilità**: Chi ha fatto cosa e quando

### 2. Sicurezza del Team
- **No conflitti**: Nessun rebase/reset che causa conflitti
- **No perdita lavoro**: Il lavoro degli altri è sempre preservato
- **Workflow prevedibile**: Tutti sanno cosa aspettarsi

### 3. Apprendimento
- **Pattern di errori**: Si vedono gli errori comuni e come vengono risolti
- **Debugging**: Storia completa aiuta a capire l'evoluzione del codice
- **Documentazione**: I commit sono documentazione vivente

### 4. Business Logic
- **Rollback controllato**: Si può sempre deployare una versione vecchia senza modificare Git
- **A/B Testing**: Versioni diverse possono coesistere
- **Compliance**: Nessuna "cancellazione" di storia

## Esempi Pratici

### Scenario 1: Ho Committato un Bug

```bash
# ❌ SBAGLIATO
git reset --hard HEAD~1

# ✅ CORRETTO
# 1. Trova il bug
# 2. Correggi
nano buggy-file.php
# 3. Committa fix
git add buggy-file.php
git commit -m "fix: corretto bug in calculateTotal()

Problema: calcolo errato per sconti >50%
Causa: condizione if invertita nel commit abc123
Fix: corretta condizione if
Test: aggiunti test per sconti edge cases"

git push
```

### Scenario 2: File Cancellato per Errore

```bash
# ❌ SBAGLIATO
git restore --source=HEAD~5 deleted-file.php

# ✅ CORRETTO
# 1. Recupera contenuto (da GitHub UI, backup, o memoria)
# 2. Ricrea file
cat > deleted-file.php << 'EOF'
<?php
// contenuto recuperato
EOF

# 3. Committa
git add deleted-file.php
git commit -m "fix: ripristinato deleted-file.php rimosso per errore

Riferimento: file rimosso nel commit xyz789
Contenuto: recuperato da backup/GitHub UI
Motivo rimozione: merge conflict mal gestito"

git push
```

### Scenario 3: Codice su Branch Sbagliato

```bash
# ❌ SBAGLIATO
git reset --hard origin/main

# ✅ CORRETTO
# 1. Lascia il commit dove sta
# 2. Crea nuovo branch dal punto corretto
git checkout -b feature-correct origin/main

# 3. Cherry-pick i commit buoni (se serve)
git cherry-pick <commit-hash>

# 4. Vai avanti
```

## Template Commit di Fix

Quando correggi un errore, usa questo template:

```
fix: <breve descrizione>

Problema: <cosa era sbagliato>
Causa: <perché era sbagliato>  
Fix: <come è stato corretto>
Riferimento: <commit che aveva l'errore>
Test: <come verificare>
```

Esempio:

```
fix: corretto import mancante in UserService

Problema: UserService non trovava UserRepository
Causa: import dimenticato dopo refactoring namespace
Fix: aggiunto use Modules\User\Repositories\UserRepository
Riferimento: commit abc123 (refactor namespace)
Test: PHPStan level 10 passa, UserServiceTest passa
```

## Eccezioni (Rarissime)

Le uniche situazioni dove è "accettabile" (con cautela):

### 1. Branch Locale Non Pushato

```bash
# OK solo se branch NON pushato e NON condiviso
git reset --soft HEAD~1
# Poi rifai commit corretto
```

### 2. Branch Feature Personale

```bash
# OK prima del push, per "pulire" storia
git rebase -i HEAD~3
```

**Importante**: Appena fai `git push`, quella storia diventa immutabile.

## Cosa Fare se Serve "Rollback"

Se il cliente/team chiede di "tornare alla versione precedente":

1. **Non modificare Git**: La storia resta intatta
2. **Deploy vecchia versione**: Usa CI/CD per deployare commit precedente
3. **Fix forward in parallelo**: Sul branch main, continua a lavorare al fix
4. **Deploy fix**: Quando pronto, deploy della versione corretta

## Checklist

Prima di ogni operazione Git "pericolosa":

- [ ] Sto per usare `git reset`? → STOP
- [ ] Sto per usare `git revert`? → STOP  
- [ ] Sto per fare checkout di vecchio commit? → STOP
- [ ] Posso risolvere con nuovo commit forward? → GO

## Collegamenti

- [.cursor/rules/git-never-go-back.mdc](../../../.cursor/rules/git-never-go-back.mdc)
- [Git Scripts](../../../bashscripts/git/)
- [Commit Conventions](../../docs/commit-conventions.md)

---

**Status**: REGOLA INVIOLABILE  
**Applicabilità**: Tutti i progetti, tutti i membri team  
**Eccezioni**: Solo branch locali non pushati  
**Ultimo aggiornamento**: 2 Dicembre 2025

⚠️ **Ricorda**: Forward fixes proteggono il lavoro di tutti. Non shortcuts!

