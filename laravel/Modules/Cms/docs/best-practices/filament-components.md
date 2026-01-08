# Best Practices per l'Utilizzo dei Componenti Filament

## Principio Fondamentale

Utilizziamo Filament come starterkit sia per il backend che per il frontend. È fondamentale mantenere la coerenza utilizzando i componenti Filament invece di creare componenti personalizzati quando possibile.

## Componenti da Utilizzare

### 1. Links e Buttons

❌ **ERRATO**:
```blade
<!-- Non usare componenti custom -->
<x-one::link href="/example">
    Link Example
</x-one::link>

<!-- Non usare x-filament::link (non esiste) -->
<x-filament::link href="/example">
    Link Example
</x-filament::link>
```

✅ **CORRETTO**:
```blade
<!-- Per i link, usa x-filament::button con tag="a" -->
<x-filament::button
    href="/example"
    tag="a"
    color="gray"
    size="sm"
>
    Link Example
</x-filament::button>

<!-- Per i bottoni standard -->
<x-filament::button>
    Button Example
</x-filament::button>
```

### 2. Icon Buttons

❌ **ERRATO**:
```blade
<a href="#" class="icon-button">
    <i class="fas fa-star"></i>
</a>
```

✅ **CORRETTO**:
```blade
<x-filament::icon-button
    icon="heroicon-o-star"
    href="#"
    tag="a"
    target="_blank"
    rel="noopener noreferrer"
/>
```

### 3. Form Components

❌ **ERRATO**:
```blade
<input type="text" class="form-input" />
```

✅ **CORRETTO**:
```blade
<x-filament::input type="text" />
```

## Vantaggi dell'Utilizzo dei Componenti Filament

1. **Consistenza**
   - UI/UX coerente in tutta l'applicazione
   - Comportamento standardizzato
   - Stili unificati

2. **Manutenibilità**
   - Aggiornamenti automatici con Filament
   - Meno codice da mantenere
   - Debugging più semplice

3. **Accessibilità**
   - Implementazione ARIA integrata
   - Best practices incorporate
   - Testing accessibilità già effettuato

4. **Performance**
   - Ottimizzazione integrata
   - Lazy loading dove appropriato
   - Bundle size ottimizzato

## Implementazione nei Temi

### 1. Footer Example
```blade
@props([
    'links' => [],
    'copyrightText' => null,
    'showSocial' => false,
    'socialLinks' => [],
])

<footer {{ $attributes->class(['bg-white border-t border-gray-200']) }}>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between space-y-4 sm:flex-row sm:space-y-0">
            <div class="text-sm text-gray-500">
                {{ $copyrightText ?? '© ' . date('Y') . ' ' . config('app.name') }}
            </div>

            @if($links)
                <nav class="flex space-x-4">
                    @foreach($links as $link)
                        <x-filament::button
                            :href="$link['url']"
                            :class="$link['class'] ?? ''"
                            :target="$link['target'] ?? '_self'"
                            tag="a"
                            color="gray"
                            size="sm"
                        >
                            {{ $link['title'] }}
                        </x-filament::button>
                    @endforeach
                </nav>
            @endif

            @if($showSocial && !empty($socialLinks))
                <div class="flex items-center space-x-4">
                    @foreach($socialLinks as $social)
                        <x-filament::icon-button
                            :icon="$social['icon']"
                            :href="$social['url']"
                            tag="a"
                            :target="'_blank'"
                            :rel="'noopener noreferrer'"
                            :aria-label="$social['title']"
                            color="gray"
                        />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</footer>
```

### 2. Navigation Example
```blade
<nav>
    <x-filament::dropdown placement="bottom-end">
        <x-slot name="trigger">
            <x-filament::button>
                Menu
            </x-filament::button>
        </x-slot>

        @foreach($menuItems as $item)
            <x-filament::dropdown.item
                :href="$item['url']"
                :icon="$item['icon']"
            >
                {{ $item['label'] }}
            </x-filament::dropdown.item>
        @endforeach
    </x-filament::dropdown>
</nav>
```

## Testing

```php
it('renders filament button components as links correctly', function () {
    $links = [
        ['url' => '/test', 'title' => 'Test Link']
    ];

    Livewire::test(Footer::class, ['links' => $links])
        ->assertSeeHtml('button')
        ->assertSeeHtml('href="/test"')
        ->assertSee('Test Link');
});

it('renders filament icon buttons for social links', function () {
    $socialLinks = [
        [
            'icon' => 'heroicon-o-globe',
            'url' => 'https://example.com',
            'title' => 'Website'
        ]
    ];

    Livewire::test(Footer::class, [
        'showSocial' => true,
        'socialLinks' => $socialLinks
    ])
        ->assertSeeHtml('x-filament::icon-button');
});
```

## Riferimenti

- [Documentazione Filament](https://filamentphp.com/docs/3.x/support/blade-components/button)
- [Componenti Blade Filament](https://filamentphp.com/docs/3.x/support/blade-components)
- [Best Practices Filament](https://filamentphp.com/docs/3.x/support/overview)

## Collegamenti Interni
- [Guida ai Temi](/laravel/Themes/One/docs/README.md)
- [Componenti UI](/laravel/Modules/Cms/docs/components/README.md)
- [Testing Components](/laravel/Modules/Cms/docs/testing/components.md) 

## Collegamenti tra versioni di filament-components.md
* [filament-components.md](laravel/Modules/User/docs/best-practices/filament-components.md)
* [filament-components.md](laravel/Modules/Cms/docs/best-practices/filament-components.md)
* [filament-components.md](laravel/Modules/Cms/docs/filament-components.md)
* [filament-components.md](laravel/docs/rules/filament-components.md)

