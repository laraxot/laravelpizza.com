# Struttura dei Temi

## Struttura Standard

```
ThemeName/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── ...
│   │   ├── pages/          # Per Folio
│   │   │   ├── auth/
│   │   │   │   ├── login.blade.php
│   │   │   │   ├── register.blade.php
│   │   │   │   └── logout.blade.php
│   │   │   └── ...
│   │   ├── components/     # Per Volt
│   │   │   ├── auth/
│   │   │   │   ├── login-form.blade.php
│   │   │   │   ├── register-form.blade.php
│   │   │   │   └── ...
│   │   │   └── ...
│   │   └── ...
│   ├── lang/
│   │   ├── it/
│   │   └── en/
│   └── ...
├── public/
│   ├── css/
│   ├── js/
│   └── ...
└── composer.json
```

## Organizzazione delle Views

### Pagine Folio
- `pages/`: Contiene tutte le pagine dell'applicazione
  - Organizzate per feature/area
  - Nomi descrittivi e chiari
  - Struttura piatta quando possibile

### Componenti Volt
- `components/`: Contiene i componenti riutilizzabili
  - Organizzati per feature/area
  - Nomi specifici e descrittivi
  - Logica separata dalla presentazione

## Best Practices

1. **Folio**
   - Usare nomi descrittivi per le pagine
   - Organizzare le pagine in sottocartelle logiche
   - Mantenere la struttura piatta quando possibile
   - Utilizzare middleware appropriati

2. **Volt**
   - Creare componenti atomici
   - Separare la logica dalla presentazione
   - Documentare gli stati e i metodi
   - Utilizzare props per la configurazione

3. **Layout**
   - Mantenere i layout generici
   - Utilizzare slot per il contenuto
   - Supportare diversi tipi di contenuto

## Esempi

### Layout Base
```php
// resources/views/layouts/app.blade.php
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'App' }}</title>
</head>
<body>
    @yield('content')
</body>
</html>
```

### Pagina Folio
```php
// resources/views/pages/auth/login.blade.php
<?php

use function Livewire\Volt\{state, mount};

state([
    'email' => '',
    'password' => '',
]);

$login = function() {
    // logica di login
};

?>

<div>
    <x-auth.login-form />
</div>
```

### Componente Volt
```php
// resources/views/components/auth/login-form.blade.php
<?php

use function Livewire\Volt\{state, mount};

state([
    'email' => '',
    'password' => '',
    'remember' => false,
]);

$submit = function() {
    // logica di submit
};

?>

<form wire:submit="submit">
    <!-- campi del form -->
</form>
```

## Organizzazione dei Temi

### 1. Struttura Base
```
Themes/
└── ThemeName/
    ├── app/               # Classi del tema
    │   ├── Components/   # Componenti Blade
    │   ├── Services/     # Servizi specifici
    │   └── Providers/    # Service Providers
    ├── resources/        # Risorse del tema
    │   ├── views/       # Viste Blade
    │   ├── css/         # Stili CSS
    │   └── js/          # Script JavaScript
    └── docs/            # Documentazione
```

### 2. Componenti
- I componenti devono essere indipendenti
- Non devono contenere riferimenti specifici al progetto
- Devono essere configurabili tramite props

### 3. Viste
- Organizzare le viste per sezioni
- Utilizzare layout riutilizzabili
- Separare la logica dalla presentazione

## Best Practices

### 1. Indipendenza
```php
// ❌ Sbagliato - Riferimento hardcoded al progetto
<div class="<nome progetto>-footer">
    il progetto © 2024
</div>

// ✅ Corretto - Configurabile
<div class="theme-footer">
    {{ config('app.name') }} © {{ date('Y') }}
</div>
```

### 2. Configurazione
```php
// ✅ Esempio di componente configurabile
class Footer extends Component
{
    public function __construct(
        public ?string $copyrightText = null,
        public ?string $companyName = null
    ) {
        $this->copyrightText ??= config('theme.footer.copyright');
        $this->companyName ??= config('app.name');
    }
}
```

### 3. Stili
- Utilizzare TailwindCSS per lo styling
- Mantenere gli stili modulari
- Evitare stili globali quando possibile

## Struttura dei Componenti

### 1. Layout
```
resources/views/
├── layouts/
│   ├── app.blade.php
│   ├── header.blade.php
│   └── footer.blade.php
```

### 2. Componenti
```
resources/views/
├── components/
│   ├── buttons/
│   ├── cards/
│   └── forms/
```

### 3. Sezioni
```
resources/views/
├── sections/
│   ├── hero/
│   ├── features/
│   └── contact/
```

## Collegamenti

- [Regole di Namespacing](namespacing.md)
- [Standard del Codice](code-standards.md)
- [Regole di Documentazione](documentation-rules.md) 

## Collegamenti tra versioni di themes-structure.md
* [themes-structure.md](docs/tecnico/themes-structure.md)
* [themes-structure.md](../../../Xot/docs/themes-structure.md)

