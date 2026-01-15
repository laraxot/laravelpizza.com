# Gestione Avanzata dei Conflitti Git

## Approccio Sicuro alla Risoluzione dei Conflitti

### 1. Strategie di Prevenzione

```bash

# Pre-commit hook per verificare conflitti potenziali
git diff --check

# Aggiornamento regolare del branch
git fetch origin
git rebase origin/main

# Verifica dello stato prima del merge
git status
git diff origin/main...HEAD
```

### 2. Risoluzione Intelligente

#### Metodo 1: Merge con Strategy
```bash

# Usa strategie di merge avanzate
git merge -X ours feature_branch    # Preferisci il branch corrente
git merge -X theirs feature_branch  # Preferisci il branch remoto
```

#### Metodo 2: Rebase Interattivo
```bash

# Riorganizza i commit per evitare conflitti
git rebase -i origin/main

# Opzioni disponibili:

# pick   - mantieni il commit

# edit   - modifica il commit

# pick   - mantieni il commit

# edit   - modifica il commit

# squash - unisci con il commit precedente
```

#### Metodo 3: Stash e Apply
```bash

# Salva le modifiche locali
git stash save "modifiche_importanti"

# Aggiorna il branch
git pull --rebase origin main

# Riapplica le modifiche
git stash pop
```

### 3. Strumenti di Merge

1. **Git Mergetool**
```bash

# Configura il tool preferito
git config --global merge.tool vscode

# Usa il mergetool
git mergetool
```

2. **Visual Studio Code**
```json
// settings.json
{
  "merge-conflict.autoNavigateNextConflict.enabled": true,
  "merge-conflict.codeLens.enabled": true
}
```

3. **PhpStorm**
```bash

# Usa il merge tool integrato
Tools -> Git -> Resolve Conflicts
```

### 4. Script di Automazione

```bash
#!/bin/bash

resolve_conflicts() {
    local branch=$1
    local strategy=${2:-"ours"}
    
    # Backup del branch corrente
    git branch "backup/$(date +%Y%m%d_%H%M%S)"
    
    # Merge con strategia specificata
    if [[ "$strategy" == "ours" ]]; then
        git merge -X ours "$branch"
    else
        git merge -X theirs "$branch"
    fi
    
    # Verifica risultato
    if git status | grep -q "conflict"; then
        echo "Risoluzione automatica fallita, necessario intervento manuale"
        return 1
    fi
    
    return 0
}

safe_merge() {
    local branch=$1
    
    # Verifica stato working directory
    if ! git diff-index --quiet HEAD --; then
        echo "Working directory non pulita. Commit o stash le modifiche."
        return 1
    fi
    
    # Backup
    git branch "backup/$(date +%Y%m%d_%H%M%S)"
    
    # Merge
    if ! git merge "$branch"; then
        echo "Conflitto rilevato, ripristino stato precedente"
        git merge --abort
        return 1
    fi
    
    return 0
}
```

### 5. Best Practices

1. **Prima del Merge**
   - Backup del branch corrente
   - Verifica dello stato Git
   - Pull delle ultime modifiche

2. **Durante il Merge**
   - Usa strumenti visuali
   - Verifica file per file
   - Mantieni la logica di business

3. **Dopo il Merge**
   - Test completi
   - Code review
   - Verifica funzionalità

### 6. Comandi Utili

```bash

# Verifica branch e modifiche
git branch -vv
git status -s

# Diff intelligente
git diff --word-diff
git diff --color-words

# Log grafico
git log --graph --oneline --all
```

### 7. Configurazione Git

```bash

# Configurazione globale
git config --global merge.conflictstyle diff3
git config --global merge.tool vscode
git config --global mergetool.keepBackup false

# Alias utili
git config --global alias.conflicts 'diff --name-only --diff-filter=U'
git config --global alias.ours '!f() { git checkout --ours "$@" && git add "$@"; }; f'
git config --global alias.theirs '!f() { git checkout --theirs "$@" && git add "$@"; }; f'
```

### 8. Prevenzione

1. **Organizzazione del Codice**
   - Moduli indipendenti
   - Interfacce chiare
   - Dependency injection

2. **Workflow Git**
   - Feature branch
   - Pull request
   - Code review

3. **Comunicazione**
   - Documentazione aggiornata
   - Standup meeting
   - Pair programming

### Note Importanti

1. Mai usare force push su branch condivisi
2. Mantenere commit atomici e descrittivi
3. Usare tag per le release
4. Documentare le decisioni di merge
5. Testare dopo ogni risoluzione 
