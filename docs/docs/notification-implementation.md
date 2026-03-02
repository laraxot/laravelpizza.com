# Notification System Implementation Plan

## Overview
We are adding a bulk action to trigger notifications using `RecordNotification`.

## Components

### 1. Spatie Queueable Action
- **Path**: `Modules/Notify/app/Actions/SendRecordNotificationAction.php`
- **Responsibility**: Execute the notification sending logic.
- **Inputs**: `Model $record`, `string $slug`, `array $channels`.

### 2. Filament Bulk Action
- **Path**: `Modules/Notify/app/Filament/Actions/SendNotificationBulkAction.php`
- **Responsibility**: UI for user input (Template, Channels).
- **Inputs**: Selection of records.

### 3. Integration
- Integrated into `Modules/TechPlanner/app/Filament/Resources/ClientResource/Pages/ListClients.php`.

## Data Flow
Customer List -> Bulk Action -> Modal (Select Template + Channels) -> Submit -> Loop Records -> SendRecordNotificationAction -> Notification::route -> RecordNotification

## Validation
- phpstan (level 10/max)
- phpmd
- phpinsights

## Refactoring Notes

### Composizione Actions (DRY Pattern)

- **SendRecordsNotificationBulkAction**: Composes `SendRecordNotificationAction` instead of duplicating logic (DRY pattern).
- **SendRecordsNotificationBulkAction (Renaming & Delegation)**:
    - **Renaming**: Changed to plural `SendRecords...` to clearly indicate it handles a collection of records.
    - **Delegation**: Now delegates the per-record logic to `SendRecordNotificationAction`.
    - **Reasoning**: Applies DRY and KISS. The logic to send to *one* record exists in `SendRecordNotificationAction`. The Bulk action should only care about iteration and result aggregation, not the sending implementation details.

Vedi: [DRY Composition Pattern](./dry-composition-pattern.md)

### Estrazione Attributi Contatti (DRY Pattern)

- **SendRecordNotificationAction**: Refactored `getRecordEmail()`, `getRecordPhone()`, `getRecordWhatsApp()` per eliminare duplicazione.
    - **Prima**: ~45 righe di codice duplicato (stesso pattern: offsetExists, getAttribute, validazione)
    - **Dopo**: Metodo generico `extractRecordAttribute()` (~25 righe) + 3 wrapper semplici (~15 righe totali)
    - **Risparmio**: ~30 righe di codice duplicato eliminate
    - **Pattern**: Metodo generico con validator opzionale per validazione custom (es. email validation)
    - **Reasoning**: DRY + KISS. Logica di estrazione centralizzata in un metodo, wrapper mantengono semantica chiara.

Vedi: [Contact Extraction Pattern](./contact-extraction-pattern.md)

### Dependency Resolution (Runtime Service Resolution)

- **SendRecordNotificationAction**: Uses `app(NormalizePhoneNumberAction::class)->execute()` for phone normalization (no constructor injection).
    - **Reasoning**: Spatie Queueable Actions are serialized when queued. Constructor dependencies can cause serialization issues or unnecessary overhead. Using `app()` inside methods ensures lazy loading and cleaner serialization.
    - **Philosophy**: Keep Actions simple, stateless, and serialization-friendly.

Vedi: [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md)


