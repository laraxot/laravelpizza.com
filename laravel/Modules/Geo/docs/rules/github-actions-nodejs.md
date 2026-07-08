# GitHub Actions Node.js Version Rule

> **Regola: Usare sempre Node.js 24 per GitHub Actions**
> 
> **Status:** Active
> **Last Updated:** 2026-03-13
> **Owner:** AI Development Team

---

## Regola Generale

**Tutti i workflow GitHub Actions devono usare Node.js 24** per evitare warning di deprecazione di Node.js 20.

### Context

GitHub ha deprecato Node.js 20. Dal 2 Giugno 2026, tutte le actions dovranno usare Node.js 24.

---

## Implementazione

### Workflow Configuration

```yaml
# ✅ CORRETTO - Node.js 24
name: My Workflow

on:
  push:
    branches: [main]

# Forza uso di Node.js 24
env:
  FORCE_JAVASCRIPT_ACTIONS_TO_NODE24: 'true'

jobs:
  my-job:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v5      # ✅ v5 supporta Node.js 24
      - uses: actions/upload-artifact@v5  # ✅ v5 supporta Node.js 24
      - uses: actions/github-script@v8  # ✅ v8 supporta Node.js 24
```

### Versioni Raccomandate

| Action | Versione Minima | Note |
|--------|----------------|------|
| `actions/checkout` | @v5 | ✅ Supporta Node.js 24 |
| `actions/upload-artifact` | @v5 | ✅ Supporta Node.js 24 |
| `actions/download-artifact` | @v5 | ✅ Supporta Node.js 24 |
| `actions/github-script` | @v8 | ✅ Supporta Node.js 24 |
| `actions/setup-node` | @v4 | ✅ Supporta Node.js 24 |
| `actions/cache` | @v4 | ✅ Supporta Node.js 24 |

### Environment Variable

```yaml
# Aggiungere SEMPRE in tutti i workflow
env:
  FORCE_JAVASCRIPT_ACTIONS_TO_NODE24: 'true'
```

Questo forza l'uso di Node.js 24 per tutte le JavaScript actions.

---

## Before/After

### ❌ SBAGLIATO (Node.js 20 - Deprecated)

```yaml
name: Old Workflow

jobs:
  my-job:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4      # ❌ Node.js 20
      - uses: actions/upload-artifact@v4  # ❌ Node.js 20
      - uses: actions/github-script@v7  # ❌ Node.js 20
```

**Warning:**
```
Node.js 20 actions are deprecated. The following actions are running on Node.js 20...
```

### ✅ CORRETTO (Node.js 24)

```yaml
name: Updated Workflow

env:
  FORCE_JAVASCRIPT_ACTIONS_TO_NODE24: 'true'

jobs:
  my-job:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v5      # ✅ Node.js 24
      - uses: actions/upload-artifact@v5  # ✅ Node.js 24
      - uses: actions/github-script@v8  # ✅ Node.js 24
```

**Result:** No warnings! 🎉

---

## Migration Guide

### Step 1: Add Environment Variable

```yaml
# In cima al workflow file
env:
  FORCE_JAVASCRIPT_ACTIONS_TO_NODE24: 'true'
```

### Step 2: Update Action Versions

```bash
# Cerca e sostituisci:
actions/checkout@v4      → actions/checkout@v5
actions/upload-artifact@v4 → actions/upload-artifact@v5
actions/github-script@v7 → actions/github-script@v8
```

### Step 3: Test Workflow

```bash
# Trigger manuale
gh workflow run my-workflow.yml

# Verifica logs
gh run view <run-id> --log

# Cerca warning
gh run view <run-id> --log | grep -i "node.js"
```

---

## Checklist Aggiornamento

Prima di commitare un workflow:

- [ ] Aggiunto `FORCE_JAVASCRIPT_ACTIONS_TO_NODE24: 'true'`
- [ ] Tutte le actions usano versioni compatibili con Node.js 24
- [ ] Testato con `gh workflow run`
- [ ] Verificato nessun warning nei logs
- [ ] Documentato in AGENTS.md

---

## Riferimenti

### GitHub Documentation

- [Node.js 20 Deprecation](https://github.blog/changelog/2025-09-19-deprecation-of-node-20-on-github-actions-runners/)
- [GitHub Actions Versions](https://github.com/actions)

### Related Files

- [sync-remote-repo.yml](../.github/workflows/sync-remote-repo.yml) - Example workflow

---

*Ultimo aggiornamento: 2026-03-13*
