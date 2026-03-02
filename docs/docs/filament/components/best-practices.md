# XotBaseSection Best Practices

## Critical Rules for Laraxot Philosophy

### 1. Always Extend XotBaseSection
✅ **CORRECT**: Extend `Modules\Xot\Filament\Schemas\Components\XotBaseSection`
❌ **WRONG**: Directly extend `Filament\Schemas\Components\Section`

```php
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

class YourSection extends XotBaseSection // ✅ Correct
{
    // Implementation
}
```

### 2. Available Methods in XotBaseSection
XotBaseSection currently provides:
- Standard Section methods from Filament
- `disableLiveUpdates(false)` in setUp() (common setup)

### 3. Common Pitfalls to Avoid

#### Don't Use Non-Existent Methods
```php
// ❌ WRONG - These methods don't exist
protected bool $disableLiveUpdates = false;
$this->disableLiveUpdates(false);
```

#### Do Use Valid Section Methods
```php
// ✅ CORRECT
protected function setUp(): void
{
    parent::setUp();
    $this->label('Section Label');
    $this->description('Section description');
    $this->schema([...]);
    $this->columns(2);
}
```

### 4. Enum-Driven Pattern (Preferred)
Follow the enum-driven pattern for form schemas:

```php
use Modules\YourModule\Enums\YourItemEnum;

class YourSection extends XotBaseSection
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->schema(fn (): array => $this->getFormSchema());
        $this->columns(2);
    }

    protected function getFormSchema(): array
    {
        return YourItemEnum::getFormSchema();
    }
}
```

### 5. Testing Your Components
Always test after creating custom sections:
1. Check the page loads without errors
2. Verify form fields appear correctly
3. Test form submission
4. Run PHPStan level 10: `vendor/bin/phpstan analyse`

### 6. Migration from Filament Section
When converting existing Filament Section components:

1. Change the extends statement
2. Remove any invalid method calls
3. Test thoroughly
4. Update documentation

```php
// Before
use Filament\Schemas\Components\Section;
class MySection extends Section

// After
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;
class MySection extends XotBaseSection
```

## Remember
- XotBaseSection is the **only** correct base class for custom sections in Laraxot
- Always verify method existence in Filament documentation
- The docs folders are your memory - update them when you learn something new
