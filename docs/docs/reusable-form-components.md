# Reusable Form Components

## Overview
This document describes the reusable Filament form components created to implement the DRY (Don't Repeat Yourself) principle in the Notify module.

## Components

### MailTemplateSelect
A reusable Select component for choosing mail templates from the database.

#### Usage
```php
use Modules\Notify\Filament\Forms\Components\MailTemplateSelect;

MailTemplateSelect::make('mail_template_slug')
```

#### Features
- Pre-configured with proper label from translation files
- Automatically loads mail templates from database (ordered by name)
- Required validation by default
- Proper typing with PHP generics

#### Implementation
```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\Select;
use Modules\Notify\Models\MailTemplate;

class MailTemplateSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('notify::form.mail_template'))
            ->options(
                /** @return array<string, string> */
                fn (): array => MailTemplate::query()
                    ->orderBy('name')
                    ->pluck('name', 'slug')
                    ->all()
            )
            ->required();
    }

    public static function make(string $name = 'mail_template_slug'): static
    {
        return parent::make($name);
    }
}
```

### ChannelCheckboxList
A reusable CheckboxList component for selecting notification channels.

#### Usage
```php
use Modules\Notify\Filament\Forms\Components\ChannelCheckboxList;

ChannelCheckboxList::make('channels')
```

#### Features  
- Pre-configured with proper label from translation files
- Automatically loads channel options from ChannelEnum
- 3-column layout by default
- Required validation by default
- Proper typing with PHP generics

#### Implementation
```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Forms\Components;

use Filament\Forms\Components\CheckboxList;
use Modules\Notify\Enums\ChannelEnum;

class ChannelCheckboxList extends CheckboxList
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('notify::form.channels'))
            ->options(
                /** @return array<string, string> */
                fn (): array => collect(ChannelEnum::cases())
                    ->mapWithKeys(function (ChannelEnum $enum): array {
                        $label = $enum->getLabel();
                        return [$enum->value => is_string($label) ? $label : $enum->value];
                    })
                    ->all()
            )
            ->columns(3)
            ->required();
    }

    public static function make(string $name = 'channels'): static
    {
        return parent::make($name);
    }
}
```

## Benefits

### DRY (Don't Repeat Yourself)
- Eliminates duplicated form field definitions across multiple actions/pages
- Centralized configuration for mail template selection and channel options
- Single source of truth for these common form components

### KISS (Keep It Simple, Stupid)
- Simple API for reusing complex form fields
- Minimal configuration needed when using these components
- Clear and predictable behavior

### Maintainability
- Changes to mail template or channel selection logic only need to be made in one place
- Consistent user experience across all forms using these components
- Easier to test and validate since logic is centralized

## Implementation Example
These components are used in `SendRecordsNotificationBulkAction` to replace the inline schema definitions:

**Before:**
```php
->schema([
    Select::make('mail_template_slug')
        ->label(__('notify::form.mail_template'))
        ->options(...)
        ->required(),
    CheckboxList::make('channels')
        ->label(__('notify::form.channels'))
        ->options(...)
        ->columns(3)
        ->required(),
])
```

**After:**
```php
->schema([
    MailTemplateSelect::make('mail_template_slug'),
    ChannelCheckboxList::make('channels'),
])
```

## Quality Checks Results
- ✅ PHPStan Level 10: No errors detected
- ✅ Syntax validation: All files valid
- ✅ Type safety: Proper generics and return type declarations
- ✅ Consistency: Follows existing code patterns in the module

## Related Documentation
- [Send Notification Bulk Action](./send-notification-bulk-action.md)
- [Enums Documentation](../enums/)
- [Filament Extension Rules](../FILAMENT_EXTENSION_RULES.md)

## Last Updated
December 19, 2025