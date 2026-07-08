# ⚠️ CRITICAL STATUS: Accessor Location

## 🚨 Situazione Attuale

**SchedaTrait**: 27 righe (solo composition) ✅  
**SchedaMutator**: 520 righe (NO accessor ancora) ❌  
**Accessor (83)**: **MANCANTI** ⚠️

## 🔍 Dove Sono Gli Accessor?

Gli 83 accessor erano in:
- `SchedaTrait.php` originale (73KB) prima del cleanup
- `/tmp/accessors_to_move.php` (estratti ma con syntax errors)
- Git history (recuperabili)

## 🎯 Piano di Recovery

### Step 1: Recuperare Accessor da Git
```bash
git checkout HEAD~1 -- SchedaTrait.php
cp SchedaTrait.php /tmp/SchedaTrait_WITH_ACCESSORS.php
```

### Step 2: Estrarre Accessor Validi
Usare script più robusto o estrazione manuale batch.

### Step 3: Merge in SchedaMutator
Append accessor a SchedaMutator con validazione.

## 📊 Current State Files

| File | Righe | Accessor | Status |
|------|-------|----------|--------|
| SchedaTrait.php | 27 | 0 | ✅ Clean |
| SchedaMutator.php | 520 | 0 | ❌ Incomplete |
| SchedaHelper.php | 714 | 0 | ✅ Complete |
| `/tmp/SchedaTrait_WITH_ACCESSORS.php` | ~2500 | 83 | 📋 Backup |

## 🚀 Next Action

**CRITICAL**: Spostare accessor da backup in SchedaMutator per restore funzionalità.

---

**Created**: 29 Gennaio 2026  
**Priority**: 🔴 URGENT

