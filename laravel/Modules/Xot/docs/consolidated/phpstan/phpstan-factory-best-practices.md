# PHPStan Best Practices per Factory Laravel - Laraxot Framework

## 🎯 Overview

Documentazione completa delle best practice PHPStan per le factory Laravel, basata sulle correzioni implementate nel modulo <nome progetto> e conformi ai principi del framework Laraxot.

## 📚 Principi Fondamentali

### 1. Template Generics per Factory Base
Le factory base che devono essere estese dovrebbero usare template generics:

```php
/**
 * UserFactory for module.
 * 
 * @template TModel of \Modules\ModuleName\Models\User
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class UserFactory extends Factory
{
    /**
     * @var class-string<\Modules\ModuleName\Models\User>
     */
    protected $model = User::class;
}
```

### 2. Factory Figlie Senza Generics
Le factory che estendono altre factory NON devono usare generics in `@extends`:

```php
/**
 * AdminFactory extends UserFactory.
 * 
 * @extends \Modules\ModuleName\Database\Factories\UserFactory
 */
class AdminFactory extends UserFactory
{
    /**
     * @var class-string<\Modules\ModuleName\Models\Admin>
     */
    protected $model = Admin::class;
}
```

## 🔧 Correzioni PHPStan Specifiche

### 1. Importazioni Safe Functions
Usare le funzioni sicure di `thecodingmachine/safe`:

```php
use function Safe\mkdir;
use function Safe\file_put_contents;

// Uso sicuro
mkdir($directory, 0755, true);
file_put_contents($filename, $content);
```

### 2. State Management con Class Strings
```php
// ❌ ERRATO
$user->state = new Active();

// ✅ CORRETTO
$user->state = Active::class;
```

### 3. Faker Methods Locale-Safe
```php
// ❌ ERRATO: year() con parametri
$this->faker->year('-15 years', '-2 years')

// ✅ CORRETTO: dateTimeBetween + format
$this->faker->dateTimeBetween('-15 years', '-2 years')->format('Y')

// ❌ ERRATO: stateAbbr() non disponibile per italiano
$this->faker->stateAbbr()

// ✅ CORRETTO: randomElement con province italiane
$this->faker->randomElement(['RM', 'MI', 'NA', 'TO', 'FI'])
```

### 4. Type Safety in Callbacks
```php
// ❌ ERRATO: Type mismatch in callback
->afterCreating(function (Doctor $doctor): void {
    // UserFactory ma callback tipizzato come Doctor
})

// ✅ CORRETTO: Consistent typing
->afterCreating(function (User $user): void {
    if ($user instanceof Doctor) {
        // Doctor-specific logic
    }
})
```

### 5. Binary Operations Type Safety
```php
// ❌ ERRATO: Binary operation con mixed
'+39 ' . $this->faker->numerify('#######')

// ✅ CORRETTO: Ensure string type
'+39 ' . (string) $this->faker->numerify('#######')
```

### 6. Null Safety in String Functions
```php
// ❌ ERRATO: Null può essere passato
strtolower($value)

// ✅ CORRETTO: Null check
strtolower($value ?? '')
```

### 7. Void Methods Documentation
Per metodi void senza side effects evidenti:

```php
/**
 * @phpstan-ignore-next-line method.void
 */
private function createMockAttachments(User $user, array $attachments): void
{
    // Placeholder implementation
}
```

## 📋 Pattern di Implementazione Corretti

### Factory Base con Template
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ModuleName\Models\User;

/**
 * @template TModel of \Modules\ModuleName\Models\User
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            // ...
        ];
    }
}
```

### Factory Specializzata
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Database\Factories;

use Modules\ModuleName\Models\Admin;

/**
 * @extends \Modules\ModuleName\Database\Factories\UserFactory
 */
class AdminFactory extends UserFactory
{
    protected $model = Admin::class;

    public function definition(): array
    {
        return array_merge(parent::definition(), [
            'type' => UserTypeEnum::ADMIN,
            'permissions' => $this->generatePermissions(),
        ]);
    }
}
```

## 🎯 Checklist PHPStan Compliance

### Pre-Implementazione
- [ ] Identificare gerarchia factory (base vs figlie)
- [ ] Pianificare uso di template generics
- [ ] Verificare dipendenze Safe functions

### Durante Implementazione
- [ ] Template generics solo su factory base
- [ ] Import Safe functions quando necessario
- [ ] Type safety in tutti i callback
- [ ] Null safety nelle operazioni stringa
- [ ] Cast espliciti per operazioni binarie

### Post-Implementazione
- [ ] Eseguire PHPStan livello 9+
- [ ] Verificare nessun errore generics
- [ ] Testare factory functionality
- [ ] Documentare pattern utilizzati

## 🔍 Strumenti di Validazione

### Comando PHPStan
```bash
cd /var/www/html/_bases/base_projectname/laravel
./vendor/bin/phpstan analyze Modules/ModuleName/database/factories --level=9
```

### Verifica Factory
```bash
php artisan tinker
>>> Modules\ModuleName\Models\User::factory()->count(5)->create()
>>> Modules\ModuleName\Models\Admin::factory()->count(2)->create()
```

## ⚠️ Errori Comuni da Evitare

### 1. Generics nelle Factory Figlie
```php
// ❌ ERRATO
/**
 * @extends \Parent\Factory<\Child\Model>
 */
class ChildFactory extends ParentFactory
```

### 2. Unsafe Functions
```php
// ❌ ERRATO
mkdir($dir);
file_put_contents($file, $content);

// ✅ CORRETTO
use function Safe\mkdir;
use function Safe\file_put_contents;
mkdir($dir);
file_put_contents($file, $content);
```

### 3. Mixed in Binary Operations
```php
// ❌ ERRATO
$result = $string . $faker->method(); // Se method() returns mixed

// ✅ CORRETTO
$result = $string . (string) $faker->method();
```

## 🔗 Risorse e Collegamenti

- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Larastan Extension](https://github.com/larastan/larastan)
- [Safe Functions Library](https://github.com/thecodingmachine/safe)
- [Laravel Factory Documentation](https://laravel.com/project_docs/database-testing#model-factories)

## 📝 Esempi Pratici

### Correzione Completa UserFactory
Vedere: `Modules/<nome progetto>/database/factories/UserFactory.php`

### Factory Specializzate Corrette
Vedere:
- `Modules/<nome progetto>/database/factories/AdminFactory.php`
- `Modules/<nome progetto>/database/factories/DoctorFactory.php`
- `Modules/<nome progetto>/database/factories/PatientFactory.php`

### Documentazione Implementazione
Vedere: `Modules/<nome progetto>/project_docs/factories/phpstan-factory-compliance.md`

## 📊 Metriche di Successo

- **0 errori PHPStan** livello 9+
- **100% type safety** in callback e operazioni
- **Compliance Safe functions** per file operations
- **Documentazione completa** di tutti i pattern

*Ultimo aggiornamento: Dicembre 2024*
*Versione: 1.0*
*Compatibilità: PHPStan 1.10+, Larastan 3.x, Laravel 11+* 
