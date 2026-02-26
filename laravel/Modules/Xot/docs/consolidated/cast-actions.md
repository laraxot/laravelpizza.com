# Azioni di Cast Sicure - Sostituzione di property_exists

## Panoramica

Questo documento descrive le azioni di cast sicure che sostituiscono completamente l'uso di `property_exists()` con modelli Laravel e oggetti generici. Queste azioni forniscono metodi robusti, type-safe e performanti per l'accesso agli attributi.

## Problema con property_exists

L'uso di `property_exists()` con modelli Laravel è problematico perché:

- È una funzione PHP generica che non conosce l'architettura Laravel
- Può dare falsi positivi con proprietà dinamiche di Eloquent
- È meno performante e meno leggibile
- Non segue i principi DRY e KISS
- Può causare errori di tipo e comportamenti imprevedibili

## Soluzioni Implementate

### 1. SafeEloquentCastAction

Per modelli Eloquent, utilizzare `SafeEloquentCastAction`:

```php
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

class MyWidget extends Widget
{
    public function getStats(): array
    {
        $model = User::first();
        
        // Verifica esistenza attributo
        if (app(SafeEloquentCastAction::class)->hasAttribute($model, 'email')) {
            $email = app(SafeEloquentCastAction::class)->getStringAttribute($model, 'email', '');
        }
        
        // Cast sicuro a tipo specifico
        $age = app(SafeEloquentCastAction::class)->getIntAttribute($model, 'age', 0);
        $isActive = app(SafeEloquentCastAction::class)->getBooleanAttribute($model, 'is_active', false);
        
        // Metodo di convenienza statico
        $name = SafeEloquentCastAction::get($model, 'name', 'string', 'Unknown');
    }
}
```

### 2. SafeObjectCastAction

Per oggetti generici, utilizzare `SafeObjectCastAction`:

```php
use Modules\Xot\Actions\Cast\SafeObjectCastAction;

class MyService
{
    public function processObject(object $obj): void
    {
        // Verifica esistenza proprietà
        if (app(SafeObjectCastAction::class)->hasProperty($obj, 'value')) {
            $value = app(SafeObjectCastAction::class)->getStringProperty($obj, 'value', '');
        }
        
        // Cast sicuro con validazione
        $count = app(SafeObjectCastAction::class)->getValidatedProperty(
            $obj, 
            'count', 
            'int', 
            fn(int $val) => $val > 0,
            0
        );
    }
}
```

### 3. Azioni di Cast Specializzate

Utilizzare le azioni specializzate per tipi specifici:

```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// Cast sicuro a int
$intValue = app(SafeIntCastAction::class)->execute($mixedValue, 0);

// Cast sicuro a float
$floatValue = app(SafeFloatCastAction::class)->execute($mixedValue, 0.0);

// Cast sicuro a string
$stringValue = app(SafeStringCastAction::class)->execute($mixedValue, '');
```

## Pattern di Utilizzo

### Pattern 1: Verifica e Accesso

```php
// ❌ SBAGLIATO - Usando property_exists
if (property_exists($model, 'email')) {
    $email = $model->email;
}

// ✅ CORRETTO - Usando SafeEloquentCastAction
if (app(SafeEloquentCastAction::class)->hasAttribute($model, 'email')) {
    $email = app(SafeEloquentCastAction::class)->getStringAttribute($model, 'email', '');
}
```

### Pattern 2: Accesso Diretto con Default

```php
// ❌ SBAGLIATO - Accesso diretto senza verifica
$email = $model->email ?? '';

// ✅ CORRETTO - Accesso sicuro con cast
$email = app(SafeEloquentCastAction::class)->getStringAttribute($model, 'email', '');
```

### Pattern 3: Cast con Validazione

```php
// ❌ SBAGLIATO - Cast manuale senza validazione
$age = (int) ($model->age ?? 0);

// ✅ CORRETTO - Cast sicuro con validazione
$age = app(SafeEloquentCastAction::class)->getValidatedAttribute(
    $model, 
    'age', 
    'int', 
    fn(int $val) => $val >= 0 && $val <= 150,
    0
);
```

## Vantaggi delle Azioni di Cast

1. **Type Safety**: Tutti i metodi sono completamente tipizzati
2. **Performance**: Evita chiamate multiple a `property_exists`
3. **Robustezza**: Gestisce tutti i casi edge
4. **Manutenibilità**: Logica centralizzata e riutilizzabile
5. **Laravel Way**: Rispetta l'architettura Eloquent
6. **Validazione**: Supporta validatori personalizzati
7. **Fallback**: Gestione intelligente dei valori di default

## Integrazione con webmozart/assert

Tutte le azioni utilizzano `webmozart/assert` per validazioni robuste:

```php
use Webmozart\Assert\Assert;

// Validazione automatica dei parametri
Assert::isInstanceOf($model, Model::class);
Assert::stringNotEmpty($attribute);
Assert::inArray($type, ['string', 'int', 'float', 'bool', 'array']);
```

## Best Practices

1. **Mai usare property_exists** con modelli Eloquent
2. **Utilizzare sempre le azioni di cast** appropriate
3. **Specificare sempre i tipi** di cast desiderati
4. **Fornire valori di default** appropriati
5. **Utilizzare la validazione** quando necessario
6. **Preferire i metodi statici** per chiamate semplici

## Esempi di Migrazione

### Prima (con property_exists)

```php
class OldWidget extends Widget
{
    public function getStats(): array
    {
        $model = User::first();
        
        if (property_exists($model, 'email')) {
            $email = $model->email;
        }
        
        if (property_exists($model, 'age')) {
            $age = (int) $model->age;
        }
        
        return ['email' => $email ?? '', 'age' => $age ?? 0];
    }
}
```

### Dopo (con SafeEloquentCastAction)

```php
class NewWidget extends Widget
{
    public function getStats(): array
    {
        $model = User::first();
        
        $email = app(SafeEloquentCastAction::class)->getStringAttribute($model, 'email', '');
        $age = app(SafeEloquentCastAction::class)->getIntAttribute($model, 'age', 0);
        
        return ['email' => $email, 'age' => $age];
    }
}
```

## Testing

Le azioni di cast sono completamente testate e supportano PHPStan livello 9+:

```bash
./vendor/bin/phpstan analyse Modules/Xot/app/Actions/Cast --level=9
```

## Collegamenti

- [SafeEloquentCastAction](../app/Actions/Cast/SafeEloquentCastAction.php)
- [SafeObjectCastAction](../app/Actions/Cast/SafeObjectCastAction.php)
- [SafeIntCastAction](../app/Actions/Cast/SafeIntCastAction.php)
- [SafeFloatCastAction](../app/Actions/Cast/SafeFloatCastAction.php)
- [SafeStringCastAction](../app/Actions/Cast/SafeStringCastAction.php)
- [SafeBooleanCastAction](../app/Actions/Cast/SafeBooleanCastAction.php)
- [SafeArrayCastAction](../app/Actions/Cast/SafeArrayCastAction.php)
