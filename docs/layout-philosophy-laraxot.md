# Layout Philosophy - Laraxot Architecture

## La Filosofia

Nella architettura Laraxot, esiste UN SOLO layout entry point: `<x-layouts.app>`

### ❌ SBAGLIATO
```blade
<!-- In Folio pages - NON fare così -->
<x-layouts.public>
    ...
</x-layouts.public>

<x-layouts.dashboard>
    ...
</x-layouts.dashboard>
```

### ✅ CORRETTO
```blade
<!-- In Folio pages - fare SEMPRE così -->
<x-layouts.app>
    ...
</x-layouts.app>
```

## Perché?

### Principio di Singola Responsabilità per Layout
- Il Folio page (index.blade.php, [slug].blade.php) NON deve sapere quale layout usare
- Il Folio page chiama SEMPRE `<x-layouts.app>`
- Il layout `app.blade.php` è RESPONSABILE di decidere quale layout renderizzare

### Vantaggi
1. **Separation of Concerns**: La logica di scelta del layout è centralizzata
2. **DRY**: Non si ripete la scelta del layout in ogni pagina
3. **Flessibilità**: Cambiare la logica di routing del layout in un solo posto
4. **Consistenza**: Tutti i Folio pages usano lo stesso pattern

## Implementazione Corretta

### File: `resources/views/components/layouts/app.blade.php`

Il layout deve:
1. Controllare il contesto (utente autenticato? pagina pubblica?)
2. Delegare al layout appropriato
3. Passare lo slot content

```blade
@auth
    {{-- Utente autenticato: usa layout dashboard con sidebar --}}
    <x-layouts.app.sidebar>
        {{ $slot }}
    </x-layouts.app.sidebar>
@else
    {{-- Utente guest: usa layout pubblico --}}
    <x-layouts.public>
        {{ $slot }}
    </x-layouts.public>
@endauth
```

## Struttura Corretta

```
resources/views/components/layouts/
├── app.blade.php           ← Entry point (sceglie il layout)
├── public.blade.php        ← Layout pubblico (guest)
└── app/
    └── sidebar.blade.php   ← Layout dashboard (auth)
```

## Folio Pages

Tutti i Folio pages usano lo stesso pattern:

```blade
<x-layouts.app>
    @volt('nome')
        <div>
            <x-page side="content" slug="..." />
        </div>
    @endvolt
</x-layouts.app>
```

## Regole Laraxot

1. **Mai hardcodare il layout specifico nei Folio pages**
2. **Sempre usare `<x-layouts.app>`**
3. **La logica di scelta sta in `app.blade.php`**
4. **Layout pubblico e dashboard sono dettagli implementativi**

## Vantaggi Architetturali

### Estensibilità
Se in futuro serve un terzo tipo di layout (es: mobile), basta modificare `app.blade.php`:

```blade
@if(request()->header('User-Agent') contains 'Mobile')
    <x-layouts.mobile>{{ $slot }}</x-layouts.mobile>
@elseauth
    <x-layouts.app.sidebar>{{ $slot }}</x-layouts.app.sidebar>
@else
    <x-layouts.public>{{ $slot }}</x-layouts.public>
@endif
```

### Testabilità
I test possono mockare il comportamento di `app.blade.php` senza toccare i Folio pages.

### Manutenibilità
Cambiare la logica di routing del layout non richiede modifiche a centinaia di Folio pages.

## Confronto con Altri Pattern

### Pattern Sbagliato (Non-Laraxot)
```blade
<!-- Ogni pagina decide il suo layout -->
@if(auth()->check())
    <x-layouts.dashboard>
@else
    <x-layouts.public>
@endif
```

❌ Problemi:
- Logica duplicata in ogni pagina
- Difficile da manutenere
- Viola DRY
- Folio page ha troppa responsabilità

### Pattern Laraxot
```blade
<!-- Folio page delega la scelta -->
<x-layouts.app>
```

✅ Vantaggi:
- Singola fonte di verità
- DRY
- Separation of Concerns
- Facile da testare e manutenere

## Conclusione

La filosofia Laraxot per i layout è:
- **ONE entry point**: `<x-layouts.app>`
- **Smart delegation**: Il layout decide, non la pagina
- **Separation of Concerns**: Ogni componente ha una sola responsabilità
- **DRY**: Don't Repeat Yourself

Questo è il modo "Laraxot" di gestire i layout. Qualsiasi altro approccio NON rispetta la "politica, filosofia, religione laraxot".
