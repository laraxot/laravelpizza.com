# Pattern: Model-First Volt Components

In the Laraxot methodology, when building Livewire Volt components that represent or detail a specific Eloquent model, we follow the **Model-First** pattern.

## 🎯 The Rule

**DO NOT EXPLODE** the model attributes into separate public properties in the `new class extends Component` block.

### ❌ Anti-Pattern: Variable-Splitting
Creating separate properties for every attribute makes the component brittle, non-DRY, and harder to maintain.

```php
new class extends Component {
    public string $title;       // ❌ Ridondante
    public string $description; // ❌ Ridondante
    public string $date;        // ❌ Ridondante
    
    public function mount(Event $event): void {
        $this->title = $event->title;
        $this->description = $event->description;
        // ... eccetera per 20 variabili
    }
}
```

### ✅ Best Practice: Model-First
Keep the model instance as a public property and use it directly.

```php
new class extends Component {
    public ?Event $event = null; // ✅ Singola fonte di verità
    public string $slug0 = '';
    
    public function mount(): void {
        $this->event = Event::where('slug', $this->slug0)->first();
    }
}
```

## 🏗️ Direct Blade Access

In the Blade portion of the file, access properties and methods directly from the model instance. This leverages Eloquent's power and custom model methods (like `toSchemaOrg()`) without boilerplate.

```blade
<h1>{{ $this->event->title }}</h1>
<p>{{ $this->event->description }}</p>

@push('meta')
<script type="application/ld+json">
{!! json_encode($this->event->toSchemaOrg()) !!}
</script>
@endpush
```

## 💎 Benefits
1. **DRY**: No need to sync 20 properties in `mount()`.
2. **KISS**: The component remains small and easy to read.
3. **Robust**: Any changes to the Model are automatically reflected in the component without updates.
4. **Type Safety**: Properties are natively typed via the Eloquent model.

## Plain Blade with Strict Logic (The Sacred Pattern)

Content blocks like `detail.blade.php` MUST remain **Plain Blade Components** (not Volt) when they require standalone tactical logic.

### Rules
1.  **Always** use `<?php declare(strict_types=1);` at the top.
2.  **Always** follow with a descriptive docblock.
3.  **Local Model Resolution**: Use `Request::segment()` or pass variables from the container.
4.  **UI Preservation**: Never change the "Dress" (HTML/CSS) when modernizing the "Engine".

This pattern ensures robustness while maintaining full control over the template's logic and structure.
