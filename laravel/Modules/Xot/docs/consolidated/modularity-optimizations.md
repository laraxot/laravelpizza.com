# Modulo Xot - Ottimizzazioni per Modularità

## Problemi Identificati

Durante l'audit del modulo `Xot` (modulo base del framework), sono state identificate **violazioni critiche dei principi di modularità** che compromettono la riutilizzabilità del framework in progetti diversi.

## Violazioni Critiche Trovate

### 1. Path Hardcoded per Progetti Specifici
```php
// ❌ ERRORE CRITICO - Path hardcoded
public static string $projectBasePath = '/var/www/html/<nome progetto>';
public static string $laravelBasePath = '/var/www/html/<nome progetto>/laravel';
public static string $modulesBasePath = '/var/www/html/<nome progetto>/laravel/Modules';
```

**File contaminati:**
- `app/Helpers/PathHelper.php`

### 2. Dipendenze su Moduli Specifici nei Test
```php
// ❌ ERRORE CRITICO - Dipendenze hardcoded nei test
->andReturn(\Modules\<nome progetto>\Models\User::class);
```

**File contaminati:**
- `tests/TestCase.php`

### 3. Riferimenti a Traduzioni Specifiche
```php
// ❌ ERRORE CRITICO - Traduzioni hardcoded
self::MONDAY => __('<nome progetto>::common.days.description.monday'),
self::TUESDAY => __('<nome progetto>::common.days.description.tuesday'),
```

**File contaminati:**
- `app/Enums/DayOfWeek.php`

### 4. Factory con Dati Specifici
```php
// ❌ ERRORE CRITICO - Dati hardcoded nelle factory
'table_schema' => $this->faker->randomElement(['<nome progetto>', 'public', 'main']),
```

**File contaminati:**
- `database/factories/InformationSchemaTableFactory.php`

### 5. Dipendenze su Moduli Specifici nei Widget
```php
// ❌ ERRORE CRITICO - Import hardcoded
use Modules\<nome progetto>\Models\Appointment;
```

**File contaminati:**
- `app/Filament/Widgets/ModelTrendChartWidget.php`
- `app/Filament/Widgets/StateOverviewWidget.php`

## Impatto delle Violazioni

### Architetturale
1. **Lock-in al Progetto**: Il framework Xot non può essere utilizzato in altri progetti
2. **Violazione Principi Base**: Il modulo base viola i principi di modularità
3. **Dipendenze Cicliche**: Creazione di dipendenze tra framework e progetti specifici

### Operativo
1. **Impossibilità di Riuso**: Framework non trasportabile
2. **Manutenzione Impossibile**: Modifiche richieste per ogni progetto
3. **Testing Impossibile**: Test dipendenti da moduli esterni

## Soluzioni Proposte

### 1. Path Helper Dinamico
```php
// ✅ CORRETTO - Path dinamici
class PathHelper
{
    public static function getProjectBasePath(): string
    {
        return env('PROJECT_BASE_PATH', base_path());
    }
    
    public static function getLaravelBasePath(): string
    {
        return env('LARAVEL_BASE_PATH', base_path());
    }
    
    public static function getModulesBasePath(): string
    {
        return env('MODULES_BASE_PATH', base_path('Modules'));
    }
    
    public static function normalizePath(string $path): string
    {
        $projectPath = self::getProjectBasePath();
        $laravelPath = self::getLaravelBasePath();
        $modulesPath = self::getModulesBasePath();
        
        // Normalizzazione dinamica
        return str_replace(
            ['/<nome progetto>/', '/Modules/'],
            [$projectPath, $modulesPath],
            $path
        );
    }
}
```

### 2. Configurazione Centralizzata
```php
// config/xot.php
return [
    'paths' => [
        'project_base' => env('PROJECT_BASE_PATH', base_path()),
        'laravel_base' => env('LARAVEL_BASE_PATH', base_path()),
        'modules_base' => env('MODULES_BASE_PATH', base_path('Modules')),
    ],
    'models' => [
        'user' => env('XOT_USER_MODEL', \App\Models\User::class),
        'appointment' => env('XOT_APPOINTMENT_MODEL', \App\Models\Appointment::class),
    ],
    'translations' => [
        'namespace' => env('XOT_TRANSLATION_NAMESPACE', 'xot'),
        'fallback' => env('XOT_TRANSLATION_FALLBACK', 'xot'),
    ],
    'factory' => [
        'table_schemas' => env('XOT_TABLE_SCHEMAS', 'public,main,information_schema'),
    ],
];
```

### 3. Service Provider di Configurazione
```php
// ✅ CORRETTO - Configurazione dinamica
class XotServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('xot.user.model', function ($app) {
            $userClass = config('xot.models.user', \App\Models\User::class);
            return $userClass;
        });
        
        $this->app->bind('xot.appointment.model', function ($app) {
            $appointmentClass = config('xot.models.appointment', \App\Models\Appointment::class);
            return $appointmentClass;
        });
    }
}
```

### 4. Widget Generici
```php
// ✅ CORRETTO - Widget generico
class ModelTrendChartWidget extends Widget
{
    protected function getModelClass(): string
    {
        return config('xot.models.appointment', \App\Models\Appointment::class);
    }
    
    protected function getData(): array
    {
        $modelClass = $this->getModelClass();
        return $modelClass::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->toArray();
    }
}
```

### 5. Enum Generici
```php
// ✅ CORRETTO - Enum generico
enum DayOfWeek: int
{
    case MONDAY = 1;
    case TUESDAY = 2;
    case WEDNESDAY = 3;
    case THURSDAY = 4;
    case FRIDAY = 5;
    case SATURDAY = 6;
    case SUNDAY = 7;
    
    public function getDescription(): string
    {
        $namespace = config('xot.translations.namespace', 'xot');
        return __("{$namespace}::common.days.description.{$this->name}");
    }
}
```

## Piano di Ottimizzazione

### Fase 1: Path Helper (CRITICA)
- [ ] Refactoring `PathHelper.php`
- [ ] Path dinamici configurabili
- [ ] Normalizzazione path intelligente

### Fase 2: Configurazione (ALTA PRIORITÀ)
- [ ] Creazione `config/xot.php`
- [ ] Variabili d'ambiente per path
- [ ] Configurazione modelli dinamica

### Fase 3: Service Provider (ALTA PRIORITÀ)
- [ ] Creazione `XotServiceProvider`
- [ ] Binding dinamici per modelli
- [ ] Configurazione centralizzata

### Fase 4: Widget Generici (MEDIA PRIORITÀ)
- [ ] `ModelTrendChartWidget.php`
- [ ] `StateOverviewWidget.php`
- [ ] Configurazione modelli dinamica

### Fase 5: Enum Generici (MEDIA PRIORITÀ)
- [ ] `DayOfWeek.php`
- [ ] Traduzioni configurabili
- [ ] Namespace dinamico

### Fase 6: Factory Generiche (BASSA PRIORITÀ)
- [ ] `InformationSchemaTableFactory.php`
- [ ] Dati configurabili
- [ ] Schema dinamico

### Fase 7: Test Generici (BASSA PRIORITÀ)
- [ ] `TestCase.php`
- [ ] Modelli configurabili
- [ ] Dipendenze dinamiche

## Benefici delle Ottimizzazioni

### Architetturali
1. **Modularità Vera**: Framework Xot completamente indipendente
2. **Separazione Responsabilità**: Xot gestisce solo la base, non i progetti
3. **Inversione Dipendenze**: Dipendenze verso configurazione, non implementazioni

### Operativi
1. **Riutilizzabilità**: Funziona in qualsiasi progetto Laraxot
2. **Configurabilità**: Personalizzabile tramite configurazione
3. **Manutenibilità**: Modifiche centralizzate e standardizzate

### Business
1. **Scalabilità**: Facile aggiunta di nuovi progetti
2. **Riuso**: Framework vendibile/condivisibile
3. **Competitività**: Architettura modulare avanzata

## Configurazione per Progetti

### Variabili d'Ambiente
```env
# Configurazione Path Xot
PROJECT_BASE_PATH=/var/www/html/<nome progetto>
LARAVEL_BASE_PATH=/var/www/html/<nome progetto>/laravel
MODULES_BASE_PATH=/var/www/html/<nome progetto>/laravel/Modules

# Configurazione Modelli Xot
XOT_USER_MODEL=Modules\<nome progetto>\Models\User
XOT_APPOINTMENT_MODEL=Modules\<nome progetto>\Models\Appointment

# Configurazione Traduzioni Xot
XOT_TRANSLATION_NAMESPACE=<nome progetto>
XOT_TRANSLATION_FALLBACK=xot

# Configurazione Factory Xot
XOT_TABLE_SCHEMAS=<nome progetto>,public,main,information_schema
```

### Override per Progetti Specifici
Ogni progetto può personalizzare path, modelli e traduzioni tramite variabili d'ambiente.

## Test di Conformità

### Comando di Verifica
```bash
# Verifica path hardcoded
grep -r "/var/www/html/<nome progetto>" laravel/Modules/Xot/ --include="*.php"

# Verifica dipendenze hardcoded
grep -r "Modules\\<nome progetto>" laravel/Modules/Xot/ --include="*.php"

# Verifica traduzioni hardcoded
grep -r "<nome progetto>::" laravel/Modules/Xot/ --include="*.php"
```

### Risultato Atteso
Dopo l'ottimizzazione completa, i comandi devono restituire **0 occorrenze**.

## Documentazione Correlata

- [Root Docs: Modularity Hardcoded Names](../../../project_docs/modularity-hardcoded-names.md)
- [Regole Cursor: Modularity Rules](../../../.cursor/rules/modularity-hardcoded-names.mdc)
- [Xot Architecture Overview](./architecture-overview.md)
- [Xot Best Practices](./best-practices/README.md)

## Note di Implementazione

### Principi Guida
1. **Dependency Inversion**: Dipendere da configurazione, non da implementazioni
2. **Configuration over Convention**: Configurazione esplicita e flessibile
3. **Separation of Concerns**: Xot gestisce solo la base, non i progetti
4. **Environment-Driven**: Tutto configurabile tramite variabili d'ambiente

### Approccio
- **Incremental**: Ottimizzare un componente alla volta
- **Configuration-First**: Creare configurazione prima di implementare
- **Path-Agnostic**: Path completamente configurabili
- **Testing-Validated**: Verificare modularità con test specifici

---

**Queste ottimizzazioni sono CRITICHE per mantenere l'architettura modulare del sistema. Ogni violazione deve essere corretta immediatamente.**

