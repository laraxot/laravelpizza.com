## EnumSelect Component Specification

A reusable Iron Select for PHP-backed enums in Filament v5.

**Key Features:**
- : Enums via `->enum(MyEnum::class)`
- : Handles HasLabel/HasIcon interfaces
- : Fallback labels/icons via case name
- : HTML support in labels
- : Tom Select compatibility

**Usage Example:**
```php
use Modules\UI\Filament\Forms\Components\EnumSelect;

EnumSelect::make('type_id')
    ->enum(TicketTypeEnum::class)
    ->required()
    ->searchable()
```

... (continued in next file)
