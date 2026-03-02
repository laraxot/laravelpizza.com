# Convenzione di Naming per le Interfacce 

## Regola Fondamentale

, tutte le interfacce **DEVONO** utilizzare il suffisso `Contract` e **MAI** il suffisso `Interface`.

## Esempi Corretti e Incorretti

```php
// ✅ CORRETTO
interface SmsActionContract
interface WhatsAppProviderActionContract
interface TelegramProviderActionContract

// ❌ ERRATO
interface SmsActionInterface
interface WhatsAppProviderActionInterface
interface TelegramProviderActionInterface
```

## Motivazione

1. **Coerenza con Laravel**: Il framework Laravel utilizza il suffisso `Contract` per le sue interfacce (es. `Illuminate\Contracts\Auth\Authenticatable`).
2. **Chiarezza semantica**: Il termine "Contract" esprime meglio il concetto di un "contratto" che le classi implementatrici devono rispettare.
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli .
<<<<<<< HEAD
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli Laraxot.
=======
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli healthcare_app.
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
4. **Integrazione con tooling**: Gli strumenti di analisi statica e generazione di codice sono configurati per questa convenzione.

## Implementazione

Per garantire la conformità a questa convenzione:

1. Tutte le nuove interfacce devono essere create con il suffisso `Contract`.
2. Le interfacce esistenti con il suffisso `Interface` devono essere rinominate.
3. I riferimenti alle interfacce rinominate devono essere aggiornati in tutto il codice.

## Verifica

Per verificare la corretta implementazione:

```bash

# Cerca interfacce con naming errato
grep -r "interface.*Interface" --include="*.php" /var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules
<<<<<<< HEAD
grep -r "interface.*Interface" --include="*.php" /var/www/html/ptvx/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/ptvx/laravel/Modules
=======
grep -r "interface.*Interface" --include="*.php" /var/www/html/healthcare_app/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/healthcare_app/laravel/Modules
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
grep -r "interface.*Interface" --include="*.php" /var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules
```

## Riferimenti

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PTVX Code Quality Guidelines](/var/www/html/_bases/base_ptvx_fila5_mono/docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules/Xot/app/Contracts/)
<<<<<<< HEAD
- [Laraxot Code Quality Guidelines](/var/www/html/ptvx/docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [Laraxot Code Quality Guidelines](/var/www/html/ptvx/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/ptvx/laravel/Modules/Xot/app/Contracts/)
- [Laraxot Code Quality Guidelines](/var/www/html/_bases/base_techplanner_fila5_mono/docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [Laraxot Code Quality Guidelines](/var/www/html/_bases/base_techplanner_fila5_mono/laravel/project_docs/code-quality.md)
=======
- [healthcare_app Code Quality Guidelines](/var/www/html/healthcare_app/docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [healthcare_app Code Quality Guidelines](/var/www/html/healthcare_app/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/healthcare_app/laravel/Modules/Xot/app/Contracts/)
- [healthcare_app Code Quality Guidelines](/var/www/html/_bases/base_techplanner_fila5_mono/docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [healthcare_app Code Quality Guidelines](/var/www/html/_bases/base_techplanner_fila5_mono/laravel/project_docs/code-quality.md)
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
- [Modulo Xot Contracts](/var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules/Xot/app/Contracts/)
