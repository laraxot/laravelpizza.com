# PHPStan Analysis Pattern — Lock & Dispatch

**Data:** 2026-05-26

## Overview

PHPStan analysis è costoso (5-15 min per modulo). Per evitare duplicati:

1. ✅ **Controllare lock issue** prima di lanciare analisi
2. ✅ **Creare GitHub issue** come "lock" se non esiste
3. ✅ **Eseguire analisi** solo se lock confermato
4. ✅ **Aggiornare issue** con risultati
5. ✅ **Chiudere issue** quando fatto

---

## Processo

### Step 1: Identifica remote del modulo/tema

```bash
cd laravel/Modules/Xot
git remote -v

# Output:
# origin  git@github.com:laraxot/module_xot_fila5.git (fetch)
# origin  git@github.com:laraxot/module_xot_fila5.git (push)
```

### Step 2: Controlla se esiste issue di lock

```bash
# Sostituisci <owner>/<repo> con quello di git remote -v
gh issue list --repo laraxot/module_xot_fila5 --label "phpstan" --state open

# Output:
# ID   TITLE                          STATE  UPDATED
# 45   [LOCK] PHPStan Analysis v1.14   OPEN   2026-05-26
```

**Se esiste:** Leggi issue, attendi o commenta "running analysis now"  
**Se non esiste:** Crea nuova issue

### Step 3: Crea GitHub issue di lock

```bash
gh issue create \
  --repo laraxot/module_xot_fila5 \
  --title "[LOCK] PHPStan Analysis — XotModule (2026-05-26)" \
  --label "phpstan,automation" \
  --body "Analisi PHPStan in corso. Non lanciare di nuovo.

Repository: XotModule  
Branch: develop  
Inizio: $(date)  

Attendi completamento prima di nuove analisi."
```

### Step 4: Lancia PHPStan

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Xot --level=max --format=table > /tmp/xot-phpstan.txt

# Salva risultati in issue
gh issue comment <ISSUE_ID> --body "$(cat /tmp/xot-phpstan.txt)"
```

### Step 5: Chiudi issue e documenta

```bash
gh issue close <ISSUE_ID> \
  --repo laraxot/module_xot_fila5 \
  --comment "✅ Analisi completata. Vedi commenti per dettagli."
```

---

## Versione Migliorata: GitHub Action + Automation

Crea `.github/workflows/phpstan-analysis.yml` in ogni modulo:

```yaml
name: PHPStan Analysis

on:
  push:
    branches: [main, develop]
    paths:
      - 'app/**'
      - 'config/**'
      - 'routes/**'
  workflow_dispatch:  # Manual trigger

jobs:
  check-lock:
    runs-on: ubuntu-latest
    outputs:
      lock-issue-id: ${{ steps.check.outputs.issue-id }}
    
    steps:
      - name: Check for lock issue
        id: check
        run: |
          ISSUE=$(gh issue list --label phpstan --state open --json number --jq '.[0].number' 2>/dev/null || echo "")
          if [ -n "$ISSUE" ]; then
            echo "Lock issue exists: #$ISSUE"
            echo "issue-id=$ISSUE" >> $GITHUB_OUTPUT
            exit 1
          fi
        env:
          GH_TOKEN: ${{ secrets.GITHUB_TOKEN }}

  phpstan:
    needs: check-lock
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v4
      
      - name: Create lock issue
        id: create-lock
        run: |
          ISSUE=$(gh issue create \
            --title "[LOCK] PHPStan Analysis — $(date +%Y-%m-%d)" \
            --label phpstan,automation \
            --body "PHPStan in progress..." \
            --json number -q)
          echo "issue-id=$ISSUE" >> $GITHUB_OUTPUT
        env:
          GH_TOKEN: ${{ secrets.GITHUB_TOKEN }}

      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          
      - name: Install dependencies
        run: composer install --no-interaction
        working-directory: laravel

      - name: Run PHPStan
        id: analysis
        continue-on-error: true
        run: |
          cd laravel
          ./vendor/bin/phpstan analyse Modules/$(basename ${{ github.repository }}) \
            --level=max \
            --format=table > phpstan-results.txt
          cat phpstan-results.txt
          
      - name: Comment results
        run: |
          gh issue comment ${{ steps.create-lock.outputs.issue-id }} \
            --body "$(cat laravel/phpstan-results.txt)"
        env:
          GH_TOKEN: ${{ secrets.GITHUB_TOKEN }}

      - name: Close lock
        run: |
          gh issue close ${{ steps.create-lock.outputs.issue-id }} \
            --comment "✅ Analysis done"
        env:
          GH_TOKEN: ${{ secrets.GITHUB_TOKEN }}
```

---

## Istruzioni per AI Agents

Quando lanciate PHPStan analisi:

```bash
# 1. Controlla remote del modulo
git remote -v

# 2. Estrai owner/repo
OWNER=$(git remote get-url origin | sed 's/.*github.com[:/]\(.*\)\/.*/\1/')
REPO=$(git remote get-url origin | sed 's/.*\/\(.*\)\.git/\1/')

# 3. Controlla lock issue
gh issue list --repo $OWNER/$REPO --label phpstan --state open

# 4. Se non esiste, crea lock issue
if [ $(gh issue list --repo $OWNER/$REPO --label phpstan --state open --json number | wc -l) -eq 0 ]; then
  ISSUE=$(gh issue create --repo $OWNER/$REPO \
    --title "[LOCK] PHPStan Analysis — $(date +%Y-%m-%d)" \
    --label phpstan)
else
  echo "Lock issue exists, exit"
  exit 0
fi

# 5. Lancia analisi
cd laravel
./vendor/bin/phpstan analyse Modules/<ModuleName> --level=max --format=table

# 6. Chiudi lock
gh issue close $ISSUE --repo $OWNER/$REPO
```

---

## Benefits

- ✅ Zero duplicati di analisi
- ✅ Traccia cronologica di ogni run
- ✅ Auto-fail se analysis in progress
- ✅ Agenti collaborano senza conflitti
- ✅ Results documentati in GitHub

---

**Next:** Applica questo pattern su tutti i 50+ moduli/temi.
