# GDPR Compliance Guide for Registration

## Core Principles (Italian Privacy Code & GDPR)

1.  **Consent must be Free, Specific, Informed, and Unambiguous.**
2.  **No Pre-ticked Checkboxes.**
3.  **Granular Consent**: Separate checkboxes for different purposes.
4.  **Clear Information**: Links to legal documents must be visible.

## Required Fields for Registration

### 1. Mandatory Acceptances (Contractual/Legal)
*   **Terms of Service**: Acceptance of the contract. (Mandatory, Unchecked)
*   **Privacy Policy**: Acknowledgement of the information notice. (Mandatory, Unchecked)

### 2. Optional Consents (Marketing/Profiling)
*   **Marketing**: Sending promotional communications. (Optional, Unchecked)
*   **Profiling**: Analyzing preferences for targeted advertising. (Optional, Unchecked)
*   **Third Party Sharing**: Sharing data with partners. (Optional, Unchecked - *If applicable*)

## Implementation Rules

### Filament Components
Use `Checkbox::make()` for all consents.

```php
Checkbox::make('privacy_policy')
    ->label(__('user::auth.fields.privacy_policy'))
    ->required()
    ->accepted() // Custom rule to ensure it's checked
    ->validationAttribute(__('user::auth.fields.privacy_policy'));

Checkbox::make('marketing_consent')
    ->label(__('user::auth.fields.marketing_consent'))
    ->default(false); // MUST be false
```

### Translations
All label text must be translatable.
*   `user::auth.consents.privacy_policy`
*   `user::auth.consents.terms_of_service`
*   `user::auth.consents.marketing`
*   `user::auth.consents.profiling`

### Storage
Consents should be stored in a dedicated `consents` JSON column or a related `consents` table, timestamped and versioned (e.g., `privacy_policy_v1_accepted_at`).
*For this implementation, we will assume standard columns or a `consents` json field on the user model if available, or just log them.*
*Actually, standard practice in simple apps is just ensuring they are checked for the mandatory ones, and storing the boolean for optional ones in the user profile.*

## References
*   [Garante Privacy Marketing Guidelines](https://www.garanteprivacy.it)
*   [GDPR Art. 6 & 7](https://gdpr-info.eu)
