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
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli <nome progetto>.
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
grep -r "interface.*Interface" --include="*.php" Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" Modules
grep -r "interface.*Interface" --include="*.php" Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" Modules
grep -r "interface.*Interface" --include="*.php" Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" Modules
```

## Riferimenti

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PTVX Code Quality Guidelines](laravel/docs/code-quality.md)
- [Modulo Xot Contracts](laravel/Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
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
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli <nome progetto>.
3. **Standardizzazione**: Questa convenzione è applicata in modo coerente in tutti i moduli <nome progetto>.
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
grep -r "interface.*Interface" --include="*.php" Modules

# Cerca interfacce con naming corretto
grep -r "interface.*Contract" --include="*.php" Modules
grep -r "interface.*Interface" --include="*.php" Modules

grep -r "interface.*Contract" --include="*.php" Modules
grep -r "interface.*Interface" --include="*.php" Modules

grep -r "interface.*Contract" --include="*.php" Modules

```

## Riferimenti

- [Laravel Contracts Documentation](https://laravel.com/docs/contracts)
- [PTVX Code Quality Guidelines](laravel/docs/code-quality.md)
- [Modulo Xot Contracts](laravel/Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
- [Laravel Contracts Documentation](https://laravel.com/project_docs/contracts)
- [<nome progetto> Code Quality Guidelines](docs/code-quality.md)
- [Modulo Xot Contracts](Modules/Xot/app/Contracts/)
- [<nome progetto> Code Quality Guidelines](project_docs/code-quality.md)
