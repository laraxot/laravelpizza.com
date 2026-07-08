# Standard di Posizionamento dei File in Notify

## Organizzazione Directory Principali

| Tipo di File | Percorso Standard | Errori da Evitare |
|--------------|-------------------|-------------------|
| **Interfacce/Contratti** | `/app/Contracts/` | ❌ `/app/Actions/*/InterfaceName.php` |
| **Actions** | `/app/Actions/` | |
| **Datas** | `/app/Datas/` | ❌ `/app/Data/` (singolare), ❌ `/app/DTOs/` |
| **Models** | `/app/Models/` | |
| **Channels** | `/app/Channels/` | |

## Regole Specifiche per le Interfacce

Le interfacce devono sempre essere collocate nella directory `/app/Contracts/`, **mai** nelle directory delle implementazioni.

### Corretta Organizzazione delle Interfacce

```
Modules/Notify/app/Contracts/
Modules/Notify/app/Contracts/
Modules/Notify/app/Contracts/
├── SmsProviderActionInterface.php   ✅ CORRETTO
├── NotificationChannelInterface.php ✅ CORRETTO
└── ...
```

### Errori da Evitare

```
Modules/Notify/app/Actions/SMS/
Modules/Notify/app/Actions/SMS/
Modules/Notify/app/Actions/SMS/
├── SmsActionInterface.php           ❌ ERRATO
└── ...
```

## Regole per la Nomenclatura delle Interfacce

- Utilizzare il suffisso `Interface` per le interfacce
- Utilizzare il prefisso con il nome del concetto primario
- Esempio: `SmsProviderActionInterface` per le azioni di provider SMS

## Regole per il Namespace delle Interfacce

- Namespace corretto: `Modules\Notify\Contracts\`
- Namespace errato: `Modules\Notify\Actions\SMS\`

## Implementazioni Corrette

Quando si implementa un'interfaccia:

```php
// CORRETTO
use Modules\Notify\Contracts\SmsProviderActionInterface;

final class SendNetfunSMSAction implements SmsProviderActionInterface
{
    // ...
}

// ERRATO
use Modules\Notify\Actions\SMS\SmsActionInterface;

final class SendNetfunSMSAction implements SmsActionInterface
{
    // ...
}
```

## Principi Guida

1. **Separazione delle Responsabilità**:
   - Le interfacce definiscono i contratti
   - Le implementazioni forniscono l'implementazione specifica

2. **Inversione delle Dipendenze**:
   - Le classi concrete dipendono dalle astrazioni (interfacce)
   - Le interfacce non dipendono dalle implementazioni

3. **Consistenza**:
   - Tutte le interfacce dello stesso tipo devono essere nello stesso namespace
   - Il pattern di organizzazione deve essere coerente in tutto il modulo
# Standard di Posizionamento dei File in Notify

## Organizzazione Directory Principali

| Tipo di File | Percorso Standard | Errori da Evitare |
|--------------|-------------------|-------------------|
| **Interfacce/Contratti** | `/app/Contracts/` | ❌ `/app/Actions/*/InterfaceName.php` |
| **Actions** | `/app/Actions/` | |
| **Datas** | `/app/Datas/` | ❌ `/app/Data/` (singolare), ❌ `/app/DTOs/` |
| **Models** | `/app/Models/` | |
| **Channels** | `/app/Channels/` | |

## Regole Specifiche per le Interfacce

Le interfacce devono sempre essere collocate nella directory `/app/Contracts/`, **mai** nelle directory delle implementazioni.

### Corretta Organizzazione delle Interfacce

```
Modules/Notify/app/Contracts/
├── SmsProviderActionInterface.php   ✅ CORRETTO
├── NotificationChannelInterface.php ✅ CORRETTO
└── ...
```

### Errori da Evitare

```
Modules/Notify/app/Actions/SMS/
├── SmsActionInterface.php           ❌ ERRATO
└── ...
```

## Regole per la Nomenclatura delle Interfacce

- Utilizzare il suffisso `Interface` per le interfacce
- Utilizzare il prefisso con il nome del concetto primario
- Esempio: `SmsProviderActionInterface` per le azioni di provider SMS

## Regole per il Namespace delle Interfacce

- Namespace corretto: `Modules\Notify\Contracts\`
- Namespace errato: `Modules\Notify\Actions\SMS\`

## Implementazioni Corrette

Quando si implementa un'interfaccia:

```php
// CORRETTO
use Modules\Notify\Contracts\SmsProviderActionInterface;

final class SendNetfunSMSAction implements SmsProviderActionInterface
{
    // ...
}

// ERRATO
use Modules\Notify\Actions\SMS\SmsActionInterface;

final class SendNetfunSMSAction implements SmsActionInterface
{
    // ...
}
```

## Principi Guida

1. **Separazione delle Responsabilità**:
   - Le interfacce definiscono i contratti
   - Le implementazioni forniscono l'implementazione specifica

2. **Inversione delle Dipendenze**:
   - Le classi concrete dipendono dalle astrazioni (interfacce)
   - Le interfacce non dipendono dalle implementazioni

3. **Consistenza**:
   - Tutte le interfacce dello stesso tipo devono essere nello stesso namespace
   - Il pattern di organizzazione deve essere coerente in tutto il modulo
