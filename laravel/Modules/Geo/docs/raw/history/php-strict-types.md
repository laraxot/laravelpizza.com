# PHP Strict Types Convention

## Regola Generale

Tutti i file PHP del progetto che contengono logica di business DEVONO iniziare con la dichiarazione `declare(strict_types=1);` subito dopo il tag di apertura PHP.

### File che Richiedono strict_types
- Controllers
- Models
- Actions
- Services
- Traits
- Interfaces
- Tests
- Helpers

### File che NON Richiedono strict_types
- File di vista Blade (.blade.php)
- File di configurazione (config/*.php)
- File di routing (routes/*.php)
- File di traduzione (lang/*.php)

## Formato Corretto

```php
<?php

declare(strict_types=1);

namespace Example;
// ... resto del codice
```

## Motivazione

L'uso di `declare(strict_types=1);` offre diversi vantaggi:

1. **Type Safety**: Forza il type checking rigoroso per:
   - Parametri delle funzioni
   - Valori di ritorno delle funzioni
   - Assegnazioni di proprietà tipizzate

2. **Prevenzione Errori**: Aiuta a catturare errori di tipo in fase di sviluppo invece che in runtime

3. **Codice Più Pulito**: Rende esplicite le intenzioni riguardo ai tipi di dati attesi

4. **Migliore Integrazione con Tools**: Facilita l'analisi statica del codice con strumenti come PHPStan

## Implementazione

- Tutti i nuovi file PHP devono includere questa dichiarazione
- I file esistenti devono essere aggiornati per includere questa dichiarazione quando vengono modificati
- La dichiarazione deve essere posizionata immediatamente dopo il tag di apertura PHP e prima di qualsiasi altro codice

## Verifica

È possibile verificare la presenza di questa dichiarazione usando il seguente comando grep:

```bash
find Modules -name "*.php" -type f -exec grep -L "declare(strict_types=1)" {} \;
```

Questo comando mostrerà tutti i file PHP che non hanno la dichiarazione `strict_types`.
