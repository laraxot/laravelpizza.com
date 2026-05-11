# Module Directory Structure Rule

> **Regola**: Le cartelle dei moduli devono seguire la struttura standard Laravel/Packt.

**Date Established**: 2026-03-13  
**Status**: Active  
**Priority**: Critical  

---

## La Regola

**Tutti i file di codice sorgente devono stare in `app/`, MAI nella root del modulo.**

### Struttura Corretta

```
laravel/Modules/{ModuleName}/
├── app/
│   ├── Actions/
│   ├── Datas/          ✅ Data Objects qui
│   ├── Filament/
│   ├── Helpers/
│   ├── Http/
│   ├── Models/
│   ├── Providers/
│   ├── Rules/
│   ├── Services/
│   └── Traits/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docs/
├── lang/
├── resources/
│   ├── views/
│   └── assets/
├── routes/
├── tests/
│   ├── Feature/
│   └── Unit/
├── composer.json
└── module.json
```

### Struttura SBAGLIATA ❌

```
laravel/Modules/{ModuleName}/
├── Actions/            ❌ Mai nella root
├── Datas/              ❌ Mai nella root
├── Models/             ❌ Mai nella root
├── Services/           ❌ Mai nella root
├── app/                ✅ Solo app/ è corretto
└── ...
```

---

## Esempi Specifici

### ✅ Corretto: Xot Module

```
laravel/Modules/Xot/
├── app/
│   ├── Actions/
│   ├── Datas/              ✅ XotData.php qui
│   ├── Filament/
│   ├── Models/
│   ├── Providers/
│   └── Services/
├── config/
├── database/
├── docs/
└── module.json
```

### ❌ Sbagliato: Xot Module (Pre-Cleanup)

```
laravel/Modules/Xot/
├── Datas/                  ❌ XotData.php stub qui (RIMOSSO)
├── app/
│   └── Datas/              ✅ XotData.php reale qui
└── ...
```

---

## Rationale

### 1. Standard Laravel/Packt

I moduli Laravel seguono la convenzione di Packt/`nwidart/laravel-modules`:
- Tutto il codice PHP va in `app/`
- La root del modulo contiene solo configurazione e metadata

### 2. Autoloading Coerente

Il composer.json del modulo configura l'autoloading su `app/`:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\ModuleName\\": "app/"
        }
    }
}
```

File nella root del modulo non sono autoloadati correttamente.

### 3. Consistenza

Tutti i moduli devono avere la stessa struttura per:
- Facilità di navigazione
- Strumenti di analisi statica (PHPStan, Psalm)
- IDE autocomplete e refactoring

### 4. Separazione Chiara

- `app/` = Codice sorgente (classes, traits, interfaces)
- `config/` = Configurazione
- `database/` = Migrazioni, factories, seeders
- `resources/` = Views, assets
- `docs/` = Documentazione

---

## Violazioni Comuni

### 1. Datas nella Root

**Violazione**: `Modules/Xot/Datas/XotData.php`

**Fix**: Spostare in `Modules/Xot/app/Datas/XotData.php`

**Stato**: ✅ Risolto (2026-03-13)

### 2. Filament nella Root

**Violazione**: `Modules/Xot/Filament/Forms/Components/XotBasePlaceholder.php`

**Fix**: Spostare in `Modules/Xot/app/Filament/Forms/Components/XotBasePlaceholder.php`

**Stato**: ✅ Risolto (2026-03-13) - cartella `Filament/` rimossa

### 3. Services nella Root

**Violazione**: `Modules/Xot/Services/ArrayService.php`

**Fix**: Spostare in `Modules/Xot/app/Services/ArrayService.php`

**Stato**: ✅ Risolto (2026-03-13) - cartella `Services/` rimossa

### 4. Helpers nella Root

**Violazione**: `Modules/Xot/Helpers/Helper.php` o `Modules/Xot/helpers/Helper.php`

**Fix**: Se sono helper moderni, spostare in `Modules/Xot/app/Helpers/`. Se sono legacy, rimuovere.

**Stato**: ✅ Risolto (2026-03-13) - entrambe le cartelle `Helpers/` e `helpers/` rimosse

### 5. Actions/Models/Providers nella Root

**Violazione**: `Modules/{Module}/Actions/`, `Modules/{Module}/Models/`, etc.

**Fix**: Tutto deve stare in `app/`

**Stato**: ✅ Nessuna violazione trovata

---

## Cleanup Eseguito

### 2026-03-13: Xot Module Root Cleanup

**Prima**:
```
laravel/Modules/Xot/
├── Datas/                  ❌ Cartella legacy nella root
│   └── XotData.php         (stub vuoto)
├── Filament/               ❌ Cartella legacy nella root
│   └── Forms/Components/
│       └── XotBasePlaceholder.php  (duplicato)
├── Services/               ❌ Cartella legacy nella root
│   └── ArrayService.php    (file singolo)
├── Helpers/                ❌ Cartella legacy nella root
│   ├── Helper.php          (legacy)
│   └── PathHelper.php      (legacy)
├── helpers/                ❌ Cartella legacy nella root (lowercase)
│   ├── Helper.php          (legacy)
│   └── PathHelper.php      (legacy)
└── app/
    ├── Datas/              ✅ XotData.php qui
    ├── Filament/           ✅ Tutti i componenti Filament qui
    ├── Services/           ✅ ArrayService.php qui
    └── ...
```

**Dopo**:
```
laravel/Modules/Xot/
├── app/
│   ├── Datas/              ✅ XotData.php qui
│   ├── Filament/           ✅ Tutti i componenti Filament qui
│   ├── Services/           ✅ ArrayService.php qui
│   └── ...
└── (root pulita - solo config, docs, lang, resources, routes, tests)
```

**Elementi Rimossi**:
- `laravel/Modules/Xot/Datas/` (cartella intera)
- `laravel/Modules/Xot/Filament/` (cartella intera)
- `laravel/Modules/Xot/Services/` (cartella intera)
- `laravel/Modules/Xot/Helpers/` (cartella intera)
- `laravel/Modules/Xot/helpers/` (cartella intera)

---

## Verifica

### Comando di Verifica

```bash
# Trova cartelle "app-like" nella root dei moduli
find laravel/Modules -maxdepth 2 -type d \( \
    -name "Actions" -o \
    -name "Datas" -o \
    -name "Filament" -o \
    -name "Helpers" -o \
    -name "helpers" -o \
    -name "Models" -o \
    -name "Providers" -o \
    -name "Services" \
\) ! -path "*/app/*" ! -path "*/tests/*"
```

**Output atteso**: (vuoto - nessuna violazione)

### Checklist per Nuovi Moduli

Quando crei un nuovo modulo:

- [ ] Tutte le classi in `app/`
- [ ] Nessuna cartella di codice nella root
- [ ] `composer.json` configurato correttamente
- [ ] `module.json` nella root

---

## Eccezioni

### Nessuna Eccezione

Non ci sono eccezioni a questa regola. Tutto il codice sorgente DEVE stare in `app/`.

### Cartelle NON Consentite nella Root

Queste cartelle **NON** devono mai stare nella root del modulo:

- `Actions/` → deve essere `app/Actions/`
- `Datas/` → deve essere `app/Datas/`
- `Filament/` → deve essere `app/Filament/`
- `Helpers/` o `helpers/` → deve essere `app/Helpers/` o rimosso se legacy
- `Models/` → deve essere `app/Models/`
- `Providers/` → deve essere `app/Providers/`
- `Services/` → deve essere `app/Services/`
- Qualsiasi altra cartella contenente codice PHP sorgente

### File Consentiti nella Root

Solo questi file sono permessi nella root del modulo:

- `composer.json` - Dipendenze PHP
- `module.json` - Metadata del modulo
- `package.json` - Dipendenze JavaScript (opzionale)
- `README.md` - Documentazione base
- `CHANGELOG.md` - Storico cambiamenti
- `.editorconfig` - Configurazione editor
- `.gitignore` - Git ignore rules
- `*.code-workspace` - VSCode workspace (UNO solo)

### File NON Consentiti nella Root (Backup/Copy)

I seguenti file **NON** devono mai stare nella root del modulo (o in qualsiasi cartella):

- `* copy.*` - File di copia (es. `.gitattributes copy`, `.gitconfig copy`)
- `*.copy` - File con estensione .copy
- `*.bak`, `*.backup` - File di backup
- `*.old`, `*.old1`, `*.old2` - File vecchi
- `*_old` - File con suffisso _old

Questi file devono essere:
1. Aggiunti al `.gitignore` (root e modulo)
2. Eliminati dal filesystem

**Stato**: ✅ Pattern aggiunti ai .gitignore (2026-03-13)

---

## Documentazione Correlata

- [Workspace File Naming Rule](workspace-file-rule.md)
- [Module Structure Standards](module-structure.md)
- [Coding Standards](best-practices.md)
- [Architecture Guide](architecture/structure.md)

---

## Riferimenti

- [Laravel Package Structure](https://laravel.com/docs/packages)
- [Packt/Laravel Modules](https://packtmodules.com/)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)

---

*Ultimo aggiornamento: 2026-03-13*
