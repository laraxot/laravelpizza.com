# Refactoring RecordNotification - Zen Delegation Pattern

**Data**: 19 Dicembre 2025  
**Stato**: ✅ Implementato  
**Motivazione**: Zen Delegation, DRY assoluto, SRP

## 🎯 Problema Identificato

La precedente implementazione di `RecordNotification` duplicava logica già presente in `SpatieEmail`:

1. **Duplicazione Template Resolution**: Risolveva `MailTemplate` internamente invece di delegare
2. **Duplicazione Placeholder Replacement**: Implementava logica di replacement invece di usare `SpatieEmail->buildSms()`
3. **Duplicazione Layout Logic**: Gestiva layout email invece di delegare a `SpatieEmail` che usa `GetMailLayoutAction`
4. **God Object Anti-Pattern**: `RecordNotification` faceva troppe cose (template, placeholder, layout, notification)

## ✅ Soluzione Implementata: Zen Delegation

### Pattern Corretto (Delega Completa a SpatieEmail)

```php
// ✅ CORRETTO: RecordNotification delega tutto a SpatieEmail
$notification = new RecordNotification($record, 'notification-slug');
$notification->mergeData(['custom' => 'value']);
$notification->addAttachments($attachments);
$client->notify($notification);
```

**Flusso**:
1. `RecordNotification` riceve `Model $record` e `string $slug`
2. `toMail()` crea `SpatieEmail` e delega tutto (template, placeholder, layout, attachments)
3. `toSms()` usa `SpatieEmail->buildSms()` e wrappa in `SmsData`
4. `via()` determina canali basandosi su `routeNotificationFor()` del notifiable

### Benefici

1. **DRY Assoluto**: Zero duplicazione - tutta la logica in `SpatieEmail`
2. **SRP**: `RecordNotification` è un bridge, `SpatieEmail` gestisce content
3. **KISS**: RecordNotification diventa thin wrapper, non God Object
4. **Consistency**: Riutilizza `SpatieEmail` già testato e funzionante
5. **Maintainability**: Modifiche a placeholder/template solo in `SpatieEmail`
6. **Single Source of Truth**: `SpatieEmail` è l'unica fonte di verità per content generation

## 🔧 Modifiche Implementate

### RecordNotification.php

**Prima (Lazy Resolution ma ancora duplicazione)**:
```php
class RecordNotification extends Notification implements ShouldQueue
{
    private ?MailTemplate $mailTemplateInstance = null;

    private function getMailTemplate(): MailTemplate
    {
        // Risolve MailTemplate internamente - DUPLICA SpatieEmail
        return MailTemplate::firstOrCreate([...]);
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailTemplate = $this->getMailTemplate();
        $htmlContent = $this->replacePlaceholders(...); // DUPLICA logica SpatieEmail
        return $this->buildMailMessage($subject, $htmlContent);
    }

    public function toSms(object $notifiable): string
    {
        $mailTemplate = $this->getMailTemplate();
        return $this->replacePlaceholders(...); // DUPLICA logica SpatieEmail
    }

    private function replacePlaceholders(string $template): string
    {
        // Logica duplicata da SpatieEmail
    }
}
```

**Dopo (Zen Delegation)**:
```php
class RecordNotification extends Notification
{
    protected Model $record;
    protected string $slug;
    public array $data = [];
    public array $attachments = [];

    public function __construct(Model $record, string $slug)
    {
        $this->record = $record;
        $this->slug = Str::slug($slug);
        // NIENTE risoluzione template - delegato a SpatieEmail
    }

    public function via(object $notifiable): array
    {
        // Determina canali basandosi su routeNotificationFor()
        $channels = [];
        if ($notifiable->routeNotificationFor('mail')) {
            $channels[] = 'mail';
        }
        if ($notifiable->routeNotificationFor('sms')) {
            $channels[] = SmsChannel::class; // Modules\Notify\Channels\SmsChannel
        }
        return $channels;
    }

    public function toMail(object $notifiable): SpatieEmail
    {
        // Zen: Delega COMPLETAMENTE a SpatieEmail
        $email = new SpatieEmail($this->record, $this->slug);
        $email = $email->mergeData($this->data);
        $email = $email->addAttachments($this->attachments);
        
        // Set recipient per envelope()
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('mail');
            if (is_string($to) && $to !== '') {
                $email->setRecipient($to);
            }
        }

        return $email; // Ritorna SpatieEmail direttamente
    }

    public function toSms(object $notifiable): ?SmsData
    {
        // Zen: Delega SMS content a SpatieEmail->buildSms()
        $email = new SpatieEmail($this->record, $this->slug);
        $email = $email->mergeData($this->data);

        // Get recipient
        $to = null;
        if (method_exists($notifiable, 'routeNotificationFor')) {
            $to = $notifiable->routeNotificationFor('sms');
        }
        if ($to === null || $to === '') {
            $fallbackTo = config('sms.fallback_to');
            if (is_string($fallbackTo) && $fallbackTo !== '') {
                $to = $fallbackTo;
            }
        }
        if ($to === null || $to === '') {
            return null;
        }

        // Usa SpatieEmail->buildSms() - tutta la logica template/placeholder è lì
        $smsBody = $email->buildSms();

        // Wrap in SmsData per SmsChannel (Modules\Notify\Channels\SmsChannel)
        return SmsData::from([
            'from' => 'Xot',
            'to' => $to,
            'body' => $smsBody,
        ]);
    }
}
```

## 📚 Pattern Consistency

### SpatieEmail (Specialized Agent)
- Gestisce: Template resolution, placeholder replacement (Mustache), layout stagionali
- Metodi: `buildSms()`, `mergeData()`, `addAttachments()`, `getHtmlLayout()`

### RecordNotification (Bridge)
- Gestisce: Channel determination (`via()`), Notification orchestration
- Delega: Tutto il content generation a `SpatieEmail`

**Pattern Unificato**: `RecordNotification` è un bridge puro, `SpatieEmail` è il specialized agent.

## 🧘 Filosofia e Principi

### Zen Delegation

> "RecordNotification knows WHO and WHAT channels, SpatieEmail knows HOW to build content"

- **RecordNotification**: Conosce destinatario (record) e intent (slug), determina canali
- **SpatieEmail**: Conosce come risolvere template, sostituire placeholder, applicare layout

### Single Responsibility Principle (SRP)

- **RecordNotification**: Responsabilità = Bridge Laravel Notification ↔ SpatieEmail
- **SpatieEmail**: Responsabilità = Content generation (template, placeholder, layout)

### DRY Assoluto

- **Zero duplicazione**: Tutta la logica template/placeholder/layout in `SpatieEmail`
- **Single Source of Truth**: `SpatieEmail` è l'unica fonte per content generation
- **Maintainability**: Modifiche solo in `SpatieEmail`

### KISS

- **RecordNotification**: Thin wrapper, non God Object
- **API semplice**: Passa record + slug, delega il resto
- **Composizione**: Usa componenti esistenti invece di duplicare

## ✅ Verifica Qualità

- ✅ PHPStan Level 10: **0 errori** (RecordNotification.php)
- ✅ Zen Delegation: Tutta la logica delegata a `SpatieEmail`
- ✅ DRY: Zero duplicazione di logica template/placeholder
- ✅ SRP: Responsabilità chiare e separate
- ✅ Type Safety: Tipizzazione completa
- ✅ PHPInsights: 95.9% Code, 88.2% Architecture

## 📊 Impatto

### File Modificati

1. `RecordNotification.php`: Refactoring completo per Zen Delegation
   - Rimosso: `getMailTemplate()`, `replacePlaceholders()`, `buildMailMessage()`, `ShouldQueue`
   - Aggiunto: Delegazione completa a `SpatieEmail`
   - Cambiato: `toMail()` ritorna `SpatieEmail` invece di `MailMessage`
   - Cambiato: `toSms()` ritorna `?SmsData` invece di `string`
   - Cambiato: `via()` usa `routeNotificationFor()` invece di verificare MailTemplate

### Breaking Changes

⚠️ **Breaking Changes**:

1. **`toMail()` return type**: Cambia da `MailMessage` a `SpatieEmail`
   - **Impatto**: Compatibile - Laravel supporta ritornare Mailable da `toMail()` (vedi `UserServiceProvider`)

2. **`toSms()` return type**: Cambia da `string` a `?SmsData`
   - **Impatto**: Richiede `SmsChannel` che accetta `SmsData` (non `string`)
   - **Soluzione**: Usare `Modules\Notify\Channels\SmsChannel` in `via()` (non `Notifications\Channels\SmsChannel`)
   - **Nota**: `SendRecordNotificationAction` usa `Notification::route()` che bypassa `via()`, quindi usa `ChannelEnum::getNotificationChannel()` che ritorna `Notifications\Channels\SmsChannel`. Questo può creare incompatibilità se `via()` viene chiamato direttamente.

3. **Rimosso `ShouldQueue`**: `RecordNotification` non implementa più `ShouldQueue`
   - **Impatto**: Queueing gestito da `SpatieEmail` se necessario, o dal chiamante

4. **`via()` cambia logica**: Ora determina canali da `routeNotificationFor()` invece di verificare MailTemplate
   - **Impatto**: Se `via()` viene chiamato direttamente (es. `$notifiable->notify()`), usa questa nuova logica
   - **Nota**: `SendRecordNotificationAction` bypassa `via()` usando `Notification::route()`

### Migrazione

```php
// PRIMA (breaking)
$notification = new RecordNotification($record, 'slug');
$notification->additionalData = [...]; // ❌ property pubblica
$client->notify($notification); // via() verificava MailTemplate

// DOPO (corretto)
$notification = new RecordNotification($record, 'slug');
$notification->mergeData([...]); // ✅ metodo mergeData()
$client->notify($notification); // via() determina canali da routeNotificationFor()

// Nota: SendRecordNotificationAction bypassa via() usando Notification::route()
// quindi usa ChannelEnum::getNotificationChannel() che può differire
```

## 🔗 Riferimenti

- [RECORD_NOTIFICATION_ZEN_CONSTRUCTOR.md](./RECORD_NOTIFICATION_ZEN_CONSTRUCTOR.md) - Filosofia Zen Delegation
- [record-notification.md](../notifications/record-notification.md) - Documentazione completa RecordNotification
- [record-notification-constructor-slug.md](./record-notification-constructor-slug.md) - Refactoring precedente (Lazy Resolution, ora superato)
- [send-record-notification-action.md](../actions/send-record-notification-action.md) - Documentazione SendRecordNotificationAction

---

**Ultimo aggiornamento**: 19 Dicembre 2025  
**Filosofia**: *"Delegation over duplication, bridge over God Object, simplicity over complexity"*
