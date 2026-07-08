# Architettura dei Provider SMS 

## Convenzioni delle Interfacce

, l'architettura dei provider SMS segue una struttura specifica:

### 1. Interfaccia Principale: `SmsActionContract`

```php
// Posizione: /Modules/Notify/app/Contracts/SMS/SmsActionContract.php
namespace Modules\Notify\Contracts\SMS;

use Modules\Notify\Datas\SmsData;

interface SmsActionContract
{
    public function execute(SmsData $smsData): array;
}
```

**IMPORTANTE**: Tutte le classi Action in `/Modules/Notify/app/Actions/SMS/` DEVONO implementare questa interfaccia.

### 2. Implementazioni Provider

Ogni provider SMS deve:

1. Implementare `SmsActionContract`
2. Essere collocato in `/Modules/Notify/app/Actions/SMS/`
3. Seguire la convenzione di naming `Send{Provider}SMSAction`
4. Utilizzare `QueueableAction` per supportare code e job asincroni

Esempio:

```php
final class SendNetfunSMSAction implements SmsActionContract
{
    use QueueableAction;
    
    // Implementazione...
}
```

### 3. Factory Pattern

Il sistema utilizza un factory pattern per la creazione dinamica di provider SMS:

```php
// /Modules/Notify/app/Factories/SmsActionFactory.php
namespace Modules\Notify\Factories;

use Modules\Notify\Contracts\SMS\SmsActionContract;

final class SmsActionFactory
{
    public function create(?string $driver = null): SmsActionContract
    {
        // Logica di creazione...
    }
}
```

## Configurazione

Tutti i provider SMS devono essere configurati in `/config/sms.php` e NON in `/config/services.php`:

```php
// /config/sms.php
return [
    'default' => env('SMS_DRIVER', 'netfun'),
    
    'drivers' => [
        'netfun' => [
            'api_key' => env('NETFUN_API_KEY'),
            // Altre configurazioni...
        ],
        // Altri driver...
    ],
];
```

## Errori Comuni da Evitare

1. **MAI** utilizzare interfacce in namespace errato:
   - ❌ `Modules\Notify\Contracts\SmsProviderContract`
   - ✅ `Modules\Notify\Contracts\SMS\SmsActionContract`

2. **MAI** utilizzare naming inconsistente per le interfacce:
   - ❌ `SmsInterface`, `SmsProviderInterface`
   - ✅ `SmsActionContract`

3. **MAI** implementare interfacce multiple o inconsistenti:
   - ❌ Alcune classi implementano `SmsProviderContract`, altre `SmsActionContract`
   - ✅ Tutte implementano `SmsActionContract`

4. **MAI** configurare provider SMS in `config/services.php`

## Note di Migrazione

Quando si aggiunge un nuovo provider SMS:

1. Creare una nuova classe in `/Actions/SMS/` che implementa `SmsActionContract`
2. Aggiungere la configurazione in `/config/sms.php`
3. Aggiornare l'enum `SmsDriverEnum` se necessario
