# Guida all'Implementazione delle Interfacce nel Modulo Notify

## Struttura delle Interfacce

Nel modulo Notify, le interfacce seguono una struttura specifica che è importante rispettare per garantire il corretto funzionamento del sistema.

### Posizionamento delle Interfacce

Le interfacce sono organizzate in due livelli:

1. **Interfacce Generiche**: Posizionate direttamente nella directory `app/Contracts/`
   ```
   /var/www/html/saluteora/laravel/Modules/Notify/app/Contracts/SmsActionContract.php
   ```

2. **Interfacce Specifiche per Canale**: Posizionate in sottodirectory dedicate
   ```
   /var/www/html/saluteora/laravel/Modules/Notify/app/Contracts/SMS/SmsActionContract.php
   ```

### Convenzioni di Naming

1. **Suffisso `Contract`**: Tutte le interfacce devono utilizzare il suffisso `Contract` e non `Interface`
   ```php
   // ✅ CORRETTO
   interface SmsActionContract
   
   // ❌ ERRATO
   interface SmsActionInterface
   ```

2. **Namespace Corretto**: Il namespace deve riflettere la posizione fisica del file
   ```php
   // Per interfacce nella directory principale
   namespace Modules\Notify\Contracts;
   
   // Per interfacce in sottodirectory
   namespace Modules\Notify\Contracts\SMS;
   ```

## Implementazione nelle Classi

Le classi che implementano queste interfacce devono importare l'interfaccia corretta:

```php
// Per classi che implementano interfacce nella directory principale
use Modules\Notify\Contracts\SmsActionContract;

// Per classi che implementano interfacce in sottodirectory
use Modules\Notify\Contracts\SMS\SmsActionContract;
```

### Esempio di Implementazione Corretta

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

final class SendNetfunSMSAction implements SmsActionContract
{
    // Implementazione...
    
    public function execute(SmsData $smsData): array
    {
        // Logica di invio SMS...
    }
}
```

## Risoluzione dei Problemi Comuni

### Errore: Interface Not Found

Se si verifica l'errore `Interface "Modules\Notify\Contracts\SMS\SmsActionContract" not found`, verificare:

1. **Esistenza del File**: Assicurarsi che il file dell'interfaccia esista nella posizione corretta
2. **Namespace Corretto**: Verificare che il namespace nell'interfaccia corrisponda alla sua posizione fisica
3. **Import Corretto**: Verificare che la classe stia importando l'interfaccia dal namespace corretto
4. **Cache di Composer**: Provare a pulire la cache di Composer con `composer dump-autoload`
5. **Cache di Laravel**: Pulire la cache di Laravel con `php artisan optimize:clear`

## Note Importanti

1. **Discrepanza nella Documentazione**: Esiste una discrepanza tra alcuni documenti che indicano che le interfacce dovrebbero essere solo nella directory principale e l'implementazione attuale che utilizza anche sottodirectory. L'implementazione attuale è quella corretta da seguire.

2. **Coerenza all'Interno del Modulo**: Mantenere la coerenza all'interno del modulo è fondamentale. Se le classi esistenti utilizzano interfacce in sottodirectory, continuare a seguire questo pattern.

## Collegamenti Correlati

- [Convenzioni di Naming per le Interfacce](./INTERFACE_NAMING_CONVENTION.md)
- [Chiarimento sulla Struttura delle Interfacce](./INTERFACE_STRUCTURE_CLARIFICATION.md)
- [Architettura dei Contratti](./CONTRACTS_ARCHITECTURE.md)
