# Architettura delle Azioni dei Provider in Notify

## Struttura e Principi Fondamentali

Le azioni dei provider in Notify seguono il pattern di Spatie Queueable Actions e sono progettate per supportare molteplici provider mantenendo un'interfaccia comune e consistente.

### 1. Interfaccia Comune

Tutte le azioni di invio SMS devono implementare `SmsProviderActionInterface` per garantire un'interfaccia unificata:

```php
interface SmsProviderActionInterface
{
    public function execute(SmsData $smsData): array;
}
```

Questo assicura che qualsiasi client possa utilizzare qualsiasi provider senza modificare il codice di utilizzo.

### 2. Posizione delle Azioni

Le azioni specifiche dei provider SMS si trovano nella directory:
- `Modules/Notify/app/Actions/SMS/`

### 3. Convenzioni di Nomenclatura

- Le azioni devono essere nominate seguendo il pattern `Send{Provider}SMSAction`
- Esempio: `SendNetfunSMSAction`, `SendTwilioSMSAction`, ecc.

## Data Transfer Objects

### Principale: `SmsData`

La classe `SmsData` è l'interfaccia comune che tutte le azioni di provider devono accettare:

```php
class SmsData extends Data
{
    public string $from;    // Mittente
    public string $to;      // Destinatario
    public string $body;    // Corpo del messaggio
}
```

### DTOs Specifici dei Provider

I provider possono avere anche DTOs specifici che estendono `SmsData` con proprietà aggiuntive:

```php
class NetfunSmsData extends Data
{
    public string $recipient;    // Equivalente a 'to' in SmsData
    public string $message;      // Equivalente a 'body' in SmsData
    public string $sender;       // Equivalente a 'from' in SmsData
    public ?string $reference;   // Proprietà specifica di Netfun
    public ?string $scheduledDate; // Proprietà specifica di Netfun
}
```

## Adattamento tra SmsData e DTOs Specifici

Le azioni di provider devono sempre:

1. **Accettare `SmsData` nel metodo `execute()`**:
   ```php
   public function execute(SmsData $smsData): array
   ```

2. **Adattare internamente `SmsData` ai propri DTOs specifici** se necessario:
   ```php
   // All'interno di SendNetfunSMSAction
   $netfunData = new NetfunSmsData(
       recipient: $smsData->to,
       message: $smsData->body,
       sender: $smsData->from,
       reference: null,
       scheduledDate: null
   );
   ```

## Gestione delle Configurazioni

Le azioni devono recuperare le configurazioni specifiche del provider dal percorso corretto:

```php
// Configurazioni specifiche del provider
$token = config('sms.drivers.provider_name.token');

// Configurazioni globali a livello di root
$debug = config('sms.debug', false);
```

## Risultato dell'Esecuzione

Tutte le azioni devono restituire un array con almeno i seguenti campi:

```php
return [
    'success' => true|false,  // Successo o fallimento
    'message_id' => '...',    // ID del messaggio (se disponibile)
    'reference' => '...',     // Riferimento per il tracciamento
    // Altri campi specifici del provider...
];
```

## Gestione degli Errori

Tutte le azioni devono gestire correttamente gli errori:

1. Log appropriati degli errori
2. Lancio di eccezioni in caso di errori critici
3. Restituzione di un array con `'success' => false` in caso di errori non critici
