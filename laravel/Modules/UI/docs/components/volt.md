# Componenti Volt

## Panoramica
Volt è un framework per la creazione di componenti Livewire in modo dichiarativo. Questa guida spiega come utilizzare Volt nel nostro sistema.

## Collegamenti
- [Documentazione Volt](https://livewire.laravel.com/docs/volt)
- [Livewire](https://livewire.laravel.com)
- [Filament](https://filamentphp.com)
- [Documentazione UI](../readme.md)
- [Best Practices](../best-practices.md)
- [Layout](../layouts.md)
- [Temi](../themes.md)

## Struttura Base

### Componente Base
```php
<?php

use function Livewire\Volt\{state, mount};

state([
    'name' => '',
    'email' => '',
]);

$submit = function() {
    // logica di submit
};

?>

<form wire:submit="submit">
    <input type="text" wire:model="name">
    <input type="email" wire:model="email">
    <button type="submit">Invia</button>
</form>
```

## Stati e Proprietà

### Definizione Stati
```php
state([
    'count' => 0,
    'items' => [],
    'isLoading' => false,
]);
```

### Proprietà Computate
```php
$total = fn() => count($this->items);

$filteredItems = fn() => collect($this->items)
    ->filter(fn($item) => $item['active'])
    ->values()
    ->toArray();
```

## Metodi e Azioni

### Metodi Base
```php
$increment = function() {
    $this->count++;
};

$addItem = function($item) {
    $this->items[] = $item;
};
```

### Azioni con Parametri
```php
$updateItem = function($id, $data) {
    $this->items[$id] = $data;
};
```

## Ciclo di Vita

### Hook
```php
mount(function() {
    // inizializzazione
});

updated(function($property, $value) {
    // dopo l'aggiornamento di una proprietà
});

hydrated(function() {
    // dopo l'idratazione
});
```

## Eventi

### Emettere Eventi
```php
$notify = function($message) {
    $this->dispatch('notify', message: $message);
};
```

### Ascoltare Eventi
```php
$listeners = [
    'refresh' => 'refreshData',
];

$refreshData = function() {
    // logica di refresh
};
```

## Validazione

### Regole di Validazione
```php
$rules = [
    'name' => 'required|min:3',
    'email' => 'required|email',
];

$messages = [
    'name.required' => 'Il nome è obbligatorio',
    'email.email' => 'Email non valida',
];
```

### Validazione Manuale
```php
$validateData = function() {
    $this->validate();
    // logica dopo la validazione
};
```

## Interazione con il DOM

### Modificare il DOM
```php
$showModal = function() {
    $this->dispatch('show-modal');
};
```

### Gestire Eventi DOM
```php
$handleClick = function($event) {
    // logica di gestione click
};
```

## Best Practices

### Organizzazione
1. Raggruppare stati correlati
2. Separare logica di business
3. Utilizzare proprietà computate
4. Documentare componenti complessi

### Performance
1. Minimizzare gli stati
2. Utilizzare lazy loading
3. Ottimizzare re-render
4. Caching quando appropriato

### Sicurezza
1. Validare input
2. Sanitizzare output
3. Proteggere dati sensibili
4. Gestire errori

## Esempi Pratici

### Form di Login
```php
<?php

use function Livewire\Volt\{state, mount};

state([
    'email' => '',
    'password' => '',
    'remember' => false,
]);

$rules = [
    'email' => 'required|email',
    'password' => 'required|min:8',
];

$login = function() {
    $this->validate();

    if (auth()->attempt([
        'email' => $this->email,
        'password' => $this->password,
    ], $this->remember)) {
        return redirect()->intended('/dashboard');
    }

    $this->addError('email', 'Credenziali non valide');
};

?>

<form wire:submit="login">
    <input type="email" wire:model="email">
    <input type="password" wire:model="password">
    <label>
        <input type="checkbox" wire:model="remember">
        Ricordami
    </label>
    <button type="submit">Accedi</button>
</form>
```

### Lista Todo
```php
<?php

use function Livewire\Volt\{state, mount};

state([
    'todos' => [],
    'newTodo' => '',
]);

$addTodo = function() {
    $this->validate(['newTodo' => 'required|min:3']);

    $this->todos[] = [
        'id' => uniqid(),
        'text' => $this->newTodo,
        'completed' => false,
    ];

    $this->newTodo = '';
};

$toggleTodo = function($id) {
    foreach ($this->todos as &$todo) {
        if ($todo['id'] === $id) {
            $todo['completed'] = !$todo['completed'];
            break;
        }
    }
};

$removeTodo = function($id) {
    $this->todos = array_filter($this->todos, fn($todo) => $todo['id'] !== $id);
};

?>

<div>
    <form wire:submit="addTodo">
        <input type="text" wire:model="newTodo">
        <button type="submit">Aggiungi</button>
    </form>

    <ul>
        @foreach($todos as $todo)
            <li>
                <input type="checkbox"
                       wire:click="toggleTodo({{ $todo['id'] }})"
                       {{ $todo['completed'] ? 'checked' : '' }}>
                <span>{{ $todo['text'] }}</span>
                <button wire:click="removeTodo({{ $todo['id'] }})">Rimuovi</button>
            </li>
        @endforeach
    </ul>
</div>
```

## Integrazione con Filament

### Widget Volt
```php
<?php

use function Livewire\Volt\{state, mount};

state([
    'stats' => [],
]);

mount(function() {
    $this->stats = [
        'users' => User::count(),
        'posts' => Post::count(),
        'comments' => Comment::count(),
    ];
});

?>

<div class="grid grid-cols-3 gap-4">
    @foreach($stats as $key => $value)
        <div class="p-4 bg-white rounded-lg shadow">
            <h3 class="text-lg font-semibold">{{ ucfirst($key) }}</h3>
            <p class="text-2xl font-bold">{{ $value }}</p>
        </div>
    @endforeach
</div>
```

## Risoluzione Problemi

### Errori Comuni
1. Stati non aggiornati
2. Eventi non gestiti
3. Validazione fallita
4. Performance scadenti

### Debug
1. Utilizzare `@dump()`
2. Controllare console browser
3. Verificare network requests
4. Monitorare re-render

## Collegamenti Moduli

### Modulo Xot
- [Core](../../xot/docs/core.md)
- [Servizi](../../xot/docs/services.md)
- [Traits](../../xot/docs/traits.md)
- [Best Practices](../../xot/docs/best-practices.md)

### Modulo Cms
- [Frontend](../../cms/docs/frontend.md)
- [Temi](../../cms/docs/themes.md)
- [Contenuti](../../cms/docs/content.md)
- [Convenzioni Filament](../../cms/docs/convenzioni-namespace-filament.md)

### Modulo Lang
- [Traduzioni](../../lang/docs/translations.md)
- [Localizzazione](../../lang/docs/localization.md)
- [API Traduzioni](../../lang/docs/api.md)

### Modulo User
- [Autenticazione](../../user/docs/auth.md)
- [Permessi](../../user/docs/permissions.md)
- [Profilo](../../user/docs/profile.md)

### Modulo Patient
- [Gestione Pazienti](../../patient/docs/patients.md)
- [Cartelle Cliniche](../../patient/docs/records.md)
- [Appuntamenti](../../patient/docs/appointments.md)

### Modulo Dental
- [Trattamenti](../../dental/docs/treatments.md)
- [Pianificazione](../../dental/docs/planning.md)
- [Documenti](../../dental/docs/documents.md)

### Modulo Tenant
- [Multi-tenant](../../tenant/docs/multi-tenant.md)
- [Configurazione](../../tenant/docs/configuration.md)
- [Migrazione](../../tenant/docs/migration.md)

### Modulo Media
- [Gestione File](../../media/docs/files.md)
- [Upload](../../media/docs/upload.md)
- [Storage](../../media/docs/storage.md)

### Modulo Notify
- [Notifiche](../../notify/docs/notifications.md)
- [Email](../../notify/docs/email.md)
- [SMS](../../notify/docs/sms.md)

### Modulo Reporting
- [Report](../../reporting/docs/reports.md)
- [Esportazione](../../reporting/docs/export.md)
- [Analytics](../../reporting/docs/analytics.md)

### Modulo Gdpr
- [Privacy](../../gdpr/docs/privacy.md)
- [Consensi](../../gdpr/docs/consents.md)
- [Sicurezza](../../gdpr/docs/security.md)

### Modulo Job
- [Jobs](../../job/docs/jobs.md)
- [Queue](../../job/docs/queue.md)
- [Scheduling](../../job/docs/scheduling.md)

### Modulo Chart
- [Grafici](../../chart/docs/charts.md)
- [Dashboard](../../chart/docs/dashboard.md)
- [Visualizzazione](../../chart/docs/visualization.md)
