---
title: "🚨 FILAMENT 5 - OFFICIAL POLICY"
type: concept
tags: [filament, official, policy]
created: 2026-07-14
updated: 2026-07-14
qmd: "filament-5-official-policy 🚨 filament 5 - official policy"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# 🚨 FILAMENT 5 - OFFICIAL POLICY

**Data**: 2026-03-30  
**Stato**: ✅ **POLITICA UFFICIALE OBBLIGATORIA**

## ⚡ REGOLA ASSOLUTA

**UTILIZZARE SEMPRE E SOLO FILAMENT 5!**

**NON ACCETTABILE**: Filament 3.x, 4.x o versioni vecchie  
**OBBLIGATORIO**: Filament 5.x (ultima versione stabile)

## 📋 Stato Attuale

### ✅ Completamente Aggiornato a Filament 5

**Tutti i moduli**:
- ✅ Modules/Xot: Filament ^5.0
- ✅ Modules/Notify: Filament ^5.0
- ✅ Modules/UI: Filament ^5.0
- ✅ Modules/Cms: Filament ^5.0
- ✅ Modules/User: Filament ^5.0
- ✅ Modules/Blog: Filament ^5.0
- ✅ **TUTTI GLI ALTRI**: Filament ^5.0

**Pacchetti Correlati**:
- ✅ filament/forms: ^5.0
- ✅ filament/tables: ^5.0
- ✅ filament/spatie-laravel-media-library-plugin: ^5.0
- ✅ filament/spatie-laravel-tags-plugin: ^5.0
- ✅ saade/filament-fullcalendar: ^5.0
- ✅ codewithdennis/filament-select-tree: ^4.0 (compatibile con F5)

## 🔧 Comandi Utili

### Verifica Versione
```bash
cd laravel
composer show filament/filament | grep versions
```

### Aggiorna Tutto
```bash
cd laravel
composer update "filament/*" -W
```

### Verifica Moduli
```bash
find Modules -name "composer.json" \
  -exec grep -H "filament" {} \; \
  | grep -v "\^5"
# Deve restituire: vuoto (nessun risultato)
```

## 📊 Pacchetti Filament

### Core Packages (TUTTI ^5.0)
```json
{
    "filament/filament": "^5.0",
    "filament/forms": "^5.0",
    "filament/tables": "^5.0",
    "filament/actions": "^5.0",
    "filament/notifications": "^5.0"
}
```

### Plugin Packages (TUTTI ^5.0)
```json
{
    "filament/spatie-laravel-media-library-plugin": "^5.0",
    "filament/spatie-laravel-tags-plugin": "^5.0",
    "filament/spatie-laravel-settings-plugin": "^5.0",
    "saade/filament-fullcalendar": "^5.0",
    "codewithdennis/filament-select-tree": "^4.0"
}
```

## ⚠️ Cosa è VIETATO

### ❌ Mixed Versions
```json
// ASSOLUTAMENTE NO!
{
    "filament/filament": "^3.2",
    "filament/forms": "^5.0"
}
```

### ❌ Old Versions
```json
// ASSOLUTAMENTE NO!
{
    "filament/filament": "^3.0"
}
```

### ❌ Ambiguous Constraints
```json
// ASSOLUTAMENTE NO!
{
    "filament/filament": "^5.0, ^3.4"
}
```

## ✅ Cosa è OBBLIGATORIO

### ✅ Consistent Versions
```json
// OBBLIGATORIO!
{
    "filament/filament": "^5.0",
    "filament/forms": "^5.0",
    "filament/tables": "^5.0"
}
```

### ✅ All Modules Same Version
```json
// Module 1
{
    "filament/filament": "^5.0"
}

// Module 2
{
    "filament/filament": "^5.0"
}

// ALL MODULES: SAME!
```

## 🔄 Update Process

### When New Version Released

1. **Check Release**
   ```
   https://filamentphp.com/docs/5.x/upgrade-guide
   ```

2. **Update All Modules Immediately**
   ```bash
   find Modules -name "composer.json" \
     -exec sed -i 's|"filament/\([^"]*\)": "\^[0-9].*"|"filament/\1": "^5.0"|g' {} \;
   ```

3. **Run Composer Update**
   ```bash
   cd laravel
   composer update -W
   ```

4. **Test Everything**
   - ✅ Admin panel
   - ✅ All forms
   - ✅ All tables
   - ✅ All modules

## 📚 Riferimenti

### Official
- [Filament 5 Docs](https://filamentphp.com/docs/5.x/)
- [Filament 5 Upgrade Guide](https://filamentphp.com/docs/5.x/upgrade-guide)
- [GitHub Releases](https://github.com/filamentphp/filament/releases)

### Project
- [filament-version-policy.md](filament-version-policy.md)
- [composer-strategy.md](composer-strategy.md)
- [composer-update-report.md](composer-update-report.md)

## ✅ Verification Checklist

### Per Nuovo Modulo
- [x] `filament/filament": "^5.0"`
- [x] `filament/forms": "^5.0"`
- [x] `filament/tables": "^5.0"`
- [x] Tutti i plugin: `^5.0`

### Per Aggiornamento
- [x] Controllare release notes
- [x] Aggiornare tutti i moduli
- [x] Composer update
- [x] Test completo

### Per Verifica
- [x] `composer show filament/filament` → 5.x
- [x] Tutti i moduli: `^5.0`
- [x] Nessun `^3.x` o `^4.x`
- [x] Nessun vincolo ambiguo

---

**Stato**: ✅ **FILAMENT 5 OBBLIGATORIO**  
**Versione**: **5.x (ultima stabile)**  
**Politica**: **MAI versioni vecchie**  
**Aggiornamento**: **APPENA esce nuova versione**
