# Folio Container Routing Priority: index.blade.php vs [slug].blade.php

## Problema

Per la URL `/it/events/laravel-beginners-pizza-night`, Folio usa `[container0]/[container1]/index.blade.php` invece di `[container0]/[slug].blade.php`.

## Perché succede

Folio risolve le route in questo ordine di priorità:

1. **File esatti** (`index.blade.php`, `about.blade.php`)
2. **Route statiche** (`users.blade.php`)
3. **Route annidate** (`users/profile.blade.php`)
4. **Route con parametri** (`[slug].blade.php`, `[id].blade.php`)

**Regola critica**: Quando due pattern matchano la stessa URL, Folio preferisce:
- **`index.blade.php`** rispetto a **`[slug].blade.php`** nella stessa struttura di directory
- Pattern con più segmenti specifici rispetto a pattern con meno segmenti

### Esempio: `/it/events/laravel-beginners-pizza-night`

**Pattern disponibili:**
- `pages/[container0]/[container1]/index.blade.php` → matcha: `container0 = 'events'`, `container1 = 'laravel-beginners-pizza-night'`
- `pages/[container0]/[slug].blade.php` → matcha: `container0 = 'events'`, `slug = 'laravel-beginners-pizza-night'`

**Risultato**: Folio sceglie `[container0]/[container1]/index.blade.php` perché:
- `index.blade.php` ha priorità su `[slug].blade.php` quando entrambi matchano
- Entrambi hanno 2 segmenti dinamici, ma `index.blade.php` è considerato più specifico

## Verifica con `php artisan folio:list`

```bash
php artisan folio:list | grep container
```

Output esempio:
```
GET  /it/{container0}/{container1}  → [container0]/[container1]/index.blade.php
GET  /it/{container0}/{slug}        → [container0]/[slug].blade.php
```

Entrambi matchano `/it/events/laravel-beginners-pizza-night`, ma Folio usa il primo (index.blade.php).

## Soluzioni

### Soluzione 1: Rimuovere `[container0]/[container1]/index.blade.php` (consigliata)

Se `[container0]/[container1]/index.blade.php` è solo un file di test e non serve:

```bash
# Rimuovere il file
rm Themes/Meetup/resources/views/pages/[container0]/[container1]/index.blade.php

# Pulire cache
php artisan view:clear
php artisan route:clear
```

**Risultato**: `/it/events/laravel-beginners-pizza-night` userà `[container0]/[slug].blade.php`.

### Soluzione 2: Usare directory specifica invece di `[container0]`

Invece di `[container0]/[slug].blade.php`, creare:

```
pages/events/[slug].blade.php
```

**Vantaggi**:
- Più specifico: `/events/{slug}` ha priorità su pattern generici `/{container0}/{container1}`
- Più chiaro: il nome della directory indica il contesto
- Folio preferisce route specifiche rispetto a catch-all generici

**Esempio**:
```blade
{{-- pages/events/[slug].blade.php --}}
@php
    $slug = $slug ?? request()->route('slug');
@endphp

<x-layouts.app>
    @volt('events.detail')
        <x-page side="content" :slug="$slug" />
    @endvolt
</x-layouts.app>
```

### Soluzione 3: Rinominare `[container0]/[slug].blade.php` in modo più specifico

Se vuoi mantenere il pattern generico ma dare priorità, usa un nome più specifico:

```
pages/[container0]/[slug-detail].blade.php
```

Poi nel file:
```blade
@php
    $slug = $slugDetail ?? request()->route('slug-detail');
@endphp
```

**Nota**: Questa soluzione è meno chiara e non è consigliata.

## Architettura consigliata per LaravelPizza

### Pattern attuale (CMS-driven)

```
pages/
├── index.blade.php                    → / (home)
├── [slug].blade.php                   → /{slug} (CMS catch-all: events, about, etc.)
└── events/
    └── [.Modules.Meetup.Models.Event].blade.php → /events/{slug} (model binding)
```

**Perché funziona**:
- `/it/events` → `[slug].blade.php` con `slug = 'events'` → carica `events.json`
- `/it/events/laravel-11` → `events/[.Modules.Meetup.Models.Event].blade.php` → model binding

### Pattern con container (se necessario)

Se serve supportare percorsi generici tipo `/it/{container}/{slug}`, usa:

```
pages/
├── [slug].blade.php                   → /{slug} (CMS)
└── [container0]/
    └── [slug].blade.php               → /{container}/{slug} (CMS nested)
```

**NON usare** `[container0]/[container1]/index.blade.php` perché intercetta route che dovrebbero andare a `[container0]/[slug].blade.php`.

## Riferimenti

- [Folio Routing Documentation](folio-routing.md)
- [Folio Official Docs](https://laravel.com/docs/folio)
- [GitHub Laravel Folio](https://github.com/laravel/folio)
