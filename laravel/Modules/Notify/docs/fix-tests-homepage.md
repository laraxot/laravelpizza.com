---
title: "✅ Fix Applicati - Tests Homepage"
type: concept
tags: [fix, tests, homepage]
created: 2026-07-14
<<<<<<< .merge_file_yWT5qI
updated: 2026-11-23
=======
<<<<<<< HEAD
updated: 2026-07-14
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> .merge_file_64oblb
qmd: "fix-tests-homepage ✅ fix applicati - tests homepage"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index-1.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-100.md"
<<<<<<< .merge_file_yWT5qI
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions-2.md"
<<<<<<< HEAD
  - "./acronym-naming-conventions.md"
=======
<<<<<<< HEAD
=======
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions-2.md"
>>>>>>> .merge_file_64oblb
  - "./acronym-naming-conventions.md"
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
  - "./action-plan-immediate.md"
---

# ✅ Fix Applicati - Tests Homepage

## Problemi Risolti

### 1. Struttura File Errata ❌ → ✅

**Prima:**
```
pages/tests/homepage.blade.php  ← File statico (ERRATO)
```

**Dopo:**
```
pages/tests/[slug].blade.php  ← Folio dynamic route (CORRETTO)
```

### 2. Implementazione Folio + Volt

```php
<?php
use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $slug = '';
    public string $pageSlug = '';
    public array $data = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
        $this->data = ['slug' => $slug];
    }
};
?>

<x-layouts.app>
    @volt('tests.view')
    <div>
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

### 3. Fix Errore Icone `o-bus`

**Errore:** `Svg by name "o-bus" from set "heroicons" not found`

**Causa:** Il componente usava `<x-filament::icon>` con icone nel formato `o-bus` che non esiste in heroicons.

**Soluzione:** Pulita cache views corrotte.

## Route Mapping

| URL | Route Name | File |
|-----|------------|------|
| `/it/tests/homepage` | `tests.view` | `[slug].blade.php` (slug=homepage) |
| `/it/tests/servizi` | `tests.view` | `[slug].blade.php` (slug=servizi) |
| `/it/tests/amministrazione` | `tests.view` | `[slug].blade.php` (slug=amministrazione) |

## Come Funziona

1. **Folio** rileva `[slug].blade.php` e crea una route dinamica
2. **Volt** gestisce la logica del componente
3. **PageSlugMiddleware** intercetta la richiesta
4. **`<x-page>`** component carica le sezioni CMS dinamiche

## Vantaggi

✅ **DRY**: Un solo file per tutte le pagine tests/*  
✅ **CMS-driven**: Contenuti gestiti dal modulo Cms  
✅ **Scalabile**: Nuove pagine tests senza creare file  
✅ **Manutenibile**: Modifiche in un solo punto  

## Testing

```bash
# Homepage
curl http://ptv.local/it/tests/homepage

# Altre pagine (se esistono nel CMS)
curl http://ptv.local/it/tests/servizi
curl http://ptv.local/it/tests/amministrazione
```

## Files Modificati

- ✅ `pages/tests/[slug].blade.php` - Ricreato con Folio + Volt
- ✅ `pages/tests/homepage.blade.php` - Eliminato
- ✅ Cache views pulita

## Status

✅ **Homepage tests funzionante**  
✅ **Route `tests.view` registrata**  
✅ **Nessun errore icone**  
✅ **CMS integration attiva**
