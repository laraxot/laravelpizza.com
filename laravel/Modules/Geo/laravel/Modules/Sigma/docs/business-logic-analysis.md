# Business Logic - Module Sigma

## Scopo del Modulo

Il modulo **Sigma** gestisce il **sistema di calcolo delle schede di valutazione** per le progressioni di carriera nella Pubblica Amministrazione.

### Perché Sigma?

**Sigma (Σ)** rappresenta il simbolo matematico della sommatoria - appropriato per un modulo che:
- **Aggrega** dati da multiple fonti (presenze, assenze, performance, integparam)
- **Calcola** valori derivati complessi
- **Persiste** risultati per ottimizzazione performance
- **Supporta** decisioni su progressioni di carriera

## Filosofia Architetturale

### Denormalizzazione Controllata

> "Calcolare una volta, consultare mille volte."

**Principio**: Valori derivati complessi vengono calcolati e **persistiti** per evitare ricalcoli costosi.

**Trade-off**:
- ✅ **PRO**: Performance drasticamente migliorate su query complesse
- ✅ **PRO**: Consistenza garantita (ricalcolo on-demand con flag refresh)
- ⚠️ **CON**: Accessor che modificano stato (pattern non convenzionale)
- ⚠️ **CON**: Richiede gestione attenta del ciclo di vita del modello

### Pattern Accessor con Salvataggio

**Documentazione completa**: Vedere [scheda-trait-accessor-pattern.md](./scheda-trait-accessor-pattern.md)

**Implementazione**:
```php
public function getCalcolatoAttribute(?float $value): ?float
{
    // 1. Cache hit
    if (null !== $value && ! request()->input('refresh', 0)) {
        return $value;
    }
    
    // 2. Guard sulla PK (FIX Duplicate Entry Error)
    if ($this->getKey() === null) {
        return null;
    }
    
    // 3. Calcolo
    $value = $this->calcolaValore();
    
    // 4. Persistenza
    $this->attributes['calcolato'] = $value;
    $this->save(); // Salvataggio sicuro
    
    return $value;
}
```

## Entità Principali

### Scheda

**Cosa rappresenta**: Una scheda di valutazione per un dipendente in un anno specifico.

**Attributi Core**:
- `id`: Primary Key
- `ente`: Codice ente PA
- `matr`: Matricola dipendente
- `anno`: Anno di riferimento
- `dal`, `al`: Periodo di valutazione

**Attributi Calcolati**:
- `perf_ind_media`: Media performance individuale (aggregazione multi-anno)
- `gg_integ_params_asz`: Giorni assenza con parametri integrativi
- `gg_esperienza_no_asz`: Giorni esperienza senza assenze
- `gg_in_sede`: Giorni di presenza in sede
- `gg_fuori_sede`: Giorni di presenza fuori sede
- `gg_anno`: Giorni effettivi annui
- ... +50 altri attributi calcolati

**Relazioni**:
- `anag` → Anagrafica dipendente (modulo User/Anagrafica)
- `integParams` → Parametri integrativi (tabella integparam)
- `qua00fs` → Codici qualifica
- `stipendioTabellare` → Tabelle stipendiali

### IntegParam

**Cosa rappresenta**: Parametri integrativi per il calcolo delle indennità e progressioni.

**Utilizzo**: Definisce intervalli temporali e criteri per il conteggio giorni validabili.

## Workflow Business

### 1. Creazione Scheda

```php
// Fase 1: Creazione scheda vuota
$scheda = new Scheda([
    'ente' => 90,
    'matr' => 21870,
    'anno' => 2025,
]);

// Gli accessor ritornano null (nessuna PK)
$media = $scheda->perf_ind_media; // null

// Fase 2: Primo salvataggio
$scheda->save(); // Genera ID, exists = true

// Fase 3: Gli accessor ora calcolano e salvano
$media = $scheda->perf_ind_media; // 85.5 (calcolato e persistito)
```

### 2. Edit Scheda Esistente

```php
// Load scheda esistente
$scheda = Scheda::find(10660);

// Gli accessor verificano:
// 1. Cache hit? Usa valore esistente
// 2. Refresh richiesto? Ricalcola
// 3. Ha PK? Salva il nuovo valore

$media = $scheda->perf_ind_media; // Accesso sicuro, UPDATE se necessario
```

### 3. Refresh On-Demand

```php
// Forza ricalcolo di tutti i valori
$scheda = Scheda::find(10660);
request()->merge(['refresh' => true]);

// Tutti gli accessor ricalcolano e aggiornano i valori
$media = $scheda->perf_ind_media; // Nuovo calcolo
$gg_esperienza = $scheda->gg_esperienza_no_asz; // Nuovo calcolo
```

## Calcoli Complessi

### Performance Individuale Media

**Business Rule**: Media ponderata delle performance degli ultimi N anni.

**Implementazione**:
```php
public function perfIndMedia(): float
{
    $anni = [
        $this->perf_ind_2023,
        $this->perf_ind_2024,
        $this->perf_ind_2025,
    ];
    
    $valori = array_filter($anni, fn($v) => $v !== null);
    
    if (empty($valori)) {
        return 0.0;
    }
    
    return array_sum($valori) / count($valori);
}
```

### Giorni Esperienza Validi

**Business Rule**: Giorni di servizio validi = giorni cateco_posfun - giorni assenza

**Implementazione**:
```php
public function getGgEsperienzaNoAszAttribute(?int $value): ?int
{
    if ($this->getKey() === null) {
        return null;
    }
    
    if (null != $this->gg_integ_params) {
        $gg_totali = intval($this->gg_integ_params);
        $gg_assenza = intval($this->gg_integ_params_asz);
        $gg_validi = $gg_totali - $gg_assenza;
        
        $this->attributes['gg_esperienza_no_asz'] = $gg_validi;
        $this->save();
        
        return $gg_validi;
    }
    
    return $this->gg_cateco_posfun_no_asz;
}
```

## Normative PA di Riferimento

### CCNL Comparto Funzioni Locali

**Articoli Rilevanti**:
- **Art. 16**: Progressioni economiche orizzontali
- **Art. 19**: Valutazione della performance
- **Allegato A**: Criteri oggettivi per le progressioni

**Impatto sul Sistema**:
- Calcoli devono rispettare parametri CCNL
- Trasparenza e tracciabilità obbligatorie
- Criteri oggettivi e misurabili

### Normativa Presenza/Assenza

**Codici Tipo Assenza Rilevanti**:
- Aspettative (escludono da calcolo giorni validabili)
- Malattia (parzialmente validabile secondo CCNL)
- Ferie/Permessi (validabili completamente)

## Ottimizzazioni Performance

### Cache Strategy

**Livello 1 - Attributo DB**: 
- Valore calcolato salvato nel DB
- Accesso immediato senza calcolo

**Livello 2 - Refresh Flag**:
- `?refresh=1` in query string
- Force ricalcolo quando dati fonte cambiano

**Livello 3 - Redis (futuro)**:
- Cache distribuita per calcoli più pesanti
- Invalidazione automatica su update

### Query Optimization

```php
// ❌ N+1 Problem
foreach ($schede as $scheda) {
    $media = $scheda->perf_ind_media; // Query su ogni iterazione
}

// ✅ Eager Loading
$schede = Scheda::with('anag', 'integParams')->get();
foreach ($schede as $scheda) {
    $media = $scheda->perf_ind_media; // Usa dati già caricati
}
```

## Sicurezza e Audit

### Activity Log

Tutti i salvataggi sono tracciati da Spatie Activity Log:

```php
// Automatico su ogni save()
activity()
    ->performedOn($scheda)
    ->causedBy($user)
    ->log('Ricalcolato perf_ind_media');
```

### Validazione Dati

```php
// Prima del calcolo, validare integrità dati
if ($this->anag === null) {
    throw new BusinessLogicException('Scheda senza anagrafica');
}

if ($this->anno < 2015 || $this->anno > 2030) {
    throw new BusinessLogicException('Anno fuori range valido');
}
```

## Edge Cases Gestiti

### 1. Dipendente Senza Presenze

```php
if ($this->anag === null || $this->gg_presenza_anno === 0) {
    return 0; // Nessun giorno validabile
}
```

### 2. Periodo Parziale

```php
if ($this->dal > $this->anno.'-06-30') {
    // Assunzione a metà anno: pro-rata
    $gg_proporzionali = $this->calcolaProporzionali();
}
```

### 3. Cambio Categoria durante l'Anno

```php
// Gestito da integParams con multiple entries per anno
$periodi = $this->integParams()->where('anno', $this->anno)->get();
foreach ($periodi as $periodo) {
    $gg += $this->calcolaGgPeriodo($periodo);
}
```

## Collegamenti

### Documentazione Tecnica
- [Accessor Pattern](./scheda-trait-accessor-pattern.md)
- [Fix Duplicate Entry](./fix-duplicate-entry-error-summary.md)
- [Fix Implementation Guide](./fix-accessor-save-pattern.md)

### Documentazione CCNL
- [Normativa Progressioni](./normativa/progressioni.md)
- [Criteri Valutazione](./normativa/valutazione.md)

### Moduli Correlati
- [Progressioni Module](../../Progressioni/docs/README.md)
- [Performance Module](../../Performance/docs/README.md)
- [PresenzeAssenze Module](../../PresenzeAssenze/docs/README.md)

---

**Creato**: 2025-01-29  
**Responsabile**: AI Assistant  
**Status**: Documentazione aggiornata con fix Duplicate Entry

