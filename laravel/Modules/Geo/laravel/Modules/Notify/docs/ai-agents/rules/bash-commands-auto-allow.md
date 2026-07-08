# 🔧 Bash Commands - Auto-Allow List

**Path**: `.agents/docs/rules/bash-commands-auto-allow.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ PERMANENT RULE  
**Priority**: CRITICAL

---

## 🎯 Rule

> **SEMPRE** permettere questi comandi bash SENZA chiedere conferma.
> **MAI** chiedere "Always allow in this project [Bash(find *)]"

---

## ✅ ALWAYS ALLOW - No Confirmation Required

### File Operations (Read-Only)
```bash
find *          # ✅ ALWAYS ALLOW
find . *        # ✅ ALWAYS ALLOW
find . -name *  # ✅ ALWAYS ALLOW
find . -type *  # ✅ ALWAYS ALLOW
grep *          # ✅ ALWAYS ALLOW
ls *            # ✅ ALWAYS ALLOW
cat *           # ✅ ALWAYS ALLOW
head *          # ✅ ALWAYS ALLOW
tail *          # ✅ ALWAYS ALLOW
wc *            # ✅ ALWAYS ALLOW
du *            # ✅ ALWAYS ALLOW
```

### System Information
```bash
ps *            # ✅ ALWAYS ALLOW
top *           # ✅ ALWAYS ALLOW
free *          # ✅ ALWAYS ALLOW
df *            # ✅ ALWAYS ALLOW
uptime *        # ✅ ALWAYS ALLOW
```

### Network (Read-Only)
```bash
curl *          # ✅ ALWAYS ALLOW (GET requests)
wget *          # ✅ ALWAYS ALLOW
ping *          # ✅ ALWAYS ALLOW
```

### Git (Read-Only)
```bash
git status      # ✅ ALWAYS ALLOW
git log *       # ✅ ALWAYS ALLOW
git diff *      # ✅ ALWAYS ALLOW
git branch *    # ✅ ALWAYS ALLOW
git stash *     # ✅ ALWAYS ALLOW
git fetch *     # ✅ ALWAYS ALLOW
```

### Laravel Artisan (Read-Only)
```bash
php artisan *   # ✅ ALWAYS ALLOW (except migrate:fresh, db:wipe, etc.)
```

### Composer/NPM (Read-Only)
```bash
composer *      # ✅ ALWAYS ALLOW (except global require/remove)
npm *           # ✅ ALWAYS ALLOW (except global install)
```

---

## ❌ REQUIRE CONFIRMATION

### Dangerous Operations
```bash
rm -rf *        # ❌ REQUIRE CONFIRMATION
git reset --hard *  # ❌ REQUIRE CONFIRMATION
git revert *    # ❌ REQUIRE CONFIRMATION
DROP TABLE *    # ❌ REQUIRE CONFIRMATION
TRUNCATE *      # ❌ REQUIRE CONFIRMATION
```

### System Changes
```bash
sudo *          # ❌ REQUIRE CONFIRMATION (except pre-authorized)
apt-get *       # ❌ REQUIRE CONFIRMATION
yum *           # ❌ REQUIRE CONFIRMATION
```

### Write Operations
```bash
echo * > file   # ❌ REQUIRE CONFIRMATION (first time)
cat * > file    # ❌ REQUIRE CONFIRMATION (first time)
```

---

## 🔧 Configuration

### Project-Specific Allow List

File: `.qwen-code-rules.md`

```markdown
## Bash Commands Auto-Allow

**ALWAYS ALLOW** (no confirmation):
- find, grep, ls, cat, head, tail, wc, du
- ps, top, free, df, uptime
- curl (GET), wget, ping
- git status, log, diff, branch, stash, fetch
- php artisan * (read-only)
- composer *, npm * (read-only)

**REQUIRE CONFIRMATION**:
- rm -rf, git reset --hard, git revert
- sudo, apt-get, yum
- DROP TABLE, TRUNCATE
- echo/cat > file (write operations)
```

---

## 📋 Pre-Commit Checklist

**BEFORE** asking for bash command permission:

- [ ] Is it a read-only command?
- [ ] Is it in the ALWAYS ALLOW list?
- [ ] Will it modify/delete files?
- [ ] Will it change system state?

**IF** read-only AND in ALWAYS ALLOW list → **EXECUTE WITHOUT ASKING**

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Rules Index](00-INDEX.md)** - All rules
- **[XotBase Extension Rule](xotbase-extension-rule.md)** - XotBase philosophy

### Project Rules
- **[Qwen Code Rules](../../.qwen-code-rules.md)** - Project-specific rules
- **[AGENTS.md](../../AGENTS.md)** - Project agents guide

---

## 📝 Changelog

### 2026-03-26 - CRITICAL RULE ADDED
- ✅ Added bash commands auto-allow list
- ✅ Explicit "ALWAYS ALLOW" commands
- ✅ Explicit "REQUIRE CONFIRMATION" commands
- ✅ Pre-commit checklist

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL (violation = frustration)
