# Folio Route Naming Convention

## 🎯 Principio Fondamentale: Naming Semantico e Generico

I nomi delle route Folio devono essere **semantici e generici**, non legati ai parametri specifici della route.

## 📜 Convenzione Naming

### Pattern Generale

```
name('{scope}.{action}')
```

Dove:
- `{scope}`: Il contesto della route (container0, pages, auth, ecc.)
- `{action}`: L'azione/ruolo della route (view, index, ecc.)

### Esempi Corretti

| File | Route Name | Perché |
|------|------------|--------|
| `[slug].blade.php` | `name('pages.view')` | Vista generica per qualsiasi slug CMS |
| `[container0]/index.blade.php` | `name('container0')` | Index/lista per qualsiasi container0 |
| `[container0]/[slug0]/index.blade.php` | `name('container0.view')` | Vista generica per qualsiasi container0+slug0 |
| `auth/login.blade.php` | `name('login')` | Azione specifica login |
| `auth/password/reset.blade.php` | `name('password.reset')` | Azione specifica reset password |

## ❌ Anti-Pattern: Naming Legato ai Parametri

**NON fare questo:**

```php
// ❌ VIETATO - Nome legato al parametro slug0
name('container0.slug0');
```

**Problemi:**
- ❌ Nome troppo specifico e legato ai parametri
- ❌ Non semantico: non indica cosa fa la route
- ❌ Inconsistente con altri pattern (`pages.view`)

## ✅ Pattern Corretto: Naming Semantico

**Fare questo:**

```php
// ✅ CORRETTO - Nome semantico che indica una vista generica
name('container0.view');
```

**Vantaggi:**
- ✅ Semantico: indica che è una "vista" per container0
- ✅ Generico: funziona per qualsiasi container0+slug0
- ✅ Consistente: segue il pattern `pages.view`
- ✅ Agnostic: non dipende dai parametri specifici

## 🧠 Logica: Perché `.view`?

### Semantica

- **`.view`**: Indica una pagina di visualizzazione/dettaglio generica
- **`.index`**: Indica una pagina di lista/indice
- **`.create`**: Indica una pagina di creazione
- **`.edit`**: Indica una pagina di modifica

### Consistenza con Pattern Esistenti

```
pages/
├── [slug].blade.php              → name('pages.view')
├── [container0]/
│   ├── index.blade.php          → name('container0')
│   └── [slug0]/
│       └── index.blade.php      → name('container0.view')
```

**Pattern**: Il naming segue la struttura gerarchica ma usa azioni semantiche invece di parametri.

## 📚 Esempi Completi

### [container0]/[slug0]/index.blade.php

```php
<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');  // ✅ Generico e semantico
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $container0;
    public string $slug0;
    // ...
};

<x-layouts.app>
    @volt('container0.view')  // ✅ Coerente con name()
    // ...
    @endvolt
</x-layouts.app>
```

### [slug].blade.php

```php
name('pages.view');  // ✅ Vista generica per qualsiasi slug CMS
```

### [container0]/index.blade.php

```php
name('container0');  // ✅ Index/lista per qualsiasi container0
```

## ✅ Best Practices

1. **Usare azioni semantiche**: `.view`, `.index`, `.create`, `.edit`
2. **Evitare nomi legati ai parametri**: NON usare `.slug0`, `.slug`, `.id`
3. **Essere consistenti**: Seguire il pattern esistente (`pages.view`)
4. **Essere generici**: Il nome deve funzionare per qualsiasi valore del parametro
5. **Essere semantici**: Il nome deve indicare cosa fa la route, non quali parametri ha

## 🔗 Riferimenti

- [Folio Routing](folio-routing.md)
- [Container0 Pattern Philosophy](container0-pattern-philosophy.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
