# 🔧 PHPMD Installation - .phar NOT Composer

**Path**: `.agents/docs/rules/phpmd-phar-installation.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ CRITICAL RULE  
**Priority**: BLOCKER

---

## 🎯 The Rule

> **SEMPRE** installare PHPMD come **.phar** standalone.
> **MAI** installare PHPMD con Composer (`composer require --dev phpmd/phpmd`).

**Why**:
- ✅ **.phar** è standalone (nessuna dipendenza)
- ✅ **.phar** non modifica `composer.json`
- ✅ **.phar** non aggiunge dipendenze al progetto
- ✅ **.phar** è sempre aggiornato
- ❌ **Composer** aggiunge dipendenze inutili
- ❌ **Composer** modifica `composer.json`
- ❌ **Composer** può causare conflitti

---

## 📚 Installation Guide

### Step 1: Download .phar

```bash
curl -L https://phpmd.org/phpmd.phar -o phpmd.phar
```

### Step 2: Make Executable

```bash
chmod +x phpmd.phar
```

### Step 3: Move to Global Path

```bash
sudo mv phpmd.phar /usr/local/bin/phpmd
```

### Step 4: Verify Installation

```bash
phpmd --version
```

**Expected Output**:
```
PHPMD 2.15.0
```

---

## 🔧 Usage

### Basic Usage

```bash
phpmd <source> <format> <ruleset>
```

### Examples

```bash
# Analyze directory
phpmd /path/to/code text codesize,unusedcode,naming

# Analyze specific file
phpmd /path/to/file.php text design

# With custom ruleset
phpmd /path/to/code xml phpmd.xml

# Exclude directories
phpmd /path/to/code text codesize --exclude vendor,tests
```

### Common Rulesets

| Ruleset | Description |
|---------|-------------|
| **codesize** | Code size rules |
| **unusedcode** | Unused code rules |
| **naming** | Naming conventions |
| **design** | Design rules |
| **cleancode** | Clean code rules |
| **controversial** | Controversial rules |

---

## 📋 Quality Gates

### Pre-Commit Checklist

**BEFORE** committing PHP code:

- [ ] PHPMD installed as .phar (NOT Composer)
- [ ] PHPMD version >= 2.15.0
- [ ] Run: `phpmd <source> text codesize,unusedcode,naming`
- [ ] **0 warnings** in output
- [ ] No violations in critical rules

### CI/CD Integration

```yaml
# .github/workflows/phpmd.yml
name: PHPMD

on: [push, pull_request]

jobs:
  phpmd:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      
      - name: Install PHPMD
        run: |
          curl -L https://phpmd.org/phpmd.phar -o phpmd.phar
          chmod +x phpmd.phar
          sudo mv phpmd.phar /usr/local/bin/phpmd
      
      - name: Run PHPMD
        run: phpmd src text codesize,unusedcode,naming
```

---

## 🔍 How to Spot the Violation

### Red Flag 🚩

```bash
# 🚩 RED FLAG: composer.json contains phpmd
{
    "require-dev": {
        "phpmd/phpmd": "^2.15"  # 🚩 SBAGLIATO!
    }
}

# 🚩 RED FLAG: vendor/phpmd/ directory exists
ls vendor/phpmd/  # 🚩 SBAGLIATO!
```

**Immediate Fix**:
```bash
# ✅ Remove from composer.json
composer remove phpmd/phpmd

# ✅ Install .phar
curl -L https://phpmd.org/phpmd.phar -o phpmd.phar
chmod +x phpmd.phar
sudo mv phpmd.phar /usr/local/bin/phpmd
```

---

## 📊 Comparison

| Aspect | .phar Installation | Composer Installation |
|--------|-------------------|---------------------|
| **Dependencies** | ✅ None | ❌ Adds dependencies |
| **composer.json** | ✅ Unchanged | ❌ Modified |
| **vendor/** | ✅ Unchanged | ❌ phpmd/ added |
| **Updates** | ✅ Manual (download new .phar) | ❌ composer update |
| **Conflicts** | ✅ None | ❌ Possible |
| **Portability** | ✅ High (single file) | ❌ Low (vendor/) |

---

## 🔗 Related Documentation

### AI Agents Docs
- **[Rules Index](00-INDEX.md)** - All rules
- **[Quality Gates](quality-gates.md)** - Quality gates
- **[PHP Best Practices](php-best-practices.md)** - PHP best practices

### External Resources
- **[PHPMD Official](https://phpmd.org/)** - Official website
- **[PHPMD Download](https://phpmd.org/phpmd.phar)** - Direct download
- **[PHPMD Rules](https://phpmd.org/documentation/)** - Rules documentation

---

## 📝 Changelog

### 2026-03-26 - CRITICAL RULE ADDED
- ✅ Added ".phar NOT Composer" rule
- ✅ Installation guide
- ✅ Usage examples
- ✅ Quality gates
- ✅ Comparison table

**NOTE**: PHPMD **DEVE** essere .phar.
**MAI** con Composer.
**ORA È PERMANENTE**.

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL (violation = code review failure)
