# Refactoring: Da PageContent a Section

## Motivazione
Il modello `PageContent` è stato rinominato in `Section` per riflettere meglio il suo scopo effettivo:

1. **Chiarezza Semantica**:
   - `PageContent` suggeriva contenuto di pagina
   - `Section` riflette meglio l'idea di sezioni riutilizzabili (header, footer, etc.)
   - Evita confusione con il modello `Page`

2. **Allineamento con HTML5**:
   - `<section>` è un elemento HTML5 standard
   - Riflette meglio la semantica web moderna
   - Migliora la comprensione per gli sviluppatori

3. **Separazione delle Responsabilità**:
   - `Page` gestisce le pagine complete
   - `Section` gestisce sezioni riutilizzabili
   - Chiara distinzione tra i due concetti

## Impatto del Cambio

### Files Rinominati
- `PageContent.php` → `Section.php`
- `PageContentResource.php` → `SectionResource.php`
- `page-content-management.md` → `section-management.md`

### Namespace Aggiornati
```php
namespace Modules\Cms\Models;
namespace Modules\Cms\Filament\Resources;
namespace Modules\Cms\Filament\Resources\SectionResource\Pages;
```

### Struttura Dati Invariata
```php
protected $fillable = [
    'name',
    'slug',
    'blocks'
];
```

## Best Practices Emerse

1. **Naming**:
   - Usare nomi che riflettono il dominio
   - Evitare ambiguità con altri concetti
   - Seguire le convenzioni HTML5

2. **Organizzazione**:
   - Separare chiaramente le responsabilità
   - Mantenere la coerenza nella documentazione
   - Aggiornare tutti i riferimenti

3. **Documentazione**:
   - Documentare le motivazioni dei cambi
   - Mantenere collegamenti bidirezionali
   - Aggiornare esempi e riferimenti

## Collegamenti
- [Gestione Sezioni](../section-management.md)
- [Documentazione Root](../../../../../docs/sections.md)
- [Documentazione Pagine](../page-management.md) 
