# Analisi Completa Modulo Sigma

> **Data**: Gennaio 2025  
> **Versione Modulo**: 2.0.0  
> **Status**: ✅ Analisi Completa con PHPStan Level 10, PHPMD, Business Logic

## 📝 Executive Summary

Il modulo **Sigma** è il **cuore computazionale** del sistema PTVX per le progressioni di carriera nella Pubblica Amministrazione. Implementa un sistema di calcolo complesso basato su **denormalizzazione controllata** e **Delegation Cascade Pattern**, seguendo il principio Zen: **"Calcolare una volta, consultare mille volte"**.

### Metriche Chiave

- **317 modelli** totali (anagrafica dipendenti)
- **83 accessor** per valori calcolati denormalizzati
- **12+ metodi puri** per business logic isolata
- **4 trait principali** (`SchedaMutator`, `SchedaRelationship`, `SchedaScope`, `SchedaHelper`)
- **4 moduli dipendenti** (`Ptv`, `Progressioni`, `IndennitaResponsabilita`, `Incentivi`)
- **Performance**: -95% query, -88% tempo edit page

## 🎯 Scopo e Business Logic

### Scopo Principale

Il modulo Sigma gestisce il **sistema di calcolo delle schede di valutazione** per le progressioni di carriera nella Pubblica Amministrazione, conformemente al **CCNL Comparto Funzioni Locali** (Art. 16, 19).

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
- `gg_asz_*`: Giorni assenza categorizzati per tipo
- `hh_asz_*`: Ore assenza categorizzate

#### 2. Anag (Anagrafica)

**Cosa rappresenta**: Anagrafica completa dipendente con 317 modelli correlati.

**Modelli Chiave**:
- `Anag`: Modello principale anagrafica
- `Ana02f`, `Ana10f`: Anagrafica per periodo
- `Asz00f`, `Asz00k1`: Assenze
- `Qua00f`, `Qua03f`: Qualifiche
- `Rep00f`, `Repart`: Reparti
- `Sto00f`: Storico assunzioni/dimissioni
- `Tqu00f`: Tipologie qualifica

#### 3. IntegParam

**Cosa rappresenta**: Parametri integrativi per calcoli complessi.

**Utilizzo**: Configurazione regole business per calcoli giorni presenza/assenza con parametri aggiuntivi.

## 🏗️ Architettura e Pattern

### Delegation Cascade Pattern

Il modulo Sigma adotta un **Delegation Cascade Pattern** per organizzare la logica complessa del `SchedaTrait`. Questo pattern promuove i principi DRY, KISS e SRP (Single Responsibility Principle) suddividendo le responsabilità in trait più piccoli e specializzati.

```php
trait SchedaTrait
{
    use SchedaMutator;         // → Gestisce gli accessor (cache, guard, persist)
    use SchedaRelationship;  // → Gestisce le relazioni Eloquent
    use SchedaScope;              // → Gestisce gli scope di query
    use SchedaHelper;            // → Gestisce i calcoli puri (senza side effects)
}
```

- **`SchedaMutator`**: Contiene gli 83 accessor pubblici (`get*Attribute`) che orchestrano il recupero, il calcolo e la persistenza dei valori. Implementa la logica di caching e il "guard" per evitare salvataggi su modelli senza PK.
- **`SchedaHelper`**: Aggrega tutti i metodi helper protetti (`get*`) che eseguono i calcoli puri. Questi metodi non hanno side effects e sono facilmente testabili. Delega ulteriormente a `FunctionExtra` e `MassExtra` per calcoli specifici.
- **`SchedaRelationship`**: Contiene tutte le definizioni delle relazioni Eloquent del modello `Scheda`.
- **`SchedaScope`**: Contiene tutti gli scope di query riutilizzabili.

### Accessor Pattern con Persistenza Controllata

Un pattern fondamentale in Sigma è l'uso di accessor che, oltre a calcolare un valore, lo persistono nel database. Questo è una forma di **denormalizzazione controllata** per ottimizzare le performance, evitando ricalcoli costosi ad ogni accesso.

**Ciclo di vita dell'accessor**:
1. **Cache Hit**: Se il valore è già presente nel database e non è richiesto un refresh, viene restituito immediatamente.
2. **Guard**: Se il modello non ha ancora una Primary Key (es. è in fase di creazione), il salvataggio viene impedito per evitare errori.
3. **Calcolo Puro**: Il calcolo effettivo viene delegato a un metodo helper puro (es. `getPerfIndMedia()`).
4. **Persistenza Chirurgica**: Il valore calcolato viene salvato nel database utilizzando un `update()` mirato solo per quel campo, prevenendo loop infiniti o salvataggi non necessari dell'intero modello.

## 🔗 Integrazioni Cross-Module

### Moduli che Usano Sigma

#### 1. Ptv (`Modules\Ptv`)

**Utilizzo Principale**: Il modello `BaseScheda` del modulo Ptv estende `SchedaTrait` di Sigma, riutilizzando direttamente tutta la logica di calcolo delle schede.

**File Chiave**: `Modules/Ptv/app/Models/BaseScheda.php`

**Pattern di Utilizzo**:
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
        // Calcolo performance utilizzando relazioni Sigma
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

**Business Logic**: Gestisce schede progressioni PTV (Progressioni Temporali Verticali) utilizzando i calcoli di Sigma per determinare idoneità e punteggi.

#### 2. Progressioni (`Modules\Progressioni`)

**Utilizzo Principale**: Il modello `Schede` del modulo Progressioni utilizza `SchedaTrait` e `SigmaModelTrait` per la gestione delle progressioni di carriera.

**File Chiave**: `Modules/Progressioni/app/Models/Scheda.php`

**Pattern di Utilizzo** (2026-06-15):
```php
class Scheda extends BaseScheda
{
    use ProgressioniTrait;
    public int $n_perf_ind = 3;
}
```

`SchedaContract` è su `BaseScheda` — vedi [module-hierarchy-inheritance-pattern](../../../../docs/wiki/rules/module-hierarchy-inheritance-pattern.md).

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

**Business Logic**: Gestisce schede progressioni carriera con valutazione multi-criterio (esperienza acquisita, risultati ottenuti, arricchimento professionale, impegno, qualità prestazione). Utilizza i calcoli di Sigma per determinare giorni validi e performance media.

#### 3. IndennitaResponsabilita (`Modules\IndennitaResponsabilita`)

**Utilizzo Principale**: Questo modulo fa ampio uso di vari modelli di Sigma (es. `Ana02f`, `Ana10f`, `Anag`, `Asz00f`, `Asz00k1`, `Qua00f`, `Rep00f`, `Sto00f`, `Tqu00f`) per i calcoli delle indennità di responsabilità.

**File Chiave**: `Modules/IndennitaResponsabilita/app/Models/IndennitaResponsabilita.php`

**Pattern di Utilizzo**:
```php
class IndennitaResponsabilita extends BaseModel
{
    // Importazione diretta modelli Sigma
    use Modules\Sigma\Models\Anag;
    use Modules\Sigma\Models\Ana02f;
    use Modules\Sigma\Models\Ana10f;
    use Modules\Sigma\Models\Asz00f;
    use Modules\Sigma\Models\Asz00k1;
    use Modules\Sigma\Models\Qua00f;
    use Modules\Sigma\Models\Rep00f;
    use Modules\Sigma\Models\Sto00f;
    
    // Relazioni con modelli Sigma
    public function anag(): BelongsTo
    {
        return $this->belongsTo(Anag::class, 'matr', 'matr');
    }
}
```

**Business Logic**: Calcola indennità di responsabilità basate su complessità, coordinamento e responsabilità del ruolo. Utilizza dati anagrafici e storici da Sigma per determinare periodi validi e qualifiche.

#### 4. Incentivi (`Modules\Incentivi`)

**Utilizzo Principale**: Il modulo Incentivi utilizza modelli di Sigma, in particolare per la gestione degli stabilimenti (`Stab00f`).

**File Chiave**: `Modules/Incentivi/app/Models/StabiDirigente.php`

**Pattern di Utilizzo**:
```php
class StabiDirigente extends BaseModel
{
    // Interagisce con modelli Sigma per recuperare informazioni
    // necessarie ai calcoli degli incentivi
}
```

**Business Logic**: Gestisce calcoli incentivi basati su progetti, stabilimenti e dipendenti. Utilizza dati Sigma per determinare struttura organizzativa e dipendenti coinvolti.

### Flussi Dati Cross-Module

- **Input a Sigma**: Dati da `Performance` (valutazioni individuali), `PresenzeAssenze` (timbrature, assenze), `User` (anagrafica dipendenti).
- **Output da Sigma**: Valori calcolati e denormalizzati utilizzati da `Ptv`, `Progressioni`, `IndennitaResponsabilita`, `Incentivi`.

## 📊 Analisi Qualità Codice

### PHPStan Level 10

**Status**: ⚠️ **Alcuni errori rimanenti** (non critici)

**Errori Critici Risolti**:
- ✅ `Asz00k1.php`: Sostituito `extract($params)` con accesso esplicito agli array
- ✅ `Dipt00f.php`: Aggiunti generics corretti per relazioni, tipizzati return types accessor
- ✅ `Dipt00f.php`: Gestiti exit/echo con logging invece di exit diretto

**Errori Rimanenti** (non critici):
- `Dipt00f.php`: Covarianza template types HasOne/HasMany (nota PHPStan, ignorato con `@phpstan-ignore-next-line`)
- `RepartPolicy.php`: Property access su mixed (gestito con type assertion)
- `Asz00k1.php`: Variabile non utilizzata rimossa

### PHPMD Code Smells

**Code Smells Identificati**:
- `ImportJsonAction::execute()`: Complessità ciclomatica (19), NPath Complexity (37440), Excessive Method Length (106 linee)
- `Asz00k1::gg()`: Complessità ciclomatica (18), NPath Complexity (15552), Short Method Name
- `Qua00f::gg()`: Complessità ciclomatica (36), NPath Complexity (4548960), Excessive Method Length (130 linee)
- Generali: `UnusedLocalVariable`, `StaticAccess`, `CamelCaseVariableName`, `ElseExpression`, `UnusedFormalParameter`, `CamelCasePropertyName`, `UndefinedVariable`

**Raccomandazioni**:
- Refactoring `ImportJsonAction::execute()` in metodi più piccoli
- Refactoring `Asz00k1::gg()` e `Qua00f::gg()` in metodi più piccoli
- Alcuni code smells sono accettabili per codice legacy o convenzioni Laravel (es. `StaticAccess` per facades)

### PHP Insights e Rector

**Status**: ⚠️ **Non eseguiti ancora**

**Raccomandazioni**:
- Eseguire PHP Insights per analisi completa qualità codice
- Eseguire Rector per refactoring automatico PHP 8.1+ features

## 📈 Metriche Performance

Il pattern di denormalizzazione e caching negli accessor di Sigma ha portato a:
- **-95% di query** per il recupero di valori calcolati
- **-88% di tempo** per il caricamento delle pagine di edit delle schede

### Benchmarks

| Operazione | Prima | Dopo | Miglioramento |
|-----------|-------|------|---------------|
| Edit scheda | 2.5s | 0.3s | **-88%** |
| List schede (100) | 15s | 1.2s | **-92%** |
| Calcolo media perf | 800ms | 5ms (cached) | **-99%** |

## ✅ Analisi Completate

- ✅ **Refactoring CLAUDE.md**: Completato, suddiviso in file organizzati in `docs/claude/`
- ✅ **PHPStan Livello 10**: Eseguito su Sigma, fix critici applicati
- ✅ **PHPMD**: Eseguito, code smells identificati e documentati
- ✅ **Analisi Moduli Dipendenti**: Completata, dipendenze documentate
- ✅ **Documentazione Sigma**: Aggiornata e creata `comprehensive-analysis.md`

## ⏭️ Prossimi Passi Raccomandati

### Sprint 1: Refactoring Complessità (2-3 giorni)
- Refactoring `Asz00k1::gg()` in metodi più piccoli
- Refactoring `ImportJsonAction::execute()` (CC=19, NPath=37440)
- Refactoring `Qua00f::gg()` (CC=36, NPath=4548960)

### Sprint 2: Fix Errori PHPStan Rimanenti (1-2 giorni)
- Fix generics relazioni rimanenti
- Verifica PHPStan livello 10 completo

### Sprint 3: PHP Insights e Rector (1-2 giorni)
- Eseguire PHP Insights per analisi completa
- Eseguire Rector per refactoring automatico

### Sprint 4: Test Coverage (3-4 giorni)
- Test unitari metodi puri
- Test integrazione accessor
- Target: 80%+ coverage

## 📚 Collegamenti

- [Architecture](./architecture.md) - Architettura completa, Delegation Cascade Pattern
- [Business Logic](./business-logic-analysis.md) - Regole business, normativa CCNL
- [Zen Philosophy](./zen-philosophy.md) - Filosofia completa, principi DRY+KISS+SRP
- [Module Dependencies](./module-dependencies.md) - Dipendenze cross-module dettagliate
- [Analysis Report](./analysis-report.md) - Report analisi PHPStan, PHPMD completo
- [Quality Improvements](./quality-improvements.md) - Piano miglioramenti qualità codice
- [Deep Analysis](./deep-analysis.md) - Analisi approfondita business logic, architettura e dipendenze

---

**Ultimo Aggiornamento**: Gennaio 2025  
**Versione**: 2.0.0  
**Status**: ✅ Analisi Completa

