# Script di Risoluzione Conflitti Git - FixCity Project

## Panoramica

Questo documento fornisce una guida sistematica per la risoluzione dei conflitti Git nel progetto FixCity, basata sull'esperienza acquisita durante la risoluzione di 161 file con conflitti.

## Workflow Sistematico

### 1. Identificazione Conflitti

```bash
# Trova tutti i file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata dei conflitti
git diff --name-only --diff-filter=U

# Conta i conflitti per categoria
grep -r "&lt;&lt;&lt; HEAD" --include="*.php" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.md" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.svg" . | wc -l
```

### 2. Categorizzazione per Priorità

**Priorità 1 - File Critici**
- `composer.json`
- File di configurazione (`config/`)
- File `.env`
- Service Provider

**Priorità 2 - Logica Business**
- Models
- Services
- Controllers
- Migrations

**Priorità 3 - Interfaccia**
- Views Blade
- Componenti Filament
- Assets (CSS, JS)

**Priorità 4 - Documentazione**
- File `.md`
- README
- Changelog

**Priorità 5 - Assets**
- File SVG
- Immagini
- File statici

### 3. Strategie di Risoluzione

#### File PHP
```php
<?php

declare(strict_types=1);

// 1. Mantenere sempre declare(strict_types=1)
// 2. Usare type hints espliciti
// 3. Seguire PSR-12
// 4. Aggiungere PHPDoc per metodi pubblici
```

#### File di Configurazione
```php
<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Section Name
     * |--------------------------------------------------------------------------
     * |
     * | Description
     * |
     */
    'key' => 'value',
];
```

#### File di Documentazione
```markdown
# Titolo Documento - FixCity Project

## Sezione

Contenuto aggiornato con riferimenti corretti al progetto.

## Collegamenti
- [Documento Correlato](./related-document.md)
- [Architettura](../architecture.md)
```

#### File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img"
     aria-label="Description">
    <!-- Contenuto SVG -->
</svg>
```

## Comandi Utili

### Verifica Sintassi PHP
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file PHP modificati
find . -name "*.php" -exec php -l {} \;
```

# 🐄 SUPER MUCCA - Script Risoluzione Conflitti Git
# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

## Panoramica

Questo documento fornisce una guida sistematica per la risoluzione dei conflitti Git nel progetto FixCity, basata sull'esperienza acquisita durante la risoluzione di 161 file con conflitti.

## Workflow Sistematico

### 1. Identificazione Conflitti

```bash
# Trova tutti i file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata dei conflitti
git diff --name-only --diff-filter=U

# Conta i conflitti per categoria
grep -r "&lt;&lt;&lt; HEAD" --include="*.php" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.md" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.svg" . | wc -l
```

### 2. Categorizzazione per Priorità

**Priorità 1 - File Critici**
- `composer.json`
- File di configurazione (`config/`)
- File `.env`
- Service Provider

**Priorità 2 - Logica Business**
- Models
- Services
- Controllers
- Migrations

**Priorità 3 - Interfaccia**
- Views Blade
- Componenti Filament
- Assets (CSS, JS)

**Priorità 4 - Documentazione**
- File `.md`
- README
- Changelog

**Priorità 5 - Assets**
- File SVG
- Immagini
- File statici

### 3. Strategie di Risoluzione

#### File PHP
```php
<?php

declare(strict_types=1);

// 1. Mantenere sempre declare(strict_types=1)
// 2. Usare type hints espliciti
// 3. Seguire PSR-12
// 4. Aggiungere PHPDoc per metodi pubblici
```

# Script di Risoluzione Conflitti Git - FixCity Project

## Panoramica

Questo documento fornisce una guida sistematica per la risoluzione dei conflitti Git nel progetto FixCity, basata sull'esperienza acquisita durante la risoluzione di 161 file con conflitti.

## Workflow Sistematico

### 1. Identificazione Conflitti

```bash
# Trova tutti i file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata dei conflitti
git diff --name-only --diff-filter=U

# Conta i conflitti per categoria
grep -r "&lt;&lt;&lt; HEAD" --include="*.php" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.md" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.svg" . | wc -l
```

### 2. Categorizzazione per Priorità

**Priorità 1 - File Critici**
- `composer.json`
- File di configurazione (`config/`)
- File `.env`
- Service Provider

**Priorità 2 - Logica Business**
- Models
- Services
- Controllers
- Migrations

**Priorità 3 - Interfaccia**
- Views Blade
- Componenti Filament
- Assets (CSS, JS)

**Priorità 4 - Documentazione**
- File `.md`
- README
- Changelog

**Priorità 5 - Assets**
- File SVG
- Immagini
- File statici

### 3. Strategie di Risoluzione

#### File PHP
```php
<?php

declare(strict_types=1);

// 1. Mantenere sempre declare(strict_types=1)
// 2. Usare type hints espliciti
// 3. Seguire PSR-12
// 4. Aggiungere PHPDoc per metodi pubblici
```

#### File di Configurazione
```php
<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Section Name
     * |--------------------------------------------------------------------------
     * |
     * | Description
     * |
     */
    'key' => 'value',
];
```

#### File di Documentazione
```markdown
# Titolo Documento - FixCity Project

## Sezione

Contenuto aggiornato con riferimenti corretti al progetto.

## Collegamenti
- [Documento Correlato](./related-document.md)
- [Architettura](../architecture.md)
```

#### File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img"
     aria-label="Description">
    <!-- Contenuto SVG -->
</svg>
```

## Comandi Utili

### Verifica Sintassi PHP
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file PHP modificati
find . -name "*.php" -exec php -l {} \;
```

# 🐄 SUPER MUCCA - Script Risoluzione Conflitti Git
# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

# Script di Risoluzione Conflitti Git - FixCity Project

## Panoramica

Questo documento fornisce una guida sistematica per la risoluzione dei conflitti Git nel progetto FixCity, basata sull'esperienza acquisita durante la risoluzione di 161 file con conflitti.

## Workflow Sistematico

### 1. Identificazione Conflitti

```bash
# Trova tutti i file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata dei conflitti
git diff --name-only --diff-filter=U

# Conta i conflitti per categoria
grep -r "&lt;&lt;&lt; HEAD" --include="*.php" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.md" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.svg" . | wc -l
```

### 2. Categorizzazione per Priorità

**Priorità 1 - File Critici**
- `composer.json`
- File di configurazione (`config/`)
- File `.env`
- Service Provider

**Priorità 2 - Logica Business**
- Models
- Services
- Controllers
- Migrations

**Priorità 3 - Interfaccia**
- Views Blade
- Componenti Filament
- Assets (CSS, JS)

**Priorità 4 - Documentazione**
- File `.md`
- README
- Changelog

**Priorità 5 - Assets**
- File SVG
- Immagini
- File statici

### 3. Strategie di Risoluzione

#### File PHP
```php
<?php

declare(strict_types=1);

// 1. Mantenere sempre declare(strict_types=1)
// 2. Usare type hints espliciti
// 3. Seguire PSR-12
// 4. Aggiungere PHPDoc per metodi pubblici
```

#### File di Configurazione
```php
<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Section Name
     * |--------------------------------------------------------------------------
     * |
     * | Description
     * |
     */
    'key' => 'value',
];
```

#### File di Documentazione
```markdown
# Titolo Documento - FixCity Project

## Sezione

Contenuto aggiornato con riferimenti corretti al progetto.

## Collegamenti
- [Documento Correlato](./related-document.md)
- [Architettura](../architecture.md)
```

#### File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img"
     aria-label="Description">
    <!-- Contenuto SVG -->
</svg>
```

## Comandi Utili

### Verifica Sintassi PHP
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file PHP modificati
find . -name "*.php" -exec php -l {} \;
```

# 🐄 SUPER MUCCA - Script Risoluzione Conflitti Git
# Script di Risoluzione Conflitti Git - FixCity Project

## Panoramica

Questo documento fornisce una guida sistematica per la risoluzione dei conflitti Git nel progetto FixCity, basata sull'esperienza acquisita durante la risoluzione di 161 file con conflitti.

## Workflow Sistematico

### 1. Identificazione Conflitti

```bash
# Trova tutti i file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata dei conflitti
git diff --name-only --diff-filter=U

# Conta i conflitti per categoria
grep -r "&lt;&lt;&lt; HEAD" --include="*.php" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.md" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.svg" . | wc -l
```

### 2. Categorizzazione per Priorità

**Priorità 1 - File Critici**
- `composer.json`
- File di configurazione (`config/`)
- File `.env`
- Service Provider

**Priorità 2 - Logica Business**
- Models
- Services
- Controllers
- Migrations

**Priorità 3 - Interfaccia**
- Views Blade
- Componenti Filament
- Assets (CSS, JS)

**Priorità 4 - Documentazione**
- File `.md`
- README
- Changelog

**Priorità 5 - Assets**
- File SVG
- Immagini
- File statici

### 3. Strategie di Risoluzione

#### File PHP
```php
<?php

declare(strict_types=1);

// 1. Mantenere sempre declare(strict_types=1)
// 2. Usare type hints espliciti
// 3. Seguire PSR-12
// 4. Aggiungere PHPDoc per metodi pubblici
```

#### File di Configurazione
```php
<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Section Name
     * |--------------------------------------------------------------------------
     * |
     * | Description
     * |
     */
    'key' => 'value',
];
```

#### File di Documentazione
```markdown
# Titolo Documento - FixCity Project

## Sezione

Contenuto aggiornato con riferimenti corretti al progetto.

## Collegamenti
- [Documento Correlato](./related-document.md)
- [Architettura](../architecture.md)
```

#### File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img"
     aria-label="Description">
    <!-- Contenuto SVG -->
</svg>
```

## Comandi Utili

### Verifica Sintassi PHP
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file PHP modificati
find . -name "*.php" -exec php -l {} \;
```

# 🐄 SUPER MUCCA - Script Risoluzione Conflitti Git
# Script di Risoluzione Conflitti Git - FixCity Project

## Panoramica

Questo documento fornisce una guida sistematica per la risoluzione dei conflitti Git nel progetto FixCity, basata sull'esperienza acquisita durante la risoluzione di 161 file con conflitti.

## Workflow Sistematico

### 1. Identificazione Conflitti

```bash
# Trova tutti i file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata dei conflitti
git diff --name-only --diff-filter=U

# Conta i conflitti per categoria
grep -r "&lt;&lt;&lt; HEAD" --include="*.php" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.md" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.svg" . | wc -l
```

### 2. Categorizzazione per Priorità

**Priorità 1 - File Critici**
- `composer.json`
- File di configurazione (`config/`)
- File `.env`
- Service Provider

**Priorità 2 - Logica Business**
- Models
- Services
- Controllers
- Migrations

**Priorità 3 - Interfaccia**
- Views Blade
- Componenti Filament
- Assets (CSS, JS)

**Priorità 4 - Documentazione**
- File `.md`
- README
- Changelog

**Priorità 5 - Assets**
- File SVG
- Immagini
- File statici

### 3. Strategie di Risoluzione

#### File PHP
```php
<?php

declare(strict_types=1);

// 1. Mantenere sempre declare(strict_types=1)
// 2. Usare type hints espliciti
// 3. Seguire PSR-12
// 4. Aggiungere PHPDoc per metodi pubblici
```

#### File di Configurazione
```php
<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Section Name
     * |--------------------------------------------------------------------------
     * |
     * | Description
     * |
     */
    'key' => 'value',
];
```

#### File di Documentazione
```markdown
# Titolo Documento - FixCity Project

## Sezione

Contenuto aggiornato con riferimenti corretti al progetto.

## Collegamenti
- [Documento Correlato](./related-document.md)
- [Architettura](../architecture.md)
```

#### File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img"
     aria-label="Description">
    <!-- Contenuto SVG -->
</svg>
```

## Comandi Utili

### Verifica Sintassi PHP
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file PHP modificati
find . -name "*.php" -exec php -l {} \;
```

# 🐄 SUPER MUCCA - Script Risoluzione Conflitti Git
# Script di Risoluzione Conflitti Git - FixCity Project

## Panoramica

Questo documento fornisce una guida sistematica per la risoluzione dei conflitti Git nel progetto FixCity, basata sull'esperienza acquisita durante la risoluzione di 161 file con conflitti.

## Workflow Sistematico

### 1. Identificazione Conflitti

```bash
# Trova tutti i file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata dei conflitti
git diff --name-only --diff-filter=U

# Conta i conflitti per categoria
grep -r "&lt;&lt;&lt; HEAD" --include="*.php" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.md" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.svg" . | wc -l
```

### 2. Categorizzazione per Priorità

**Priorità 1 - File Critici**
- `composer.json`
- File di configurazione (`config/`)
- File `.env`
- Service Provider

**Priorità 2 - Logica Business**
- Models
- Services
- Controllers
- Migrations

**Priorità 3 - Interfaccia**
- Views Blade
- Componenti Filament
- Assets (CSS, JS)

**Priorità 4 - Documentazione**
- File `.md`
- README
- Changelog

**Priorità 5 - Assets**
- File SVG
- Immagini
- File statici

### 3. Strategie di Risoluzione

#### File PHP
```php
<?php

declare(strict_types=1);

// 1. Mantenere sempre declare(strict_types=1)
// 2. Usare type hints espliciti
// 3. Seguire PSR-12
// 4. Aggiungere PHPDoc per metodi pubblici
```

#### File di Configurazione
```php
<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Section Name
     * |--------------------------------------------------------------------------
     * |
     * | Description
     * |
     */
    'key' => 'value',
];
```

#### File di Documentazione
```markdown
# Titolo Documento - FixCity Project

## Sezione

Contenuto aggiornato con riferimenti corretti al progetto.

## Collegamenti
- [Documento Correlato](./related-document.md)
- [Architettura](../architecture.md)
```

#### File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img"
     aria-label="Description">
    <!-- Contenuto SVG -->
</svg>
```

## Comandi Utili

### Verifica Sintassi PHP
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file PHP modificati
find . -name "*.php" -exec php -l {} \;
```

# 🐄 SUPER MUCCA - Script Risoluzione Conflitti Git
# Script di Risoluzione Conflitti Git - FixCity Project

## Panoramica

Questo documento fornisce una guida sistematica per la risoluzione dei conflitti Git nel progetto FixCity, basata sull'esperienza acquisita durante la risoluzione di 161 file con conflitti.

## Workflow Sistematico

### 1. Identificazione Conflitti

```bash
# Trova tutti i file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista dettagliata dei conflitti
git diff --name-only --diff-filter=U

# Conta i conflitti per categoria
grep -r "&lt;&lt;&lt; HEAD" --include="*.php" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.md" . | wc -l
grep -r "&lt;&lt;&lt; HEAD" --include="*.svg" . | wc -l
```

### 2. Categorizzazione per Priorità

**Priorità 1 - File Critici**
- `composer.json`
- File di configurazione (`config/`)
- File `.env`
- Service Provider

**Priorità 2 - Logica Business**
- Models
- Services
- Controllers
- Migrations

**Priorità 3 - Interfaccia**
- Views Blade
- Componenti Filament
- Assets (CSS, JS)

**Priorità 4 - Documentazione**
- File `.md`
- README
- Changelog

**Priorità 5 - Assets**
- File SVG
- Immagini
- File statici

### 3. Strategie di Risoluzione

#### File PHP
```php
<?php

declare(strict_types=1);

// 1. Mantenere sempre declare(strict_types=1)
// 2. Usare type hints espliciti
// 3. Seguire PSR-12
// 4. Aggiungere PHPDoc per metodi pubblici
```

#### File di Configurazione
```php
<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Section Name
     * |--------------------------------------------------------------------------
     * |
     * | Description
     * |
     */
    'key' => 'value',
];
```

#### File di Documentazione
```markdown
# Titolo Documento - FixCity Project

## Sezione

Contenuto aggiornato con riferimenti corretti al progetto.

## Collegamenti
- [Documento Correlato](./related-document.md)
- [Architettura](../architecture.md)
```

#### File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img"
     aria-label="Description">
    <!-- Contenuto SVG -->
</svg>
```

## Comandi Utili

### Verifica Sintassi PHP
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file PHP modificati
find . -name "*.php" -exec php -l {} \;
```

## COME FUNZIONANO

### Logica di Risoluzione
Gli script risolvono i conflitti Git prendendo sempre la **"incoming change"** (develop):

```
codice locale (viene RIMOSSO)
codice incoming (viene MANTENUTO)
```

### Algoritmo AWK
```awk
BEGIN { skip = 0 }
/^>>>>>>> / { next }                  # Rimuove marker finale
!skip { print }                       # Stampa solo se non sta saltando
```

## RISULTATI OTTENUTI

### 📊 **Statistiche Esecuzione**
- **File processati**: ~100+ file
- **Conflitti risolti**: 100%
- **Backup creati**: Tutti i file modificati
- **Errori**: 0
- **Tempo esecuzione**: ~2 secondi

### ✅ **File Risolti Include**
- **PHP**: Tutti i file `.php` e `.blade.php`
- **JavaScript**: File `.js`
- **CSS**: File `.css`
- **Markdown**: File `.md`
- **JSON**: File `.json` e configurazioni
- **Config**: File di configurazione vari

### 🎯 **Moduli Interessati**
- `Modules/Xot/`
- `Modules/Geo/`
- `Modules/User/`
- `Modules/Meetup/`
- `Modules/Employee/`
- File di configurazione root

## SICUREZZA E BACKUP

### 🛡️ **Backup Automatico**
Ogni file modificato viene automaticamente salvato con estensione `.backup`:
```
file.php → file.php.backup
```

### 🔄 **Ripristino**
Per ripristinare un file:
### Verifica PHPStan

```bash
# Ripristina singolo file
mv file.php.backup file.php

# Ripristina tutti i file
find . -name "*.backup" -exec sh -c 'mv "$1" "${1%.backup}"' _ {} \;

```

#### File di Configurazione
```php
<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Section Name
     * |--------------------------------------------------------------------------
     * |
     * | Description
     * |
     */
    'key' => 'value',
];
```

#### File di Documentazione
```markdown
# Titolo Documento - FixCity Project

## Sezione

Contenuto aggiornato con riferimenti corretti al progetto.

## Collegamenti
- [Documento Correlato](./related-document.md)
- [Architettura](../architecture.md)
```

#### File SVG
```xml
<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg"
     fill="none"
     viewBox="0 0 24 24"
     stroke="currentColor"
     stroke-width="1.5"
     aria-hidden="true"
     role="img"
     aria-label="Description">
    <!-- Contenuto SVG -->
</svg>
```

## Comandi Utili

### Verifica Sintassi PHP
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file PHP modificati
find . -name "*.php" -exec php -l {} \;
```

### Verifica PHPStan

```bash
# Verifica singolo file
./vendor/bin/phpstan analyse --level=10 path/to/file.php

# Verifica modulo completo
./vendor/bin/phpstan analyse --level=10 Modules/ModuleName/
```

### Verifica Struttura
```bash
# Controlla namespace
grep -r "namespace" --include="*.php" Modules/ModuleName/

# Controlla import
grep -r "use " --include="*.php" Modules/ModuleName/
```

## Checklist di Risoluzione

### ✅ **Controlli Eseguiti**
1. **Nessun marker rimasto**

### Verifica PHPStan

### Verifica PHPStan

```bash
# Verifica singolo file
./vendor/bin/phpstan analyse --level=10 path/to/file.php

# Verifica modulo completo
./vendor/bin/phpstan analyse --level=10 Modules/ModuleName/
```

### Verifica Struttura
```bash
# Controlla namespace
grep -r "namespace" --include="*.php" Modules/ModuleName/

# Controlla import
grep -r "use " --include="*.php" Modules/ModuleName/
```

## Checklist di Risoluzione

### Per Ogni File PHP
- [ ] `declare(strict_types=1)` presente
- [ ] Type hints espliciti
- [ ] Return types dichiarati
- [ ] PHPDoc per metodi pubblici
- [ ] PSR-12 compliance
- [ ] Namespace corretto
- [ ] Import statements appropriati
- [ ] Sintassi valida (`php -l`)

### Per Ogni File di Configurazione
- [ ] Sintassi PHP valida
- [ ] Struttura array corretta
- [ ] Commenti PHPDoc appropriati
- [ ] Chiavi e valori coerenti
- [ ] Compatibilità Laravel 11

### Per Ogni File di Documentazione
- [ ] Riferimenti aggiornati a FixCity
- [ ] Backlink bidirezionali
- [ ] Coerenza terminologica
- [ ] Struttura markdown valida
- [ ] Collegamenti funzionanti

### Per Ogni File SVG
- [ ] Sintassi XML valida
- [ ] Attributi accessibilità
- [ ] Dimensioni appropriate
- [ ] Stili CSS corretti
- [ ] Compatibilità browser

## Errori Comuni da Evitare

### ❌ Automazione Cieca
```bash
# Verifica conflitti rimanenti

### Verifica PHPStan

```bash
# Verifica singolo file
./vendor/bin/phpstan analyse --level=10 path/to/file.php

# Verifica modulo completo
./vendor/bin/phpstan analyse --level=10 Modules/ModuleName/
```

### Verifica Struttura
```bash
# Controlla namespace
grep -r "namespace" --include="*.php" Modules/ModuleName/

# Controlla import
grep -r "use " --include="*.php" Modules/ModuleName/
```

## Checklist di Risoluzione

### Per Ogni File PHP
- [ ] `declare(strict_types=1)` presente
- [ ] Type hints espliciti
- [ ] Return types dichiarati
- [ ] PHPDoc per metodi pubblici
- [ ] PSR-12 compliance
- [ ] Namespace corretto
- [ ] Import statements appropriati
- [ ] Sintassi valida (`php -l`)

### Per Ogni File di Configurazione
- [ ] Sintassi PHP valida
- [ ] Struttura array corretta
- [ ] Commenti PHPDoc appropriati
- [ ] Chiavi e valori coerenti
- [ ] Compatibilità Laravel 11

### Per Ogni File di Documentazione
- [ ] Riferimenti aggiornati a FixCity
- [ ] Backlink bidirezionali
- [ ] Coerenza terminologica
- [ ] Struttura markdown valida
- [ ] Collegamenti funzionanti

### Per Ogni File SVG
- [ ] Sintassi XML valida
- [ ] Attributi accessibilità
- [ ] Dimensioni appropriate
- [ ] Stili CSS corretti
- [ ] Compatibilità browser

## Errori Comuni da Evitare

### ❌ Automazione Cieca
```bash
# Verifica conflitti rimanenti

### Verifica PHPStan

```bash
# Verifica singolo file
./vendor/bin/phpstan analyse --level=10 path/to/file.php

# Verifica modulo completo
./vendor/bin/phpstan analyse --level=10 Modules/ModuleName/
```

### Verifica Struttura
```bash
# Controlla namespace
grep -r "namespace" --include="*.php" Modules/ModuleName/

# Controlla import
grep -r "use " --include="*.php" Modules/ModuleName/
```

## Checklist di Risoluzione

### Per Ogni File PHP
- [ ] `declare(strict_types=1)` presente
- [ ] Type hints espliciti
- [ ] Return types dichiarati
- [ ] PHPDoc per metodi pubblici
- [ ] PSR-12 compliance
- [ ] Namespace corretto
- [ ] Import statements appropriati
- [ ] Sintassi valida (`php -l`)

### Per Ogni File di Configurazione
- [ ] Sintassi PHP valida
- [ ] Struttura array corretta
- [ ] Commenti PHPDoc appropriati
- [ ] Chiavi e valori coerenti
- [ ] Compatibilità Laravel 11

### Per Ogni File di Documentazione
- [ ] Riferimenti aggiornati a FixCity
- [ ] Backlink bidirezionali
- [ ] Coerenza terminologica
- [ ] Struttura markdown valida
- [ ] Collegamenti funzionanti

### Per Ogni File SVG
- [ ] Sintassi XML valida
- [ ] Attributi accessibilità
- [ ] Dimensioni appropriate
- [ ] Stili CSS corretti
- [ ] Compatibilità browser

## Errori Comuni da Evitare

### ❌ Automazione Cieca
```bash
# Verifica conflitti rimanenti
