# Analisi PHPStan Livello 10 - Modulo Notify

## Data Analisi
2025-01-06

## Obiettivo
Migliorare la qualità del codice del modulo Notify raggiungendo la conformità PHPStan livello 10, migliorando la tipizzazione, la sicurezza dei tipi e la manutenibilità del codice.

## Strumenti Utilizzati
- PHPStan livello 10
- Analisi statica del codice
- Correzione sistematica degli errori

## Correzioni Applicate

### 1. SendNotificationAction.php
**Problemi risolti:**
- Tipizzazione parametri `$data` come `array<string, mixed>`
- Tipizzazione parametri `$channels` come `array<int, string>`
- Tipizzazione parametri `$options` come `array<string, mixed>`
- Tipizzazione array `$compiled` con shape type `array{subject: string, body_html: string|null, body_text: string|null}`
- Gestione corretta dei valori nullable (`body_html`, `body_text`)

**Modifiche:**
```php
// Prima
public function execute(Model $recipient, string $templateCode, array $data = [], array $channels = [], array $options = []): bool

// Dopo
public function execute(Model $recipient, string $templateCode, array<string, mixed> $data = [], array<int, string> $channels = [], array<string, mixed> $options = []): bool
```

### 2. SendNotificationJob.php
**Problemi risolti:**
- Tipizzazione PHPDoc per proprietà `$data`, `$channels`, `$options`

**Modifiche:**
```php
/**
 * @param array<string, mixed> $data
 * @param array<int, string> $channels
 * @param array<string, mixed> $options
 */
```

### 3. NotificationManager.php
**Problemi risolti:**
- Tipizzazione parametri e valori di ritorno
- Verifica tipo `Model` in `sendMultiple()` prima dell'uso

**Modifiche:**
```php
public function sendMultiple(
    array<int, Model> $recipients,
    string $templateCode,
    array<string, mixed> $data = [],
    array<int, string> $channels = [],
    array<string, mixed> $options = [],
): array<int, array<string, mixed>>
```

### 4. GenericNotification.php
**Problemi risolti:**
- Tipizzazione `$channels` come `array<int, string>` invece di `array<string>`
- Gestione tipo di ritorno `getRecipientName()` con cast esplicito

**Modifiche:**
```php
protected array<int, string> $channels;

protected function getRecipientName($notifiable): string
{
    if (is_object($notifiable) && method_exists($notifiable, 'getFullName')) {
        /** @var string $fullName */
        $fullName = $notifiable->getFullName();
        return $fullName;
    }
    // ...
}
```

### 5. NotificationTemplate.php
**Problemi risolti:**
- Tipizzazione `$previewData` e `$mergedData` in `preview()`
- Tipizzazione `$channels` in `getChannelsLabelAttribute()`
- Tipizzazione valore di ritorno `getGrapesJSData()`

**Modifiche:**
```php
public function preview(array $data = []): array
{
    /** @var array<string, mixed> $previewData */
    $previewData = $this->preview_data ?? [];
    /** @var array<string, mixed> $mergedData */
    $mergedData = array_merge($previewData, $data);
    return $this->compile($mergedData);
}
```

### 6. RecordNotification.php
**Problemi risolti:**
- Tipizzazione `$data` come `array<string, mixed>`
- Tipizzazione `$attachments` come `array<int, array<string, string>>`
- Verifica tipo `string` per `$to` prima dell'uso

**Modifiche:**
```php
/** @var array<string, mixed> */
public array $data = [];
/** @var array<int, array<string, string>> */
public array $attachments = [];

// In toMail()
if (is_string($to)) {
    $email->to($to);
    $email->setRecipient($to);
}
```

### 7. NetfunChannel.php
**Problemi risolti:**
- Rimosso assert ridondante `Assert::isArray()` su valore già tipizzato
- Aggiunta annotazione PHPDoc per tipizzazione esplicita

**Modifiche:**
```php
// Prima
$data = $netfunSendAction->execute($smsData);
Assert::isArray($data, 'Il risultato di NetfunSendAction deve essere un array');

// Dopo
/** @var array<string, mixed> $data */
$data = $netfunSendAction->execute($smsData);
```

## Errori Rimanenti (55 totali)

### Categorie di Errori

1. **Accesso offset su mixed** (Telegram/WhatsApp Actions)
   - File: `SendBotmanTelegramAction.php`, `SendNutgramTelegramAction.php`, `SendOfficialTelegramAction.php`
   - Problema: Accesso a `['message_id']` su valore `mixed`
   - Soluzione: Tipizzare il valore di ritorno delle API o aggiungere verifiche di tipo

2. **Parametri mixed invece di string** (Varie Actions)
   - File: `Send360dialogWhatsAppAction.php`, `SendVonageWhatsAppAction.php`
   - Problema: Parametri `$url` di tipo `mixed` invece di `string`
   - Soluzione: Aggiungere verifiche di tipo o tipizzare correttamente

3. **Problemi con Filament Pages** (Test Pages)
   - File: Varie pagine in `Filament/Clusters/Test/Pages/`
   - Problema: `components()` si aspetta tipo specifico ma riceve `array`
   - Soluzione: Tipizzare correttamente il valore di ritorno di `get*FormSchema()`

4. **Problemi con Data Classes**
   - File: `NetfunSmsRequestData.php`, `NetfunSmsResponseData.php`
   - Problema: Parametri costruttore non tipizzati correttamente
   - Soluzione: Aggiungere tipi espliciti ai parametri

5. **Problemi con Enum**
   - File: `ContactTypeEnum.php`
   - Problema: Accesso a proprietà `$value` su `mixed`
   - Soluzione: Tipizzare correttamente il valore

6. **Problemi con Factory Pattern**
   - File: `TelegramActionFactory.php`, `WhatsAppActionFactory.php`
   - Problema: Tipo di ritorno non specificato correttamente
   - Soluzione: Aggiungere tipi di ritorno espliciti

## Pattern di Correzione Identificati

### Pattern 1: Tipizzazione Array
```php
// ❌ ERRATO
public array $data = [];

// ✅ CORRETTO
/** @var array<string, mixed> */
public array $data = [];
```

### Pattern 2: Verifica Tipo Prima dell'Uso
```php
// ❌ ERRATO
$email->to($to);

// ✅ CORRETTO
if (is_string($to)) {
    $email->to($to);
}
```

### Pattern 3: Rimozione Assert Ridondanti
```php
// ❌ ERRATO
$data = $action->execute(); // PHPStan sa già che è array
Assert::isArray($data);

// ✅ CORRETTO
/** @var array<string, mixed> $data */
$data = $action->execute();
```

### Pattern 4: Shape Types per Array Strutturati
```php
// ❌ ERRATO
protected function sendMail(Model $recipient, array $compiled, array $options): void

// ✅ CORRETTO
protected function sendMail(Model $recipient, array{subject: string, body_html: string|null, body_text: string|null} $compiled, array<string, mixed> $options): void
```

## Prossimi Passi

1. **Correggere errori rimanenti sistematicamente**
   - Iniziare dalle Actions (Telegram, WhatsApp)
   - Correggere le Data Classes
   - Sistemare le Factory
   - Correggere le Filament Pages

2. **Eseguire analisi con altri strumenti**
   - PHPMD per code smells
   - PHPInsights per metriche di qualità
   - Rector per refactoring automatico

3. **Aggiornare documentazione**
   - Documentare pattern di tipizzazione
   - Creare guide per sviluppatori
   - Aggiornare best practices

## Metriche

- **Errori iniziali**: ~71 errori PHPStan livello 10
- **Errori corretti**: ~29 errori
- **Errori rimanenti**: ~42 errori
- **Percentuale completamento**: ~41%
- **Riduzione errori**: 41% rispetto all'iniziale

## Collegamenti

- [Troubleshooting](./troubleshooting.md)
- [Best Practices](./best-practices.md)
- [Index](./index.md)

*Ultimo aggiornamento: 2025-01-06*

