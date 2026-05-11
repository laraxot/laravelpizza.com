---
name: final-constructor-rule
description: Prevent overriding final __construct() from Filament Field base class.
type: concept
---

# Final Constructor Rule

## Why the error occurs

`Filament\Forms\Components\Field` declares its constructor as **final** to guarantee proper initialization of internal Filament state. Any subclass that defines its own `__construct()` attempts to replace that logic and triggers the PHP fatal error:

```
Cannot override final method Filament\Forms\Components\Field::__construct()
```

## Correct implementation

- **Do not define `__construct()`** in custom field components such as `GeopointPicker` or `CoordinatePicker`.
- Use the `setUp()` method (provided by `XotBaseField`/`Filament\Forms\Components\Field`) to add custom initialization logic.
- If a property needs a default value, assign it directly in the class body or in `setUp()`.

```php
class GeopointPicker extends XotBaseField {
    use HasCoordinatePicker;

    protected ?string $latitude = null;
    protected ?string $longitude = null;

    protected function setUp(): void {
        parent::setUp();
        $this->setUpCoordinatePicker();
        // Any other custom defaults go here
    }
}
```

## Enforcement

| Step | Tool |
|------|------|
| **Static analysis** | PHPStan will flag attempts to override a final method. |
| **Pre‑commit hook** | Scan for `function __construct(` in files extending `Filament\Forms\Components\Field`. |
| **CI test** | Add a test that ensures no subclass of `Field` declares its own constructor. |

## Related rules
- `blade-component-extraction-rule` – keep component logic in PHP classes, not in Blade. 
- `static-analysis-workflow` – run PHPStan after every edit to catch overrides early.

---
