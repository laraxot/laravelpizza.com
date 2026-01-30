# Cross-Module Relations in Laraxot <nome progetto>

## Panoramica

Questo documento descrive l'architettura e l'implementazione delle relazioni tra moduli diversi nel sistema Laraxot <nome progetto>, con particolare focus sui RelationManager Filament che gestiscono entità cross-module.

## Architettura General

### Principi Fondamentali

1. **Separazione Domini**: Ogni modulo gestisce un dominio specifico
2. **Separazione UI/Logic**: Interfacce utente separate dai modelli di dominio  
3. **Cross-Database**: Relazioni che attraversano database diversi
4. **Modularità**: Ogni modulo può essere sviluppato/deployato indipendentemente

### Pattern Architetturale

```
┌─────────────────┐    ┌─────────────────┐
│    SaluteMo     │    │    <nome progetto>    │
│   (UI Module)   │    │ (Domain Module) │
├─────────────────┤    ├─────────────────┤
│ • Resources     │────│ • Models        │
│ • Relations     │    │ • Business      │
│ • Forms         │    │ • Pivots        │
│ • Tables        │    │ • Logic         │
└─────────────────┘    └─────────────────┘
```

## Relazioni Doctor-Studio

### Implementazione Multi-Module

#### <nome progetto> (Domain Module)
- **Responsabilità**: Modelli, relazioni, logica di business
- **Database**: `salute_ora` per Studio, `user` per Doctor
- **File**: 
  - `Modules/<nome progetto>/Models/Doctor.php`
  - `Modules/<nome progetto>/Models/Studio.php`
  - `Modules/<nome progetto>/Models/DoctorStudio.php`

#### SaluteMo (UI Module)  
- **Responsabilità**: Interfaccia Filament, RelationManager, Forms
- **File**:
  - `Modules/SaluteMo/Filament/Resources/DoctorResource.php`
  - `Modules/SaluteMo/Filament/Resources/StudioResource.php`
  - `Modules/SaluteMo/Filament/Resources/DoctorResource/RelationManagers/StudiosRelationManager.php`

### Struttura della Relazione

```php
// Doctor Model (<nome progetto>)
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}

// Studio Model (<nome progetto>)  
public function doctors(): BelongsToMany
{
    return $this->belongsToManyX(Doctor::class);
}

// RelationManager (SaluteMo)
class StudiosRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'studios';
    public static string $resourceClass = StudioResource::class;
}
```

## Cross-Database Considerations

### Configurazioni Database

```php
// Doctor (Database: user)
'doctor' => [
    'driver' => 'mysql',
    'database' => 'user_db',
    // ...
],

// Studio (Database: salute_ora)
'studio' => [
    'driver' => 'mysql', 
    'database' => 'salute_ora_db',
    // ...
],
```

### Pivot Table Location

La tabella pivot `doctor_studio` risiede nel database `salute_ora` per garantire:
- Coerenza referenziale con Studio
- Ottimizzazione query sanitarie
- Centralizzazione logica di business

### Limitazioni Cross-Database

1. **Transazioni**: Non supportate tra database diversi
2. **Foreign Keys**: Devono essere gestite a livello applicativo
3. **Joins**: Limitati, necessario eager loading
4. **Performance**: Query più complesse e potenzialmente più lente

## RelationManager Implementation

### Pattern XotBaseRelationManager

```php
abstract class XotBaseRelationManager extends FilamentRelationManager
{
    use HasXotTable;
    
    public function getTableColumns(): array
    {
        // Eredita colonne dalla risorsa collegata
        return $this->getResource()::getFormSchema();
    }
    
    public function getResource(): string
    {
        return static::$resourceClass;
    }
}
```

### Vantaggi del Pattern

1. **DRY**: Riuso configurazioni della risorsa principale
2. **Consistenza**: Stesse colonne in tabella e relazione
3. **Manutenibilità**: Modifiche centrali si propagano automaticamente
4. **Type Safety**: Controlli di tipo e validazione automatica

## Best Practices Cross-Module

### ✅ Conformità Laraxot

1. **Namespace Consistency**: 
   - Domain: `Modules\{Domain}\Models\`
   - UI: `Modules\{UI}\Filament\Resources\`

2. **No Hardcoded Labels**: Sempre traduzioni da file di lingua

3. **Base Class Extension**: 
   - Models: Extend `BaseModel` del modulo
   - RelationManagers: Extend `XotBaseRelationManager`

4. **Type Safety**: `declare(strict_types=1)` e PHPDoc completi

### ✅ Performance Optimization

1. **Eager Loading**: Precarica relazioni cross-database
```php
$doctors = Doctor::with('studios.address')->get();
```

2. **Query Scoping**: Limita query cross-database
```php
$doctor->studios()->active()->limit(10)->get();
```

3. **Caching**: Cache relazioni frequenti
```php
Cache::remember("doctor.{$id}.studios", 300, fn() => $doctor->studios);
```

## Testing Cross-Module Relations

### Database Setup

```php
// TestCase.php
protected function setUp(): void
{
    parent::setUp();
    
    // Setup multiple database connections
    $this->setUpMultipleDatabases();
    
    // Seed related data
    $this->seedCrossModuleData();
}
```

### Test Examples

```php
/** @test */
public function doctor_can_have_multiple_studios(): void
{
    $doctor = Doctor::factory()->create();
    $studios = Studio::factory()->count(3)->create();
    
    $doctor->studios()->attach($studios);
    
    $this->assertCount(3, $doctor->fresh()->studios);
}

/** @test */
public function relation_manager_shows_correct_columns(): void
{
    $doctor = Doctor::factory()->create();
    
    $relationManager = new StudiosRelationManager();
    $columns = $relationManager->getTableColumns();
    
    $this->assertArrayHasKey('name', $columns);
    $this->assertArrayHasKey('phone', $columns);
}
```

## Troubleshooting Common Issues

### Query Performance

**Problema**: Query lente cross-database
**Soluzione**: 
- Usare eager loading
- Implementare caching
- Limitare risultati con scoping

### Consistency Issues

**Problema**: Dati inconsistenti tra moduli
**Soluzione**:
- Implementare eventi Eloquent
- Usare jobs per sincronizzazione
- Aggiungere validation a livello applicativo

### Testing Complexity

**Problema**: Test complessi con multiple database
**Soluzione**:
- Usare database in-memory per test
- Mock delle relazioni complesse
- Factory dedicate per setup cross-module

## Documentazione Correlata

### Moduli Specifici
- [SaluteMo RelationManager](/var/www/html/base_<nome progetto>/laravel/Modules/SaluteMo/docs/filament/relationmanagers.md)
- [<nome progetto> RelationManager](/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/docs/relationmanagers.md)
- [Doctor Model](/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/docs/models/doctor.md)
- [Studio Model](/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/docs/models/studio.md)

### Framework Documentation
- [Filament Best Practices](/var/www/html/base_<nome progetto>/docs/filament-best-practices.md)
- [Laraxot Conventions](/var/www/html/base_<nome progetto>/docs/laraxot-conventions.md)
- [Module Structure](/var/www/html/base_<nome progetto>/docs/module-structure.md)

---

*Ultimo aggiornamento: Gennaio 2025*  
*Versione: 1.0*  
*Compatibilità: Laraxot <nome progetto>, Filament 4.x, Laravel 10+* 