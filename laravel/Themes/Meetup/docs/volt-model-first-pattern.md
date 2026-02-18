# Pattern: Model-First Volt Components

In the Laraxot methodology, when building Livewire Volt components that represent or detail a specific Eloquent model, we follow the **Model-First** pattern.

## 🎯 The Rule

**DO NOT EXPLODE** the model attributes into separate public properties in the `new class extends Component` block. Keep the model instance as a single source of truth.

## 👗 UI Preservation ("The Dress")

When refactoring a Blade component to a Volt component, you MUST **preserve the HTML structure 1:1**. The goal is to modernize the logic, not to redesign the UI. 
- Keep all CSS classes.
- Keep all SVG icons.
- Keep all structural tags.
- Only update variable references (e.g., from `$eventData['title']` to `$this->event->title`).

## 🚫 No `strict_types` in Includes
Do NOT use `declare(strict_types=1);` in Blade files that are intended to be `@included` as blocks (like in `x-page` or `x-section`). This causes a fatal error if any output (even a single byte) has already been sent by the parent component.

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
