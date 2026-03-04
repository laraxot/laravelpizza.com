# Best Practices Progetto Laraxot PTVX - 2025

> **Documento Master** - Regole fondamentali aggiornate dopo risoluzione massiva merge conflicts

## 🔐 REGOLE FONDAMENTALI (NON NEGOZIABILI)

### 1. File Locking Pattern ⭐ NUOVO ⭐

**SEMPRE** prima di modificare un file:

```bash
# Check se locked
if [ -f "file.php.lock" ]; then
    echo "File locked, skipping"
    exit 0
fi

# Acquisisci lock
touch file.php.lock

# Modifica il file
# ... your changes ...

# Rilascia lock
rm file.php.lock
```

**Filosofia:**
> "Un file alla volta, un maestro alla volta."

📚 **Documentazione:** [file-locking-pattern.md](./file-locking-pattern.md)

### 2. Namespace PSR-4 Laraxot

**I namespace NON includono il segmento `app/`:**

```php
// File: Modules/User/app/Models/User.php
// ✅ CORRETTO
namespace Modules\User\Models;

// ❌ SBAGLIATO
namespace Modules\User\App\Models;
```

### 3. XotBase Classes Obbligatorie

**MAI estendere Filament direttamente:**

```php
// ❌ SBAGLIATO
class MyPage extends Filament\Resources\Pages\EditRecord

// ✅ CORRETTO
class MyPage extends Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
```

### 4. No Hardcoded Labels

**Traduzioni gestite automaticamente:**

```php
// ❌ SBAGLIATO
TextInput::make('name')->label('Nome')

// ✅ CORRETTO
TextInput::make('name')  // Label automatica da translations
```

### 5. Actions > Services

**Usa Spatie QueueableActions:**

```php
// ❌ SBAGLIATO
class UserService { ... }

// ✅ CORRETTO
class CreateUserAction
{
    use QueueableAction;
    public function execute(UserData $data): User { ... }
}
```

### 6. Type Safety Strict

**Sempre:**

```php
<?php

declare(strict_types=1);

// Return types obbligatori
public function method(string $param): bool
{
    // Implementation
}
```

### 7. Documentation Naming

**kebab-case lowercase, NO dates:**

```bash
# ✅ CORRETTO
my-document.md
business-logic.md
architecture-overview.md

# ❌ SBAGLIATO
MY_DOCUMENT.md              # UPPERCASE
my_document.md              # underscore
analysis-2025-11-04.md      # date in name (use CHANGELOG.md)
```

### 8. DRY Principle

**Prima di creare nuovo file/classe:**
1. CERCA se esiste già
2. Considera aggiornare esistente
3. Solo se necessario, crea nuovo

### 9. Git Workflow

**Commit atomici con message chiari:**

```bash
# ✅ BUONO
git commit -m "fix(xot): resolve merge conflicts in RouteServiceProvider

- Remove duplicate if statements
- Fix unclosed braces
- Apply file locking pattern"

# ❌ CATTIVO
git commit -m "fix stuff"
```

### 10. Testing Obbligatorio

**Ogni change DEVE avere test:**

```bash
# Pest v3
php artisan make:test --pest MyFeatureTest
php artisan test --filter=MyFeatureTest
```

## 📋 Checklist Pre-Commit

Prima di ogni commit, verifica:

- [ ] ✅ File locking applicato durante modifiche
- [ ] ✅ Namespace PSR-4 corretto (NO `App\` nel namespace)
- [ ] ✅ XotBase classes usate (NO direct Filament extends)
- [ ] ✅ Nessun ->label() hardcoded
- [ ] ✅ Actions usate (NO Services)
- [ ] ✅ `declare(strict_types=1)` presente
- [ ] ✅ Return types dichiarati
- [ ] ✅ `php -l file.php` passa (no syntax errors)
- [ ] ✅ `vendor/bin/pint --dirty` eseguito
- [ ] ✅ Tests scritti e passanti
- [ ] ✅ PHPStan warnings risolti (quando possibile)
- [ ] ✅ Documentation aggiornata se necessario

## 🚫 Anti-Patterns da Evitare

### ❌ Merge Conflicts Non Risolti

```php
// ❌ LASCIARE DUPLICAZIONI
if (! $condition) {
if (! $condition) {
if (!$condition) {
    return;
}

// ❌ LASCIARE MARKER GIT
```

### ❌ Import Duplicati

```php
// ❌ SBAGLIATO
use Filament\Actions\Action;
use Illuminate\Support\Str;
use Filament\Actions\Action;  // Duplicato!
```

### ❌ Proprietà/Metodi Duplicati

```php
// ❌ SBAGLIATO
public ?string $name = null;
public null|string $name = null;  // Stesso significato, syntax diversa

public function method(): ?string { }
public function method(): null|string { }  // Duplicato
```

### ❌ Services invece di Actions

```php
// ❌ SBAGLIATO
class UserService
{
    public function create(array $data) { }
}

// ✅ CORRETTO
class CreateUserAction
{
    use QueueableAction;
    public function execute(UserData $data): User { }
}
```

### ❌ Direct Filament Extends

```php
// ❌ SBAGLIATO
class MyPage extends \Filament\Resources\Pages\EditRecord

// ✅ CORRETTO
class MyPage extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
```

## 🎯 Pattern Corretti da Seguire

### ✅ Type Safety

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\ModuleName\Datas\MyData;

class MyAction
{
    use QueueableAction;

    public function execute(MyData $data): MyData
    {
        // Business logic
        return $data;
    }
}
```

### ✅ Filament Resource

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class MyResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('name'),  // No ->label()!
            TextInput::make('email'),
        ];
    }
}
```

### ✅ Model with BaseModel

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Models;

use Modules\Xot\Models\BaseModel;

class MyModel extends BaseModel
{
    protected $fillable = ['name', 'email'];

    // Relationships, scopes, accessors...
}
```

## 🔧 Tools Workflow

### Pre-Development
```bash
# Pull latest
git pull origin develop

# Check module status
php artisan module:list

# Clear caches
php artisan config:clear
php artisan route:clear
```

### During Development
```bash
# File locking (manuale o script)
touch file.php.lock

# Make changes...

# Release lock
rm file.php.lock
```

### Pre-Commit
```bash
# Format code
vendor/bin/pint --dirty

# Check syntax
php -l path/to/file.php

# Run tests
php artisan test --filter=MyTest

# PHPStan (se modifiche core)
./vendor/bin/phpstan analyse Modules/ModuleName --memory-limit=2G
```

### Commit
```bash
git add .
git commit -m "type(module): brief description

- Detail 1
- Detail 2"
git push origin feature-branch
```

## 📚 Documentazione Required

### Per Nuove Feature
- [ ] README del modulo aggiornato
- [ ] Tests scritti (coverage >80%)
- [ ] Se nuovo pattern: documento in `docs/`
- [ ] Se API: aggiornare `api.md`

### Per Bug Fix
- [ ] Se merge conflict: documentare pattern
- [ ] Se architectural: aggiornare architecture docs
- [ ] Aggiungere a troubleshooting.md se comune

## 🎓 Training e Onboarding

### Week 1: Foundations
- Giorno 1-2: Leggi 10 essential docs
- Giorno 3: Setup ambiente + primi test
- Giorno 4-5: Piccole modifiche supervised

### Week 2: Practice
- Implementa feature semplice end-to-end
- Code review con senior
- Applica tutti i pattern appresi

### Week 3: Autonomy
- Feature completa autonoma
- Contribuisci a documentazione
- Help altri developer

## 🔗 Resources

### Documentazione Interna
- [Index Completo](./index.md) - Navigazione tutte le 2,560 docs
- [Essential Reading](./essential-reading.md) - Top 10 docs
- [Consolidation Strategy](./documentation-consolidation-strategy.md) - Piano riduzione docs

### Documentazione Laravel Ecosystem
- [Laravel 12 Docs](https://laravel.com/docs/12.x)
- [Filament 4 Docs](https://filamentphp.com/docs/4.x)
- [Livewire 3 Docs](https://livewire.laravel.com/docs/3.x)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data)
- [Spatie QueueableAction](https://github.com/spatie/laravel-queueable-action)

### External Standards
- [PSR-12 Coding Style](https://www.php-fig.org/psr/psr-12/)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [Conventional Commits](https://www.conventionalcommits.org/)

---

**Creato:** 2025-11-04  
**Versione:** 1.0  
**Autori:** Team Laraxot + AI Claude Process Filosofico  
**Prossimo Review:** Trimestrale o dopo major changes

