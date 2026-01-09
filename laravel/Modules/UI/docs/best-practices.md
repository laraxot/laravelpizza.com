# Best Practices UI

## Principi Generali

### 1. Consistenza
- Utilizzare componenti standard
- Mantenere uno stile uniforme
- Seguire le convenzioni di naming
- Riutilizzare pattern comuni

### 2. Accessibilità
- Supportare la navigazione da tastiera
- Utilizzare attributi ARIA
- Mantenere contrasto adeguato
- Fornire testi alternativi

### 3. Performance
- Ottimizzare il caricamento
- Minimizzare le dipendenze
- Utilizzare lazy loading
- Implementare caching

### 4. Responsive Design
- Mobile-first approach
- Breakpoint standard
- Layout fluidi
- Testing multi-device

## Sviluppo Componenti

### 1. Struttura
```php
class CustomComponent extends Component
{
    // Proprietà pubbliche con type hint
    public string $label;
    public ?string $hint = null;

    // Proprietà private per stato interno
    private bool $isLoading = false;

    // Metodi pubblici con return type
    public function render(): View
    {
        return view('ui::components.custom');
    }
}
```

### 2. Template
```blade
<div class="custom-component">
    {{-- Utilizzare slot nominati --}}
    <div class="header">
        {{ $header ?? '' }}
    </div>

    {{-- Gestire stati condizionali --}}
    <div class="content {{ $isLoading ? 'loading' : '' }}">
        {{ $slot }}
    </div>

    {{-- Fornire fallback --}}
    <div class="footer">
        {{ $footer ?? 'Default Footer' }}
    </div>
</div>
```

### 3. Stili
```scss
// Utilizzare BEM naming
.custom-component {
    &__header { }
    &__content { }
    &__footer { }

    // Stati
    &--loading { }
    &--disabled { }

    // Varianti
    &--primary { }
    &--secondary { }
}
```

## Form Components

### 1. Validazione
```php
// Definire regole di validazione
public array $rules = [
    'email' => ['required', 'email'],
    'password' => ['required', 'min:8'],
];

// Messaggi personalizzati
public array $messages = [
    'email.required' => 'trans.validation.email.required',
];
```

### 2. Eventi
```php
// Emettere eventi standard
$this->emit('saved');
$this->emit('deleted', $id);

// Ascoltare eventi
protected $listeners = [
    'refresh' => '$refresh',
];
```

### 3. Loading States
```php
// Gestire stati di caricamento
public function save()
{
    $this->loading = true;
    // ...
    $this->loading = false;
}
```

## Table Components

### 1. Configurazione
```php
// Definire colonne in modo chiaro
protected function getColumns(): array
{
    return [
        Column::make('name')->sortable()->searchable(),
        Column::make('email')->searchable(),
    ];
}

// Configurare filtri
protected function getFilters(): array
{
    return [
        Filter::make('active')->query(fn ($query) => $query->where('active', true)),
    ];
}
```

### 2. Actions
```php
// Definire azioni in modo modulare
protected function getActions(): array
{
    return [
        Action::make('edit')->visible(fn ($record) => $this->can('edit', $record)),
        Action::make('delete')->requiresConfirmation(),
    ];
}
```

## Chart Components

### 1. Dati
```php
// Formattare dati in modo standard
protected function getData(): array
{
    return [
        'labels' => ['Gen', 'Feb', 'Mar'],
        'datasets' => [
            [
                'label' => 'Vendite',
                'data' => [10, 20, 30],
            ],
        ],
    ];
}
```

### 2. Opzioni
```php
// Configurare opzioni in modo chiaro
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'position' => 'bottom',
            ],
        ],
    ];
}
```

## Testing

### 1. Unit Tests
```php
public function test_component_renders()
{
    $component = Livewire::test(CustomComponent::class);
    $component->assertSee('Expected Content');
}
```

### 2. Browser Tests
```php
public function test_component_interaction()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/page')
            ->click('@button')
            ->assertSee('Result');
    });
}
```

## Documentazione

### 1. PHPDoc
```php
/**
 * Componente per la gestione di form avanzati.
 *
 * @property string $label Label del componente
 * @property string|null $hint Suggerimento opzionale
 *
 * @method void save() Salva i dati del form
 * @method void reset() Resetta il form
 */
class AdvancedForm extends Component
```

### 2. README
- Descrizione chiara
- Esempi di utilizzo
- Configurazioni disponibili
### Versione HEAD

- Breaking changes
## Collegamenti tra versioni di best-practices.md
* [best-practices.md](docs/tecnico/filament/best-practices.md)
* [best-practices.md](../../../Xot/docs/laraxot/best-practices.md)
* [best-practices.md](../../../UI/docs/best-practices.md)
* [best-practices.md](../../../../Themes/One/docs/best-practices.md)

### Versione Incoming

- Breaking changes

---
# Best Practices UI

## Principi Generali

### 1. Consistenza
- Utilizzare componenti standard
- Mantenere uno stile uniforme
- Seguire le convenzioni di naming
- Riutilizzare pattern comuni

### 2. Accessibilità
- Supportare la navigazione da tastiera
- Utilizzare attributi ARIA
- Mantenere contrasto adeguato
- Fornire testi alternativi

### 3. Performance
- Ottimizzare il caricamento
- Minimizzare le dipendenze
- Utilizzare lazy loading
- Implementare caching

### 4. Responsive Design
- Mobile-first approach
- Breakpoint standard
- Layout fluidi
- Testing multi-device

## Sviluppo Componenti

### 1. Struttura
```php
class CustomComponent extends Component
{
    // Proprietà pubbliche con type hint
    public string $label;
    public ?string $hint = null;

    // Proprietà private per stato interno
    private bool $isLoading = false;

    // Metodi pubblici con return type
    public function render(): View
    {
        return view('ui::components.custom');
    }
}
```

### 2. Template
```blade
<div class="custom-component">
    {{-- Utilizzare slot nominati --}}
    <div class="header">
        {{ $header ?? '' }}
    </div>

    {{-- Gestire stati condizionali --}}
    <div class="content {{ $isLoading ? 'loading' : '' }}">
        {{ $slot }}
    </div>

    {{-- Fornire fallback --}}
    <div class="footer">
        {{ $footer ?? 'Default Footer' }}
    </div>
</div>
```

### 3. Stili
```scss
// Utilizzare BEM naming
.custom-component {
    &__header { }
    &__content { }
    &__footer { }

    // Stati
    &--loading { }
    &--disabled { }

    // Varianti
    &--primary { }
    &--secondary { }
}
```

## Form Components

### 1. Validazione
```php
// Definire regole di validazione
public array $rules = [
    'email' => ['required', 'email'],
    'password' => ['required', 'min:8'],
];

// Messaggi personalizzati
public array $messages = [
    'email.required' => 'trans.validation.email.required',
];
```

### 2. Eventi
```php
// Emettere eventi standard
$this->emit('saved');
$this->emit('deleted', $id);

// Ascoltare eventi
protected $listeners = [
    'refresh' => '$refresh',
];
```

### 3. Loading States
```php
// Gestire stati di caricamento
public function save()
{
    $this->loading = true;
    // ...
    $this->loading = false;
}
```

## Table Components

### 1. Configurazione
```php
// Definire colonne in modo chiaro
protected function getColumns(): array
{
    return [
        Column::make('name')->sortable()->searchable(),
        Column::make('email')->searchable(),
    ];
}

// Configurare filtri
protected function getFilters(): array
{
    return [
        Filter::make('active')->query(fn ($query) => $query->where('active', true)),
    ];
}
```

### 2. Actions
```php
// Definire azioni in modo modulare
protected function getActions(): array
{
    return [
        Action::make('edit')->visible(fn ($record) => $this->can('edit', $record)),
        Action::make('delete')->requiresConfirmation(),
    ];
}
```

## Chart Components

### 1. Dati
```php
// Formattare dati in modo standard
protected function getData(): array
{
    return [
        'labels' => ['Gen', 'Feb', 'Mar'],
        'datasets' => [
            [
                'label' => 'Vendite',
                'data' => [10, 20, 30],
            ],
        ],
    ];
}
```

### 2. Opzioni
```php
// Configurare opzioni in modo chiaro
protected function getOptions(): array
{
    return [
        'responsive' => true,
        'maintainAspectRatio' => false,
        'plugins' => [
            'legend' => [
                'position' => 'bottom',
            ],
        ],
    ];
}
```

## Testing

### 1. Unit Tests
```php
public function test_component_renders()
{
    $component = Livewire::test(CustomComponent::class);
    $component->assertSee('Expected Content');
}
```

### 2. Browser Tests
```php
public function test_component_interaction()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/page')
            ->click('@button')
            ->assertSee('Result');
    });
}
```

## Documentazione

### 1. PHPDoc
```php
/**
 * Componente per la gestione di form avanzati.
 *
 * @property string $label Label del componente
 * @property string|null $hint Suggerimento opzionale
 *
 * @method void save() Salva i dati del form
 * @method void reset() Resetta il form
 */
class AdvancedForm extends Component
```

### 2. README
- Descrizione chiara
- Esempi di utilizzo
- Configurazioni disponibili
### Versione HEAD

- Breaking changes
## Collegamenti tra versioni di best-practices.md
* [best-practices.md](docs/tecnico/filament/best-practices.md)
* [best-practices.md](../../../Xot/project_docs/laraxot/best-practices.md)
* [best-practices.md](../../../UI/project_docs/best-practices.md)
* [best-practices.md](../../../../Themes/One/project_docs/best-practices.md)
* [best-practices.md](../../../Xot/project_docs/laraxot/best-practices.md)
* [best-practices.md](../../../UI/project_docs/best-practices.md)
* [best-practices.md](../../../../Themes/One/project_docs/best-practices.md)
* [best-practices.md](../../../Xot/project_docs/laraxot/best-practices.md)
* [best-practices.md](../../../UI/project_docs/best-practices.md)
* [best-practices.md](../../../../Themes/One/project_docs/best-practices.md)

### Versione Incoming

- Breaking changes

---
