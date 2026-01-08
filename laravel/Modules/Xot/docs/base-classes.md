# Classi Base del Modulo Xot

### Versione HEAD

## Panoramica
Il modulo Xot fornisce una serie di classi base che devono essere estese dagli altri moduli. Questo garantisce coerenza e funzionalità comuni in tutta l'applicazione.

## Classi Base Principali

### 1. XotBaseResource
```php
namespace Modules\Xot\Filament\Resources;

class XotBaseResource
{
    public static function getFormSchema(): array;
    public static function getListTableColumns(): array;
}
```

**Uso**:
```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class DoctorResource extends XotBaseResource
{
    // Implementazione specifica
}
```

### 2. XotBaseServiceProvider
```php
namespace Modules\Xot\Providers;

class XotBaseServiceProvider
{
    protected function registerConfig();
    protected function registerViews();
    protected function registerTranslations();
}
```

### 3. XotBaseModel
```php
namespace Modules\Xot\Models;

class XotBaseModel
{
    protected $fillable = [];
    protected $casts = [];
}
```

## Pages Filament

### XotBaseListRecords
```php
namespace Modules\Xot\Filament\Resources\Pages;

class XotBaseListRecords
{
    public function getListTableColumns(): array;
}
```

### XotBaseCreateRecord
```php
namespace Modules\Xot\Filament\Resources\Pages;

class XotBaseCreateRecord
{
    // Implementazione base
}
```

### XotBaseEditRecord
```php
namespace Modules\Xot\Filament\Resources\Pages;

class XotBaseEditRecord
{
    // Implementazione base
}
```

## Best Practices

1. **Estensione Classi**
   - Sempre estendere le classi base appropriate
   - Non saltare la gerarchia di ereditarietà
   - Mantenere la coerenza nei namespace

2. **Override Metodi**
   - Rispettare i contratti delle interfacce
   - Documentare le modifiche al comportamento
   - Mantenere la compatibilità

3. **Namespace**
   - Usare i namespace corretti
   - Mantenere la struttura standard
   - Seguire le convenzioni PSR-4

## Collegamenti Bidirezionali
- [README](README.md)
- [Struttura Moduli](module-structure.md)
- [Convenzioni Namespace](namespace-conventions.md)

## Vedi Anche
- [Filament Best Practices](filament-best-practices.md)
- [Service Provider](service-provider-best-practices.md)
- [Convenzioni](conventions.md)


### Versione Incoming


---

## XotBaseResource

Classe base per tutte le risorse Filament dell'applicazione.

### Caratteristiche Principali

```php
use Modules\Xot\Filament\Resources\XotBaseResource;

class PolizzaConvenzioneResource extends XotBaseResource
{
    protected static ?string $model = PolizzaConvenzione::class;
    
    // Non definire proprietà di navigazione - gestite automaticamente
    // protected static ?string $navigationIcon = 'heroicon-o-document';
    // protected static ?string $navigationGroup = 'Portafoglio';
    // protected static ?int $navigationSort = 1;
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolizzeConvenzioni::route('/'),
            'view' => Pages\ViewPolizzaConvenzione::route('/{record}'),
            'edit' => Pages\EditPolizzaConvenzione::route('/{record}/edit'),
        ];
    }
}
```

### Funzionalità Ereditate

- Gestione automatica della navigazione
- Integrazione con il sistema di traduzioni
- Gestione permessi e autorizzazioni
- Configurazioni comuni predefinite

## XotBasePage

Classe base per tutte le pagine Filament dell'applicazione.

### Caratteristiche Principali

```php
use Modules\Xot\Filament\Pages\XotBasePage;

class ConvenzioniStatistiche extends XotBasePage
{
    // Non definire proprietà di navigazione - gestite automaticamente
    
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Select::make('anno')
                        ->options(range(2020, date('Y')))
                        ->required(),
                ])
        ];
    }
    
    protected function authorizeAccess(): void
    {
        $this->authorize('statistiche.read');
    }
}
```

### Funzionalità Ereditate

- Layout standard dell'applicazione
- Gestione permessi integrata
- Integrazione con il sistema di traduzioni
- Funzionalità comuni predefinite

## XotBaseModel

Classe base per tutti i modelli dell'applicazione.

### Caratteristiche Principali

```php
use Modules\Xot\Models\XotBaseModel;

class PolizzaConvenzione extends XotBaseModel
{
    protected $table = 'polizze_convenzione';
    
    protected $fillable = [
        'numero_adesione',
        'data_decorrenza',
        'premio_lordo',
    ];
    
    // Soft delete gestito automaticamente
    
    // Timestamps gestiti automaticamente
    
    // Relazioni standard disponibili
}
```

### Funzionalità Ereditate

- Soft delete automatico
- Gestione automatica timestamps
- Relazioni standard predefinite
- Metodi di utilità comuni

## XotBaseController

Classe base per tutti i controller dell'applicazione.

### Caratteristiche Principali

```php
use Modules\Xot\Http\Controllers\XotBaseController;

class PolizzaConvenzioneController extends XotBaseController
{
    protected function authorizeResource(): void
    {
        $this->authorizeResource(PolizzaConvenzione::class);
    }
    
    public function index()
    {
        $this->authorize('viewAny', PolizzaConvenzione::class);
        
        // Logica del controller
    }
}
```

### Funzionalità Ereditate

- Gestione autorizzazioni integrata
- Metodi di utilità comuni
- Gestione errori standardizzata
### Versione HEAD

- Risposte JSON predefinite 

### Versione Incoming


---

- Risposte JSON predefinite

## Best Practices

1. **Estensione Classi Base**
   - Estendere sempre le classi base appropriate
   - Non sovrascrivere le funzionalità base senza motivo
   - Mantenere la coerenza con l'architettura

2. **Navigazione**
   - Non definire proprietà di navigazione nelle risorse
   - Utilizzare il sistema di traduzioni per le etichette
   - Rispettare la struttura di navigazione definita

3. **Permessi**
   - Utilizzare il sistema di autorizzazioni integrato
   - Definire i permessi in modo granulare
   - Documentare i permessi necessari

4. **Personalizzazione**
   - Estendere le funzionalità tramite trait
   - Mantenere la retrocompatibilità
### Versione HEAD

   - Documentare le modifiche significative 
## Collegamenti tra versioni di base-classes.md
* [base-classes.md](../../../Xot/docs/base-classes.md)
* [base-classes.md](../../../Xot/docs/roadmap/base-classes.md)


### Versione Incoming

   - Documentare le modifiche significative 

---

