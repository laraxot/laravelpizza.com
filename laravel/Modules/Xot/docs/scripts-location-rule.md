# Scripts Location Rule - Xot Module

**Rule**: Scripts MUST be in bashscripts/ directory  
**Scope**: All modules  
**Priority**: 🔴 MANDATORY

---

## 🚨 The Rule

ALL scripts (.sh, .php, .py, etc.) MUST be placed in:

```
/var/www/_bases/base_ptvx_fila4_mono/bashscripts/{category}/
```

NEVER in:
- ❌ `laravel/` directory
- ❌ `Modules/*/` directories  
- ❌ `docs/` directory

---

## 📂 Categories

- `analysis/` - Code analysis
- `quality-assurance/` - PHPStan, PHPMD, etc.
- `database/` - DB operations
- `fix/` - Automated fixes
- `utilities/` - General utilities
- `testing/` - Test scripts
- etc.

**Full list**: [bashscripts/README.md](../../../../bashscripts/README.md)

---

## ✅ Examples

### Correct

```bash
# Analysis script
bashscripts/analysis/analyze_xot_models.sh

# Quality script
bashscripts/quality-assurance/phpstan_xot.sh

# Database script
bashscripts/database/migration/run_xot_migrations.sh
```

### Wrong

```bash
# ❌ In Xot module
laravel/Modules/Xot/scripts/analyze.sh

# ❌ In laravel directory
laravel/analyze_xot.sh

# ❌ In docs
laravel/Modules/Xot/docs/scripts/fix.sh
```

---

## 🔗 References

- [Main Scripts README](../../../../bashscripts/README.md)
- [Scripts Location Rule](../../../../docs/rules/scripts-location.md)
- [.cursor/rules](../../../../.cursor/rules/scripts-location-mandatory.mdc)

---

**Remember**: bashscripts/{category}/ - ALWAYS!


