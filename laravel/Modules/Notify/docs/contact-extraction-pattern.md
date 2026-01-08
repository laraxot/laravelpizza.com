# Pattern DRY: Estrazione Attributi Contatti da Modelli

**Data**: 2025-01-18  
**Modulo**: Notify  
**Status**: ✅ Pattern consolidato

## Problema Identificato

I metodi `getRecordEmail()`, `getRecordPhone()`, e `getRecordWhatsApp()` in `SendRecordNotificationAction` duplicavano completamente la stessa logica di estrazione attributi da modelli Eloquent (~45 righe di codice duplicato).

In particolare:
- `getRecordEmail()` e `getRecordPhone()` già usavano `getFirstValidAttribute()` (buono)
- `getRecordWhatsApp()` **duplicava** la logica di estrazione invece di usare `getFirstValidAttribute()`

Anche i metodi `sendMail()` e `sendSms()` condividevano logica comune che è stata estratta in `sendGenericNotification()`.

## Soluzione DRY: Metodo Generico

### Metodo Generico `extractRecordAttribute()`

```php
/**
 * Estrae un attributo dal record cercando in una lista di attributi possibili.
 *
 * Pattern DRY: Metodo generico per estrarre attributi da modelli Eloquent evitando
 * duplicazione tra getRecordEmail(), getRecordPhone(), getRecordWhatsApp().
 *
 * @param Model $record Il modello da cui estrarre l'attributo
 * @param array<int, string> $attributes Lista di attributi da cercare in ordine di priorità
 * @param callable(string): bool|null $validator Funzione opzionale per validazione custom (es. filter_var per email)
 * @return string Il valore dell'attributo trovato o stringa vuota se non trovato/valido
 */
private function extractRecordAttribute(Model $record, array $attributes, ?callable $validator = null): string
{
    foreach ($attributes as $attribute) {
        if (!$record->offsetExists($attribute)) {
            continue;
        }

        $value = $record->getAttribute($attribute);
        if (!is_string($value) || $value === '') {
            continue;
        }

        // Se c'è un validator custom, validalo (es. email)
        if ($validator !== null && !$validator($value)) {
            continue;
        }

        return $value;
    }

    return '';
}
```

### Utilizzo nel Codice

#### getRecordEmail()

```php
private function getRecordEmail(Model $record): string
{
    return $this->extractRecordAttribute(
        $record,
        ['email', 'pec', 'contact_email'],
        fn (string $value): bool => filter_var($value, FILTER_VALIDATE_EMAIL) !== false
    );
}
```

#### getRecordPhone()

```php
private function getRecordPhone(Model $record): string
{
    return $this->extractRecordAttribute(
        $record,
        ['mobile', 'phone', 'telephone', 'contact_phone']
    );
}
```

#### getRecordWhatsApp()

```php
/**
 * Ottiene il numero WhatsApp dal record.
 *
 * Pattern DRY: Prova prima l'attributo 'whatsapp' usando getFirstValidAttribute(),
 * poi fallback a getRecordPhone() se non disponibile.
 */
private function getRecordWhatsApp(Model $record): string
{
    // Prova prima l'attributo WhatsApp specifico usando il metodo generico
    $whatsapp = $this->getFirstValidAttribute($record, 'whatsapp');
    if ($whatsapp !== '') {
        return $whatsapp;
    }

    // Fallback: usa mobile o phone se whatsapp non è disponibile
    return $this->getRecordPhone($record);
}
```

**Refactoring applicato**: Eliminata duplicazione di logica (offsetExists + getAttribute + validazione string) usando `getFirstValidAttribute()`. Questo metodo ora segue lo stesso pattern DRY degli altri metodi di estrazione contatti.

## Filosofia

### DRY (Don't Repeat Yourself)

- **Prima**: 3 metodi con ~45 righe di codice duplicato (stesso pattern: offsetExists, getAttribute, validazione)
- **Dopo**: 1 metodo generico (~25 righe) + 3 wrapper semplici (~15 righe totali)
- **Risparmio**: ~30 righe di codice duplicato eliminato

### KISS (Keep It Simple, Stupid)

- Metodo generico semplice e chiaro
- Wrapper specifici mantengono semantica chiara (getRecordEmail vs getRecordPhone)
- Nessun over-engineering: il metodo generico è diretto e leggibile

### Single Responsibility

- `extractRecordAttribute()`: Responsabile solo dell'estrazione generica
- `getRecordEmail/Phone/WhatsApp()`: Responsabili della configurazione specifica (attributi + validazione)

## Pattern Applicabile Altrove

Questo pattern può essere riutilizzato in altre Actions che devono estrarre attributi da modelli Eloquent:

```php
// Esempio: estrazione indirizzo
private function getRecordAddress(Model $record): string
{
    return $this->extractRecordAttribute(
        $record,
        ['full_address', 'address', 'street_address', 'contact_address']
    );
}

// Esempio: estrazione codice fiscale con validazione
private function getRecordTaxCode(Model $record): string
{
    return $this->extractRecordAttribute(
        $record,
        ['tax_code', 'fiscal_code', 'vat_number'],
        fn (string $value): bool => strlen($value) >= 11 && strlen($value) <= 16
    );
}
```

## Validazione Custom

Il validator è una closure che riceve il valore estratto e restituisce `bool`:

```php
// Email validation
fn (string $value): bool => filter_var($value, FILTER_VALIDATE_EMAIL) !== false

// Phone validation (es. almeno 10 caratteri)
fn (string $value): bool => strlen(preg_replace('/\D/', '', $value)) >= 10

// Custom format validation
fn (string $value): bool => preg_match('/^[A-Z]{2}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/', $value) === 1
```

## Refactoring Aggiuntivo: sendGenericNotification()

Inoltre, `sendMail()` e `sendSms()` condividevano la logica di creazione e invio di `RecordNotification`. È stato estratto il metodo comune:

```php
/**
 * Invia una notifica generica usando RecordNotification.
 *
 * Pattern DRY: Metodo comune per inviare notifiche via mail e SMS,
 * evitando duplicazione tra sendMail() e sendSms().
 */
private function sendGenericNotification(Model $record, string $templateSlug, string $channel, string $to): void
{
    $recordNotification = new RecordNotification($record, $templateSlug);
    Notification::route($channel, $to)->notify($recordNotification);
}
```

Utilizzo:
- `sendMail()`: Estrae email, chiama `sendGenericNotification('mail', $email)`
- `sendSms()`: Estrae phone, normalizza, chiama `sendGenericNotification('sms', $normalizedPhone)`
- `sendWhatsApp()`: Mantiene logica separata perché usa `WhatsAppNotification` invece di `RecordNotification`

## Vantaggi

1. **DRY**: Zero duplicazione di logica di estrazione e invio
2. **Manutenibilità**: Modifiche al pattern di estrazione/invio in un solo punto
3. **Testabilità**: Testare `extractRecordAttribute()` e `sendGenericNotification()` una volta, wrapper testabili con mock
4. **Estendibilità**: Facile aggiungere nuovi metodi getRecord*() usando lo stesso pattern
5. **Leggibilità**: Codice più pulito e chiaro
6. **Risparmio codice**: ~30 righe duplicate eliminate tra estrazione contatti, ~10 righe duplicate tra invio mail/sms

## Backlink e Riferimenti

- [DRY Composition Pattern](./dry-composition-pattern.md) - Pattern composizione Actions
- [SendRecordNotificationAction](../../app/Actions/SendRecordNotificationAction.php) - Implementazione completa
- [SendNotificationBulkAction](./send-notification-bulk-action.md) - Azione bulk che usa SendRecordNotificationAction

---

**Filosofia**: "Estrai una volta, usa ovunque" - DRY Principle  
**Pattern**: Metodo generico + wrapper specifici  
**Beneficio**: ~30 righe duplicate eliminate, codice più manutenibile
