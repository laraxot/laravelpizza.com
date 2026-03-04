# Refactoring RecordNotification Constructor - Slug Pattern

**Stato**: ✅ Implementato  
**Motivazione**: Lazy Resolution, Consistency, DRY + KISS

## 🎯 Problema Identificato

Il costruttore di `RecordNotification` accettava un `MailTemplate $mailTemplate`, richiedendo ai chiamanti di caricare il template dal database prima di creare la notifica. Questo violava:

1. **DRY**: Logica di risoluzione template duplicata nei chiamanti
2. **KISS**: Complessità inutile - caricare template prima di creare notifica
3. **Lazy Resolution**: Template caricato anche quando non necessario
4. **Inconsistency**: Pattern diverso da `SpatieEmail` che usa `string $slug`

**Nota**: Questo refactoring è stato successivamente superato dal [Zen Delegation Pattern](./record-notification-zen-delegation.md), dove `RecordNotification` delega completamente a `SpatieEmail` per template resolution e content generation, eliminando anche la lazy resolution interna.

## ✅ Soluzione Implementata

### Pattern Corretto (Lazy Resolution con Slug)

```php
// ✅ CORRETTO: Pass slug string - RecordNotification resolves MailTemplate internally
$notification = new RecordNotification($record, 'notification-slug');
```

**Flusso**:
1. Chiamante passa solo `string $slug` (intent, non implementation detail)
2. `RecordNotification` risolve `MailTemplate` internamente via `firstOrCreate()`
3. Se template non esiste, viene creato automaticamente con default
4. Template caricato solo quando necessario (lazy resolution)

### Benefici

1. **DRY**: Logica di risoluzione template centralizzata in `RecordNotification`
2. **KISS**: API più semplice - solo slug, non oggetto complesso
3. **Consistency**: Stesso pattern di `SpatieEmail` che usa `string $slug`
4. **Lazy Resolution**: Template caricato solo quando necessario
5. **Automatic Creation**: Default template creato automaticamente se non esiste
6. **Queue-Safe**: Notification serializzabile senza dipendere da oggetti DB

## 🔧 Modifiche Implementate

### RecordNotification.php

**Prima**:
```php
public function __construct(
    public Model $record,
    public MailTemplate $mailTemplate
) {
    // MailTemplate già caricato dal chiamante
}
```

**Dopo (Lazy Resolution - ora superato da Zen Delegation)**:
```php
public function __construct(
    Model $record,
    string $slug
) {
    $this->record = $record;
    // Lazy resolution: MailTemplate resolved internally from slug using firstOrCreate
    // NOTA: Questo pattern è stato successivamente sostituito da Zen Delegation
    // dove RecordNotification delega tutto a SpatieEmail che gestisce template resolution
    $this->mailTemplate = MailTemplate::firstOrCreate(
        [
            'mailable' => self::class,
            'slug' => $slug,
        ],
        [
            'subject' => 'Notification for ' . class_basename($record),
            'html_template' => '<p>Default notification for {{ first_name }} {{ last_name }}</p>',
            // ... altri default
        ],
    );
}
```

**Attuale (Zen Delegation)**:
```php
public function __construct(
    Model $record,
    string $slug
) {
    $this->record = $record;
    $this->slug = Str::slug($slug);
    // NIENTE risoluzione template qui - delegato completamente a SpatieEmail
    // SpatieEmail gestisce template resolution quando toMail() o toSms() viene chiamato
}
```

### SendRecordNotificationAction.php

**Prima**:
```php
public function execute(
    Model $record,
    MailTemplate $mailTemplate,
    array $channels
): void {
    $notification = new RecordNotification($record, $mailTemplate);
    // ...
}
```

**Dopo**:
```php
public function execute(
    Model $record,
    string $mailTemplateSlug,
    array $channels
): void {
    // Pass slug string, not MailTemplate instance - RecordNotification resolves it internally
    $notification = new RecordNotification($record, $mailTemplateSlug);
    // ...
}
```

### SendRecordsNotificationBulkAction.php

**Prima**:
```php
// Load MailTemplate once
$mailTemplate = MailTemplate::where('slug', $templateSlug)->first();
if ($mailTemplate === null) {
    // Error handling...
}
// ...
$singleRecordAction->execute($record, $mailTemplate, $channelEnums);
```

**Dopo**:
```php
// Template will be resolved internally by RecordNotification using firstOrCreate
// No need to pre-load MailTemplate - RecordNotification handles it lazily
// ...
$singleRecordAction->execute($record, $templateSlug, $channelEnums);
```

### Altri File Aggiornati

- `SendSmsPage.php`: Passa slug direttamente invece di caricare MailTemplate
- `SendSpatieEmailPage.php`: Passa slug direttamente invece di caricare MailTemplate
- `XotBaseTransition.php`: Passa slug direttamente invece di caricare MailTemplate

## 📚 Pattern Consistency

### SpatieEmail vs RecordNotification

**SpatieEmail** (già implementato):
```php
public function __construct(Model $record, string $slug)
{
    $this->slug = Str::slug($slug);
    $tpl = MailTemplate::firstOrCreate(
        ['mailable' => SpatieEmail::class, 'slug' => $this->slug],
        [/* defaults */]
    );
}
```

**RecordNotification** (Zen Delegation - attuale):
```php
public function __construct(Model $record, string $slug)
{
    $this->record = $record;
    $this->slug = Str::slug($slug);
    // NIENTE risoluzione template - delegato completamente a SpatieEmail
    // Template resolution avviene quando SpatieEmail viene istanziato in toMail()/toSms()
}
```

**Pattern Unificato**: Entrambi accettano `string $slug`. `RecordNotification` delega template resolution a `SpatieEmail` (Zen Delegation), mentre `SpatieEmail` gestisce la risoluzione internamente quando necessario.

## 🧘 Filosofia e Principi

### Intent-Based Identification

> "Tell me what you want (slug), not how to get it (MailTemplate instance)"

- **Slug = Intent**: Rappresenta l'intento logico ('welcome-email', 'invoice-ready')
- **MailTemplate = Implementation**: È un dettaglio di implementazione che la Notification gestisce

### Lazy Resolution

> "Load only when needed, not eagerly"

- Template caricato solo quando la Notification viene renderizzata
- Riduce query DB premature
- Garantisce uso di contenuti più recenti (anche dopo coda)

### Separation of Concerns

> "Caller knows WHAT, Notification knows HOW"

- Chiamante: Conosce solo intent (slug) e destinatario (record)
- Notification: Gestisce risoluzione template internamente

### DRY + KISS

- **DRY**: Logica risoluzione template in un solo posto (`RecordNotification`)
- **KISS**: API semplice - solo slug, non oggetto complesso

## ✅ Verifica Qualità

- ✅ PHPStan Level 10: **0 errori**
- ✅ Pattern Consistency: Allineato con `SpatieEmail`
- ✅ Lazy Resolution: Template caricato solo quando necessario
- ✅ Automatic Creation: Default template creato se non esiste
- ✅ Queue-Safe: Notification serializzabile

## 📊 Impatto

### File Modificati

1. `RecordNotification.php`: Costruttore modificato per accettare `string $slug`
2. `SendRecordNotificationAction.php`: Parametro modificato da `MailTemplate` a `string`
3. `SendRecordsNotificationBulkAction.php`: Rimossa pre-caricamento MailTemplate
4. `SendSmsPage.php`: Passa slug direttamente
5. `SendSpatieEmailPage.php`: Passa slug direttamente
6. `XotBaseTransition.php`: Passa slug direttamente
7. Documentazione: Aggiornata per riflettere nuovo pattern

### Breaking Changes

⚠️ **Breaking Change**: Tutti i chiamanti devono passare `string $slug` invece di `MailTemplate $mailTemplate`

**Migrazione**:
```php
// PRIMA (breaking)
$mailTemplate = MailTemplate::where('slug', 'welcome')->first();
$notification = new RecordNotification($record, $mailTemplate);

// DOPO (corretto)
$notification = new RecordNotification($record, 'welcome');
```

## 🔗 Riferimenti

- [RECORD_NOTIFICATION_ZEN_CONSTRUCTOR.md](./record_notification_zen_constructor.md) - Filosofia Zen per costruttore
- [RecordNotification Zen Delegation](./record-notification-zen-delegation.md) - **✅ Pattern attuale**: Delega completa a SpatieEmail
- [record-notification.md](../notifications/record-notification.md) - Documentazione completa RecordNotification
- [send-record-notification-action.md](../actions/send-record-notification-action.md) - Documentazione SendRecordNotificationAction

## ⚠️ Nota Importante

**Questo documento descrive il pattern "Lazy Resolution" che è stato successivamente superato dal [Zen Delegation Pattern](./record-notification-zen-delegation.md)**.

Il pattern attuale di `RecordNotification` è **Zen Delegation**: invece di risolvere `MailTemplate` internamente (lazy resolution), `RecordNotification` delega completamente a `SpatieEmail` che gestisce tutta la logica di template resolution, placeholder replacement e layout application. Questo elimina qualsiasi duplicazione e segue il principio DRY in modo assoluto.

---

**
**Filosofia**: *"Intent over implementation, lazy over eager, simple over complex"*
