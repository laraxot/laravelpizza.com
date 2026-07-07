# 🔄 Sync .github with bashscripts/ai/.github

> **Last Updated**: 2026-03-13  
> **Status**: ✅ Active  
> **Rule**: CRITICAL

---

## 🎯 Rule Statement

**QUANDO aggiorni `.github/` → DEVI sincronizzare `bashscripts/ai/.github/`**

---

## 📋 Why

1. **bashscripts/ è nel .gitignore**
   - Il repository principale ignora tutta la cartella `bashscripts/`
   - I file `.github/` dentro bashscripts NON vengono commitati automaticamente
   - Devi copiare manualmente i file

2. **Consistenza**
   - Stessi workflow in entrambi i posti
   - Stesse configurazioni
   - Stessi template

3. **Multi-Agent Collaboration**
   - Altri agenti AI lavorano su bashscripts
   - Devono avere gli stessi workflow
   - Documentazione centralizzata

---

## 🔧 How To Sync

### Manual Sync (Every Time)

```bash
# After updating .github/workflows/
cd /var/www/_bases/base_fixcity_fila5

# Create directory if needed
mkdir -p bashscripts/ai/.github/workflows

# Copy workflow files
cp .github/workflows/*.yml bashscripts/ai/.github/workflows/

# Copy other files
cp .github/*.md bashscripts/ai/.github/
cp .github/*.yml bashscripts/ai/.github/

# Document the sync
echo "Synced .github with bashscripts/ai/.github on $(date)" >> bashscripts/ai/.github/SYNC_LOG.md
```

---

## 📝 Files to Sync

### Always Sync

| Source | Destination | Purpose |
|--------|-------------|---------|
| `.github/workflows/*.yml` | `bashscripts/ai/.github/workflows/` | All workflows |
| `.github/CONTRIBUTING.md` | `bashscripts/ai/.github/` | Contribution guide |
| `.github/pull_request_template.md` | `bashscripts/ai/.github/` | PR template |
| `.github/dependabot.yml` | `bashscripts/ai/.github/` | Dependabot config |
| `.github/security.md` | `bashscripts/ai/.github/` | Security policy |

---

## 🚨 Common Mistakes

### ❌ WRONG

```bash
# Update .github/workflows/sync-remote-repo.yml
# Commit and push
# FORGET to sync bashscripts/ai/.github/
```

### ✅ RIGHT

```bash
# Update .github/workflows/sync-remote-repo.yml
# Copy to bashscripts/ai/.github/workflows/
# Document the sync
# Commit and push
```

---

## 📚 Documentation Requirements

### Create SYNC_LOG.md

**Location**: `bashscripts/ai/.github/SYNC_LOG.md`

**Format**:
```markdown
# .github Sync Log

| Date | Action | Files Synced | Agent |
|------|--------|--------------|-------|
| 2026-03-13 | Initial sync | All workflows | @marco76tv |
| 2026-03-13 | Update sync-remote-repo.yml | sync-remote-repo.yml | @marco76tv |
```

---

## 🤖 Multi-Agent Rule

**ALL AI AGENTS MUST**:

1. ✅ Sync .github with bashscripts/ai/.github
2. ✅ Document the sync in SYNC_LOG.md
3. ✅ Verify both locations have same files
4. ✅ Commit both locations together

---

## 🔍 Verification Commands

```bash
# Check if files are in sync
diff .github/workflows/sync-remote-repo.yml bashscripts/ai/.github/workflows/sync-remote-repo.yml

# List all workflows in both locations
echo "=== .github/workflows ==="
ls -la .github/workflows/

echo "=== bashscripts/ai/.github/workflows ==="
ls -la bashscripts/ai/.github/workflows/
```

---

## 📊 Current Status

| File | .github | bashscripts/ai/.github | Status |
|------|---------|------------------------|--------|
| sync-remote-repo.yml | ✅ | ✅ | ✅ Synced |
| sync-subtrees.yml | ✅ | ✅ | ✅ Synced |
| semantic-versioning.yml | ✅ | ✅ | ✅ Synced |
| ci.yml | ✅ | ❌ | ⚠️ To Sync |
| comprehensive-quality.yml | ✅ | ❌ | ⚠️ To Sync |

---

## 🎯 Best Practices

### Before Commit

1. ✅ Updated .github workflows?
2. ✅ Copied to bashscripts/ai/.github?
3. ✅ Updated SYNC_LOG.md?
4. ✅ Verified both locations?

### After Commit

1. ✅ Check GitHub Actions
2. ✅ Verify workflows run
3. ✅ Update documentation

---

**Rule Created**: 2026-03-13  
**Reason**: bashscripts/ is in .gitignore  
**Applies To**: All AI agents working on .github
