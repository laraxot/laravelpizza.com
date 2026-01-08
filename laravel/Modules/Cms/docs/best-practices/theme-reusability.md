# Best Practices per la Riusabilità dei Temi

## Errori Comuni da Evitare

### 1. Hard-coding dei Nomi delle Applicazioni

❌ **ERRATO**:
```blade
<span class="self-center text-2xl font-semibold">il progetto</span>
```

✅ **CORRETTO**:
```blade
<span class="self-center text-2xl font-semibold">{{ config('app.name') }}</span>
```

### 2. Riferimenti Diretti al Business Logic

❌ **ERRATO**:
```php
class FooterViewModel
{
    public function getLinks(): array
    {
        return [
            ['label' => 'Prenota Visita', 'url' => route('booking')],
            ['label' => 'I Nostri Medici', 'url' => route('doctors')]
        ];
    }
}
```

✅ **CORRETTO**:
```php
class FooterViewModel
{
    public function getLinks(): array
    {
        return config('theme.footer.links', []);
    }
}
```

### 3. Stili Specifici dell'Applicazione

❌ **ERRATO**:
```css
.footer {
    background-color: #1a5f7a; /* Colore specifico di il progetto */
}
```

✅ **CORRETTO**:
```css
.footer {
    @apply bg-primary-600; /* Utilizzo di variabili del tema */
}
```

## Principi di Riusabilità

### 1. Configurazione Esterna
- Utilizzare file di configurazione per tutti i contenuti variabili
- Mantenere le configurazioni nel progetto principale, non nel tema
- Utilizzare valori di default generici

### 2. Dependency Injection
- Iniettare le dipendenze invece di crearle nel componente
- Utilizzare interfacce invece di implementazioni concrete
- Permettere l'override dei servizi

### 3. Naming Conventions
- Utilizzare nomi generici e descrittivi
- Evitare riferimenti al dominio specifico
- Documentare chiaramente lo scopo di ogni componente

## Struttura Raccomandata

```
themes/
└── one/
    ├── config/
    │   └── theme.php      # Configurazione predefinita del tema
    ├── resources/
    │   └── views/
    │       └── components/
    │           └── layouts/
    │               └── footer.blade.php
    └── src/
        └── ViewModels/
            └── FooterViewModel.php
```

## Implementazione Corretta

### 1. Configurazione del Tema
```php
// config/theme.php
return [
    'footer' => [
        'links' => [],
        'social_links' => [],
        'show_logo' => true,
        'show_social' => true,
    ]
];
```

### 2. View Model
```php
namespace Themes\One\ViewModels;

class FooterViewModel
{
    public function getLinks(): array
    {
        return config('theme.footer.links', []);
    }

    public function getSocialLinks(): array
    {
        return config('theme.footer.social_links', []);
    }

    public function shouldShowLogo(): bool
    {
        return config('theme.footer.show_logo', true);
    }
}
```

### 3. Template
```blade
<footer {{ $attributes->class(['footer']) }}>
    @if($shouldShowLogo)
        <a href="{{ route('home') }}" class="flex items-center">
            <x-application-logo class="w-8 h-8 mr-3" />
            <span class="self-center text-2xl font-semibold">
                {{ config('app.name') }}
            </span>
        </a>
    @endif
    <!-- Resto del template -->
</footer>
```

## Testing della Riusabilità

```php
it('uses application name from config', function () {
    Config::set('app.name', 'Test App');
    
    $this->blade('<x-layouts.footer />')
        ->assertSee('Test App')
        ->assertDontSee('il progetto');
});

it('uses configured links', function () {
    Config::set('theme.footer.links', [
        ['label' => 'Test Link', 'url' => '/test']
    ]);
    
    $this->blade('<x-layouts.footer />')
        ->assertSee('Test Link');
});
```

## Checklist di Verifica

Prima di committare modifiche a un tema, verificare che:

- [ ] Non ci siano riferimenti hard-coded all'applicazione
- [ ] Tutti i testi siano configurabili
- [ ] I colori utilizzino le variabili del tema
- [ ] Le route siano configurabili
- [ ] Il componente sia testato con diverse configurazioni
- [ ] La documentazione non contenga riferimenti specifici all'applicazione

## Collegamenti

- [Documentazione Temi](/laravel/Modules/Cms/docs/themes/README.md)
- [Configurazione Temi](/laravel/Modules/Cms/docs/themes/configuration.md)
- [Testing dei Temi](/laravel/Modules/Cms/docs/themes/testing.md) 

## Collegamenti tra versioni di theme-reusability.md
* [theme-reusability.md](laravel/Modules/Cms/docs/best-practices/theme-reusability.md)
* [theme-reusability.md](laravel/Themes/One/docs/best_practices/theme-reusability.md)
* [theme-reusability.md](laravel/Themes/One/docs/theme-reusability.md)

