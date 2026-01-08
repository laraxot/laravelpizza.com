# Case Sensitivity Rules - Xot Module

## Problema / Problem

**NON possono esistere file con lo stesso nome che differiscono solo per maiuscole/minuscole nella stessa directory.**

I filesystem case-insensitive (Windows, macOS default) non possono distinguere tra file come `MetatagDataTest.php` e `metatagdatatest.php`, causando:
- Conflitti durante il checkout del repository
- Perdita di dati
- Errori di compilazione/esecuzione
- Problemi in produzione

## Regola / Rule

**Un solo file per nome (case-insensitive) per directory.**

## Convenzioni PHP/Laravel

### 1. Test Files
- **Formato**: PascalCase
- **Esempi**: `MetatagDataTest.php`, `UserTest.php`
- ❌ **Errato**: `metatagdatatest.php`, `usertest.php`

### 2. Model/Factory/Seeder Files
- **Formato**: PascalCase
- **Esempi**: `User.php`, `UserFactory.php`, `UserSeeder.php`

### 3. Directory Structure
- **Formato**: lowercase
- **Esempi**: `database/factories/`, `database/migrations/`, `database/seeders/`
- ❌ **Errato**: `Database/Factories/`, `Database/Migrations/`, `Database/Seeders/`

### 4. Pest Configuration
- **File corretto**: `Pest.php` (PascalCase)
- ❌ **Errato**: `pest.php`

### 5. Locales
- **ISO 639-1 + ISO 3166-1**: `it/`, `en/`, `de/`
- **With region**: `pt_BR/` (underscore + uppercase)
- ❌ **Errato**: `pt_br/`, `IT/`, `EN/`

### 6. Controllers
- **Formato**: PascalCase
- **Esempi**: `XotBaseController.php`, `UserController.php`
- ❌ **Errato**: `xotbasecontroller.php`

## File Rimossi da Xot Module

I seguenti file sono stati eliminati perché violavano le regole:

```
✗ Removed: tests/Unit/metatagdatatest.php
✓ Kept:    tests/Unit/MetatagDataTest.php

✗ Removed: tests/pest.php
✓ Kept:    tests/Pest.php

✗ Removed: app/Http/Http/Controllers/xotbasecontroller.php
✓ Kept:    app/Http/Http/Controllers/XotBaseController.php

✗ Removed: lang/pt_br/ (entire directory)
✓ Kept:    lang/pt_BR/
```

## Filosofia / Philosophy

### Perché questa regola è importante?

1. **Portabilità Cross-Platform**: Il codice deve funzionare su tutti i sistemi operativi
2. **Prevenzione Errori**: Evita perdita di dati e conflitti git
3. **Conformità Standard**: Segue le convenzioni Laravel/PSR
4. **Manutenibilità**: Codice più prevedibile e facile da gestire
5. **CI/CD**: Pipeline di deploy funzionano su tutti gli ambienti

### Zen del Naming

> "Ci deve essere un solo modo ovvio per nominare un file."

- **Consistency**: Stesso pattern in tutto il codebase
- **Clarity**: Il nome riflette il contenuto
- **Convention**: Seguire gli standard della community
- **Simplicity**: Non complicare con varianti di case

### Logica Dietro le Convenzioni

- **PascalCase per classi**: Riflette il nome della classe PHP (PSR-4)
- **lowercase per directory**: Standard Unix/Linux
- **locale con regione**: Standard ISO (pt_BR, en_US)

## Verifica / Check

Per verificare che non ci siano duplicati case-insensitive nel modulo:

```bash
cd /var/www/_bases/base_ptvx_fila4_mono/laravel/Modules/Xot
python3 << 'EOF'
import os
from collections import defaultdict

files_by_lower = defaultdict(list)

for root, dirs, files in os.walk('.'):
    # Skip vendor and node_modules
    if 'vendor' in root or 'node_modules' in root:
        continue

    for file in files:
        if file.endswith('.php') or file.endswith('.blade.php'):
            full_path = os.path.join(root, file)
            key = (root.lower(), file.lower())
            files_by_lower[key].append(full_path)

# Print only duplicates
duplicates_found = False
for key, paths in sorted(files_by_lower.items()):
    if len(paths) > 1:
        duplicates_found = True
        print(f"❌ DUPLICATES FOUND:")
        for path in sorted(paths):
            print(f"   {path}")
        print()

if not duplicates_found:
    print("✅ No case-insensitive duplicates found!")
EOF
```

## Politica / Policy

### Durante lo Sviluppo

1. **Prima di creare un file**: Verifica che non esista già con case diverso
2. **Durante il commit**: Verifica con git status che non ci siano conflitti
3. **Nei test CI/CD**: Aggiungi check automatici per duplicati

### Durante il Code Review

1. Verificare che i nuovi file seguano le convenzioni
2. Rifiutare PR con duplicati case-insensitive
3. Richiedere correzioni prima del merge

### Automazione

Aggiungi questo pre-commit hook:

```bash
# .git/hooks/pre-commit
#!/bin/bash
# Check for case-insensitive duplicates
python3 << 'EOF'
import os, sys
from collections import defaultdict

files = defaultdict(list)
for root, _, filenames in os.walk('Modules'):
    for f in filenames:
        if f.endswith('.php'):
            key = (root.lower(), f.lower())
            files[key].append(os.path.join(root, f))

duplicates = [paths for paths in files.values() if len(paths) > 1]
if duplicates:
    print("❌ Case-insensitive duplicates found:")
    for paths in duplicates:
        for p in paths:
            print(f"   {p}")
    sys.exit(1)
EOF
```

## Religione / Religion

### I Comandamenti del Naming

1. **Thou shalt use PascalCase** per classi PHP
2. **Thou shalt use lowercase** per directory
3. **Thou shalt follow ISO standards** per locales
4. **Thou shalt check for duplicates** prima di creare file
5. **Thou shalt not rely** su case sensitivity
6. **Thou shalt maintain consistency** in tutto il codebase
7. **Thou shalt automate checks** per prevenire errori
8. **Thou shalt educate** i team member su queste regole
9. **Thou shalt refactor** vecchio codice che viola le regole
10. **Thou shalt document** le decisioni di naming

## References

- [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/)
- [Laravel Directory Structure](https://laravel.com/docs/structure)
- [ISO 639-1 Language Codes](https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes)
- [ISO 3166-1 Country Codes](https://en.wikipedia.org/wiki/ISO_3166-1)
- [Filesystem Case Sensitivity](https://en.wikipedia.org/wiki/Case_sensitivity)

## Update Log

- **2025-11-04**: Initial documentation and cleanup
  - Removed: `metatagdatatest.php`, `pest.php`, `xotbasecontroller.php`, `pt_br/`
  - Established rules and conventions
