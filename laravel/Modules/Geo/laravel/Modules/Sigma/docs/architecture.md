# Architettura Modulo Sigma

> **Versione**: 2.0.0  
> **Ultimo aggiornamento**: Gennaio 2025  
> **Principio Fondamentale**: "Calcolare una volta, consultare mille volte"

## Panoramica Architetturale

Il modulo Sigma implementa un'architettura basata su **Delegation Cascade Pattern** per gestire calcoli complessi per le progressioni di carriera nella Pubblica Amministrazione.

### Gerarchia Modelli

```
Illuminate\Database\Eloquent\Model
  └── XotBaseModel                          # Modulo Xot
        └── BaseModel                       # Connessione 'generale', casts comuni
              └── BaseDateRangeModel        # CommonScope, timestamps=false
                    ├── Asz00k1             # rangeFromField()='asz2kd'
                    ├── Asz00f              # rangeFromField()='asz2kd' + SigmaModelTrait
                    ├── Qua00f              # rangeFromField()='qua2kd'
                    ├── Qua03f              # rangeFromField()='q32kd'
                    ├── Rep00f              # rangeFromField()='rep2kd'
                    └── Sto00f              # rangeFromField()='st2kas'
```

**Regola**: MAI `extends Model` direttamente. Usare `BaseModel` o `BaseDateRangeModel`.

### Contratti (Contracts)

**Naming**: suffisso `Contract`, MAI prefisso modulo (il namespace è sufficiente).

| Contratto | Metodi | Implementato da |
|---|---|---|
| `EnteMatrFieldsContract` | `matrField()`, `enteField()`, `yearField()` | `BaseModel` (default `'matr'`/`'ente'`) |
| `DateRangeFieldsContract` | `rangeFromField()`, `rangeToField()`, `annFieldName()` | `BaseDateRangeModel`; Ptv via `SchedaContract` |
| `SchedaContract` (Ptv) | extends `EnteMatrFieldsContract` + `DateRangeFieldsContract` | `BaseScheda` |

### Principio: Composizione Contratti (interface extends interface)

```php
// ❌ SBAGLIATO — la classe elenca tutti i contratti manualmente
abstract class BaseScheda extends BaseModel implements SchedaContract, EnteMatrFieldsContract, DateRangeFieldsContract

// ✅ CORRETTO — il contratto composito eredita dagli altri
interface SchedaContract extends EnteMatrFieldsContract, DateRangeFieldsContract {}
abstract class BaseScheda extends BaseModel implements SchedaContract
```

La classe dichiara **un solo** `implements` (il contratto di livello più alto). I sub-contratti sono ereditati dall'interface. Questo è DRY: se il requisito cambia, si aggiorna solo l'interface.

Filtro anno attivo sulle relazioni: `HasEnteMatrRelationHelpers::applyRelatedActiveAnnFilter()` legge `annFieldName()` dal modello related — **non** serve un contratto dedicato `QuaRelationAnn*`.

I trait di relazione (`EnteMatrRelationship`, `EnteMatrAnnoRelationship`, ecc.) usano `$this->matrField()` e `$this->{$this->enteField()}` invece di stringhe hardcodate. Il metodo `hasManyByEnteMatr()` in `BaseModel` è il DRY helper per le relazioni HasMany standard.

### Principio: MAI passare ciò che il modello sa già

```php
// ❌ SBAGLIATO — 'quaann' è ridondante, Qua00f lo sa già
$this->relatedByAnno(Qua00f::class, 'quaann');

// ✅ CORRETTO — hasManyByEnteMatr chiede al modello via contratto
$this->hasManyByEnteMatr(Qua00f::class);
```

`hasManyByEnteMatr()` chiama `applyRelatedActiveAnnFilter()` che interroga `$instance->annFieldName()` sul modello related. Il modello è l'unica fonte di verità per i propri nomi colonna.

### Componenti Principali

```
Sigma Module
├── Models/
│   ├── BaseModel.php              # Base per tutti i modelli Sigma
│   ├── BaseDateRangeModel.php     # Base per modelli con date range (dal/al/ann)
│   ├── Anag.php                   # Anagrafica dipendenti (317 modelli totali)
│   └── Traits/
│       ├── SchedaTrait.php        # ⚡ Orchestrator principale
│       ├── Mutators/              # Mutators per trasformazioni dati
│       ├── Relationships/          # Relazioni Eloquent
│       ├── Scopes/                # Query scopes
│       └── Helpers/
│           └── SchedaHelper.php   # Calcoli puri (delegation cascade)
├── Services/
│   ├── SigmaService.php          # Servizio integrazione Sigma Paghe
│   └── TxtdService.php           # Servizio gestione tracciati TXTD
├── Actions/
│   └── WebService/
│       ├── ImportJsonAction.php  # Importazione dati JSON
│       └── SyncModelAction.php    # Sincronizzazione modelli
└── Filament/
    ├── Resources/
    │   └── WebServiceResource.php
    └── Pages/
        ├── Dashboard.php
        ├── ImportCsv.php
        ├── SqlUpload.php
        └── WebService.php
```

## Delegation Cascade Pattern

### Filosofia

Il **Delegation Cascade Pattern** separa le responsabilità in layer gerarchici:

```
SchedaTrait (Orchestrator)
    ↓
├── SchedaMutator (Transformations)
│   ├── CommonMutator
│   ├── EnteMatrMutator
│   ├── EnteMatrAnnoMutator
│   ├── EnteMatrDateRangeMutator
│   └── EnteStabiMutator
│
├── SchedaRelationship (Relations)
│   ├── CommonRelationship
│   ├── EnteMatrRelationship
│   ├── EnteMatrAnnoRelationship
│   ├── EnteMatrDateRangeRelationship
│   ├── EnteStabiRelationship
│   └── TquRelationship
│
├── SchedaScope (Query Scopes)
│   └── CommonScope
│
└── SchedaHelper (Pure Calculations)
    ├── FunctionExtra (gg*Tot, hh*Tot - 6 metodi DB-heavy)
    └── MassExtra (Massa calculations)
```

### Vantaggi

1. **Separazione Responsabilità (SRP)**: Ogni trait ha una responsabilità unica
2. **Testabilità**: Metodi puri testabili isolatamente
3. **Riusabilità**: Helper riutilizzabili in altri contesti
4. **Manutenibilità**: Modifiche localizzate per dominio
5. **Leggibilità**: Codice organizzato per dominio logico

## Pattern Accessor con Denormalizzazione

### Architettura Accessor

Gli accessor implementano un pattern a 4 fasi:

```php
public function getFieldAttribute(?Type $value): ?Type
{
    // 1. ☯️ Cache Hit (Zen: zero calcolo)
    if ($value !== null && !request()->input('refresh', 0)) {
        return $value;
    }
    
    // 2. 🛡️ Guard (Protezione: no save senza PK)
    if ($this->getKey() === null) {
        return null;
    }
    
    // 3. 🧮 Pure Calculation (Delegation a metodo puro)
    $value = $this->getField(); // Metodo helper puro
    
    if ($value === null) {
        return null;
    }
    
    // 4. 💾 Surgical Persistence (update chirurgico)
    $this->update(['field' => $value]);
    
    return $value;
}
```

### Separazione Accessor → Metodo Puro

**Accessor** (`getFieldAttribute`):
- Responsabilità: Cache + Persistenza
- Side effects controllati (update chirurgico)
- Template pattern standard
- Integration point

**Metodo Puro** (`getField`):
- Responsabilità: SOLO calcolo
- No side effects
- Testabile isolatamente
- Riusabile

### Esempio Concreto

```php
// ✅ METODO PURO: Solo calcolo
protected function getGgAnno(): ?int
{
    if ($this->gg_presenza_anno === null || $this->gg_assenza_anno === null) {
        return null;
    }
    
    return $this->gg_presenza_anno - $this->gg_assenza_anno;
}

// ✅ ACCESSOR: Cache + Persistenza
public function getGgAnnoAttribute(?int $value): ?int
{
    // Cache hit
    if ($value !== null && !request()->input('refresh', false)) {
        return $value;
    }
    
    // Guard PK
    if ($this->getKey() === null) {
        return null;
    }
    
    // Delega a metodo puro
    $value = $this->getGgAnno();
    
    if ($value === null) {
        return null;
    }
    
    // Persist con update chirurgico
    $this->update(['gg_anno' => $value]);
    
    return $value;
}
```

## Struttura Database

### Connessione

Tutti i modelli Sigma utilizzano la connessione `generale`:

```php
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'generale';
}
```

### Tabella Principale: `schede`

**Connessione**: `progressione` (per modelli che estendono BaseScheda)

**Campi Chiave**:
- `id` (PK): Identificativo univoco
- `ente`, `matr`, `anno`: Chiavi business
- `dal`, `al`: Periodo valutazione
- `gg_*`: Campi calcolati giorni (denormalizzati)
- `perf_ind_*`: Performance anni specifici
- `perf_ind_media`: Media performance calcolata
- `totale`, `totale_pond`: Punteggi progressione
- `valutatore_id`: Responsabile valutazione

**Indici**:
- PRIMARY KEY (`id`)
- UNIQUE (`ente`, `matr`, `anno`)
- INDEX (`valutatore_id`)

## Integrazione con Moduli Esterni

### Moduli Dipendenti

Sigma è utilizzato da:

1. **Ptv** (`Modules\Ptv\Models\BaseScheda`)
   - Estende `SchedaTrait`
   - Gestisce schede progressioni PTV

2. **Progressioni** (`Modules\Progressioni\Models\Scheda`)
   - Estende `SchedaTrait`
   - Gestisce schede progressioni carriera

3. **IndennitaResponsabilita**
   - Utilizza modelli Sigma per calcoli indennità

4. **Incentivi**
   - Utilizza modelli Sigma per calcoli incentivi

### Moduli da cui Dipende

1. **Performance** (`Modules\Performance`)
   - Fornisce dati valutazione performance
   - Accesso a `Individuale` per calcoli media

2. **PresenzeAssenze** (tramite `Anag`)
   - Fornisce dati presenze/assenze
   - Calcoli giorni presenza/assenza

3. **User** (`Modules\User`)
   - Anagrafica dipendenti
   - Relazioni con modelli Sigma

## Flusso Dati

### 1. Importazione Dati

```
Sigma Paghe (Esterno)
    ↓
SigmaService::downloadSigmaFile()
    ↓
TxtdService::toArray()
    ↓
ImportJsonAction::execute()
    ↓
Database (connessione 'generale')
```

### 2. Calcolo Schede

```
BaseScheda (Ptv/Progressioni)
    ↓
SchedaTrait::getFieldAttribute()
    ↓
Cache Check → SchedaHelper::getField()
    ↓
Calcolo Puro (delegato ad Anag/Performance)
    ↓
update(['field' => $value])
    ↓
Database (denormalizzato)
```

### 3. Visualizzazione

```
Filament Resource
    ↓
BaseScheda::find($id)
    ↓
Accessor (cache hit)
    ↓
Valore denormalizzato (veloce)
```

## Performance Architecture

### Strategia Cache Multi-Livello

1. **Livello 1 - Attributo DB**: Valore calcolato salvato nel DB
2. **Livello 2 - Refresh Flag**: `?refresh=1` per ricalcolo forzato
3. **Livello 3 - Eager Loading**: Relazioni precaricate dove possibile

### Ottimizzazioni Implementate

- **Denormalizzazione**: Valori calcolati persistiti (-95% query)
- **Update Chirurgico**: Solo campo specifico (previene loop)
- **Eager Loading**: Relazioni precaricate (`with()`)
- **Query Optimization**: Indici su chiavi business

## Sicurezza e Audit

### Activity Log

Tutti i salvataggi tracciati via Spatie Activity Log:

```php
activity()
    ->performedOn($scheda)
    ->causedBy($user)
    ->log('Ricalcolato perf_ind_media');
```

### Autorizzazioni

- Import JSON: solo admin (`can:import-data`)
- Edit schede: solo valutatori assegnati
- View schede: dipendente + responsabili

## Best Practices

### DO ✅

- Utilizzare sempre metodi puri per calcoli
- Implementare guard su PK prima di save
- Usare `update()` invece di `save()` per persistenza chirurgica
- Documentare business logic nei metodi puri
- Testare metodi puri isolatamente

### DON'T ❌

- Non calcolare valori già presenti (cache hit)
- Non salvare senza PK (guard pattern)
- Non usare `save()` per singolo campo (usa `update()`)
- Non mescolare logica di calcolo e persistenza
- Non ignorare refresh flag quando necessario

## Collegamenti

- [Business Logic](./business-logic-analysis.md) - Regole business, normativa CCNL
- [Accessor Pattern](./accessor-pattern.md) - Pattern completo accessor
- [Performance](./performance.md) - Ottimizzazioni e benchmarks
- [Refactoring](./refactoring.md) - Storia refactoring e lessons learned

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Versione**: 2.0.0  
**Status**: ✅ Documentazione completa

