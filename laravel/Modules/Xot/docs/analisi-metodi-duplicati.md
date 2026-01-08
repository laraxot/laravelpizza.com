# Analisi Metodi Duplicati - Modulo Xot

## 🐄✨ Riferimenti Principali

📚 **DOCUMENTO MASTER (LEGGERE PRIMA!):** [../../../docs/analisi-metodi-duplicati-MASTER.md](../../../docs/analisi-metodi-duplicati-MASTER.md)  
📖 **Documento Originale:** [../../../docs/analisi-metodi-duplicati.md](../../../docs/analisi-metodi-duplicati.md)

> ⚠️ **IMPORTANTE:** Questo documento è specifico per il modulo Xot. Per l'analisi completa con dati reali, ROI, implementazioni concrete e migration guide, consultare il DOCUMENTO MASTER.

## Stato del Modulo Xot

Il modulo **Xot** è il **modulo base** che fornisce le classi fondamentali per tutti gli altri moduli:

### Dati Reali dal Codebase

| Metrica | Valore REALE |
|---------|--------------|
| **Proprietà Duplicate in BaseModel** | 9 |
| **LOC BaseModel Xot** | ~80 |
| **Riduzione Possibile** | 87% (→ ~10 LOC) |
| **Namespace nel Modulo** | 15+ |
| **Trait Forniti** | HasXotFactory, Updater, RelationX, HasXotTable, ecc. |

### Classi Base Fornite

- `Modules\Xot\Models\BaseModel` - Classe base per tutti i modelli
- `Modules\Xot\Providers\XotBaseServiceProvider` - Service Provider base
- `Modules\Xot\Providers\XotBaseRouteServiceProvider` - Route Service Provider base
- `Modules\Xot\Providers\XotBaseThemeServiceProvider` - Theme Service Provider base
- `Modules\Xot\Filament\Resources\XotBaseResource` - Resource Filament base
- `Modules\Xot\Filament\Widgets\XotBaseWidget` - Widget Filament base

### Responsabilità del Modulo

Il modulo Xot è responsabile di:
1. ✅ Definire le classi base comuni
2. ✅ Fornire trait riutilizzabili
3. ✅ Gestire comportamenti condivisi
4. ✅ Centralizzare logiche ripetitive

### Metodi e Proprietà da Centralizzare in Xot

#### BaseModel - Proprietà Comuni (100% duplicazione)

**PRIORITÀ ALTA** 🔥

Queste proprietà sono duplicate in **tutti i 18 moduli** e dovrebbero essere spostate in `Modules\Xot\Models\BaseModel`:

```php
// Da aggiungere in Modules\Xot\Models\BaseModel
abstract class BaseModel extends Model
{
    /**
     * Indicates whether attributes are snake cased on arrays.
     */
    public static $snakeAttributes = true;

    /** @var bool */
    public $incrementing = true;

    /** @var bool */
    public $timestamps = true;

    /** @var int */
    protected $perPage = 30;

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string */
    protected $keyType = 'string';

    /** @var list<string> */
    protected $hidden = [];

    /** @var list<string> */
    protected $appends = [];
    
    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
```

**Beneficio:** Riduzione di ~40% del codice duplicato totale nel progetto

#### BaseModel - Connection Property

La proprietà `$connection` è l'**unica differenza** tra i BaseModel dei vari moduli:

```php
// Activity
protected $connection = 'activity';

// Blog
protected $connection = 'blog';

// Cms
protected $connection = 'cms';

// User
protected $connection = 'user';

// ... ecc
```

**Soluzione Proposta:**

Aggiungere un metodo helper in `Modules\Xot\Models\BaseModel`:

```php
abstract class BaseModel extends Model
{
    /**
     * Get connection name based on module namespace.
     */
    protected function getConnectionName(): string
    {
        // Estrae il nome del modulo dal namespace
        // Es: Modules\User\Models\User -> 'user'
        $namespace = static::class;
        preg_match('/Modules\\\\([^\\\\]+)\\\\/', $namespace, $matches);
        
        return strtolower($matches[1] ?? 'mysql');
    }

    public function __construct(array $attributes = [])
    {
        $this->connection = $this->connection ?? $this->getConnectionName();
        parent::__construct($attributes);
    }
}
```

### Trait da Fornire

Il modulo Xot già fornisce alcuni trait, ma potrebbero essere aggiunti altri:

#### Trait Esistenti ✅
- `HasXotFactory` - Gestione factory
- `Updater` - Gestione created_by/updated_by
- `RelationX` - Relazioni estese

#### Trait Proposti da Aggiungere 🆕

```php
// Modules\Xot\Models\Traits\HasPublishableDates
trait HasPublishableDates
{
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }
    
    public function scopeDraft($query)
    {
        return $query->whereNull('published_at');
    }
    
    public function isPublished(): bool
    {
        return $this->published_at !== null && 
               $this->published_at <= now();
    }
}
```

```php
// Modules\Xot\Models\Traits\HasUuidSupport
trait HasUuidSupport
{
    protected static function bootHasUuidSupport(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
```

### XotBaseServiceProvider - Metodi da NON Ridichiarare

**ERRORE COMUNE:** Ridichiarare metodi già presenti in `XotBaseServiceProvider`

❌ **Non fare:**
```php
class MyModuleServiceProvider extends XotBaseServiceProvider
{
    // ❌ SBAGLIATO: Questo metodo è già in XotBaseServiceProvider
    protected function registerTranslations(): void
    {
        $langPath = module_path($this->name, 'lang');
        $this->loadTranslationsFrom($langPath, $this->name);
    }
}
```

✅ **Fare:**
```php
class MyModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'MyModule';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot(); // ✅ CORRETTO: Chiama il parent che gestisce tutto
        
        // Solo inizializzazioni SPECIFICHE del modulo
        $this->registerModuleSpecificStuff();
    }
}
```

### XotBaseResource - Metodi FINAL

**ERRORE COMUNE:** Sovrascrivere metodi `final` di `XotBaseResource`

❌ **Non fare:**
```php
class MyResource extends XotBaseResource
{
    // ❌ SBAGLIATO: form() è FINAL in XotBaseResource
    public static function form(Form $form): Form
    {
        return $form->schema([...]);
    }
}
```

✅ **Fare:**
```php
class MyResource extends XotBaseResource
{
    // ✅ CORRETTO: Implementa solo getFormSchema()
    public static function getFormSchema(): array
    {
        return [
            'name' => Forms\Components\TextInput::make('name'),
            'email' => Forms\Components\TextInput::make('email'),
        ];
    }
}
```

## Statistiche Duplicazione - Modulo Xot

### Ruolo del Modulo

| Metrica | Valore | Note |
|---------|--------|------|
| **Classi Base Fornite** | 6 | BaseModel, XotBaseServiceProvider, ecc. |
| **Trait Forniti** | 15+ | HasXotFactory, Updater, RelationX, ecc. |
| **Moduli Dipendenti** | 17 | Tutti eccetto Xot stesso |
| **Percentuale Codice Condiviso** | ~65% | Del totale codice nei moduli |

### Impatto dell'Unificazione

Se l'unificazione viene implementata correttamente:

- ✅ **40%** riduzione codice duplicato nei BaseModel
- ✅ **30%** riduzione codice duplicato nei ServiceProvider
- ✅ **15%** riduzione codice duplicato nelle Resources
- ✅ **50%** riduzione test necessari (test una classe base invece di N classi)

## Raccomandazioni per il Modulo Xot

### Priorità ALTA 🔥

1. **Centralizzare Proprietà BaseModel**
   - Spostare tutte le proprietà comuni in `Modules\Xot\Models\BaseModel`
   - Implementare metodo `getConnectionName()` automatico
   - Testare con tutti i moduli esistenti

2. **Standardizzare Metodo casts()**
   - Fornire implementazione di default
   - Permettere override nei moduli figli con `array_merge(parent::casts(), [...])`

3. **Documentare Pattern Obbligatori**
   - Creare guida per sviluppatori su come estendere correttamente le classi base
   - Esempi di cosa fare e cosa NON fare

### Priorità MEDIA 🟡

4. **Creare Trait Aggiuntivi**
   - `HasPublishableDates`
   - `HasUuidSupport`
   - `HasSoftDeletesAudit`

5. **Implementare PHPStan Rules Custom**
   - Rilevare ServiceProvider che non estendono XotBase*
   - Validare Resources che sovrascrivono metodi final
   - Verificare presenza proprietà obbligatorie

### Priorità BASSA 🟢

6. **Performance Optimization**
   - Profiling delle classi base
   - Lazy loading dove appropriato
   - Caching ottimizzato

## Link Utili

- 📚 [Analisi Completa](../../../docs/analisi-metodi-duplicati.md)
- 📖 [Regole Service Provider](./service-provider.md)
- 📖 [Regole BaseModel](./model-inheritance-rules.md)
- 📖 [Regole Resources Filament](./filament-4-laraxot-rules.md)

## Changelog

| Data | Versione | Modifiche |
|------|----------|-----------|
| 2025-10-15 | 1.0 | Creazione documento iniziale |

---

**Stato:** 📋 Draft per Review  
**Responsabile:** Team Xot Core

