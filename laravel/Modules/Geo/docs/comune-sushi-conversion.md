# Analisi: Conversione del Modello Comune a Laravel Sushi

## Stato Attuale

Il modello `Comune` attuale implementa un pattern Facade per fornire un'interfaccia unificata ai dati geografici italiani. Utilizza `GeoJsonModel` come classe base e carica i dati da un file JSON, implementando un sistema di caching a più livelli per ottimizzare le performance.

### Caratteristiche principali dell'implementazione attuale:

1. **Accesso ai dati**:
   - Caricamento dati da file JSON (`comuni.json`)
   - Caching con TTL configurabile (1 settimana)
   - Metodi specializzati per filtrare e manipolare i dati

2. **API**:
   - Metodi statici per accedere ai dati (`byRegion`, `byProvince`, etc.)
   - Metodi di utilità per validazione e manipolazione dati

3. **Caching**:
   - Utilizzo di `Cache::remember` per ogni tipo di query
   - Sistema di pulizia cache strutturato

4. **Performance**:
   - Ottimizzato per minimizzare l'accesso al file JSON
   - Collection prefiltrare e in cache per query comuni

## Laravel Sushi: Overview

[Laravel Sushi](https://github.com/calebporzio/sushi) è un pacchetto creato da Caleb Porzio che permette di trasformare array PHP in modelli Eloquent completi, senza necessità di un database. Sushi crea automaticamente un database SQLite in memoria per fornire tutte le funzionalità di Eloquent.

### Come funziona Sushi:

1. Definisci un array di dati nel modello o un metodo che lo restituisce
2. Sushi crea un database SQLite in memoria
3. Popola il database con i dati dell'array
4. Fornisce tutte le funzionalità di Eloquent sul modello

## Implementazione con Sushi

Di seguito è riportata una possibile implementazione del modello `Comune` utilizzando Laravel Sushi:

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Sushi\Sushi;

class Comune extends Model
{
    use Sushi;
    
    /**
     * Indica a Sushi di non utilizzare timestamps
     */
    public $timestamps = false;
    
    /**
     * Definisce le colonne del modello
     */
    protected $casts = [
        'regione' => 'array',
        'provincia' => 'array',
        'cap' => 'array',
        'popolazione' => 'integer',
    ];
    
    /**
     * Carica i dati dal file JSON
     */
    public function getRows()
    {
        $path = module_path('Geo', 'resources/json/comuni.json');
        $cacheKey = 'geo_comuni_json_' . md5($path);
        
        return cache()->rememberForever($cacheKey, function () use ($path) {
            return json_decode(file_get_contents($path), true);
        });
    }
    
    /**
     * Scope per filtrare per regione
     */
    public function scopeByRegion($query, string $regionCode)
    {
        return $query->where('regione->codice', $regionCode)
                     ->orderBy('nome');
    }
    
    /**
     * Scope per filtrare per provincia
     */
    public function scopeByProvince($query, string $provinceCode)
    {
        return $query->where('provincia->codice', $provinceCode)
                     ->orderBy('nome');
    }
    
    /**
     * Scope per cercare per nome
     */
    public function scopeSearchByName($query, string $name)
    {
        return $query->where('nome', 'like', '%' . $name . '%')
                     ->orderBy('nome');
    }
    
    /**
     * Scope per filtrare per CAP
     */
    public function scopeByCap($query, string $cap)
    {
        // Nota: questo è più complesso con Sushi perché 'cap' è un array
        // Richiede una soluzione personalizzata o un'estensione
        return $query->whereRaw("JSON_CONTAINS(cap, '\"$cap\"')");
    }
    
    /**
     * Verifica se il CAP è valido
     */
    public static function isValidCap(string $cap): bool
    {
        return self::byCap($cap)->exists();
    }
    
    /**
     * Relazione con la regione
     */
    public function regioneModel()
    {
        // Implementazione della relazione se necessario
    }
    
    /**
     * Relazione con la provincia
     */
    public function provinciaModel()
    {
        // Implementazione della relazione se necessario
    }
}
```

### Modifiche all'API esistente:

Per mantenere compatibilità con il codice che utilizza l'API attuale, si potrebbero aggiungere metodi statici:

```php
/**
 * Restituisce tutti i comuni
 */
public static function all($columns = ['*']): Collection
{
    return parent::all($columns);
}

/**
 * Restituisce i comuni per regione
 */
public static function byRegion(string $regionCode): Collection
{
    return static::query()->byRegion($regionCode)->get();
}

/**
 * Restituisce i comuni per provincia
 */
public static function byProvince(string $provinceCode): Collection
{
    return static::query()->byProvince($provinceCode)->get();
}

/**
 * Cerca comuni per nome
 */
public static function searchByName(string $name, int $limit = 0): Collection
{
    $query = static::query()->searchByName($name);
    
    if ($limit > 0) {
        $query->limit($limit);
    }
    
    return $query->get();
}
```

## Analisi Comparativa: Sushi vs Implementazione Attuale

### Vantaggi di Sushi (70% pro)

1. **Query Eloquent complete (95%)**:
   - Accesso a tutti i metodi di query di Eloquent (`where`, `whereIn`, `orderBy`, etc.)
   - Supporto per query complesse e condizioni annidate
   - Possibilità di utilizzare query builder in modo fluente

2. **Relazioni (90%)**:
   - Supporto per relazioni Eloquent tra modelli (`hasMany`, `belongsTo`, etc.)
   - Possibilità di definire relazioni tra Comune, Regione, Provincia, etc.

3. **Compatibilità con l'ecosistema Laravel (85%)**:
   - Compatibilità nativa con componenti Laravel che si aspettano modelli Eloquent
   - Integrazione perfetta con Filament, Livewire, e altri pacchetti Laravel
   - Funzionamento con form request, validazioni e altre funzionalità Laravel

4. **Meno codice personalizzato (80%)**:
   - Eliminazione della necessità di implementare metodi di filtro e manipolazione dati
   - Utilizzo di metodi standard di Eloquent anziché logica personalizzata

5. **Affidabilità e manutenibilità (75%)**:
   - Pacchetto ben testato e mantenuto dalla community
   - Minor rischio di bug in logica personalizzata

### Svantaggi di Sushi (30% contro)

1. **Overhead di memoria (95%)**:
   - Crea un database SQLite in memoria, con consumo aggiuntivo
   - Duplicazione dei dati (array originale + database SQLite)

2. **Performance potenzialmente inferiori (90%)**:
   - Conversione JSON → Array PHP → Database SQLite → Query → Risultati
   - Il caching attuale potrebbe essere più efficiente per query semplici

3. **Complessità aggiunta (85%)**:
   - Dipendenza da un pacchetto esterno
   - Possibili problemi di compatibilità con versioni future di Laravel

4. **Curva di apprendimento (80%)**:
   - Necessità di comprendere come Sushi gestisce i dati
   - Conversione della logica esistente in pattern Eloquent

5. **Difficoltà con strutture dati annidate (75%)**:
   - JSON anidato può essere più complesso da gestire in Eloquent
   - Potrebbe richiedere schemi di tabella più complessi

## Impatto sulla Base di Codice

La conversione a Sushi avrebbe un impatto significativo sulla base di codice esistente:

1. **Cambiamenti al modello (100%)**:
   - Completa riscrittura del modello `Comune`
   - Aggiunta delle definizioni di colonne e relazioni

2. **Compatibilità API (85%)**:
   - Implementazione di metodi statici per mantenere compatibilità
   - Possibili differenze sottili nel comportamento

3. **Impatto sulle prestazioni (70%)**:
   - Potenziale miglioramento per query complesse
   - Potenziale peggioramento per query semplici e accessi frequenti

4. **Cache (60%)**:
   - Sushi ha il proprio meccanismo di cache
   - Potrebbe essere necessario personalizzare per mantenere le stesse prestazioni

## Considerazioni Implementative

### Memoria e Performance

Laravel Sushi crea un database SQLite in memoria per ogni istanza dell'applicazione, il che potrebbe aumentare l'utilizzo della memoria. Tuttavia, SQLite in memoria è estremamente veloce.

```
Implementazione attuale:
JSON → Collection → Cache → Filtri → Risultati

Implementazione Sushi:
JSON → Array → SQLite → Query → Cache → Risultati
```

### Struttura dei Dati

La struttura dei dati nei comuni.json contiene dati annidati (regione, provincia, cap come array). Con Sushi, questi dovrebbero essere gestiti come:

1. **JSON cast**: Per regione, provincia e cap
2. **Relazioni**: Creando modelli separati per Regione e Provincia
3. **Accessor/Mutator**: Per manipolare i dati prima/dopo l'accesso

### Compatibilità con il Codice Esistente

Per garantire compatibilità con il codice esistente, si dovrebbero:

1. Mantenere gli stessi nomi di metodo
2. Garantire che i risultati abbiano la stessa struttura
3. Implementare metodi statici che riproducono il comportamento attuale

## Approccio Raccomandato (Implementazione Ibrida)

Un approccio consigliato potrebbe essere un'**implementazione ibrida** che combina i vantaggi di Sushi con l'efficienza dell'implementazione attuale:

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;

class Comune extends Model
{
    use Sushi;
    
    public $timestamps = false;
    
    /**
     * Durata della cache in secondi (1 settimana)
     */
    protected const CACHE_TTL = 604800;
    
    /**
     * Definisce le colonne del modello
     */
    protected $casts = [
        'regione' => 'array',
        'provincia' => 'array',
        'cap' => 'array',
        'popolazione' => 'integer',
    ];
    
    /**
     * Ottiene i dati dal file JSON con caching
     */
    public function getRows()
    {
        $path = module_path('Geo', 'resources/json/comuni.json');
        $cacheKey = 'geo_comuni_json_' . md5($path);
        
        return Cache::rememberForever($cacheKey, function () use ($path) {
            return json_decode(file_get_contents($path), true);
        });
    }
    
    // Scopes Eloquent per query comuni
    
    // + implementazione dei metodi attuali per compatibilità
    
    /**
     * Pulisce tutta la cache
     */
    public static function clearCache(): void
    {
        // Reimplementare la logica di pulizia cache
        // + aggiungere pulizia cache Sushi
        static::clearSushiCache();
    }
}
```

Questo approccio:
1. Utilizza Sushi per le funzionalità Eloquent
2. Mantiene la logica di caching esistente per l'accesso ai dati
3. Implementa metodi statici per compatibilità
4. Aggiunge scope Eloquent per query comuni

## Fase di Transizione

Per una transizione graduale, si potrebbe:

1. Implementare il modello Sushi parallelamente al modello esistente (es. `ComuneSushi`)
2. Eseguire test di performance e funzionalità
3. Migrare gradualmente le parti dell'applicazione al nuovo modello
4. Sostituire completamente il modello esistente

## Conclusione

### Valutazione Finale

- **Implementazione Sushi pura**: 65% favorevole
- **Implementazione ibrida**: 80% favorevole
- **Mantenere implementazione attuale**: 70% favorevole

### Raccomandazione

Considerando l'analisi sopra, **raccomandiamo un'implementazione ibrida** che combini i vantaggi di Laravel Sushi con l'efficienza dell'implementazione attuale. Questo approccio offre:

1. I vantaggi del query builder e delle relazioni Eloquent
2. Mantenimento dell'efficienza del caching attuale
3. Compatibilità con il codice esistente
4. Migliore integrazione con l'ecosistema Laravel

L'implementazione ibrida rappresenta il miglior compromesso tra funzionalità Eloquent e prestazioni, mantenendo al contempo la compatibilità con il codice esistente.

---

*Documento creato il: 28/05/2025*
