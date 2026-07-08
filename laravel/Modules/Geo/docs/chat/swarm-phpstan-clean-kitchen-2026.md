---
title: PHPStan Swarm - Clean Kitchen Session 2026
type: swarm-coordination
status: active
created: 2026-06-17
updated: 2026-06-17
---

# PHPStan Swarm Coordination — Clean Kitchen Session

**Goal:** Achieve ZERO errors (level-max) on all 38 modules  
**Status:** 🔄 IN PROGRESS  
**Strategy:** Random-order modular analysis with memory isolation

## Modules Roster (38 total)

### ✅ COMPLETED (Green)
- Activity
- Badge
- CertFisc
- ContoAnnuale
- DbForge
- Europa
- Gdpr
- Incentivi
- Inail
- IndennitaCondizioniLavoro (fixed 9 errors)
- IndennitaResponsabilita (fixed 4 errors)
- Job
- Lang
- Legge104
- Legge109
- Media
- Mensa
- MobilitaVolontaria
- Notify
- Pdnd
- Performance
- PresenzeAssenze
- Prenotazioni
- Progressioni
- Ptv
- Questionari
- Rating
- Seo
- Setting
- Sigma
- Sindacati
- Tenant
- UI
- User
- Xot

### 🆕 NEW (untested)
- [ ] ??? (NEW modules not tested yet)

### 🔴 IN PROGRESS (Red)

| Module | Agent | Status |
|--------|-------|--------|
| TBD | phpstan-test-first-5 | Running |

## Command Template

```bash
cd /var/www/_bases/base_ptvx_fila5/laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/{MODULE_NAME} --no-progress --level=max
```

## Swarm Agents

| Agent ID | Task | Module(s) | Status |
|----------|------|-----------|--------|
| phpstan-test-first-5 | Sample 5 random | Mixed | ⏳ Running |

## Rules

1. **No parallel execution within a module** (use `php -d memory_limit=2G`)
2. **Random order** to reduce git conflicts
3. **One module per agent** to avoid context collision
4. **Document findings in this file** before fixing
5. **Commit only after verification** (re-run module after fix)

## Notes

- Previous session (2026-06-16) completed 34/34 modules ✅
- 4 new modules added → need testing
- Pest.php bootstrap issue fixed in phpstan-bootstrap.php
