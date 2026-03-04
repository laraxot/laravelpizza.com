# Migrazione a Filament 5.x Native Nesting

**Data Analisi**: 2026-01-22  
**Versione Filament**: 5.x  
**Documentazione Upstream**: https://filamentphp.com/docs/5.x/resources/nesting

## Scopo del Documento

Questo documento descrive la migrazione dal pacchetto legacy `sevendays-digital/filament-nested-resources` al nesting nativo di Filament 5.x, e identifica dove applicare il nesting nativo nei moduli del progetto.

## Panoramica

### Filament 5.x Native Nesting

Filament 5.x include supporto nativo per nested resources, eliminando la necessità di pacchetti esterni.

**Vantaggi Native Nesting**:
- ✅ **Nativo**: Parte del core Filament, sempre aggiornato
- ✅ **Semplice**: Meno codice, meno dipendenze
- ✅ **Performante**: Ottimizzato dal team Filament
- ✅ **Documentato**: Documentazione ufficiale completa

### Pacchetto Legacy (Da Deprecare)

Il progetto ha documentazione su `sevendays-digital/filament-nested-resources` che è **legacy** e non necessario con Filament 5.x.

**Pattern Legacy** (❌ NON USARE):
```php
use SevendaysDigital\FilamentNestedResources\NestedResource;
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

class ChildResource extends NestedResource
{
    public static function getParent(): string
    {
        return ParentResource::class;
    }
}

class ListChild extends XotBaseListRecords
{
    use NestedPage;  // ❌ NON NECESSARIO
}
```

### Pattern Filament 5.x Native (✅ USARE)

**Pattern Corretto**:
```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class ContactResource extends XotBaseResource
{
    protected static ?string $parentResource = SurveyPdfResource::class;
    
    // Filament 5.x gestisce automaticamente:
    // - URL nesting
    // - Breadcrumbs
    // - Parent record access
    // - Relation manager integration
}

class ListContacts extends XotBaseListRecords
{
    protected static string $resource = ContactResource::class;
    
    // ✅ NO trait necessario - Filament gestisce automaticamente
    protected function getTableQuery(): Builder
    {
        $query = static::getResource()::getEloquentQuery();
        $parent = $this->getParentRecord();
        // Filtraggio automatico per parent
        return $query;
    }
}
```

## Creazione Nested Resource

### Comando Artisan

```bash
<<<<<<< .merge_file_n4rLqL
php artisan make:filament-resource Contact --nested --module=healthcare_app
=======
php artisan make:filament-resource Contact --nested --module=ModuloEsempio
>>>>>>> .merge_file_dnlVwX
```

Questo comando crea automaticamente:
- Resource con `$parentResource` property
- Pagine (List, Create, Edit, View) configurate per nesting
- URL structure corretta

### Configurazione Manuale

Se la resource esiste già, aggiungere semplicemente:

```php
class ContactResource extends XotBaseResource
{
    protected static ?string $parentResource = SurveyPdfResource::class;
    
    // Resto implementazione...
}
```

## Relation Manager Integration

Per accedere alla nested resource dal parent, creare relation manager o page:

```bash
php artisan make:filament-relation-manager SurveyPdfResource contacts email
```

Quando Filament chiede se linkare a resource invece di modal:
- Rispondere **"yes"**
- Selezionare la nested resource (`ContactResource`)

Filament aggiungerà automaticamente:

```php
// ContactsRelationManager.php
protected static ?string $relatedResource = ContactResource::class;
```

## Customizzazione Relationship Names

Se le relazioni non seguono convenzioni standard:

```php
use Filament\Resources\ParentResourceRegistration;

public static function getParentResourceRegistration(): ?ParentResourceRegistration
{
    return SurveyPdfResource::asParent()
        ->relationship('contacts')  // Nome relazione nel parent
        ->inverseRelationship('surveyPdf');  // Nome relazione inversa nel child
}
```

## URL Parameter per Relation Manager

Quando si usa relation manager con nested resource, registrare con nome relazione come chiave:

```php
// SurveyPdfResource.php
public static function getRelations(): array
{
    return [
        'contacts' => ContactsRelationManager::class,  // ✅ Chiave = nome relazione
        'questionCharts' => QuestionChartsRelationManager::class,
    ];
}
```

Questo permette a Filament di generare correttamente gli URL quando si redirige dal nested resource al relation manager.

## Accesso Parent Record

Nelle pagine nested, accedere al parent:

```php
class ListContacts extends XotBaseListRecords
{
    protected function getTableQuery(): Builder
    {
        $query = static::getResource()::getEloquentQuery();
        
        $surveyPdf = $this->getParentRecord();
        if ($surveyPdf instanceof SurveyPdf) {
            $query = $query->where('survey_pdf_id', $surveyPdf->id);
        }
        
        return $query;
    }
    
    protected function getTableHeaderActions(): array
    {
        $surveyPdf = $this->getParentRecord();
        
        return [
            'create' => CreateAction::make()
                ->mutateFormDataUsing(function (array $data) use ($surveyPdf): array {
                    $data['survey_pdf_id'] = $surveyPdf->id;
                    return $data;
                }),
        ];
    }
}
```

## Migrazione da Legacy

### Step 1: Rimuovere Dipendenze Legacy

```bash
# Rimuovere dal composer.json
composer remove sevendays-digital/filament-nested-resources
```

### Step 2: Aggiornare Resource

```php
// PRIMA (Legacy)
use SevendaysDigital\FilamentNestedResources\NestedResource;

class ContactResource extends NestedResource
{
    public static function getParent(): string
    {
        return SurveyPdfResource::class;
    }
}

// DOPO (Filament 5.x Native)
use Modules\Xot\Filament\Resources\XotBaseResource;

class ContactResource extends XotBaseResource
{
    protected static ?string $parentResource = SurveyPdfResource::class;
}
```

### Step 3: Aggiornare Pagine

```php
// PRIMA (Legacy)
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

class ListContacts extends XotBaseListRecords
{
    use NestedPage;  // ❌ RIMUOVERE
}

// DOPO (Filament 5.x Native)
class ListContacts extends XotBaseListRecords
{
    // ✅ NO trait necessario - Filament gestisce automaticamente
    protected function getTableQuery(): Builder
    {
        // Filtraggio per parent
    }
}
```

### Step 4: Aggiornare Relation Manager

```php
// PRIMA (Legacy)
// Nella resource parent, usare ChildResourceLink

// DOPO (Filament 5.x Native)
// Relation manager con $relatedResource property
protected static ?string $relatedResource = ContactResource::class;
```

## Opportunità di Nesting per Moduli

<<<<<<< .merge_file_n4rLqL
### Modulo healthcare_app

Vedi: [Modules/healthcare_app/docs/filament-nesting-opportunities.md](../../healthcare_app/docs/filament-nesting-opportunities.md)
=======
### Moduli con nested resources

Vedi: [Filament Nesting Best Practices](../filament-nesting-best-practices.md)
>>>>>>> .merge_file_dnlVwX

**Opportunità**:
- Contact → Nested di SurveyPdf
- SurveyPdf → Nested di Customer (opzionale)
- QuestionChart → Già nested ✅

### Modulo Limesurvey

Vedi: [Modules/Limesurvey/docs/filament-nesting-opportunities.md](../../limesurvey/docs/filament-nesting-opportunities.md)

**Opportunità**:
- LimeGroup → Nested di LimeSurvey
- LimeQuestion → Nested di LimeGroup
- LimeAnswer → Nested di LimeQuestion

### Modulo Cms

Vedi: [Modules/Cms/docs/filament-nesting-opportunities.md](../../cms/docs/filament-nesting-opportunities.md)

**Opportunità**:
- Block → Nested di Page
- Block → Nested di Section
- Menu Sub-items → Nested ricorsivo

### Modulo User

Vedi: [Modules/User/docs/filament-nesting-opportunities.md](../../user/docs/filament-nesting-opportunities.md)

**Opportunità**:
- TeamInvitation → Nested di Team
- TeamUser → Nested di Team (opzionale)

## Best Practices

### 1. Quando Usare Nesting

**Usa Nested Resource quando**:
- Form è complesso (10+ campi, repeater, fieldset)
- Serve pagina dedicata per gestione
- Ci sono azioni multiple o workflow complessi
- Serve navigazione chiara parent-child
- Relazione è hasMany o belongsTo (non many-to-many semplice)

**Usa Relation Manager quando**:
- Form è semplice (pochi campi)
- Gestione può essere fatta in modal
- Non serve navigazione dedicata
- Relazione è many-to-many semplice

### 2. Filtraggio Parent

**Sempre implementare** `getTableQuery()` per filtrare per parent:

```php
protected function getTableQuery(): Builder
{
    $query = static::getResource()::getEloquentQuery();
    $parent = $this->getParentRecord();
    
    if ($parent instanceof ParentModel) {
        $query = $query->where('parent_id', $parent->id);
    }
    
    return $query;
}
```

### 3. Form Data Mutation

**Sempre popolare parent_id nel form**:

```php
protected function getTableHeaderActions(): array
{
    return [
        'create' => CreateAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $parent = $this->getParentRecord();
                if ($parent instanceof ParentModel) {
                    $data['parent_id'] = $parent->id;
                }
                return $data;
            }),
    ];
}
```

### 4. Breadcrumbs Automatici

Filament 5.x gestisce automaticamente i breadcrumbs per nested resources. Non serve configurazione manuale.

## Checklist Migrazione

### Per Ogni Nested Resource

- [ ] Rimuovere dipendenze legacy (se presenti)
- [ ] Aggiornare resource con `$parentResource`
- [ ] Rimuovere trait `NestedPage` dalle pagine
- [ ] Implementare `getTableQuery()` per filtraggio parent
- [ ] Aggiornare relation manager con `$relatedResource`
- [ ] Testare navigazione e breadcrumbs
- [ ] Verificare URL structure corretta
- [ ] Aggiornare documentazione

## Collegamenti

- [Filament 5.x Nesting Documentation](https://filamentphp.com/docs/5.x/resources/nesting)
<<<<<<< .merge_file_n4rLqL
- [healthcare_app Nesting Opportunities](../../healthcare_app/docs/filament-nesting-opportunities.md)
=======
- [Filament Nesting Best Practices](../filament-nesting-best-practices.md)
>>>>>>> .merge_file_dnlVwX
- [Limesurvey Nesting Opportunities](../../limesurvey/docs/filament-nesting-opportunities.md)
- [Cms Nesting Opportunities](../../cms/docs/filament-nesting-opportunities.md)
- [User Nesting Opportunities](../../user/docs/filament-nesting-opportunities.md)

---

**Prossima Revisione**: 2026-02-22
