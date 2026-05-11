# Protected String $view Rule

## WARNING: Never define protected string $view in Filament components extending XotBaseField

### Why this rule exists
This is a **CRITICAL ARCHITECTURAL LANDMINE** that breaks Filament's rendering lifecycle and causes silent failures. XotBaseField (the foundation of all Filament forms) declares `protected string $view;` internally as a *reserved property name* used by Laravel Blade to inject the component's view path. If you declare your own `protected string $view;`, you:

1. **Overwrite the reserved property** used by XotBaseField's core rendering logic
2. **Break the Filament framework's dynamic view resolution**
3. **Cause silent rendering failures** where components display blank or incorrect templates
4. **Create difficult-to-debug issues** that appear as "component not found" errors

### The Technical Reality
XotBaseField's rendering pipeline works like this:
```php
// Inside XotBaseField's render() method:
$userSuppliedViewPath = $this->view; // ← This is WHERE your protected string $view would conflict
// XotBaseField then internally does:
return $this->makeView($userSuppliedViewPath);
```

When you declare:
```php
protected string $view = 'some.custom.view';  // ← THIS IS FORBIDDEN
```

You're actually:
- Overwriting the property name XotBaseField uses for *its own internal state*
- Breaking Blade's automatic view path resolution
- Creating a naming collision that causes the framework to look for the wrong view file

### Correct Pattern
**DO THIS INSTEAD:**
```php
// ✅ CORRECT: Let XotBaseField handle view resolution automatically
class MyMapPicker extends XotBaseField
{
    // No protected $view property here!
    
    // ✅ ONLY override protected methods if absolutely necessary:
    protected function render(): string
    {
        return parent::render(); // Let XotBaseField handle the view path
    }

    // ✅ Add custom behavior through overrides that DON'T conflict with reserved names
    protected function getDefaultColumn(): string
    {
        return 'value';
    }
}
```

### Real-World Consequences
- ✅ **Working**: Component renders correctly using default Blade templates in `resources/views/filament/forms/components/`
- ✅ **Working**: All form interactions function properly with Livewire
- ✅ **Working**: No rendering errors in browser console
- ❌ **Failing**: Component shows blank screen with no error logs
- ❌ **Failing**: "View [some.custom.view] not found" errors during rendering
- ❌ **Failing**: Other components in the same form break unpredictably

### Documentation References
- **CRITICAL RULE**: All Filament fields MUST extend `XotBaseField` ([xotbasefield-mandatory.md](xotbasefield-mandatory.md))
- **Related Rule**: MapPicker Must Extend XotBaseField ([mappicker-xotbasefield-rule.md](mappicker-xotbasefield-rule.md))
- **Architecture Document**: XotBaseField Philosophy ([xot-base-field-philosophy.md](xot-base-field-philosophy.md))

### Verification Checklist
- [ ] No `protected string $view` declarations in component PHP classes
- [ ] All components extend `Modules\Xot\Filament\Forms\Components\XotBaseField`
- [ ] View rendering works through `parent::render()` without custom view path overrides
- [ ] No blank component rendering in browser