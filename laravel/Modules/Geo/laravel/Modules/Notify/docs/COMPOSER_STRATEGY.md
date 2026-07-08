# 🎯 Laravel-Modules Composer Strategy

**Data**: 2026-03-30  
**Stato**: ✅ **CONFIGURATO**

## 📋 Strategia Composer con laravel-modules

### Principio Fondamentale

**Il composer.json principale deve essere MINIMALE!**

Tutte le dipendenze specifiche devono essere nei `composer.json` dei moduli.

## 🏗️ Architettura

### Root composer.json (MINIMALE)

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "^12.0"
    },
    "require-dev": {
        "laravel/pint": "^1.25",
        "larastan/larastan": "^3.7"
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

### Module composer.json (SPECIFICO)

Ogni modulo gestisce le proprie dipendenze:

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

## 🔧 Configurazione Merge Plugin

### wikimedia/composer-merge-plugin

**Funzione**: Unisce automaticamente i composer.json dei moduli

**Configurazione**:
```json
{
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json",
            "Themes/*/composer.json"
        ],
        "recurse": true,
        "replace": false,
        "ignore-duplicates": false,
        "merge-dev": true,
        "merge-extra": false,
        "merge-extra-deep": false,
        "merge-scripts": false
    }
}
```

### Spiegazione Opzioni

| Opzione | Valore | Spiegazione |
|---------|--------|-------------|
| `include` | `["Modules/*", "Themes/*"]` | Pattern per trovare composer.json |
| `recurse` | `true` | Cerca ricorsivamente |
| `replace` | `false` | Non sostituire dipendenze root |
| `ignore-duplicates` | `false` | Segnala duplicati |
| `merge-dev` | `true` | Unisci anche require-dev |
| `merge-extra` | `false` | Non unire extra (evita conflitti) |
| `merge-scripts` | `false` | Non unire scripts (evita conflitti) |

## ⚠️ Problemi Comuni e Soluzioni

### Problema 1: Versioni Conflittuali

**Errore**:
```
filament/forms ^5.0 conflicts with ^3.4
```

**Soluzione**:
- ✅ Rimuovi vincoli specifici dal root composer.json
- ✅ Lascia che ogni modulo gestisca le proprie versioni
- ✅ Usa `*` o vincoli ampi nei moduli

### Problema 2: Minimum Stability

**Errore**:
```
does not match your minimum-stability
```

**Soluzione**:
```json
{
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

### Problema 3: Duplicate Packages

**Errore**:
```
Package "xyz" is listed multiple times
```

**Soluzione**:
- ✅ Imposta `"replace": false` nel merge-plugin
- ✅ Assicurati che i moduli usino le stesse versioni

## 📁 Struttura Progetto

```
laravel/
├── composer.json                 ✅ MINIMALE (root)
├── Modules/
│   ├── Cms/
│   │   └── composer.json         ✅ Specifico per Cms
│   ├── User/
│   │   └── composer.json         ✅ Specifico per User
│   └── ...
└── Themes/
    └── Sixteen/
        └── composer.json         ✅ Specifico per Theme
```

## 🎯 Best Practices

### Root composer.json

1. ✅ **SOLO** dipendenze core (Laravel, laravel-modules)
2. ✅ **SOLO** dev tools globali (pint, larastan)
3. ❌ **NON** includere dipendenze specifiche (Filament, etc.)
4. ❌ **NON** vincolare versioni di pacchetti dei moduli

### Module composer.json

1. ✅ **TUTTE** le dipendenze specifiche del modulo
2. ✅ **TUTTE** le dipendenze Filament
3. ✅ Vincoli di versione appropriati
4. ✅ Autoload PSR-4 corretto

## 🔄 Workflow

### Installazione

```bash
# Dalla cartella laravel/
composer install

# Il merge-plugin unisce automaticamente:
# - Modules/*/composer.json
# - Themes/*/composer.json
```

### Aggiornamento

```bash
# Aggiorna tutto
composer update -W

# Aggiorna solo un modulo
cd Modules/ModuleName
composer update
```

### Aggiunta Nuovo Modulo

1. Crea `Modules/ModuleName/composer.json`
2. Aggiungi dipendenze specifiche
3. Esegui `composer update` dalla root
4. Il merge-plugin lo include automaticamente

## 📊 Esempio Reale

### Root (laravel/composer.json)

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "^12.0"
    }
}
```

### Module (Modules/Cms/composer.json)

```json
{
    "name": "fixcity/cms-module",
    "require": {
        "php": "^8.2",
        "filament/filament": "^5.0",
        "filament/forms": "^5.0",
        "filament/tables": "^5.0"
    }
}
```

### Result (After Merge)

Composer vede:
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "^12.0",
        "filament/filament": "^5.0",
        "filament/forms": "^5.0",
        "filament/tables": "^5.0"
    }
}
```

## ✅ Checklist Configurazione

### Root composer.json
- [x] Solo dipendenze core
- [x] Merge-plugin configurato
- [x] Minimum stability: dev
- [x] Prefer stable: true
- [x] No dipendenze Filament
- [x] No vincoli specifici

### Module composer.json
- [x] Tutte dipendenze specifiche
- [x] Vincoli versione appropriati
- [x] Autoload PSR-4 corretto
- [x] Nome pacchetto univoco

## 🔗 Riferimenti

### Documentazione Ufficiale
- [laravel-modules](https://nwidart.com/laravel-modules/)
- [composer-merge-plugin](https://github.com/wikimedia/composer-merge-plugin)
- [Composer Documentation](https://getcomposer.org/doc/)

### Project Documentation
- [COMPOSER_STRATEGY.md](COMPOSER_STRATEGY.md) - Questo file
- [MODULES_ARCHITECTURE.md](MODULES_ARCHITECTURE.md) - Architettura moduli

---

**Stato**: ✅ **CONFIGURATO - Composer minimale con merge-plugin**  
**Principio**: **Root minimale, moduli specifici**  
**Merge Plugin**: **wikimedia/composer-merge-plugin**
