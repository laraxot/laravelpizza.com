# GDPR Actions

## Overview

The `Gdpr` module uses Spatie Queueable Actions to handle privacy-related logic, ensuring data persistence is robust and decoupled from UI components.

## Actions

### SaveGdprConsentsAction

- **Namespace**: `Modules\Gdpr\Actions`
- **Responsibility**: Maps Livewire consent properties to `Treatment` records and persists them as `Consent` entries.
- **Queueable**: Yes.

#### Usage

```php
app(SaveGdprConsentsAction::class)->execute($user, $consents);
```

#### Parameters
- `$user`: The `User` model instance.
- `$consents`: An associative array of consent flags (e.g., `['privacy_accepted' => true, ...]`).
