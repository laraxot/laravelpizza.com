# REGOLA CRITICA: Posizione Scripts

**Priority**: 🔴 MANDATORY  
**Scope**: All scripts in project  
**Updated**: 2025-01-02

---

## 📜 LA REGOLA

**TUTTI gli script** (.sh, .php, .py, .js, etc.) DEVONO essere posizionati in:

```
/var/www/_bases/base_ptvx_fila5_mono/bashscripts/{categoria}/
```

**MAI** in:
- ❌ `laravel/`
- ❌ `docs/`
- ❌ `Modules/`
- ❌ Root (except README)

---

## 🗂️ Categorie

| Directory | Purpose | Examples |
|-----------|---------|----------|
| `analysis/` | Code analysis | analyze_modules.sh, find_duplicates.php |
| `quality-assurance/` | QA tools | run_phpstan.sh, run_phpmd.sh |
| `git/` | Git operations | sync_subtree.sh, resolve_conflicts.sh |
| `database/` | DB operations | seed_data.php, backup_db.sh, migrate.sh |
| `maintenance/` | Maintenance | cleanup.sh, optimize.sh, cron_tasks.sh |
| `utilities/` | General utils | monitor.sh, report.sh, log_parser.py |
| `testing/` | Test automation | run_tests.sh, coverage_report.sh |
| `fix/` | Automated fixes | fix_phpstan.php, fix_formatting.sh |
| `deployment/` | Deploy tasks | deploy_staging.sh, deploy_prod.sh |
| `documentation/` | Doc automation | generate_docs.sh, sync_docs.py |

---

## ✅ Come Creare Uno Script

### 1. Identifica Categoria

```
Cosa fa lo script?
├── Analizza codice? → analysis/
├── Check qualità? → quality-assurance/
├── Operazione DB? → database/{seeding|migration|backup}/
├── Manutenzione? → maintenance/{cleanup|optimization}/
├── Fix automatico? → fix/
├── Test? → testing/
└── Altro? → utilities/
```

### 2. Crea nella Categoria Giusta

```bash
# Crea script
nano /var/www/_bases/base_ptvx_fila5_mono/bashscripts/analysis/my_script.sh

# Rendi eseguibile
chmod +x /var/www/_bases/base_ptvx_fila5_mono/bashscripts/analysis/my_script.sh
```

### 3. Documenta

```bash
# Aggiungi alla documentazione categoria
echo "## my_script.sh - Description" >> bashscripts/analysis/README.md
```

### 4. Se Serve Link da Laravel

```bash
# Crea wrapper (SOLO se necessario)
cat > laravel/run_analysis.sh << 'EOF'
#!/bin/bash
../bashscripts/analysis/my_script.sh "$@"
EOF
chmod +x laravel/run_analysis.sh
```

---

## ⚠️ Enforcement

### Pre-commit Check

```bash
# Script di verifica
#!/bin/bash

VIOLATIONS=$(find laravel/ docs/ Modules/ -maxdepth 2 \
    \( -name "*.sh" -o -name "*.py" \) \
    -not -path "*/vendor/*" \
    -not -path "*/node_modules/*")

if [ -n "$VIOLATIONS" ]; then
    echo "❌ Scripts in wrong location:"
    echo "$VIOLATIONS"
    echo "Move to: bashscripts/{category}/"
    exit 1
fi
```

### CI/CD Check

```yaml
# .gitlab-ci.yml or github workflow
check-scripts-location:
  script:
    - |
      if find laravel/ docs/ -name "*.sh" -o -name "*.py" | grep -v vendor; then
        echo "ERROR: Scripts in wrong location!"
        exit 1
      fi
```

---

## 📚 Riferimenti

- [bashscripts/README.md](../../bashscripts/README.md) - Complete guide
- [.cursor/rules/scripts-location-mandatory.mdc](../../.cursor/rules/scripts-location-mandatory.mdc)
- [docs/BASHSCRIPTS_ORGANIZATION_RULE.md](../BASHSCRIPTS_ORGANIZATION_RULE.md)

---

## 🎯 Quick Reference

```bash
# ✅ CORRECT
bashscripts/analysis/script.sh
bashscripts/quality-assurance/phpstan.sh
bashscripts/database/seeding/seed.php

# ❌ WRONG
laravel/script.sh
docs/fix.sh
Modules/Rating/analyze.sh
```

---

**Remember**: Scripts in `bashscripts/{category}/` - SEMPRE!


