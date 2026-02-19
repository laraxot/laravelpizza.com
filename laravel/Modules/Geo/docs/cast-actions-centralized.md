# Azioni Cast Centralizzate - Regola di Progetto

## Principio Fondamentale
Il progetto <nome progetto> utilizza azioni cast centralizzate nel modulo Xot per garantire type safety e conformità PHPStan. Questa è una **regola critica** del progetto.
Il progetto <nome progetto> utilizza azioni cast centralizzate nel modulo Xot per garantire type safety e conformità PHPStan. Questa è una **regola critica** del progetto.

## Posizione delle Azioni
```
../laravel/Modules/Xot/app/Actions/Cast/
├── SafeIntCastAction.php
├── SafeStringCastAction.php
└── SafeFloatCastAction.php
```

## Utilizzo Obbligatorio

### In Factory
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// ✅ CORRETTO
$duration = SafeIntCastAction::cast($this->faker->randomElement([30, 45, 60]));
$name = SafeStringCastAction::cast($this->faker->randomElement($types));
```

### In Seeder
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// ✅ CORRETTO
$studioName = SafeStringCastAction::cast($this->faker->company());
```

### In Controllers e Models
```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// ✅ CORRETTO per input validation
$userId = SafeIntCastAction::castAsId($request->input('user_id'));
```

## Benefici

1. **Type Safety**: Conformità PHPStan livello 9+
2. **DRY**: Nessuna duplicazione di logiche di cast
3. **Robustezza**: Gestione centralizzata di edge cases
4. **Manutenibilità**: Un solo punto di modifica per miglioramenti
5. **Coerenza**: Comportamento uniforme in tutto il progetto

## Casi d'Uso Comuni

- **Factory Faker Values**: Cast sicuro di valori random
- **User Input**: Validazione e cast di input utente
- **API Responses**: Cast sicuro di dati esterni
- **Database Values**: Cast di valori da query raw
- **Configuration**: Cast di valori di configurazione

## Anti-Pattern da Evitare

```php
// ❌ MAI fare cast custom
$value = (string) $mixedValue;
$id = (int) $userInput;

// ❌ MAI ignorare PHPStan con commenti
/** @phpstan-ignore-next-line */
$result = $mixed->property;
```

## Policy di Aggiornamento
Ogni volta che si utilizzano queste azioni:
1. Aggiornare la documentazione del modulo
2. Aggiornare .cursor/rules
3. Aggiornare le memories dell'AI
4. Documentare l'uso specifico nel contesto

## Collegamenti
- [<nome progetto> Cast Usage](../laravel/modules/<nome progetto>/docs/cast-actions-usage.md)
- [<nome progetto> Cast Usage](../laravel/modules/<nome progetto>/docs/cast-actions-usage.md)
- [Xot Cast Actions](../laravel/modules/xot/docs/actions/cast-actions.md)
- [PHPStan Best Practices](./phpstan-best-practices.md)

*Ultimo aggiornamento: gennaio 2025*
