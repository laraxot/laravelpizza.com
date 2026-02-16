# Piano di Implementazione Componenti Header

## Fase 1: Setup Struttura

### 1.1 Creazione Directory
```bash
mkdir -p laravel/Themes/One/resources/views/components/blocks/navigation
```

### 1.2 File da Creare
- `navigation/index.blade.php`
- `navigation/language-switcher.blade.php`
- `navigation/user-dropdown.blade.php`
- `navigation/avatar.blade.php`

## Fase 2: Implementazione Componenti

### 2.1 Language Switcher
```blade
<!-- language-switcher.blade.php -->
<div class="language-switcher">
    <select wire:model="locale" class="form-select">
        @foreach($availableLocales as $locale)
            <option value="{{ $locale }}">{{ $locale }}</option>
        @endforeach
    </select>
</div>
```

### 2.2 User Dropdown
```blade
<!-- user-dropdown.blade.php -->
<div class="user-dropdown" x-data="{ open: false }">
    <button @click="open = !open">
        <x-navigation.avatar />
    </button>
    
    <div x-show="open" @click.away="open = false">
        <!-- Menu Items -->
    </div>
</div>
```

### 2.3 Avatar
```blade
<!-- avatar.blade.php -->
<div class="avatar">
    @if($user->avatar)
        <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
    @else
        <div class="avatar-placeholder">
            {{ substr($user->name, 0, 1) }}
        </div>
    @endif
</div>
```

## Fase 3: Integrazione

### 3.1 Navigation Layout
```blade
<!-- navigation.blade.php -->
<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex">
                <x-logo />
            </div>

            <!-- Navigation Items -->
            <div class="flex items-center">
                <x-navigation.language-switcher />
                <x-navigation.user-dropdown />
            </div>
        </div>
    </div>
</nav>
```

## Fase 4: Stili

### 4.1 Tailwind Classes
```css
/* Aggiungere a resources/css/app.css */
@layer components {
    .language-switcher {
        @apply relative inline-block text-left;
    }

    .user-dropdown {
        @apply relative inline-block text-left;
    }

    .avatar {
        @apply h-8 w-8 rounded-full;
    }
}
```

## Fase 5: Logica

### 5.1 Language Switcher
```php
// LanguageSwitcher.php
class LanguageSwitcher extends Component
{
    public $locale;
    public $availableLocales;

    public function mount()
    {
        $this->locale = app()->getLocale();
        $this->availableLocales = config('app.available_locales');
    }

    public function updatedLocale($value)
    {
        app()->setLocale($value);
        session()->put('locale', $value);
    }
}
```

### 5.2 User Dropdown
```php
// UserDropdown.php
class UserDropdown extends Component
{
    public function render()
    {
        return view('components.blocks.navigation.user-dropdown');
    }
}
```

## Fase 6: Testing

### 6.1 Unit Tests
```php
// LanguageSwitcherTest.php
class LanguageSwitcherTest extends TestCase
{
    public function test_can_switch_language()
    {
        // Test implementation
    }
}
```

### 6.2 Feature Tests
```php
// NavigationTest.php
class NavigationTest extends TestCase
{
    public function test_navigation_renders_correctly()
    {
        // Test implementation
    }
}
```

## Fase 7: Documentazione

### 7.1 Aggiornare
- [Header Components](./HEADER_COMPONENTS.md)
- [Navigation Structure](./NAVIGATION_STRUCTURE.md)
- [Security Best Practices](./SECURITY_BEST_PRACTICES.md)

## Timeline

1. **Giorno 1**: Setup struttura e componenti base
2. **Giorno 2**: Implementazione logica e stili
3. **Giorno 3**: Testing e debugging
4. **Giorno 4**: Documentazione e review

## Risorse Necessarie

1. **Design Assets**
   - Icone
   - Avatar placeholder
   - Flag per le lingue

2. **Dependencies**
   - Alpine.js
   - Tailwind CSS
   - Filament UI

3. **Configurazioni**
   - Lingue supportate
   - Theme settings
   - Cache settings

## Collegamenti Correlati
- [Header Components](./HEADER_COMPONENTS.md)
- [Navigation Structure](./NAVIGATION_STRUCTURE.md)
- [Security Best Practices](./SECURITY_BEST_PRACTICES.md) 
