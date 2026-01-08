# Project Conventions and Standards

## File Naming Standards

### Markdown Documentation Files (.md)

**REGOLE OBBLIGATORIE:**

1. **Nomi file tutto minuscolo** (tranne `README.md`)
   - ✅ CORRETTO: `project-conventions.md`
   - ❌ SBAGLIATO: `Project-Conventions.md`, `PROJECT_CONVENTIONS.md`

2. **Nessuna data nel nome file**
   - ✅ CORRETTO: `phpstan-fixes.md`, `roadmap.md`
   - ❌ SBAGLIATO: `phpstan-fixes-2025-10-10.md`, `ROADMAP_2025.md`
   - **Motivo**: Le date nei nomi file causano duplicazione, rendono difficile il refactoring e non riflettono lo stato corrente del documento

3. **Usa trattini `-` per separare parole** (non underscore `_`)
   - ✅ CORRETTO: `filament-resource-guidelines.md`
   - ❌ SBAGLIATO: `filament_resource_guidelines.md`

4. **Solo `README.md` può avere lettere maiuscole**
   - ✅ CORRETTO: `README.md` (radice modulo/tema)
   - ❌ SBAGLIATO: qualsiasi altro file con maiuscole

### Shell Scripts (.sh)

**REGOLE OBBLIGATORIE:**

1. **Tutti gli script .sh vanno in `bashscripts/` o sue sottocartelle**
   - ✅ CORRETTO: `bashscripts/quality/run-phpstan.sh`
   - ✅ CORRETTO: `bashscripts/git/resolve-conflicts.sh`
   - ❌ SBAGLIATO: `/tmp/script.sh`, `script.sh` nella root

2. **Organizzazione per categoria in sottocartelle**
   ```
   bashscripts/
   ├── quality/           # Script per quality tools (PHPStan, Pint, Rector)
   ├── git/              # Script per operazioni Git
   ├── deployment/       # Script per deployment
   ├── maintenance/      # Script per manutenzione
   └── utils/            # Script utilities generici
   ```

3. **Naming convention per script**
   - Nomi descrittivi in kebab-case
   - Prefisso per azione: `run-`, `fix-`, `check-`, `update-`
   - ✅ CORRETTO: `run-phpstan-all-modules.sh`
   - ✅ CORRETTO: `fix-permissions.sh`
   - ❌ SBAGLIATO: `script.sh`, `temp.sh`

### Link nei File Markdown

**REGOLE OBBLIGATORIE:**

1. **SEMPRE link relativi, MAI assoluti**
   - ✅ CORRETTO: `[Documentazione](../Xot/docs/architecture.md)`
   - ✅ CORRETTO: `[Esempio](./examples/example.md)`
   - ❌ SBAGLIATO: `[Doc](/var/www/laravel/Modules/Xot/docs/architecture.md)`

2. **Portabilità totale**
   - I link devono funzionare ovunque il progetto venga clonato
   - Nessuna dipendenza da percorsi assoluti del filesystem

3. **Link intra-modulo e inter-modulo**
   - Intra-modulo: `./subdirectory/file.md`
   - Inter-modulo: `../../OtherModule/docs/file.md`

## Directory Structure Standards

### Module Documentation (`Modules/{ModuleName}/docs/`)

```
Modules/ModuleName/docs/
├── README.md                    # Overview del modulo
├── architecture.md              # Architettura e design
├── getting-started.md           # Quick start guide
├── installation.md              # Installazione e setup
├── configuration.md             # Configurazione
├── usage.md                     # Utilizzo e API
├── testing.md                   # Testing guidelines
├── troubleshooting.md           # Risoluzione problemi
├── roadmap.md                   # Roadmap (senza date nel nome!)
├── phpstan-fixes.md             # Correzioni PHPStan
├── api/                         # Documentazione API
├── examples/                    # Esempi di codice
├── guides/                      # Guide specifiche
└── architecture/                # Dettagli architetturali
```

### Theme Documentation (`Themes/{ThemeName}/docs/`)

```
Themes/ThemeName/docs/
├── README.md                    # Overview del tema
├── installation.md              # Installazione
├── components.md                # Componenti disponibili
├── customization.md             # Personalizzazione
├── assets.md                    # Gestione assets
└── examples/                    # Esempi di utilizzo
```

## Bash Scripts Organization

### Structure

```
bashscripts/
├── quality/
│   ├── run-phpstan.sh           # Esegui PHPStan
│   ├── run-pint.sh              # Esegui Pint
│   ├── run-rector.sh            # Esegui Rector
│   ├── run-all-quality.sh       # Esegui tutti i tool
│   └── fix-all-modules.sh       # Fix completo tutti moduli
├── git/
│   ├── resolve-conflicts.sh     # Risolvi conflitti Git
│   ├── cleanup-branches.sh      # Pulizia branch
│   └── conflict-resolution/     # Script risoluzione conflitti
├── deployment/
│   ├── deploy-production.sh     # Deploy in produzione
│   └── deploy-staging.sh        # Deploy in staging
├── maintenance/
│   ├── clear-caches.sh          # Pulisci cache
│   ├── optimize-autoload.sh     # Ottimizza autoload
│   └── backup-database.sh       # Backup database
└── utils/
    ├── rename-docs-files.sh     # Rinomina file docs
    └── check-conventions.sh     # Verifica convenzioni
```

### Script Template

```bash
#!/bin/bash
#
# Script Name: describe-what-this-does.sh
# Description: Brief description of what this script does
# Author: [Author Name]
# Date: [Creation Date]
# Usage: ./script-name.sh [arguments]
#

set -e  # Exit on error

# Configuration
LARAVEL_DIR="/var/www/_bases/base_fixcity_fila4_mono/laravel"
cd "$LARAVEL_DIR"

# Script logic here
echo "=== Script Title ==="
# ... implementation ...
```

## Quality Standards

### PHPStan Configuration

- **NON modificare MAI** `phpstan.neon`
- **NON creare baseline** per ignorare errori
- **TUTTI gli errori vanno corretti**, mai ignorati

### Code Quality

- **PSR-12** per coding style
- **PHPStan Level MAX** (0 errori)
- **Type safety completa** (type hints + PHPDoc)
- **Webmozart Assert** per validazioni
- **TheCodingMachine Safe** per funzioni sicure

## Documentation Standards

### Content Requirements

1. **Ogni modulo DEVE avere**:
   - `README.md` con overview
   - `architecture.md` con design decisions
   - `phpstan-fixes.md` con correzioni applicate

2. **Documentazione aggiornata**:
   - Aggiorna docs SEMPRE dopo modifiche significative
   - Documenta pattern e anti-pattern
   - Mantieni changelog di correzioni PHPStan

3. **Link documentation**:
   - Cross-reference tra documenti correlati
   - Link a esempi di codice
   - Link a risorse esterne (Filament, Laravel, etc.)

## Enforcement

### Pre-commit Checks

Prima di committare:
```bash
# Verifica naming file .md
find Modules Themes -name "*.md" | grep -E '[A-Z]|[0-9]{4}' | grep -v README.md

# Verifica script fuori da bashscripts
find . -maxdepth 2 -name "*.sh" | grep -v bashscripts

# Verifica link assoluti nei .md
grep -r "](/var/www/" Modules/*/docs Themes/*/docs
```

### Automated Fixes

Script per correzioni automatiche disponibili in `bashscripts/utils/`:
- `rename-docs-files.sh` - Rinomina file secondo convenzioni
- `fix-md-links.sh` - Converte link assoluti a relativi
- `check-conventions.sh` - Verifica tutte le convenzioni

## Migration Guide

### Rinominare File Esistenti

```bash
# Usa sempre comandi bash diretti, NON script temporanei
# Esempio: rinominare file con date
find Modules -name "*2025*.md" -exec bash -c 'mv "$0" "${0//-2025/}"' {} \;

# Esempio: convertire maiuscole in minuscole
find Modules -name "*.md" ! -name "README.md" -exec bash -c '
  dir=$(dirname "$0")
  name=$(basename "$0")
  lower=$(echo "$name" | tr "[:upper:]" "[:lower:]")
  [[ "$name" != "$lower" ]] && mv "$0" "$dir/$lower"
' {} \;
```

## References

- [Laravel Coding Standards](https://laravel.com/docs/contributions#coding-style)
- [PSR-12 Extended Coding Style](https://www.php-fig.org/psr/psr-12/)
- [PHPStan Documentation](https://phpstan.org/)
- [Markdown Style Guide](https://www.markdownguide.org/basic-syntax/)

---

**Last Updated**: 2025-10-11
**Status**: ✅ ACTIVE STANDARD
**Compliance**: MANDATORY for all modules and themes
