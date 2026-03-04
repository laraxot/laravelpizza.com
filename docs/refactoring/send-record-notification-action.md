# Refactoring Plan: SendRecordNotificationAction

## Goal
Eliminate code duplication in `SendRecordNotificationAction` by abstracting attribute retrieval logic and standardizing the notification flow, adhering to DRY and KISS principles.

## Existing Issues
1. **Duplicated Attribute Logic**: Methods `getRecordEmail`, `getRecordPhone`, and `getRecordWhatsApp` share nearly identical logic for checking multiple attributes on a model.
2. **Repetitive Validation**: Each `sendX` method (sendMail, sendSms, sendWhatsApp) manually retrieves data and throws a generic exception if empty, with slightly different messages.

## Proposed Changes

### 1. Abstract Attribute Retrieval
Introduce a private helper method to handle the common pattern of checking multiple attributes.

```php
/**
 * Trova il primo valore non vuoto tra gli attributi specificati.
 *
 * @param Model $record
 * @param array<string> $attributes
 * @param callable(mixed): bool|null $validator
 * @return string
 */
private function findAttributeValue(Model $record, array $attributes, ?callable $validator = null): string
{
    foreach ($attributes as $attribute) {
        if (! $record->offsetExists($attribute)) {
            continue;
        }

        $value = $record->getAttribute($attribute);
        
        if (! is_string($value) || $value === '') {
            continue;
        }

        if ($validator !== null && ! $validator($value)) {
            continue;
        }

        return $value;
    }

    return '';
}
```

### 2. Refactor Helpers
Update `getRecordEmail`, `getRecordPhone`, and `getRecordWhatsApp` to use this helper.

```php
private function getRecordEmail(Model $record): string
{
    return $this->findAttributeValue(
        $record, 
        ['email', 'pec', 'contact_email'], 
        fn($value) => filter_var($value, FILTER_VALIDATE_EMAIL) !== false
    );
}

private function getRecordPhone(Model $record): string
{
    return $this->findAttributeValue(
        $record, 
        ['mobile', 'phone', 'telephone', 'contact_phone']
    );
}

private function getRecordWhatsApp(Model $record): string
{
    // Check specific whatsapp field first
    $whatsapp = $this->findAttributeValue($record, ['whatsapp']);
    
    if ($whatsapp !== '') {
        return $whatsapp;
    }
    
    // Fallback to phone
    return $this->getRecordPhone($record);
}
```

### 3. Simplify Send Methods
The send methods are reasonably distinct because of the different notification classes (`RecordNotification` vs `WhatsAppNotification`) and normalization requirements (`NormalizePhoneNumberAction` vs none for email). We will keep them separate but ensure they clearly delegate value retrieval to the refactored helpers.

## Verification
- Run PHPStan to ensure no type errors.
- Verify PHPMD/PHPInsights compliance.
