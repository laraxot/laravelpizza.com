# Analisi Approfondita Modulo Sigma

> **Data**: Gennaio 2025  
> **Versione**: 2.0.0  
> **Scopo**: Analisi completa business logic, architettura e integrazioni cross-module

## 📊 Executive Summary

Il modulo **Sigma** è il **cuore computazionale** del sistema PTVX per le progressioni di carriera nella Pubblica Amministrazione. Implementa un sistema di calcolo complesso basato su **denormalizzazione controllata** e **Delegation Cascade Pattern**.

### Metriche Chiave

- **317 modelli** totali (anagrafica dipendenti)
- **83 accessor** per valori calcolati denormalizzati
- **12+ metodi puri** per business logic isolata
- **4 moduli dipendenti** (Ptv, Progressioni, IndennitaResponsabilita, Incentivi)
- **Performance**: -95% query, -88% tempo edit page

## 🎯 Scopo e Business Logic

### Scopo Principale

Il modulo Sigma gestisce il **sistema di calcolo delle schede di valutazione** per le progressioni di carriera nella Pubblica Amministrazione, conformemente al **CCNL Comparto Funzioni Locali**.

### Filosofia Architetturale

> **"Calcolare una volta, consultare mille volte"** - Principio Zen del modulo Sigma

**Denormalizzazione Controllata**:
- Valori derivati complessi vengono calcolati e **persistiti** nel database
- Evita ricalcoli costosi su query complesse
- Ricalcolo on-demand con flag `refresh`
- Trade-off: Accessor che modificano stato (pattern non convenzionale ma necessario)

### Entità Principali

#### 1. Scheda

**Cosa rappresenta**: Una scheda di valutazione per un dipendente in un anno specifico.

**Attributi Core**:
- `id`, `ente`, `matr`, `anno`: Identificativi
- `dal`, `al`: Periodo di valutazione
- `propro`, `posfun`, `categoria_eco`: Categoria economica e posizione funzionale

**Attributi Calcolati (83 totali)**:
- `perf_ind_media`: Media performance individuale (aggregazione multi-anno)
- `gg_integ_params_asz`: Giorni assenza con parametri integrativi
- `gg_esperienza_no_asz`: Giorni esperienza senza assenze
- `gg_in_sede`, `gg_fuori_sede`: Giorni presenza
- `gg_anno`: Giorni effettivi annui
- `gg_cateco_*`: Giorni per categoria economica
- `gg_asz_*`: Giorni assenza per tipo
- `hh_asz_*`: Ore assenza per tipo
- ... +50 altri attributi calcolati

#### 2. Anag (Anagrafica)

**Cosa rappresenta**: Anagrafica dipendenti con 317 modelli totali.

**Modelli Principali**:
- `Anag`: Anagrafica principale
- `Ana02f`, `Ana10f`: Dati anagrafici aggiuntivi
- `Asz00f`, `Asz00k1`: Assenze
- `Qua00f`, `Qua03f`: Qualifiche
- `Rep00f`: Reparti
- `Sto00f`: Storico
- `Tqu00f`: Tabelle qualifiche
- `Wstr01lx`: Workstream

#### 3. IntegParam

**Cosa rappresenta**: Parametri integrativi per il calcolo delle indennità e progressioni.

**Utilizzo**: Definisce intervalli temporali e criteri per il conteggio giorni validabili.

## 🏗️ Architettura Delegation Cascade Pattern

### Struttura Gerarchica

```
SchedaTrait (Orchestrator - 2517 righe)
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
└── SchedaHelper (Pure Calculations - 715 righe)
    ├── FunctionExtra (gg*Tot, hh*Tot - 6 metodi pesanti DB)
    ├── MassExtra (Massa calculations)
    └── 34 helper inline methods
```

### Pattern Accessor con Persistenza

**Implementazione**:
```php
public function getPerfIndMediaAttribute(?float $value): ?float
{
    // 1. Cache hit
    if ($value !== null && ! request()->input('refresh', 0)) {
        return round($value, 2);
    }
    
    // 2. Guard: modello deve avere PK per salvare
    if ($this->getKey() == null) {
        return null;
    }
    
    // 3. Delega calcolo al metodo puro
    $value = $this->getPerfIndMedia();
    
    if ($value === null) {
        return null;
    }
    
    // 4. Persist con update chirurgico (salva SOLO questo campo)
    $this->update(['perf_ind_media' => $value]);
    
    return round($value, 2);
}
```

**Ciclo di Vita**:
1. **Creazione**: `getKey() === null` → accessor ritorna `null` senza salvare
2. **Primo salvataggio**: `save()` genera ID
3. **Accesso successivo**: `getKey() !== null` → calcola e salva automaticamente
4. **Refresh on-demand**: `request()->merge(['refresh' => 1])` → forza ricalcolo

## 💼 Calcoli Complessi Business Logic

### 1. Performance Individuale Media

**Business Rule**: Media aritmetica performance ultimi N anni (default 3).

**Normativa**: CCNL Art. 19 - Progressione basata su media triennale performance.

**Implementazione**:
```php
protected function getPerfIndMedia(): ?float
{
    $data = [];
    
    for ($i = 1; $i <= $this->n_perf_ind; $i++) {
        $anno = $this->anno - $i;
        $ris = $this->perfInd($anno);
        
        if ($ris > 0.0) {
            $data[$anno] = $ris;
        }
    }
    
    if (count($data) === 0) {
        return null;
    }
    
    return array_sum($data) / count($data);
}
```

**Delega a**: `perfInd($anno)` che interroga `Performance::Individuale` per anno specifico.

### 2. Giorni Esperienza Validi

**Business Rule**: Giorni categoria economica posfun - giorni assenza (esclusi aspettative).

**Normativa**: CCNL Art. 16 - Esperienza acquisita per progressione.

**Implementazione**:
```php
protected function getGgEsperienzaNoAsz(): ?int
{
    // Preferenza: usa gg_integ_params se disponibile
    if ($this->gg_integ_params != null) {
        $gg_totali = intval($this->gg_integ_params);
        $gg_assenza = intval($this->gg_integ_params_asz);
        
        return $gg_totali - $gg_assenza;
    }
    
    // Fallback: usa calcolo categoria economica
    return $this->gg_cateco_posfun_no_asz;
}
```

**Delega a**: 
- `getGgIntegParams()` → `Integparam` per periodo validabile
- `getGgIntegParamsAsz()` → `Anag::ggAssenzaInSedeTot()` per assenze

### 3. Giorni Presenza

**Business Rule**: Giorni con timbratura in sede + fuori sede, esclusi giorni assenza.

**Normativa**: Regolamento timbrature ente.

**Implementazione**:
```php
protected function getGgInSede(): ?int
{
    // Guard: anagrafica deve esistere
    if (! \is_object($this->anag)) {
        return null;
    }
    
    // Setup parametri periodo
    $parz = [
        'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
        'date_max' => $this->criteriOptionsArr('data_presenza_al'),
    ];
    
    // Calcolo puro delegato ad anagrafica
    return $this->anag->ggInSedeTot($parz);
}
```

**Delega a**: `Anag::ggInSedeTot()` che interroga `PresenzeAssenze` per timbrature.

### 4. Giorni Assenza per Tipo

**Business Rule**: Categorizzazione assenze per tipo (esclusione aspettative).

**Normativa**: Codici assenza CCNL.

**Implementazione**:
```php
protected function getGgAszInSede(): ?int
{
    // Setup lista aspettative da escludere
    $lista_aspettative = $this->getListaTipoCodiceAspettative();
    
    // Setup parametri query
    $parz = [
        'lista_tipo_codice' => $lista_aspettative,
        'date_min' => $this->criteriOptionsArr('data_presenza_dal'),
        'date_max' => $this->criteriOptionsArr('data_presenza_al'),
    ];
    
    $data = GgFilterData::from($parz);
    
    // Calcolo puro delegato ad anagrafica
    return $this->anag?->ggAssenzaInSedeTot($data);
}
```

**Delega a**: `Anag::ggAssenzaInSedeTot()` che interroga `Asz00f`/`Asz00k1` filtrati per tipo.

## 🔗 Integrazioni Cross-Module

### Moduli che Usano Sigma

#### 1. Ptv (`Modules\Ptv`)

**Utilizzo**: `BaseScheda` estende `SchedaTrait`

**Pattern**:
```php
abstract class BaseScheda extends BaseModel implements SchedaContract
{
    use SchedaTrait;
    
    public function anag()
    {
        return $this->hasOne(Anag::class, 'matr', 'matr');
    }
    
    public function perfInd(int $anno): ?float
    {
        $perf_ind = $this->performanceIndividuale()
            ->where('anno', $anno)
            ->selectRaw('...')
            ->first();
        
        return $perf_ind?->perf_ind ?? 0.0;
    }
}
```

**Accessor Utilizzati**:
- `perf_ind_media` - Media performance
- `gg_anno` - Giorni effettivi annui
- `gg_in_sede`, `gg_fuori_sede` - Giorni presenza
- `gg_asz_*` - Giorni assenza vari tipi

#### 2. Progressioni (`Modules\Progressioni`)

**Utilizzo**: `Schede` estende `SchedaTrait` con conflict resolution

**Pattern** (2026-06-15 — STORY-002):
```php
// BaseScheda (Ptv) implementa SchedaContract; il figlio solo extends
class Scheda extends BaseScheda
{
    use ProgressioniTrait;
    public int $n_perf_ind = 3;
}
```

Canon: [module-hierarchy-inheritance-pattern](../../../../docs/wiki/rules/module-hierarchy-inheritance-pattern.md)

**Modelli Sigma Utilizzati**:
- `Anag`, `Ana02f`, `Ana10f`
- `Asz00f`, `Asz00k1`
- `Qua00f`, `Qua03f`
- `Rep00f`, `Repart`
- `Sto00f`, `Tqu00f`, `Wstr01lx`

**Actions Sigma Utilizzate**:
- `MassUpdateCategoriaEcoAction`
- `MassUpdateCognomeNomeAction`
- `MassUpdatePosizTxtAction`
- `MassUpdateStabiTxtReparTxtAction`

#### 3. IndennitaResponsabilita (`Modules\IndennitaResponsabilita`)

**Utilizzo**: Utilizzo diretto modelli Sigma per calcoli

**Pattern**:
```php
class IndennitaResponsabilita extends BaseModel
{
    // Relazioni con modelli Sigma
    public function anag(): BelongsTo
    {
        return $this->belongsTo(Anag::class, 'matr', 'matr');
    }
    
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
- `Anag`, `Ana02f`, `Ana10f`
- `Asz00f`, `Asz00k1`
- `Qua00f`, `Qua03f`
- `Rep00f`, `Sto00f`, `Wstr01lx`

#### 4. Incentivi (`Modules\Incentivi`)

**Utilizzo**: Utilizzo modelli Sigma per gestione dipendenti e stabilimenti

**Pattern**:
```php
class StabiDirigente extends BaseModel
{
    // Relazioni con modelli Sigma
    // Utilizzo per gestione stabilimenti dirigenti
}
```

### Moduli da cui Dipende

#### 1. Performance (`Modules\Performance`)

**Utilizzo**: Fornisce dati valutazione performance per calcoli media

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

#### 2. PresenzeAssenze (tramite Anag)

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

#### 3. User (`Modules\User`)

**Utilizzo**: Anagrafica dipendenti e relazioni utenti

**Pattern**:
```php
// Relazione anagrafica
public function anag(): HasOne
{
    return $this->hasOne(Anag::class, 'matr', 'matr');
}
```

## 📈 Flusso Dati Cross-Module

### Calcolo Performance Media

```
Progressioni/Scheda
    ↓
SchedaTrait::getPerfIndMediaAttribute()
    ↓
SchedaHelper::getPerfIndMedia()
    ↓
SchedaTrait::perfInd($anno)
    ↓
BaseScheda::performanceIndividuale() (query)
    ↓
Performance::Individuale (modulo Performance)
    ↓
Risultato calcolato e persistito in schede.perf_ind_media
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
Risultato calcolato e persistito in schede.gg_in_sede
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

## 🔧 Pattern Architetturali Implementati

### 1. Delegation Cascade Pattern

**Separazione responsabilità**:
- **SchedaTrait**: Orchestrator puro (composizione trait)
- **SchedaMutator**: Accessor con lifecycle (cache, guard, persist)
- **SchedaHelper**: Calcoli puri senza side effects
- **SchedaRelationship**: Relazioni Eloquent tipizzate
- **SchedaScope**: Query scopes riusabili

### 2. Accessor Pattern with Persistence

**Pattern**:
```php
Accessor (Lifecycle) → Metodo Puro (Business Logic) → Risultato
      ↓                         ↓                           ↓
  Cache + Guard             Calcolo Puro                Valore
      ↓                         ↓                           ↓
  Persist DB              No Side Effects            Denormalizzato
```

**Vantaggi**:
- Performance drasticamente migliorate
- Consistenza garantita (ricalcolo automatico quando necessario)
- Testabilità (metodi puri isolati)

**Trade-off**:
- Logica non convenzionale (accessor che modifica stato)
- Richiede gestione attenta del ciclo di vita del modello

### 3. Pure Calculation Methods

**Metodi puri** in `SchedaHelper`:
- Nessun side effect
- Testabili isolatamente
- Riutilizzabili
- Delegation cascade a FunctionExtra e MassExtra

**Esempi**:
- `getPerfIndMedia()`: Media performance pura
- `getGgInSede()`: Giorni presenza pura
- `getGgEsperienzaNoAsz()`: Giorni esperienza pura

## 📋 Normativa CCNL Applicata

### Art. 16 - Esperienza Acquisita

**Regola**: Esperienza acquisita per progressione basata su giorni categoria economica posfun meno giorni assenza.

**Implementazione**: `getGgEsperienzaNoAsz()`

### Art. 19 - Progressione Performance

**Regola**: Progressione basata su media triennale performance individuale.

**Implementazione**: `getPerfIndMedia()`

### Regolamento Timbrature

**Regola**: Giorni presenza calcolati da timbrature in sede/fuori sede.

**Implementazione**: `getGgInSede()`, `getGgFuoriSede()`

### Codici Assenza CCNL

**Regola**: Categorizzazione assenze per tipo, esclusione aspettative.

**Implementazione**: Vari accessor `getGgAsz*` e `getHhAsz*`

## 🐛 Problemi Identificati e Soluzioni

### Critici (Priorità Alta)

#### 1. Complessità Elevata `Asz00k1::gg()`

**Problema**: 
- CC: 17 (threshold: 10)
- NPath: 6480 (threshold: 200)
- Uso di `extract()` problematico per PHPStan

**Soluzione Applicata**:
- ✅ Sostituito `extract()` con accesso esplicito array
- ✅ Inizializzazione esplicita variabili
- ✅ Guard clauses migliorate
- ⚠️ Refactoring completo necessario (dividere in metodi più piccoli)

#### 2. Undefined Variables `Dipt00f`

**Problema**: 
- Proprietà `$anag` non definita in PHPDoc
- Return types `mixed` invece di `string|null`

**Soluzione Applicata**:
- ✅ Aggiunto `@property-read Anag|null $anag`
- ✅ Decommentata relazione `anag()`
- ✅ Fixati return types accessor
- ✅ Aggiunto `@property \Carbon\Carbon|null $data_elab`

#### 3. Generics PHPStan

**Problema**: 
- Generics relazioni incomplete (`HasOne<Anag>` invece di `HasOne<Anag, static>`)

**Soluzione Applicata**:
- ✅ Aggiunto `TDeclaringModel` ai generics
- ✅ Fixati tutti i tipi relazioni

### Non Critici (Priorità Media)

#### 1. Static Access (40+ occorrenze)

**Status**: Accettabile (facades Laravel)

#### 2. CamelCase Naming (30+ occorrenze)

**Status**: Legacy code, refactoring graduale

#### 3. Unused Variables (10+ occorrenze)

**Status**: Cleanup periodico pianificato

## 📊 Metriche Performance

| Metrica | Prima | Dopo | Miglioramento |
|---------|-------|------|---------------|
| Edit scheda | 2.5s | 0.3s | **-88%** |
| List schede (100) | 15s | 1.2s | **-92%** |
| Calcolo media perf | 800ms | 5ms (cached) | **-99%** |
| Query per pagina | 200-300 | 7-15 | **-95%** |

## ✅ Punti di Forza

1. **Architettura Solida**:
   - Delegation Cascade Pattern ben implementato
   - Separazione responsabilità chiara
   - Metodi puri testabili

2. **Performance**:
   - Denormalizzazione efficace
   - Cache accessor funzionante
   - -95% query rispetto a versione precedente

3. **Documentazione**:
   - Documentazione completa e aggiornata
   - Esempi pratici
   - Business logic documentata

## 📝 Prossimi Passi Raccomandati

### Sprint 1: Refactoring Complessità (2-3 giorni)

- [ ] Refactoring `Asz00k1::gg()` in metodi più piccoli
- [ ] Refactoring `ImportJsonAction::execute()` (CC=19, NPath=37440)
- [ ] Test unitari nuovi metodi

### Sprint 2: Fix Errori PHPStan (1-2 giorni)

- [ ] Fix generics relazioni rimanenti
- [ ] Fix undefined properties
- [ ] Verifica PHPStan livello 10 completo

### Sprint 3: Code Smells Cleanup (1 giorno)

- [ ] Rimuovere unused variables
- [ ] Migliorare naming (camelCase) dove possibile

### Sprint 4: Test Coverage (3-4 giorni)

- [ ] Test unitari metodi puri
- [ ] Test integrazione accessor
- [ ] Test cross-module
- [ ] Target: 80%+ coverage

## 📚 Collegamenti Documentazione

- [Architecture](./architecture.md) - Architettura completa
- [Business Logic](./business-logic-analysis.md) - Regole business
- [Module Dependencies](./module-dependencies.md) - Dipendenze cross-module
- [Analysis Report](./analysis-report.md) - Report analisi completo
- [Quality Improvements](./quality-improvements.md) - Piano miglioramenti

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Status**: ✅ Analisi completata, Fix PHPStan critici applicati

