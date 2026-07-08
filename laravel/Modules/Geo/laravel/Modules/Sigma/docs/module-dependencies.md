# Dipendenze Modulo Sigma

> **Ultimo aggiornamento**: Gennaio 2025  
> **Scopo**: Documentare come altri moduli utilizzano Sigma e le sue componenti

## Panoramica Dipendenze

Il modulo Sigma è utilizzato da **4 moduli principali** per calcoli e gestione dati:

1. **Ptv** - Progressioni PTV
2. **Progressioni** - Progressioni carriera
3. **IndennitaResponsabilita** - Calcoli indennità responsabilità
4. **Incentivi** - Calcoli incentivi

## Moduli che Usano Sigma

### 1. Ptv (`Modules\Ptv`)

**Utilizzo Principale**: `BaseScheda` estende `SchedaTrait`

**File Chiave**:
- `app/Models/BaseScheda.php`

**Pattern di Utilizzo**:
```php
abstract class BaseScheda extends BaseModel implements SchedaContract
{
    use SchedaTrait;
    
    // Relazioni con modelli Sigma
    public function anag()
    {
        return $this->hasOne(Anag::class, 'matr', 'matr');
    }
    
    // Utilizzo accessor SchedaTrait
    public function perfInd(int $anno): ?float
    {
        // Calcolo performance utilizzando relazioni Sigma
        $perf_ind = $this->performanceIndividuale()
            ->where('anno', $anno)
            ->selectRaw('...')
            ->first();
        
        return $perf_ind?->perf_ind ?? 0.0;
    }
}
```

**Modelli Sigma Utilizzati**:
- `Modules\Sigma\Models\Anag` - Anagrafica dipendenti
- `Modules\Sigma\Models\Traits\SchedaTrait` - Trait principale

**Accessor Utilizzati**:
- `perf_ind_media` - Media performance
- `gg_anno` - Giorni effettivi annui
- `gg_in_sede`, `gg_fuori_sede` - Giorni presenza
- `gg_asz_*` - Giorni assenza vari tipi

### 2. Progressioni (`Modules\Progressioni`)

**Utilizzo Principale**: `Scheda` estende `BaseScheda` (che implementa `SchedaContract`).

**File Chiave**:
- `app/Models/Scheda.php` (eredita da BaseScheda)

**Pattern di Utilizzo**:
```php
class Scheda extends BaseScheda
{
    use ProgressioniTrait; // Contiene aszEff(), criteriEsclusione, etc.
}
```

---

## Sigma Module — Refactor Prioritario (Story separata)

**Problema:** Model `Asz00k1`, `Qua00f`, `Qua03f`, `Rep00f` estendono `Model` invece di `BaseDateRangeModel`.

**Errore:** Violazione architettura Sigma — tutti i model con date range devono ereditare da `BaseDateRangeModel`.

**Soluzione:** Refactoring mirato su 15+ model, sostituendo `extends Model` con `extends BaseDateRangeModel`.

**Modelli Sigma Utilizzati**:
- `Modules\Sigma\Models\Anag`
- `Modules\Sigma\Models\Ana02f`, `Ana10f`
- `Modules\Sigma\Models\Asz00f`, `Asz00k1`
- `Modules\Sigma\Models\Qua00f`, `Qua03f`
- `Modules\Sigma\Models\Rep00f`, `Repart`
- `Modules\Sigma\Models\Sto00f`
- `Modules\Sigma\Models\Tqu00f`
- `Modules\Sigma\Models\Wstr01lx`
- `Modules\Sigma\Models\Traits\SchedaTrait`
- `Modules\Sigma\Models\Traits\SigmaModelTrait`

**Actions Sigma Utilizzate**:
- `Modules\Sigma\Actions\MassUpdateCategoriaEcoAction`
- `Modules\Sigma\Actions\MassUpdateCognomeNomeAction`
- `Modules\Sigma\Actions\MassUpdatePosizTxtAction`
- `Modules\Sigma\Actions\MassUpdateStabiTxtReparTxtAction`

**Relazioni Sigma Utilizzate**:
- `Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship`
- `Modules\Sigma\Models\Traits\Relationships\EnteMatrYearRelationship`

### 3. IndennitaResponsabilita (`Modules\IndennitaResponsabilita`)

**Utilizzo Principale**: Utilizzo diretto di modelli Sigma per calcoli

**File Chiave**:
- `app/Models/IndennitaResponsabilita.php`
- `app/Models/LettF.php`
- `app/Models/LettI.php`

**Pattern di Utilizzo**:
```php
class IndennitaResponsabilita extends BaseModel
{
    // Importazione diretta modelli Sigma
    use Modules\Sigma\Models\Anag;
    use Modules\Sigma\Models\Ana02f;
    use Modules\Sigma\Models\Ana10f;
    use Modules\Sigma\Models\Asz00f;
    use Modules\Sigma\Models\Qua00f;
    use Modules\Sigma\Models\Qua03f;
    use Modules\Sigma\Models\Rep00f;
    use Modules\Sigma\Models\Sto00f;
    use Modules\Sigma\Models\Asz00k1;
    use Modules\Sigma\Models\Wstr01lx;
    use Modules\Ptv\Models\BaseScheda; // Indiretto tramite Ptv
    
    // Relazioni con modelli Sigma
    public function anag(): BelongsTo
    {
        return $this->belongsTo(Anag::class, 'matr', 'matr');
    }
    
    public function ana10f(): HasOne
    {
        return $this->hasOne(Ana10f::class, 'matr', 'matr');
    }
    
    // Utilizzo per calcoli indennità
    public function calculateIndennita()
    {
        // Utilizza dati da modelli Sigma
        $anag = $this->anag;
        $qua00f = $this->qua00f;
        // ... calcoli complessi
    }
}
```

**Modelli Sigma Utilizzati**:
- `Modules\Sigma\Models\Anag` - Anagrafica
- `Modules\Sigma\Models\Ana02f`, `Ana10f` - Dati anagrafici
- `Modules\Sigma\Models\Asz00f`, `Asz00k1` - Assenze
- `Modules\Sigma\Models\Qua00f`, `Qua03f` - Qualifiche
- `Modules\Sigma\Models\Rep00f` - Reparti
- `Modules\Sigma\Models\Sto00f` - Storico
- `Modules\Sigma\Models\Wstr01lx` - Workstream

**Trait Utilizzati**:
- `Modules\IndennitaResponsabilita\Models\Traits\FunctionTrait` - Funzioni calcolo
- `Modules\IndennitaResponsabilita\Models\Traits\RelationshipTrait` - Relazioni

### 4. Incentivi (`Modules\Incentivi`)

**Utilizzo Principale**: Utilizzo modelli Sigma per gestione dipendenti e stabilimenti

**File Chiave**:
- `app/Models/StabiDirigente.php`
- `app/Models/Employee.php`
- `app/Filament/Resources/StabiDirigenteResource/Pages/ListStabiDirigentes.php`
- `app/Filament/Resources/EmployeeResource/Actions/UploadEmpoyeesAction.php`

**Pattern di Utilizzo**:
```php
class StabiDirigente extends BaseModel
{
    // Relazioni con modelli Sigma
    // Utilizzo per gestione stabilimenti dirigenti
}

class Employee extends BaseModel
{
    // Utilizzo modelli Sigma per anagrafica dipendenti
    // Importazione dati da Sigma Paghe
}
```

**Modelli Sigma Utilizzati**:
- Modelli anagrafici per gestione dipendenti
- Modelli per importazione dati da Sigma Paghe

## Moduli da cui Dipende Sigma

### 1. Performance (`Modules\Performance`)

**Utilizzo**: Fornisce dati valutazione performance per calcoli media

**Modelli Utilizzati**:
- `Modules\Performance\Models\Individuale` - Performance individuale
- `Modules\Performance\Models\Performance` - Performance generale

**Pattern**:
```php
// In SchedaTrait
public function performanceIndividuale()
{
    return $this->hasMany(Performance::class, 'matr', 'matr')
        ->where('ente', $this->ente ?? 90);
}

public function perfInd(int $anno): ?float
{
    $perf_ind = $this->performanceIndividuale()
        ->where('anno', $anno)
        ->selectRaw('...')
        ->first();
    
    return $perf_ind?->perf_ind ?? null;
}
```

### 2. PresenzeAssenze (tramite Anag)

**Utilizzo**: Fornisce dati presenze/assenze per calcoli giorni

**Pattern**:
```php
// In SchedaHelper
protected function getGgInSede(): ?int
{
    $parz = [
        'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
        'date_max' => $this->criteriOptionsArr('data_presenza_al'),
    ];
    
    $data = GgFilterData::from($parz);
    
    // Delegazione ad Anag che utilizza PresenzeAssenze
    return $this->anag?->ggInSedeTot($data);
}
```

### 3. User (`Modules\User`)

**Utilizzo**: Anagrafica dipendenti e relazioni utenti

**Pattern**:
```php
// Relazione anagrafica
public function anag(): HasOne
{
    return $this->hasOne(Anag::class, 'matr', 'matr');
}
```

## Flusso Dati Cross-Module

### Calcolo Performance Media

```
Progressioni/Scheda
    ↓
SchedaTrait::getPerfIndMediaAttribute()
    ↓
SchedaHelper::getPerfIndMedia()
    ↓
BaseScheda::perfInd($anno)
    ↓
Performance::Individuale (query)
    ↓
Risultato calcolato e persistito
```

### Calcolo Giorni Presenza

```
Ptv/BaseScheda
    ↓
SchedaTrait::getGgInSedeAttribute()
    ↓
SchedaHelper::getGgInSede()
    ↓
Anag::ggInSedeTot($data)
    ↓
PresenzeAssenze (query timbrature)
    ↓
Risultato calcolato e persistito
```

### Calcolo Indennità Responsabilità

```
IndennitaResponsabilita
    ↓
Utilizzo diretto modelli Sigma
    ↓
Anag, Qua00f, Asz00f, etc.
    ↓
Calcoli complessi
    ↓
Risultato persistito
```

## Best Practices Cross-Module

### DO ✅

- Utilizzare sempre `SchedaTrait` per calcoli schede
- Eseguire eager loading relazioni Sigma quando possibile
- Utilizzare accessor denormalizzati invece di ricalcoli
- Documentare dipendenze cross-module

### DON'T ❌

- Non duplicare logica calcolo già presente in Sigma
- Non bypassare accessor per calcoli diretti
- Non creare relazioni circolari tra moduli
- Non ignorare cache accessor quando non necessario

## Gestione Conflict Resolution

> **Nota (2026-06-15):** Progressioni\Scheda ora estende BaseScheda direttamente, eliminando i conflitti trait. `ProgressioneSchedaContract` rimosso - Scheda eredita SchedaContract da BaseScheda.

```php
use SchedaTrait, SigmaModelTrait {
    SchedaTrait::ggInSedeTot insteadof SigmaModelTrait;
    SchedaTrait::ggFuoriSedeTot insteadof SigmaModelTrait;
    // ... altri metodi
}
```

**Motivazione**: `SchedaTrait` contiene implementazioni più complete e ottimizzate.

## Testing Cross-Module

### Test Integrazione

```php
test('Progressioni utilizza correttamente SchedaTrait', function () {
    $scheda = Progressioni\Scheda::factory()->create([
        'ente' => 90,
        'matr' => 12345,
        'anno' => 2025,
    ]);
    
    // Test accessor SchedaTrait
    expect($scheda->perf_ind_media)->toBeFloat();
    expect($scheda->gg_anno)->toBeInt();
    
    // Test relazioni Sigma
    expect($scheda->anag)->toBeInstanceOf(Sigma\Anag::class);
});
```

## Documentazione Correlata

- [Architecture](./architecture.md) - Architettura Sigma
- [Business Logic](./business-logic-analysis.md) - Regole business
- [Accessor Pattern](./accessor-pattern.md) - Pattern accessor
- [Performance](./performance.md) - Ottimizzazioni cross-module

## Collegamenti Esterni

- [Ptv Documentation](../../Ptv/docs/README.md)
- [Progressioni Documentation](../../Progressioni/docs/README.md)
- [IndennitaResponsabilita Documentation](../../IndennitaResponsabilita/docs/README.md)
- [Incentivi Documentation](../../Incentivi/docs/README.md)

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Status**: ✅ Documentazione completa

