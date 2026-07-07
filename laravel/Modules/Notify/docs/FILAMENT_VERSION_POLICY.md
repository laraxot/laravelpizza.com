# 🎯 Filament Version Policy - ALWAYS LATEST

**Data**: 2026-03-30  
**Stato**: ✅ **POLITICA UFFICIALE**

## 🚨 REGOLA FONDAMENTALE

**UTILIZZARE SEMPRE L'ULTIMA VERSIONE DI FILAMENT!**

**Attuale**: **Filament 5.x** (Marzo 2026)

## 📋 Politica Ufficiale

### 1. Root composer.json

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "^12.0"
    }
}
```

**NO Filament nel root!**  
Filament è gestito dai moduli.

### 2. Module composer.json

```json
{
    "name": "fixcity/module-name",
    "require": {
        "php": "^8.2",
        "filament/filament": "^5.0",
        "filament/forms": "^5.0",
        "filament/tables": "^5.0"
    }
}
```

**TUTTI i pacchetti Filament devono usare ^5.0**

### 3. Aggiornamenti

**Quando esce una nuova versione**:
1. ✅ Aggiornare TUTTI i moduli
2. ✅ Eseguire `composer update -W`
3. ✅ Testare tutte le funzionalità
4. ✅ Documentare cambiamenti

## ✅ Verifica Attuale (Marzo 2026)

### Filament Version Installata
```bash
composer show filament/filament
# Version: 5.x.x
```

### Moduli Verificati
- ✅ Modules/Xot: Filament ^5.0
- ✅ Modules/Notify: Filament ^5.0
- ✅ Modules/UI: Filament ^5.0
- ✅ Modules/Cms: Filament ^5.0
- ✅ Modules/User: Filament ^5.0
- ✅ Tutti gli altri: Filament ^5.0

## 🔧 Comandi di Verifica

### Check Filament Version
```bash
cd laravel
composer show filament/filament | grep versions
```

### Check All Modules
```bash
find Modules -name "composer.json" \
  -exec grep -H "filament" {} \; \
  | grep -v "\^5"
# Should return: nothing
```

### Update All Filament Packages
```bash
cd laravel
composer update "filament/*" -W
```

## 📊 Version History

| Data | Version | Status |
|------|---------|--------|
| Marzo 2026 | 5.x | ✅ CURRENT |
| 2024-2025 | 3.x | ❌ DEPRECATED |
| 2022-2024 | 2.x | ❌ DEPRECATED |

## ⚠️ Perché Usare Sempre l'Ultima Versione

### 1. Security
- ✅ Latest security patches
- ✅ No known vulnerabilities
- ✅ Active maintenance

### 2. Features
- ✅ Latest features
- ✅ Best performance
- ✅ Modern APIs

### 3. Support
- ✅ Active support
- ✅ Bug fixes
- ✅ Community help

### 4. Compatibility
- ✅ Laravel 12 compatible
- ✅ PHP 8.2+ compatible
- ✅ Other packages compatible

## 🚫 Cosa NON Fare

### ❌ Mixed Versions
```json
// WRONG!
{
    "filament/filament": "^3.2",
    "filament/forms": "^5.0"
}
```

### ❌ Old Versions
```json
// WRONG!
{
    "filament/filament": "^3.0"
}
```

### ❌ Vague Constraints
```json
// WRONG!
{
    "filament/filament": "*"
}
```

## ✅ Cosa Fare

### ✅ Consistent Versions
```json
// CORRECT!
{
    "filament/filament": "^5.0",
    "filament/forms": "^5.0",
    "filament/tables": "^5.0"
}
```

### ✅ Latest Stable
```json
// CORRECT!
{
    "filament/filament": "^5.0"
}
```

### ✅ All Modules
```json
// Module 1
{
    "filament/filament": "^5.0"
}

// Module 2
{
    "filament/filament": "^5.0"
}

// All modules: SAME VERSION!
```

## 🔄 Update Workflow

### When New Filament Version Released

1. **Check Release Notes**
   ```
   https://filamentphp.com/docs/5.x/upgrade-guide
   ```

2. **Update Root composer.json** (if needed)
   ```json
   {
       "minimum-stability": "dev",
       "prefer-stable": true
   }
   ```

3. **Update All Modules**
   ```bash
   find Modules -name "composer.json" \
     -exec sed -i 's|"filament/\([^"]*\)": "\^[0-9].*"|"filament/\1": "^5.0"|g' {} \;
   ```

4. **Run Composer Update**
   ```bash
   cd laravel
   composer update -W
   ```

5. **Test Everything**
   - ✅ Admin panel
   - ✅ Forms
   - ✅ Tables
   - ✅ Notifications
   - ✅ Actions
   - ✅ Widgets

6. **Document Changes**
   - Update this file
   - Update module docs
   - Create changelog

## 📚 Riferimenti

### Official Documentation
- [Filament 5 Docs](https://filamentphp.com/docs/5.x/)
- [Upgrade Guide](https://filamentphp.com/docs/5.x/upgrade-guide)
- [GitHub Releases](https://github.com/filamentphp/filament/releases)

### Project Documentation
- [COMPOSER_STRATEGY.md](COMPOSER_STRATEGY.md)
- [COMPOSER_UPDATE_REPORT.md](COMPOSER_UPDATE_REPORT.md)

## ✅ Checklist

### Per Nuovo Modulo
- [ ] Usare `filament/filament": "^5.0"`
- [ ] Usare `filament/forms": "^5.0"`
- [ ] Usare `filament/tables": "^5.0"`
- [ ] Verificare compatibilità
- [ ] Testare funzionalità

### Per Aggiornamento
- [ ] Controllare release notes
- [ ] Aggiornare tutti i moduli
- [ ] Eseguire composer update
- [ ] Testare tutto
- [ ] Documentare cambiamenti

### Per Verifica
- [ ] `composer show filament/filament`
- [ ] Check all modules use ^5.0
- [ ] No mixed versions
- [ ] No old versions

---

**Stato**: ✅ **POLITICA UFFICIALE - SEMPRE FILAMENT 5**  
**Versione Attuale**: **Filament 5.x**  
**Prossimo Aggiornamento**: **Quando esce Filament 6**  
**Regola**: **MAI versioni vecchie, SEMPRE ultima stabile**
