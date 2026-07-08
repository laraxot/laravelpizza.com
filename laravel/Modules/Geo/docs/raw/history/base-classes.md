# Classi Base del Modulo Xot

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
- Risposte JSON predefinite

## XotBaseManageRelatedRecords

Classe base per la gestione dei record correlati (nested resources).

### Caratteristiche Principali

```php
use Modules\Xot\Filament\Resources\Pages\XotBaseManageRelatedRecords;

class ManageProjectPhases extends XotBaseManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;
    protected static string $relationship = 'phases';

    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable(),
            'status' => BadgeColumn::make('status'),
        ];
    }
}
```

### Funzionalità Ereditate

- Integrazione automatica con `HasXotTable`
- Gestione automatica del titolo e label di navigazione
- Supporto per `getInfolistSchema()` per metadati dell'owner
- Hook per azioni di associazione/attacco (`shouldShowAssociateAction()`, ecc.)

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
   - Documentare le modifiche significative 