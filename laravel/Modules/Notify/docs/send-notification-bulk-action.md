# SendNotificationBulkAction - Implementazione Completa

**Data**: 2025-01-18  
**Status**: ✅ Implementazione completata e PHPStan Level 10 compliant  
**Module**: Notify

## Overview

`SendNotificationBulkAction` è la BulkAction Filament riutilizzabile che permette di inviare notifiche a più record contemporaneamente utilizzando template MailTemplate e canali multipli (Email, SMS, WhatsApp).  
Dal 2025‑12‑18 la catena interna è stata ulteriormente semplificata:

```
Filament Bulk Action (UI) ──► SendRecordsNotificationBulkAction (queueable, multi-record)
                                      │
                                      └─► SendRecordNotificationAction (single record, multi-channel)
```

Questo significa:
- naming coerente: `SendRecordsNotificationBulkAction` per la parte bulk, `SendRecordNotificationAction` per la parte single record;
- DRY assoluto: tutta la logica di invio (normalizzazione numeri, estrazione contatti, gestione templating) vive nella action single record e viene riutilizzata dalla bulk;
- queue-friendly: entrambe le action sono stateless e risolvono le dipendenze solo quando servono tramite `app()`.

## Architettura

### Separazione delle Responsabilità

L'implementazione segue il principio di separazione tra UI (Filament) e business logic (Spatie Actions):

```
┌─────────────────────────────────────┐
│ SendNotificationBulkAction          │
│ (Filament BulkAction)               │
│ - Gestisce UI e form modal          │
│ - Validazione input utente          │
│ - Notifiche di risultato            │
└──────────────┬──────────────────────┘
               │ DELEGA
               ▼
┌─────────────────────────────────────┐
│ SendRecordsNotificationBulkAction   │
│ (Spatie QueueableAction)            │
│ - Orchestrazione bulk               │
│ - Aggregazione risultati            │
│ - Gestione errori aggregati         │
└──────────────┬──────────────────────┘
               │ COMPONE
               ▼
┌─────────────────────────────────────┐
│ SendRecordNotificationAction        │
│ (Spatie QueueableAction)            │
│ - Logica business invio notifica    │
│ - Gestione canali multipli          │
│ - Estrazione email/phone/whatsapp   │
│ - Normalizzazione telefoni          │
└──────────────┬──────────────────────┘
               │ USA
               ▼
┌─────────────────────────────────────┐
│ RecordNotification                  │
│ WhatsAppNotification                │
│ (Laravel Notification)              │
│ - Generazione contenuto da template │
│ - Invio via Notification::route()   │
└─────────────────────────────────────┘
```

## Componenti

### 1. SendRecordsNotificationBulkAction (Spatie QueueableAction)

**File**: `Modules/Notify/app/Actions/SendRecordsNotificationBulkAction.php`

**Responsabilità**:
- **Orchestrazione bulk**: Riceve una collection di record e itera su ognuno
- **Composizione DRY**: Per ogni record, compone `SendRecordNotificationAction` (singolo record)
- **Aggregazione risultati**: Converte i risultati della single-action in `SendNotificationBulkResultData`
- **Gestione errori**: Cattura eccezioni e gestisce fallimenti silenziosi

**Pattern DRY**: Questa Action **non duplica** la logica di invio. Compone semplicemente `SendRecordNotificationAction` per ogni record, seguendo il principio "Single Responsibility" e "Don't Repeat Yourself".

**Pattern simile**: `SendMailByRecordsAction` che compone `SendMailByRecordAction`.

**Metodo principale**:
```php
public function execute(
    Collection $records,
    string $templateSlug,
    array $channels
): SendNotificationBulkResultData
```

**Canali supportati**:
- **mail**: Usa `RecordNotification` con `Notification::route('mail', $email)`
- **sms**: Usa `RecordNotification` con `Notification::route('sms', $phone)`
- **whatsapp**: Usa `WhatsAppNotification` con `Notification::route('whatsapp', $whatsapp)` e contenuto estratto da `SpatieEmail::buildSms()`

**Estrazione contatti**: Gestita da `SendRecordNotificationAction` con pattern DRY:
- Metodo generico `extractRecordAttribute()` elimina duplicazione tra `getRecordEmail()`, `getRecordPhone()`, `getRecordWhatsApp()`
- Email: Cerca attributi `email`, `pec`, `contact_email` (convalidati come email valide tramite validator custom)
- Phone: Cerca attributi `mobile`, `phone`, `telephone`, `contact_phone`
- WhatsApp: Cerca attributo `whatsapp`, con fallback su phone
- Vedi: [Contact Extraction Pattern](./contact-extraction-pattern.md) per dettagli implementazione DRY

**Pattern DRY - Composizione**:
- **Questa bulk action compone** `SendRecordNotificationAction` per ogni record
- **Zero duplicazione**: La logica di estrazione contatti e invio è solo in `SendRecordNotificationAction`
- Pattern `app()`: Usa `app(SendRecordNotificationAction::class)->execute()` dentro `execute()`
- Vedi: [DRY Composition Pattern](./dry-composition-pattern.md)

### 2. SendNotificationBulkAction (Filament BulkAction)

**File**: `Modules/Notify/app/Filament/Actions/SendNotificationBulkAction.php`

**Responsabilità**:
- Fornisce UI modal per selezione template e canali
- Valida input utente
- Chiama `SendRecordsNotificationBulkAction` (nota: nome plurale "Records")
- Mostra notifiche di successo/errore all'utente

**Estende**: `XotBaseBulkAction` (che estende `Filament\Actions\BulkAction`)

**Form Schema**:
- `template_slug`: Select con slug e nome di MailTemplate, searchable, preload
- `channels`: CheckboxList con opzioni mail, sms, whatsapp (minimo 1 richiesto)

### 3. SendRecordNotificationAction (Spatie QueueableAction)

**File**: `Modules/Notify/app/Actions/SendRecordNotificationAction.php`

**Responsabilità**:
- Invia la notifica a **un singolo record** su uno o più canali
- Risolve email/phone/whatsapp occupandosi di normalizzazione (es. `NormalizePhoneNumberAction`)
- Usa sempre `RecordNotification` (mail/sms) o `WhatsAppNotification` con contenuto derivato da `SpatieEmail`

> L'intera logica di invio vive qui: la bulk action non duplica nulla, semplicemente la richiama per ogni record.

### 4. SendNotificationBulkResultData (Spatie Data)

**File**: `Modules/Notify/app/Datas/SendNotificationBulkResultData.php`

**Proprietà**:
- `successCount`: int - Numero di notifiche inviate con successo
- `errorCount`: int - Numero di errori
- `errors`: Collection<int, array{record: string, channel: string, error: string}> - Dettagli errori
- `totalProcessed`: int - Totale operazioni (record × canali)

## Utilizzo

### In una ListRecords Page

```php
use Modules\Notify\Filament\Actions\SendNotificationBulkAction;

public function getTableBulkActions(): array
{
    return [
        'sendNotifications' => SendNotificationBulkAction::make(),
        // altre azioni...
    ];
}
```

### Workflow Utente

1. L'utente seleziona uno o più record nella tabella
2. Clicca su "Invia notifiche" (BulkAction)
3. Si apre un modal con:
   - Select per template (ricercabile)
   - CheckboxList per canali (mail, sms, whatsapp)
4. L'utente seleziona template e canali
5. Clicca "Invia"
6. Sistema mostra notifiche:
   - Successo: "Inviate X notifiche su Y con successo"
   - Errori: Dettagli per ogni record/canale fallito

## Pattern di Invio

### Email
```php
$recordNotification = new RecordNotification($record, $templateSlug);
Notification::route('mail', $email)->notify($recordNotification);
```

### SMS
```php
$recordNotification = new RecordNotification($record, $templateSlug);
$normalizedPhone = app(NormalizePhoneNumberAction::class)->execute($phone);
Notification::route('sms', $normalizedPhone)->notify($recordNotification);
```

### WhatsApp
```php
$spatieEmail = new SpatieEmail($record, $templateSlug);
$message = $spatieEmail->buildSms(); // Estrae contenuto testuale dal template
$normalizedWhatsApp = app(NormalizePhoneNumberAction::class)->execute($whatsapp);
$whatsappNotification = new WhatsAppNotification($message, ['to' => $normalizedWhatsApp]);
Notification::route('whatsapp', $normalizedWhatsApp)->notify($whatsappNotification);
```

### Strategia di risoluzione delle dipendenze (NormalizePhoneNumberAction)

- **Motivazione**: `SendRecordsNotificationBulkAction` usa `QueueableAction`, quindi può essere serializzata e accodata. Iniettare `NormalizePhoneNumberAction` nel costruttore renderebbe la serializzazione fragile (dipendenza non serializzabile) e violerebbe la filosofia Laraxot *"un solo punto di verità"* per la risoluzione runtime.
- **Politica**: risolviamo il normalizzatore con `app(NormalizePhoneNumberAction::class)` esattamente dove serve (`sendSms`, `sendWhatsApp`). In questo modo l'azione rimane stateless, idempotente e compatibile con i job queue.
- **Strategia**: se in futuro servirà un normalizzatore diverso basterà aggiornare l'IoC container senza toccare l'azione. Nessun constructor injection significa meno lock‑in e più libertà di override a livello di modulo/tenant.
- **Zen**: le queueable actions devono essere leggere come piume; niente proprietà pesanti, solo dipendenze risolte al bisogno.

## Traduzioni

**File**: `Modules/Notify/lang/it/actions.php`

Struttura completa con:
- Label azione
- Form fields (template_slug, channels)
- Errori per canale non supportato, email/phone/whatsapp non disponibili
- Notifiche di successo/errore

## Error Handling

- **Email non disponibile**: Eccezione con messaggio localizzato
- **Phone non disponibile**: Eccezione con messaggio localizzato
- **WhatsApp non disponibile**: Eccezione con messaggio localizzato
- **Canale non supportato**: Eccezione con messaggio localizzato
- **Errori invio**: Loggati con contesto completo, inclusi nel risultato

Tutti gli errori vengono raccolti e mostrati all'utente tramite notifica Filament.

## Filosofia e Principi

### DRY (Don't Repeat Yourself)
- Una sola implementazione riutilizzabile in tutto il progetto
- Nessuna duplicazione di logica di invio notifiche

### KISS (Keep It Simple, Stupid)
- Modal semplice con 2 campi (template + canali)
- Logica chiara e diretta

### Separation of Concerns
- UI separata da business logic
- Azione riutilizzabile in qualsiasi contesto

### Single Responsibility
- Ogni componente ha una responsabilità ben definita
- Facile da testare e mantenere

## Integrazione in TechPlanner

**File**: `Modules/TechPlanner/app/Filament/Resources/ClientResource/Pages/ListClients.php`

```php
public function getTableBulkActions(): array
{
    return [
        'updateCoordinates' => UpdateCoordinatesBulkAction::make(),
        'sendNotifications' => SendNotificationBulkAction::make(),
    ];
}
```

L'azione è completamente riutilizzabile e può essere aggiunta a qualsiasi Resource Filament che gestisce modelli con proprietà per contatti (email, phone, whatsapp).

## Requisiti Modello

I modelli target devono avere almeno una di queste proprietà:

**Email**:
- `email` (validato come email)
- `pec` (validato come email)
- `contact_email` (validato come email)

**Phone**:
- `mobile`
- `phone`
- `telephone`
- `contact_phone`

**WhatsApp**:
- `whatsapp` (con fallback su phone)

## Estendibilità

L'azione è progettata per essere facilmente estendibile:

- **Nuovi canali**: Aggiungere case nel match statement di `sendNotificationToRecord()`
- **Nuovi attributi contatto**: Aggiungere alla lista di attributi cercati nei metodi `getRecord*()`
- **Validazioni personalizzate**: Estendere `SendRecordNotificationAction` per modificare la logica di invio singolo, che automaticamente si riflette nella bulk

## Pattern DRY: Composizione Actions

### Filosofia

Questa Action segue il pattern **DRY (Don't Repeat Yourself)** composendo `SendRecordNotificationAction` invece di duplicare la logica:

- **SendRecordNotificationAction**: Gestisce invio a UN singolo record (mail, sms, whatsapp)
- **SendRecordsNotificationBulkAction**: Gestisce orchestrazione per più record, compone `SendRecordNotificationAction`

**Pattern simile**: `SendMailByRecordsAction` che compone `SendMailByRecordAction`.

### Composizione nel Codice

```php
// In SendRecordsNotificationBulkAction
$singleRecordAction = app(SendRecordNotificationAction::class);
$singleRecordAction->execute($record, $templateSlug, [$channel]);
```

**Vantaggi**:
- **DRY**: Logica di invio in un solo punto
- **KISS**: Bulk Action semplice, solo orchestrazione
- **Single Responsibility**: Ogni Action ha uno scopo chiaro
- **Testabilità**: Testare single Action separatamente dalla bulk

Vedi: [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md)

## Backlink e Collegamenti

- [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md) - Pattern per Actions che chiamano altre Actions
- [Notification System Architecture](./notification-implementation.md)
- [MailTemplate Model](./models.md#mailtemplate)
- [RecordNotification Class](../../app/Notifications/RecordNotification.php)
- [TechPlanner Client Management](../TechPlanner/docs/README.md#client-management)
- [Geo Module Reusable Components Philosophy](../Geo/docs/reusable-components-philosophy.md)
- [Xot Filament Class Extension Rules](../Xot/docs/filament-class-extension-rules.md)

---

**Ultimo aggiornamento**: 2025-01-18  
**PHPStan Level**: ✅ 10  
**Quality**: ✅ PHPMD, PHPInsights compliant
