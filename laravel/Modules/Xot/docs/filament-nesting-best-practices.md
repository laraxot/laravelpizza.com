# Filament Nesting - Best Practices per Laraxot

## 📋 Introduzione

Questo documento fornisce best practices per implementare Filament Nesting in progetti Laraxot, basandosi sulla documentazione ufficiale di Filament 5.x e sulla strategia di implementazione nel modulo healthcare_app.

---

## 🎯 Quando Usare Filament Nesting

### ✅ Usare Nesting Quando:

1. **Entità Complessa**: Molti campi (10+) nel form
   - Esempio: SurveyPdf con 15+ campi
   - Modal dialog diventa affollato e difficile da usare

2. **Relazioni Profonde**: 3+ livelli di gerarchia
   - Esempio: Customer → SurveyPdf → QuestionChart
   - Navigazione gerarchica naturale

3. **Sub-relazioni Significative**: Entità correlata ha proprie relazioni
   - Esempio: SurveyPdf ha QuestionCharts, Contacts, NotifyThemes
   - Necessita navigazione dedicata

4. **UX Full-Page Richiesta**: Utenti necessitano esperienza completa
   - Spazio per form complessi
   - Possibilità di visualizzare relazioni correlate

### ❌ NON Usare Nesting Quando:

1. **Entità Semplice**: Pochi campi (< 5)
   - Relation manager con modal è sufficiente
   - Esempio: Toggle, Select, TextInput semplici

2. **Relazioni Lineari**: Nessuna sub-relazione
   - Relation manager è appropriato
   - Nesting aggiunge complessità inutile

3. **CRUD Minimal**: Solo create/edit semplici
   - Modal dialog è perfetto
   - Nesting è overkill

4. **Performance Critical**: Molte relazioni annidate
   - Caricamento pagine diventa lento
   - Valutare lazy loading o pagination

---

## 🏗️ Architettura Nesting in Laraxot

### Struttura Consigliata

```
ParentResource (es. CustomerResource)
  ├── RelationManager (es. SurveyPdfsRelationManager)
  │   └── NestedResource (es. SurveyPdfResource)
  │       ├── RelationManager (es. QuestionChartsRelationManager)
  │       │   └── NestedResource (es. QuestionChartResource)
  │       └── Altre relazioni (Contacts, Charts, etc.)
  └── Altre relazioni
```

### Principi di Design

1. **Gerarchia Naturale**: Seguire la struttura dati
   - Customer contiene SurveyPdfs
   - SurveyPdf contiene QuestionCharts
   - Non forzare relazioni non naturali

2. **Profondità Limitata**: Max 3-4 livelli
   - Oltre diventa difficile da navigare
   - Breadcrumb diventa troppo lungo
   - Performance degrada

3. **Responsabilità Chiara**: Ogni risorsa ha scopo definito
   - SurveyPdfResource gestisce SurveyPdf
   - QuestionChartResource gestisce QuestionChart
   - Non mescolare responsabilità

4. **Relazioni Esplicite**: Dichiarare sempre relazioni
   - Usare `getParentResourceRegistration()` per relazioni custom
   - Documentare relazioni inverse
   - Verificare coerenza dati

---

## 🔧 Implementazione in XotBase

### Estensione XotBaseResource

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Filament\Resources;

use Filament\Resources\ParentResourceRegistration;
use Modules\Xot\Filament\Resources\XotBaseResource;

class NestedResource extends XotBaseResource
{
    protected static ?string $model = YourModel::class;

    // ✅ Registrare come nested
    protected static ?string $parentResource = ParentResource::class;

    // ✅ Non registrare nella navigazione
    protected static bool $shouldRegisterNavigation = false;

    // ✅ Opzionale: Relazioni custom
    public static function getParentResourceRegistration(): ?ParentResourceRegistration
    {
        return ParentResource::asParent()
            ->relationship('yourRelation')
            ->inverseRelationship('parent');
    }

    // ... resto del codice
}
```

### Estensione XotBaseRelationManager

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Filament\Resources\ParentResource\RelationManagers;

use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class YourRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'yourRelation';

    protected static ?string $recordTitleAttribute = 'name';

    // ✅ Registrare nested resource
    protected static ?string $relatedResource = NestedResource::class;

    // Implementare metodi standard
    public function getTableColumns(): array { ... }
    public function getFormSchema(): array { ... }
    public function getTableHeaderActions(): array { ... }
    public function getTableActions(): array { ... }
}
```

---

## 📊 Gestione URL e Routing

### URL Automatici Filament

Filament genera automaticamente URL gerarchici:

```
/admin/customers
/admin/customers/{customer}/edit
/admin/customers/{customer}/survey-pdfs
/admin/customers/{customer}/survey-pdfs/{surveyPdf}/edit
/admin/customers/{customer}/survey-pdfs/{surveyPdf}/question-charts
/admin/customers/{customer}/survey-pdfs/{surveyPdf}/question-charts/{questionChart}/edit
```

### Breadcrumb Automatico

Filament genera breadcrumb basato sulla gerarchia:

```
Dashboard > Customers > Customer Name > Survey PDFs > Survey PDF Name > Question Charts
```

### Registrazione Relation Manager

**Importante**: Usare chiave = nome relazione per URL corretto:

```php
// ✅ Corretto
public static function getRelations(): array
{
    return [
        'surveyPdfs' => SurveyPdfsRelationManager::class,
    ];
}

// ❌ Errato - URL non corretti
public static function getRelations(): array
{
    return [
        'survey_pdfs' => SurveyPdfsRelationManager::class,
    ];
}
```

---

## 🔒 Sicurezza e Autorizzazione

### Policy per Nested Resources

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\User\Models\User;
use Modules\YourModule\Models\NestedModel;

class NestedModelPolicy
{
    use HandlesAuthorization;

    /**
     * Verificare accesso al parent prima di nested.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view', NestedModel::class);
    }

    public function view(User $user, NestedModel $model): bool
    {
        // Verificare accesso al parent
        return $user->can('view', $model->parent);
    }

    public function create(User $user): bool
    {
        return $user->can('create', NestedModel::class);
    }

    public function update(User $user, NestedModel $model): bool
    {
        return $user->can('update', $model->parent);
    }

    public function delete(User $user, NestedModel $model): bool
    {
        return $user->can('delete', $model->parent);
    }
}
```

### Registrazione Policy

```php
// In ServiceProvider
protected $policies = [
    NestedModel::class => NestedModelPolicy::class,
];
```

---

## 🧪 Testing Nested Resources

### Test Navigazione

```php
<?php

declare(strict_types=1);

namespace Modules\YourModule\Tests\Feature;

use Pest;
use Modules\YourModule\Models\Parent;
use Modules\YourModule\Models\Nested;

it('can navigate to nested resource', function () {
    $parent = Parent::factory()->create();
    $nested = Nested::factory()->for($parent)->create();

    $this->actingAs($this->user)
        ->get("/admin/parents/{$parent->id}/nested/{$nested->id}/edit")
        ->assertSuccessful();
});

it('shows nested resource in relation manager', function () {
    $parent = Parent::factory()->create();
    Nested::factory()->for($parent)->create();

    $this->actingAs($this->user)
        ->get("/admin/parents/{$parent->id}/edit")
        ->assertSee('nested'); // Relation manager visible
});
```

### Test Autorizzazione

```php
it('denies access without permission', function () {
    $parent = Parent::factory()->create();
    $nested = Nested::factory()->for($parent)->create();
    $unauthorizedUser = User::factory()->create();

    $this->actingAs($unauthorizedUser)
        ->get("/admin/parents/{$parent->id}/nested/{$nested->id}/edit")
        ->assertForbidden();
});
```

---

## 📈 Performance Considerations

### Lazy Loading

Per relazioni con molti record, implementare pagination:

```php
public function getTableColumns(): array
{
    return [
        // ... colonne
    ];
}

// Filament applica pagination automaticamente
```

### Eager Loading

Evitare N+1 queries con eager loading:

```php
// In RelationManager
protected function getTableQuery(): Builder
{
    return parent::getTableQuery()
        ->with('relatedModel') // Eager load
        ->with('anotherRelation');
}
```

### Caching

Per dati statici, implementare caching:

```php
public function getTableColumns(): array
{
    return Cache::remember(
        'nested_columns_' . static::class,
        3600,
        fn () => [
            // ... colonne
        ]
    );
}
```

---

## 🐛 Debugging Common Issues

### Problema: Parent Resource non trovato
```
RouteNotFoundException: Route [filament.admin.resources.parent.edit] not defined
```

**Soluzione**: Verificare che `$parentResource` sia corretto:
```php
protected static ?string $parentResource = ParentResource::class; // ✅
```

### Problema: Relation Manager non mostra nested resource
**Soluzione**: Verificare `$relatedResource`:
```php
protected static ?string $relatedResource = NestedResource::class; // ✅
```

### Problema: URL non corretti nel relation manager
**Soluzione**: Usare chiave = nome relazione:
```php
'yourRelation' => YourRelationManager::class, // ✅
```

### Problema: Breadcrumb non mostra parent
**Soluzione**: Verificare `$parentResource` e `$shouldRegisterNavigation`:
```php
protected static ?string $parentResource = ParentResource::class; // ✅
protected static bool $shouldRegisterNavigation = false; // ✅
```

---

## 📚 Checklist Implementazione

- [ ] Identificare relazioni candidate per nesting
- [ ] Verificare complessità entità (campi, sub-relazioni)
- [ ] Creare nested resource con `$parentResource`
- [ ] Impostare `$shouldRegisterNavigation = false`
- [ ] Creare relation manager con `$relatedResource`
- [ ] Registrare relation manager con chiave = relazione
- [ ] Testare navigazione e URL routing
- [ ] Testare autorizzazione e policy
- [ ] Verificare performance (N+1, lazy loading)
- [ ] Aggiornare documentazione
- [ ] Eseguire PHPStan Level 10 check

---

## 🔗 Riferimenti

- **Filament Nesting**: https://filamentphp.com/docs/5.x/resources/nesting
- **Filament Relation Managers**: https://filamentphp.com/docs/5.x/resources/managing-relationships
- **XotBaseResource**: `/Modules/Xot/docs/filament/resources.md`
- **healthcare_app Nesting Strategy**: `/Modules/healthcare_app/docs/filament-nesting-strategy.md`

---

**
**Stato**: Documentazione Best Practices  
**Applicabile a**: Tutti i moduli Laraxot
