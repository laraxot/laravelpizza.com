# Composer & Laravel-Modules Architecture

**Data**: 2026-03-30  
**Status**: ⚠️ ARCHITECTURE ISSUE

---

## 🎯 Problem

**Root composer.json** è minimale MA i moduli hanno dipendenze conflittuali:

### Moduli Composer.json Versions

| Module | Filament Version | Issue |
|--------|-----------------|-------|
| **Xot** | `^3.2` | ❌ Old version |
| **User** | `*` | ❌ Unspecified |
| **Job** | (implicit) | Via merge |
| **Root** | (removed) | ✅ Minimal |

### Conflict

```
filament/support v5.x requires livewire ^4.1
Root composer.json requires livewire ^3.5
```

---

## 🔧 Solution Options

### Option 1: Upgrade All to Filament 5 ⭐ RECOMMENDED

**Pros**:
- Latest features
- Long-term support
- Consistent versions

**Cons**:
- Breaking changes
- Requires Livewire 4 upgrade
- Time: 4-8 hours

**Steps**:
1. Update all module composer.json to `^5.0`
2. Upgrade Livewire to `^4.1`
3. Fix breaking changes
4. Test everything

### Option 2: Keep Filament 3.x

**Pros**:
- No breaking changes
- Quick fix

**Cons**:
- Old version
- No new features
- Will need upgrade soon

**Steps**:
1. Set all modules to `^3.2`
2. Remove Filament 5 requirements
3. Test

### Option 3: Hybrid (NOT RECOMMENDED)

**Don't mix Filament versions!**

---

## 📋 Recommended Action

**Execute Option 1: Full Filament 5 Upgrade**

### Root composer.json (MINIMAL)

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "^12.0",
        "wikimedia/composer-merge-plugin": "^2.1"
    },
    "extra": {
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json",
                "Themes/*/composer.json"
            ]
        }
    }
}
```

### Module composer.json (UNIFIED)

ALL modules should use:

```json
{
    "require": {
        "php": "^8.2",
        "filament/filament": "^5.0",
        "filament/forms": "^5.0",
        "filament/tables": "^5.0"
    }
}
```

---

## 🚀 Quick Fix (For Now)

If you need it working NOW:

```bash
# 1. Set all to Filament 3.2 (temporary)
find Modules -name "composer.json" -exec sed -i 's/"filament\/filament": "\^5.0"/"filament\/filament": "^3.2"/g' {} \;

# 2. Update root
cd laravel
composer update -W

# 3. Plan Filament 5 upgrade for later
```

---

## 📊 Current Status

| Component | Status | Action |
|-----------|--------|--------|
| **Root composer.json** | ✅ Minimal | None |
| **Module Versions** | ❌ Inconsistent | Need统一 |
| **Filament Version** | ⚠️ Mixed (3.x, 5.x) | Need 统一 |
| **Livewire** | ⚠️ ^3.5 (needs ^4.1 for Filament 5) | Upgrade |

---

## 🔗 References

- [Filament 5 Upgrade Guide](https://filamentphp.com/docs/5.x/upgrade-guide)
- [Laravel-Modules Docs](https://laravelmodules.com/)
- [Composer Merge Plugin](https://packagist.org/packages/wikimedia/composer-merge-plugin)

---

**Priority**: CRITICAL  
**Recommendation**: Plan Filament 5 upgrade sprint  
**Estimated Time**: 1 day for full upgrade
