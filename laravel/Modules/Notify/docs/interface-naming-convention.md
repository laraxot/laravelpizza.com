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
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli SaluteOra.
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
grep -r "interface.*Interface" --include="*.php" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules
grep -r "interface.*Interface" --include="*.php" /var/www/html/saluteora/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/saluteora/laravel/Modules
grep -r "interface.*Interface" --include="*.php" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules
```

## Riferimenti

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PTVX Code Quality Guidelines](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/_bases/base_ptvx_fila3_mono/laravel/Modules/Xot/app/Contracts/)
- [SaluteOra Code Quality Guidelines](/var/www/html/saluteora/laravel/docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [SaluteOra Code Quality Guidelines](/var/www/html/saluteora/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/saluteora/laravel/Modules/Xot/app/Contracts/)
- [SaluteOra Code Quality Guidelines](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [SaluteOra Code Quality Guidelines](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/project_docs/code-quality.md)
- [Modulo Xot Contracts](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Xot/app/Contracts/)
