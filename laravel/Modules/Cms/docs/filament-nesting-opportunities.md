# Filament 5.x Nested Resources - Opportunità di Applicazione

**Data Analisi**: [DATE]  
**Versione Filament**: 5.x  
**Documentazione Upstream**: https://filamentphp.com/docs/5.x/resources/nesting

## Scopo del Documento

Questo documento identifica dove e perché applicare il nesting nativo di Filament 5.x nel modulo Cms per gestire strutture gerarchiche (Menu, Page, Section, Block).

## Panoramica Filament 5.x Nesting

### Cos'è il Nesting

Il nesting in Filament 5.x permette di creare risorse figlie con pagine complete invece di essere gestite solo tramite modal nei relation managers.

**Vantaggi per CMS**:
- **Gerarchia Chiara**: Riflette strutture ad albero (Menu, Page)
- **Navigazione Logica**: URL che seguono la gerarchia contenuti
- **Form Complessi**: Block e Page hanno configurazioni complesse
- **Context Preservation**: Mantiene sempre il contesto del parent

## Relazioni Modulo Cms

### Schema Relazioni

```
Page (standalone o gerarchica)
├── Block (n:n) - Blocchi contenuto
└── Metatag (1:1) - SEO metadata

Menu (gerarchico ricorsivo)
├── Menu (1:n) - Sub-menu (parent_id)
└── Items (array) - Voci menu

Section (standalone)
└── Block (n:n) - Blocchi sezione
```

## Opportunità di Nesting

### 1. Block come Nested Resource di Page

**Stato Attuale**: 
- Block gestito come relazione many-to-many
- Gestione tramite relation manager o repeater

**Perché Nestare**:
- ✅ **Form Complesso**: Block ha configurazioni complesse (type, content, settings)
- ✅ **Gestione Dedicata**: Block ha logica complessa (rendering, caching)
- ✅ **Navigazione Chiara**: URL `/pages/{id}/blocks` più intuitivo
- ✅ **Workflow Dedicato**: Block ha azioni multiple (preview, duplicate, reorder)

**Implementazione**:

```php
// BlockResource.php
class BlockResource extends XotBaseResource
{
    protected static ?string $parentResource = PageResource::class;
    
    public static function getFormSchema(): array
    {
        return [
            'type' => Select::make('type')
                ->options(BlockTypeEnum::options())
                ->required(),
            'content' => Textarea::make('content'),
            'settings' => KeyValue::make('settings'),
            'order' => TextInput::make('order')->integer(),
        ];
    }
}
```

**Comando**:
```bash
php artisan make:filament-resource Block --nested --module=Cms
```

**Priorità**: 🟡 **ALTA** - Migliora gestione blocchi

### 2. Block come Nested Resource di Section

**Stato Attuale**: 
- Block gestito come relazione many-to-many
- Gestione tramite relation manager

**Perché Nestare**:
- ✅ **Stessa logica di Page**: Block appartiene a Section
- ✅ **Form Complesso**: Stesse configurazioni complesse
- ✅ **Navigazione Logica**: URL `/sections/{id}/blocks`

**Priorità**: 🟡 **ALTA** - Coerenza con Page

### 3. Metatag come Nested Resource di Page

**Stato Attuale**: 
- Metatag gestito come relazione 1:1
- Gestione nel form Page principale

**Perché Nestare**:
- ✅ **Form Dedicato**: Metatag ha molti campi SEO (title, description, og, schema.org)
- ✅ **Gestione Separata**: SEO può essere gestito separatamente dal contenuto
- ✅ **Navigazione Logica**: URL `/pages/{id}/metatag`

**Alternativa**: 
- Se form non troppo complesso, può rimanere nel form Page principale
- Nesting utile se serve pagina dedicata SEO

**Priorità**: 🟢 **MEDIA** - Dipende da complessità form

### 4. Menu Sub-items (Nested Recursive)

**Stato Attuale**: 
- Menu ha `parent_id` per gerarchia ricorsiva
- Gestito tramite HasRecursiveRelationships trait

**Perché Nestare**:
- ✅ **Gerarchia Chiara**: Sub-menu sono menu con parent
- ✅ **Navigazione Logica**: URL riflette gerarchia menu
- ✅ **Form Dedicato**: Sub-menu hanno configurazioni specifiche

**Implementazione**:

Usare lo stesso `MenuResource` con logica condizionale:

```php
// MenuResource.php
public static function getFormSchema(): array
{
    $parent = static::getParentRecord();
    $isSubMenu = $parent instanceof Menu;
    
    return [
        'title' => TextInput::make('title')->required(),
        'items' => Repeater::make('items'),
        
        // Se è sub-menu, aggiungere campo parent_id
        ...($isSubMenu ? [
            'parent_id' => Hidden::make('parent_id')
                ->default(fn () => $parent->id),
        ] : []),
    ];
}
```

**Priorità**: 🟢 **MEDIA** - Migliora gestione gerarchia menu

## Relazioni da NON Nestare

### 1. PageContent

**Motivazione**: 
- PageContent è parte integrante di Page
- Gestito meglio come campo nel form Page
- Non serve pagina dedicata

**Alternativa**: Continuare con campo nel form Page

### 2. Appearance

**Motivazione**:
- Appearance è configurazione globale
- Non ha relazione parent-child
- Gestione standalone è appropriata

**Alternativa**: Continuare con resource standalone

## URL Structure

Dopo il nesting, gli URL saranno:

```
/pages/{pageId}
  /blocks/{blockId}
  /metatag

/sections/{sectionId}
  /blocks/{blockId}

/menus/{menuId}
  /sub-menus/{subMenuId}
```

**Vantaggi**:
- ✅ Gerarchia chiara e navigabile
- ✅ Context sempre preservato
- ✅ Breadcrumbs automatici
- ✅ Filtraggio automatico per parent

## Implementazione Step-by-Step

### Step 1: Creare Block Nested Resource per Page

```bash
php artisan make:filament-resource Block --nested --module=Cms
```

```php
// BlockResource.php
class BlockResource extends XotBaseResource
{
    protected static ?string $parentResource = PageResource::class;
    
    // Gestione relazione many-to-many con pivot
    public static function getFormSchema(): array
    {
        return [
            'type' => Select::make('type')->required(),
            'content' => Textarea::make('content'),
            'order' => TextInput::make('order')->integer(),
        ];
    }
}
```

### Step 2: Creare Relation Manager per Blocks

```bash
php artisan make:filament-relation-manager PageResource blocks type
# Rispondere "yes" quando chiede di linkare a nested resource
# Selezionare BlockResource
```

### Step 3: Gestire Many-to-Many con Pivot

Per relazioni many-to-many, usare `getParentResourceRegistration()`:

```php
use Filament\Resources\ParentResourceRegistration;

public static function getParentResourceRegistration(): ?ParentResourceRegistration
{
    return PageResource::asParent()
        ->relationship('blocks')  // Nome relazione nel parent
        ->inverseRelationship('pages');  // Nome relazione inversa nel child
}
```

## Priorità Implementazione

### 🔴 CRITICA (Implementare Subito)

Nessuna funzionalità critica - il modulo Cms funziona bene con relation managers

### 🟡 ALTA (Implementare a Breve)

1. **Block Nested Resource (Page)** - Migliora UX gestione blocchi
2. **Block Nested Resource (Section)** - Coerenza con Page

### 🟢 MEDIA (Implementare Quando Possibile)

1. **Metatag Nested Resource** - Se form SEO diventa complesso
2. **Menu Sub-items Nested** - Migliora gestione gerarchia

## Checklist Implementazione

### Per Block Nested Resource

- [ ] Creare nested resource Block
- [ ] Aggiungere `$parentResource = PageResource::class`
- [ ] Gestire relazione many-to-many con pivot
- [ ] Creare relation manager per blocks
- [ ] Implementare form schema completo
- [ ] Gestire ordinamento blocchi
- [ ] Testare navigazione e breadcrumbs
- [ ] Aggiornare documentazione

## Collegamenti

- [Filament 5.x Nesting Documentation](https://filamentphp.com/docs/5.x/resources/nesting)
- [Cms Architecture](./architecture/structure.md)
- [Block System](./blocks/)
- [Page Management](./homepage-management.md)

---

**Prossima Revisione**: [DATE]
