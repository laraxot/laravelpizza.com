# Send Notification Bulk Action - DRY Refactoring

**Status**: 🚧 In Progress
**Date**: 2025-01-18
**Priority**: 🔴 High (Clean Code + Reusability)

## Problem Statement

### Business Requirement

Allow sending multi-channel notifications (Email, SMS, WhatsApp) to multiple selected records using customizable mail templates.

### Current Gap

No reusable BulkAction exists for this common pattern. Each resource would need to implement this logic separately, violating DRY.

## Philosophical Analysis

### Why This Matters

**🐄 DRY Perspective**:
> "Notification sending is a cross-cutting concern. Every module needs it. Build once, reuse everywhere."

**🏛️ SOLID Perspective**:
> "Notify module should provide notification capabilities as a service. Other modules consume, not implement."

**💋 KISS Perspective**:
> "Modal with 2 inputs (template selector + channel checkboxes). One action. Simple."

**🧘 ZEN Perspective**:
> "通知 (tsūchi) - The notification flows through many channels, but the source is one."

### Domain Boundaries

```
┌──────────────────┐
│  Meetup     │
│  (Business)      │
│                  │
│  "I need to      │
│   notify         │
│   clients"       │
└────────┬─────────┘
         │ USES
         │
         ▼
┌──────────────────┐
│  Notify          │
│  (Communication) │
│                  │
│  "I provide      │
│   multi-channel  │
│   notifications" │
└──────────────────┘
```

## Solution Architecture

### Three-Layer Approach

```
Layer 1: Core Business Logic
┌─────────────────────────────────────────────────────┐
│ Modules/Notify/app/Actions/                         │
│   SendRecordNotificationAction.php                  │
│   (Spatie QueueableAction)                          │
│                                                     │
│ - Accepts: Model, slug, channels[], data[]          │
│ - Creates: RecordNotification                       │
│ - Sends: Via Notification::route()                  │
│ - Returns: Result DTO with success/failures         │
│ - Queue-able for large batches                      │
└─────────────────────────────────────────────────────┘
                    ▲
                    │ WRAPS
                    │
Layer 2: UI Integration
┌─────────────────────────────────────────────────────┐
│ Modules/Notify/app/Filament/Actions/                │
│   SendNotificationBulkAction.php                    │
│   (Filament BulkAction with Form)                   │
│                                                     │
│ - Shows modal with:                                 │
│   * Select: Mail template slug                      │
│   * Checkboxes: SMS / Mail / WhatsApp              │
│ - Validates selections                              │
│ - Calls SendRecordNotificationAction per record     │
│ - Aggregates results                                │
│ - Shows notifications                               │
└─────────────────────────────────────────────────────┘
                    ▲
                    │ USES
                    │
Layer 3: Resource Usage
┌─────────────────────────────────────────────────────┐
│ Modules/Meetup/.../ListClients.php             │
│                                                     │
│ getTableBulkActions(): array {                      │
│   return [                                          │
│     SendNotificationBulkAction::make(),            │
│   ];                                                │
│ }                                                   │
└─────────────────────────────────────────────────────┘
```

### Data Flow

```
1. User selects records in table
2. User clicks "Send Notification" bulk action
3. Modal opens with form:
   ┌────────────────────────────────────┐
   │ Send Notification                  │
   ├────────────────────────────────────┤
   │ Template:  [Select Template ▼]    │
   │                                    │
   │ Channels:  ☑ Email                 │
   │            ☐ SMS                   │
   │            ☐ WhatsApp              │
   │                                    │
   │      [Cancel]    [Send]            │
   └────────────────────────────────────┘
4. User selects template + channels
5. For each record:
   - Create RecordNotification($record, $slug)
   - Notification::route($channel, $to)->notify($notification)
   - Track success/failure
6. Show aggregated results notification
```

## Implementation Plan

### Step 1: Create Result DTO

**File**: `Modules/Notify/app/Datas/SendNotificationResult.php`

**Properties**:
- `int $totalSent`
- `int $successCount`
- `int $failureCount`
- `Collection $errors`

### Step 2: Create Core Action

**File**: `Modules/Notify/app/Actions/SendRecordNotificationAction.php`

**Signature**:
```php
public function execute(
    Model $record,
    string $templateSlug,
    array $channels,  // ['mail', 'sms', 'whatsapp']
    array $data = []  // Additional merge data
): bool
```

**Logic**:
1. Create `RecordNotification($record, $templateSlug)`
2. Merge additional data if provided
3. For each channel:
   - Determine routing (email/phone/whatsapp number)
   - `Notification::route($channel, $to)->notify($notification)`
4. Return success/failure

### Step 3: Create Batch Wrapper Action

**File**: `Modules/Notify/app/Actions/SendBulkNotificationAction.php`

**Signature**:
```php
public function execute(
    Collection $records,
    string $templateSlug,
    array $channels
): SendNotificationResult
```

**Logic**:
- Loop through records
- Call `SendRecordNotificationAction` for each
- Aggregate results
- Return `SendNotificationResult`

### Step 4: Create Filament BulkAction

**File**: `Modules/Notify/app/Filament/Actions/SendNotificationBulkAction.php`

**Features**:
- Extends `Filament\Tables\Actions\BulkAction`
- Form with:
  - `Select` for template slug (options from `MailTemplate::pluck('name', 'slug')`)
  - `CheckboxList` for channels
- Validation:
  - At least one channel selected
  - Template slug exists
- Action:
  - Calls `SendBulkNotificationAction`
  - Shows success/error notifications

**Form Schema**:
```php
->schema([
    Select::make('template_slug')
        ->label('Mail Template')
        ->options(MailTemplate::pluck('name', 'slug'))
        ->required()
        ->searchable(),

    CheckboxList::make('channels')
        ->label('Notification Channels')
        ->options([
            'mail' => 'Email',
            'sms' => 'SMS',
            'whatsapp' => 'WhatsApp',
        ])
        ->required()
        ->minItems(1),
])
```

**⚠️ Nota Filament 4**: Il metodo `->form()` è deprecato. Usare sempre `->schema()` per definire lo schema del form nelle Actions e BulkActions.

**✅ Componenti Riutilizzabili**: Usare `MailTemplateSelect` e `ChannelCheckboxList` invece di configurare `Select`/`CheckboxList` inline. Vedi [Componenti Form Riutilizzabili](./forms/components-reusable.md).

**🧘 Extract Method Pattern**: Estrarre metodi privati per migliorare leggibilità e manutenibilità. Vedi [Extract Method Pattern](./extract-method-pattern.md).

### Step 5: Add to ListClients

**File**: `Modules/Meetup/.../ListClients.php`

**Change**:
```php
use Modules\Notify\Filament\Actions\SendNotificationBulkAction;

public function getTableBulkActions(): array
{
    return [
        ...parent::getTableBulkActions(),
        SendNotificationBulkAction::make(),
    ];
}
```

## Technical Considerations

### Channel Resolution

Each notifiable entity must implement `routeNotificationFor()`:

```php
// In Client model
public function routeNotificationForMail(): ?string
{
    return $this->email;
}

public function routeNotificationForSms(): ?string
{
    return $this->phone;
}

public function routeNotificationForWhatsapp(): ?string
{
    return $this->whatsapp_number;
}
```

If not implemented, use `Notification::route()` fallback.

### Error Handling

- Template slug not found: Show error, abort
- No channels selected: Form validation prevents
- Missing routing info (email/phone): Skip record, log error
- Notification send failure: Catch exception, log error, continue

### Performance

- For large batches (>100 records): Queue the action
- Use `SendRecordNotificationAction::onQueue()` (Spatie QueueableAction feature)
- Show "Notifications queued" message instead of waiting

## Benefits

1. **DRY**: Single implementation for bulk notifications
2. **Reusability**: Any resource can use this BulkAction
3. **Testability**: Actions independently testable
4. **Maintainability**: Changes in one place
5. **Scalability**: Queue support for large batches
6. **Type Safety**: PHPStan Level 10 compliant
7. **UX**: Consistent notification UI across modules

## Migration Path

### For Other Resources

Any resource needing bulk notifications:

```php
use Modules\Notify\Filament\Actions\SendNotificationBulkAction;

public function getTableBulkActions(): array
{
    return [
        SendNotificationBulkAction::make(),
    ];
}
```

**Zero additional code** required!

## Related Patterns

- **Actions over Services**: Spatie QueueableAction
- **XotBase Pattern**: Reusable Filament actions
- **Module Sovereignty**: Notify owns notification logic
- **DRY + KISS**: Simple, focused implementation
- **Type Safety**: PHPStan Level 10

---

**Next Steps**: Implement Step 1 (Result DTO) and verify architecture.
