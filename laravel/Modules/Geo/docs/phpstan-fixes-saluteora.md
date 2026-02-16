# Correzioni PHPStan <nome progetto> - Uso Azioni Cast Xot

## Descrizione
Questo documento documenta le correzioni PHPStan per il modulo <nome progetto> utilizzando le azioni di casting pre-esistenti in `laravel/Modules/Xot/app/Actions/Cast`.
# Correzioni PHPStan <nome progetto> - Uso Azioni Cast Xot

## Descrizione
Questo documento documenta le correzioni PHPStan per il modulo <nome progetto> utilizzando le azioni di casting pre-esistenti in `laravel/Modules/Xot/app/Actions/Cast`.

## Principio Fondamentale
**SEMPRE** utilizzare le azioni di casting Xot invece di cast manuali per risolvere errori PHPStan e garantire type safety.

## Errori Risolti

### 1. AppointmentFactory.php

#### Errore: `encapsedStringPart.nonString`
**Linea**: 42
**Problema**: `$duration` (mixed) non può essere castato a string in interpolazione

**Soluzione**:
```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// Prima (ERRATO)
$endTime = $startTime->copy()->addMinutes($duration);

// Dopo (CORRETTO)
$duration = SafeIntCastAction::cast($duration);
$endTime = $startTime->copy()->addMinutes($duration);
```

#### Errore: `property.nonObject`
**Linee**: 71-72
**Problema**: Accesso a proprietà `$value` su tipo mixed

**Soluzione**:
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// Prima (ERRATO)
$type = $this->faker->randomElement(AppointmentTypeEnum::cases())->value;
$status = $this->faker->randomElement(AppointmentStatusEnum::cases())->value;

// Dopo (CORRETTO)
$type = SafeStringCastAction::cast($this->faker->randomElement(AppointmentTypeEnum::cases())->value);
$status = SafeStringCastAction::cast($this->faker->randomElement(AppointmentStatusEnum::cases())->value);
```

#### Errore: `argument.type`
**Linee**: 226-227
**Problema**: Parametri mixed per metodi Carbon che richiedono int

**Soluzione**:
```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// Prima (ERRATO)
$startTime->setMinute($startMinute);
$startTime->addMinutes($duration);

// Dopo (CORRETTO)
$startMinute = SafeIntCastAction::cast($startMinute);
$duration = SafeIntCastAction::cast($duration);
$startTime->setMinute($startMinute);
$startTime->addMinutes($duration);
```

### 2. DoctorFactory.php

#### Errore: `generics.notGeneric`
**Linea**: 22
**Problema**: PHPDoc @extends contiene tipo generico per classe non generica

**Soluzione**:
```php
// Prima (ERRATO)
/**
 * @extends \Modules\<nome progetto>\Database\Factories\UserFactory<\Modules\<nome progetto>\Models\Doctor>
 * @extends \Modules\<nome progetto>\Database\Factories\UserFactory<\Modules\<nome progetto>\Models\Doctor>
 */

// Dopo (CORRETTO)
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\<nome progetto>\Models\Doctor>
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\<nome progetto>\Models\Doctor>
 */
```

### 3. PatientFactory.php

#### Errore: `generics.notGeneric`
**Linea**: 22
**Problema**: PHPDoc @extends contiene tipo generico per classe non generica

**Soluzione**:
```php
// Prima (ERRATO)
/**
 * @extends \Modules\<nome progetto>\Database\Factories\UserFactory<\Modules\<nome progetto>\Models\Patient>
 * @extends \Modules\<nome progetto>\Database\Factories\UserFactory<\Modules\<nome progetto>\Models\Patient>
 */

// Dopo (CORRETTO)
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\<nome progetto>\Models\Patient>
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\<nome progetto>\Models\Patient>
 */
```

### 4. PatientTeamFactory.php

#### Errore: `argument.type`
**Linea**: 182
**Problema**: array_merge con parametro mixed

**Soluzione**:
```php
use Modules\Xot\Actions\Cast\SafeArrayCastAction;

// Prima (ERRATO)
array_merge($attributes['communication_preferences'] ?? [], $preferences)

// Dopo (CORRETTO)
array_merge((array) ($attributes['communication_preferences'] ?? []), $preferences)
```

### 5. StudioFactory.php

#### Errore: `binaryOp.invalid`
**Linea**: 63
**Problema**: Operazione binaria tra mixed e string

**Soluzione**:
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// Prima (ERRATO)
$name = $this->faker->company() . ' ' . $this->faker->city();

// Dopo (CORRETTO)
$company = SafeStringCastAction::cast($this->faker->company());
$city = SafeStringCastAction::cast($this->faker->city());
$name = $company . ' ' . $city;
```

#### Errore: `theCodingMachineSafe.function`
**Linea**: 172
**Problema**: json_encode non sicuro

**Soluzione**:
```php
use function Safe\json_encode;

// Prima (ERRATO)
'opening_hours' => json_encode($openingHours),

// Dopo (CORRETTO)
'opening_hours' => json_encode($openingHours),
```

### 6. StudioUserFactory.php

#### Errore: `argument.type`
**Linea**: 203
**Problema**: array_merge con parametro mixed

**Soluzione**:
```php
// Prima (ERRATO)
array_merge($attributes['permissions'], $permissions)

// Dopo (CORRETTO)
array_merge((array) $attributes['permissions'], $permissions)
```

### 7. TeamUserFactory.php

#### Errore: `argument.type`
**Linea**: 225
**Problema**: array_merge con parametro mixed

**Soluzione**:
```php
// Prima (ERRATO)
array_merge($attributes['permissions'], $permissions)

// Dopo (CORRETTO)
array_merge((array) $attributes['permissions'], $permissions)
```

### 8. PivotSeeder.php

#### Errore: `staticMethod.notFound`
**Linee**: 73, 112, 151
**Problema**: Chiamate a ::factory() su modelli pivot

**Soluzione**:
```php
// Prima (ERRATO)
AdminStudio::factory()->create([
    'admin_id' => $admin->id,
    'studio_id' => $studio->id,
]);

// Dopo (CORRETTO)
AdminStudio::create([
    'admin_id' => $admin->id,
    'studio_id' => $studio->id,
]);
```

### 9. StudiosAttachDoctorCap66010Seeder.php

#### Errore: `encapsedStringPart.nonString`
**Linea**: 46
**Problema**: getKey() (mixed) non può essere castato a string

**Soluzione**:
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// Prima (ERRATO)
$this->command?->warn("Errore nell'aggiungere dottore allo studio " . $studio->getKey() . ": " . $e2->getMessage());

// Dopo (CORRETTO)
$studioId = SafeStringCastAction::cast($studio->getKey());
$this->command?->warn("Errore nell'aggiungere dottore allo studio " . $studioId . ": " . $e2->getMessage());
```

#### Errore: `nullsafe.neverNull`
**Linea**: 46
**Problema**: Uso di nullsafe su tipo non-nullable

**Soluzione**:
```php
// Prima (ERRATO)
$this->command?->warn("...");

// Dopo (CORRETTO)
$this->command->warn("...");
```

## Errori Rimanenti da Risolvere

### StudiosCap66010Seeder.php

#### Errore: `function.alreadyNarrowedType`
**Linea**: 36
**Problema**: method_exists sempre true

#### Errore: `method.nonObject`
**Linea**: 37
**Problema**: Chiamata update() su string

#### Errore: `property.nonObject`
**Linee**: 38-39
**Problema**: Accesso a proprietà su string

**Soluzione Proposta**:
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// Verificare il tipo di $studio prima dell'uso
if ($studio instanceof Studio) {
    $studio->update([
        'address' => SafeStringCastAction::cast($address),
        'route' => SafeStringCastAction::cast($route),
        'street_number' => SafeStringCastAction::cast($streetNumber),
    ]);
}
```

## Pattern di Correzione Standard

1. **Identificare l'errore PHPStan**
2. **Importare l'azione di casting appropriata**
3. **Sostituire il cast manuale con la chiamata all'azione**
4. **Documentare la correzione**
5. **Verificare che PHPStan non segnali più errori**

## Import delle Azioni di Cast

```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
```

## Vantaggi delle Correzioni

1. **Type Safety**: Gestione sicura di tutti i tipi di dati
2. **Consistenza**: Comportamento uniforme in tutto il codebase
3. **Manutenibilità**: Logica centralizzata e facilmente aggiornabile
4. **PHPStan Compliance**: Risoluzione automatica di errori di analisi statica
5. **Robustezza**: Gestione di tutti i casi edge e valori problematici

## Collegamenti
- [Uso delle Azioni di Cast Xot](casting-actions-usage.md)
- [Regole Cursor: Casting Actions](.cursor/rules/casting-actions-rule.mdc)
- [Memorie: Casting Actions](.cursor/memories/casting-actions.mdc)

---
Ultimo aggiornamento: [DATE]
