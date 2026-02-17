# PHPStan Class Not Found Errors - Legacy Module References

## Problema

PHPStan segnala errori per classi non trovate, tipicamente riferimenti a moduli legacy o rimossi:

```
PHPDoc tag @property for property Modules\Geo\Models\Location::$creator contains unknown class Modules\Fixcity\Models\Profile.
PHPDoc tag @property for property Modules\Geo\Models\Place::$creator contains unknown class Modules\Fixcity\Models\Profile.
```

## Causa Root

1. **Moduli Legacy**: Riferimenti a moduli che sono stati rimossi o rinominati
2. **Refactoring Incompleto**: Documentazione PHPDoc non aggiornata dopo modifiche architetturali
3. **Dipendenze Obsolete**: Classi che esistevano in versioni precedenti del progetto

## Analisi del Caso Specifico

### Modules\Fixcity\Models\Profile

Questo riferimento indica che:
- Il modulo `Fixcity` esisteva precedentemente nel progetto
- È stato rimosso o rinominato
- I modelli `Location` e `Place` mantengono riferimenti obsoleti

## Soluzioni

### 1. Sostituzione con Classe Corretta

Se esiste una classe equivalente nel progetto attuale:

```php
// ❌ ERRATO - Riferimento a modulo legacy
/**
 * @property-read \Modules\Fixcity\Models\Profile|null $creator
 * @property-read \Modules\Fixcity\Models\Profile|null $updater
 */

// ✅ CORRETTO - Riferimento a classe esistente
/**
 * @property-read \Modules\User\Models\User|null $creator
 * @property-read \Modules\User\Models\User|null $updater
 */
```

### 2. Rimozione di Proprietà Obsolete

Se le proprietà non sono più utilizzate:

```php
// ❌ ERRATO - Proprietà obsolete
/**
 * @property-read \Modules\Fixcity\Models\Profile|null $creator
 * @property-read \Modules\Fixcity\Models\Profile|null $updater
 */

// ✅ CORRETTO - Proprietà rimosse
/**
 * Class Location.
 *
 * @property int $id
 * @property string $name
 * @property float $latitude
 * @property float $longitude
 */
```

### 3. Creazione di Stub Class (Temporaneo)

Per compatibilità temporanea durante refactoring:

```php
// Modules/Fixcity/Models/Profile.php (stub temporaneo)
<?php

declare(strict_types=1);

namespace Modules\Fixcity\Models;

/**
 * @deprecated Use \Modules\User\Models\User instead
 */
class Profile
{
    // Stub class for backward compatibility
}
```

## Pattern di Correzione

### Identificazione delle Classi Mancanti

```bash

# Trova tutti i riferimenti a classi non esistenti
grep -r "Modules\\\\Fixcity" Modules/*/app/Models/ --include="*.php"
```

### Script di Sostituzione Automatica

```bash
#!/bin/bash

# Replace legacy class references

find Modules -name "*.php" -type f -exec sed -i 's/\\Modules\\Fixcity\\Models\\Profile/\\Modules\\User\\Models\\User/g' {} \;
```

### Validazione Post-Correzione

```bash
./vendor/bin/phpstan analyze Modules/Geo --level=9 --no-progress
```

## Implementazione per Location e Place

### Location.php - Correzione

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

/**
 * Class Location.
 *
 * @property int $id
 * @property string $name
 * @property float $latitude
 * @property float $longitude
 * @property string|null $address
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Modules\User\Models\User|null $creator
 * @property-read \Modules\User\Models\User|null $updater
 */
class Location extends BaseModel
{
    // Implementation
}
```

### Place.php - Correzione

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

/**
 * Class Place.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float|null $latitude
 * @property float|null $longitude
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Modules\User\Models\User|null $creator
 * @property-read \Modules\User\Models\User|null $updater
 */
class Place extends BaseModel
{
    // Implementation
}
```

## Best Practices

### 1. Audit Periodico

Eseguire controlli regolari per identificare riferimenti obsoleti:

```bash

# Script di audit per classi non esistenti
./vendor/bin/phpstan analyze --level=9 --error-format=json | jq '.files[].messages[] | select(.message | contains("unknown class"))'
```

### 2. Documentazione delle Migrazioni

Mantenere un log delle classi rimosse/rinominate:

```markdown

## Changelog Classi

### 2025-07-31
- `Modules\Fixcity\Models\Profile` → `Modules\User\Models\User`
- Motivo: Consolidamento moduli utente
```

### 3. Refactoring Graduale

Per progetti grandi, implementare la sostituzione gradualmente:

1. Identificare tutti i riferimenti
2. Creare mapping delle sostituzioni
3. Applicare le modifiche modulo per modulo
4. Validare con PHPStan dopo ogni modulo

## Prevenzione

### 1. IDE Configuration

Configurare l'IDE per segnalare classi non esistenti:

```json
// .vscode/settings.json
{
    "php.validate.enable": true,
    "php.suggest.basic": false
}
```

### 2. CI/CD Integration

Includere controlli PHPStan nella pipeline:

```yaml

# .github/workflows/phpstan.yml
- name: Run PHPStan
  run: ./vendor/bin/phpstan analyze --level=9 --error-format=github
```

### 3. Pre-commit Hooks

```bash
#!/bin/sh

# .git/hooks/pre-commit
./vendor/bin/phpstan analyze --level=9 --no-progress --quiet
```

## Note Tecniche

1. **Namespace Resolution**: PHP risolve i namespace al runtime, PHPStan li analizza staticamente
2. **Autoloading**: Classi non caricate dall'autoloader generano errori PHPStan
3. **Composer Dump**: Dopo modifiche ai namespace, eseguire `composer dump-autoload`

## Riferimenti

- [PHPStan Class Discovery](https://phpstan.org/user-guide/discovering-symbols)
- [Laravel Autoloading](https://laravel.com/project_docs/structure#autoloading)
- [Modules/Geo/project_docs/README.md](./README.md)

## Backlink

- [Root PHPStan Rules](../../../project_docs/phpstan_rules.md)
- [Geo Module Structure](./structure.md)
- [Employee PHPStan Covariance](../../Employee/project_docs/phpstan_covariance_issues.md)

*Ultimo aggiornamento: 2025-07-31*
