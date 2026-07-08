# Copy Files Cleanup Convention

> **Regola per Gestione File "copy" e Duplicati Temporanei**
> 
> **Status:** Active
> **Last Updated:** 2026-03-13
> **Owner:** Development Team

---

## Problema

I file con suffisso ` copy` o `.copy` sono duplicati temporanei creati da editor o operazioni di copia-incolla. Questi file:

- ❌ Non dovrebbero mai essere committati
- ❌ Creano confusione nel codice
- ❌ Occupano spazio inutilmente
- ❌ Possono causare conflitti di namespace

### Esempi di File da Evitare

```
❌ .gitattributes copy
❌ .gitconfig copy
❌ file.php copy
❌ backup.copy
```

---

## Regola Generale

**I file "copy" devono essere:**

1. **Aggiunti al `.gitignore`** - Sia nella root che nei moduli
2. **Eliminati immediatamente** - Dopo l'uso o se non servono
3. **Mai committati** - Anche se sembrano utili

---

## Pattern .gitignore

### Root Project (.gitignore)

```gitignore
# Copy files (duplicati temporanei)
* copy
* copy.*
*.copy
*~
```

### Module .gitignore

```gitignore
# Copy files (duplicati temporanei)
* copy
* copy.*
*.copy
*~
```

---

## Cleanup Effettuato

### File Rimossi (2026-03-13)

| File | Modulo | Status |
|------|--------|--------|
| `.gitattributes copy` | Xot | ✅ Rimosso |
| `.gitconfig copy` | Badge | ✅ Rimosso |
| `.gitconfig copy` | ContoAnnuale | ✅ Rimosso |
| `.gitconfig copy` | Inail | ✅ Rimosso |
| `.gitconfig copy` | Incentivi | ✅ Rimosso |
| `.gitconfig copy` | IndennitaResponsabilita | ✅ Rimosso |
| `.gitconfig copy` | Legge104 | ✅ Rimosso |
| `.gitconfig copy` | Legge109 | ✅ Rimosso |
| `.gitconfig copy` | Mensa | ✅ Rimosso |
| `.gitconfig copy` | MobilitaVolontaria | ✅ Rimosso |
| `.gitconfig copy` | Performance | ✅ Rimosso |
| `.gitconfig copy` | PresenzeAssenze | ✅ Rimosso |
| `.gitconfig copy` | Progressioni | ✅ Rimosso |
| `.gitconfig copy` | Ptv | ✅ Rimosso |
| `.gitconfig copy` | Questionari | ✅ Rimosso |
| `.gitconfig copy` | Sigma | ✅ Rimosso |
| `.gitconfig copy` | Sindacati | ✅ Rimosso |

**Totale:** 17 file rimossi

---

## Best Practices

### Quando fai copia-incolla:

1. **Immediatamente dopo:**
   ```bash
   # Rinomina il file correttamente
   mv "file.php copy" file_new.php
   
   # Oppure rimuovi se non serve
   rm "file.php copy"
   ```

2. **Prima di commit:**
   ```bash
   # Verifica file temporanei
   git status
   
   # Cerca file copy
   find . -name "* copy" -type f
   ```

3. **Automatizza:**
   - I pattern sono già nel `.gitignore`
   - Git non dovrebbe vederli mai

---

## Comandi Utili

### Trovare file copy

```bash
# Trovare tutti i file copy
find . -name "* copy" -type f

# Trovare e contare
find laravel/Modules -name "* copy" -type f | wc -l
```

### Rimuovere file copy

```bash
# Rimuovere tutti i file copy (dry-run)
find . -name "* copy" -type f -echo

# Rimuovere davvero
find . -name "* copy" -type f -delete
```

### Verificare .gitignore

```bash
# Verificare se un file è ignorato
git check-ignore -v "file.php copy"
```

---

## Perché Succede

I file "copy" sono creati da:

1. **Copy-paste negli editor** - VS Code, Finder, Explorer
2. **Download duplicati** - Browser aggiunge "copy" ai nomi
3. **Merge conflict** - Alcuni tool creano file "copy"
4. **Backup manuali** - Utenti creano copie temporanee

---

## Alternative Corrette

### Invece di file copy, usa:

1. **Git branching:**
   ```bash
   git checkout -b feature/new-version
   ```

2. **File versioning:**
   ```
   config.v1.php
   config.v2.php
   ```

3. **Git stash:**
   ```bash
   git stash push -m "WIP config changes"
   ```

4. **Backup temporanei (fuori dal repo):**
   ```bash
   cp file.php /tmp/file.php.backup
   ```

---

## Violazioni Comuni

### ❌ SBAGLIATO

```bash
# Committare file copy
git add ".gitattributes copy"
git commit -m "Add config copy"
```

### ✅ CORRETTO

```bash
# Rinominare o rimuovere
mv ".gitattributes copy" .gitattributes.new
# Oppure
rm ".gitattributes copy"
```

---

## Riferimenti

### Documenti Correlati

- [Workspace Naming Convention](conventions/workspace-naming.md)
- [Module Folder Structure](conventions/module-folder-structure.md)
- [AGENTS.md](../../AGENTS.md)

### Git Documentation

- [Git Ignore](https://git-scm.com/docs/gitignore)
- [Git Check Ignore](https://git-scm.com/docs/git-check-ignore)

---

## Checklist Pulizia

Prima di ogni commit:

- [ ] Nessun file `* copy` presente
- [ ] Nessun file `*.copy` presente
- [ ] Nessun file `*~` presente
- [ ] `.gitignore` aggiornato
- [ ] `git status` pulito

---

*Ultimo aggiornamento: 2026-03-13*
