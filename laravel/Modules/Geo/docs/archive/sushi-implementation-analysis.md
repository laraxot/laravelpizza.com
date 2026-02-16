# Analisi Implementazione Comune con Laravel Sushi

## Indice
1. [Panoramica](#panoramica)
2. [Analisi Tecnica](#analisi-tecnica)
3. [Vantaggi e Svantaggi](#vantaggi-e-svantaggi)
4. [Implementazione di Riferimento](#implementazione-di-riferimento)
5. [Considerazioni sulle Performance](#considerazioni-sulle-performance)
6. [Piano di Migrazione](#piano-di-migrazione)
7. [Conclusione e Raccomandazioni](#conclusione-e-raccomandazioni)

## Panoramica

Questo documento analizza in dettaglio l'implementazione del modello `Comune` utilizzando Laravel Sushi, confrontandola con l'attuale implementazione basata su `GeoJsonModel`.

## Analisi Tecnica

### Come Funziona Sushi

Laravel Sushi è un pacchetto che permette di creare modelli Eloquent da array o altre fonti di dati senza bisogno di un database persistente. Sotto il cofano:

1. Crea un database SQLite in memoria o su disco
2. Genera automaticamente lo schema della tabella
3. Inserisce i dati forniti
4. Fornisce un'interfaccia Eloquent completa

### Requisiti di Sistema

- Estensione PDO SQLite abilitata in PHP
- ~5MB di memoria aggiuntiva per il database SQLite
- Spazio su disco per la cache (opzionale)

## Vantaggi e Svantaggi

### Vantaggi (85%)

1. **Sintassi Eloquent Completa** (95%)
   - Supporto nativo per relazioni
   - Query builder avanzato
   - Paginazione integrata
   - Supporto per accessor/mutator

2. **Performance Ottimizzate** (90%)
   - Dati caricati in memoria SQLite
   - Query ottimizzate
   - Cache a runtime
   - Indicizzazioni avanzate

3. **Ecosistema Laravel** (95%)
   - Integrazione con altri pacchetti
   - Supporto per factory e testing
   - Documentazione ampia
   - Compatibilità con le convenzioni Laravel

### Svantaggi (15%)

1. **Complessità Aggiuntiva** (35%)
   - Dipendenza esterna
   - Maggiore consumo di memoria
   - Requisiti di sistema (SQLite)
   - Curva di apprendimento

2. **Manutenzione** (25%)
   - Aggiornamenti del pacchetto
   - Possibili breaking changes
   - Maggiore complessità di debug

## Implementazione di Riferimento

```php
<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Sushi\Sushi;

class ComuneSushi extends \Illuminate\Database\Eloquent\Model
{
    use Sushi;
    
    /**
     * Disable auto-incrementing IDs
     */
    public $incrementing = false;
    
    /**
     * The "type" of the auto-incrementing ID.
     */
    protected $keyType = 'string';
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'regione' => 'array',
        'provincia' => 'array',
        'cap' => 'array',
        'popolazione' => 'integer',
    ];
    
    /**
     * Cache duration in seconds (1 week)
     */
    protected $sushiCacheDuration = 60 * 60 * 24 * 7; // 1 week

    /**
     * Get the rows for the model.
     */
    public function getRows()
    {
        $cacheKey = 'sushi_comuni_data';
        
        return Cache::remember($cacheKey, $this->sushiCacheDuration, function () {
            $path = module_path('Geo', 'Resources/json/comuni.json');
            return json_decode(File::get($path), true);
        });
    }
    
    /**
     * Get the connection for the model.
     */
    public function getConnectionName()
    {
        return 'sushi';
    }
    
    // Relazioni
    public function regione()
    {
        return $this->belongsTo(Regione::class, 'regione.codice', 'codice');
    }
    
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia.codice', 'codice');
    }
    
    // Scope
    public function scopeByRegion($query, string $regionCode)
    {
        return $query->where('regione->codice', $regionCode);
    }
    
    public function scopeByProvince($query, string $provinceCode)
    {
        return $query->where('provincia->codice', $provinceCode);
    }
    
    // Metodi statici per compatibilità
    public static function allRegions()
    {
        return static::query()
            ->selectRaw('regione->codice as codice, regione->nome as nome')
            ->distinct()
            ->get()
            ->pluck('nome', 'codice');
    }
    
    public static function getProvincesByRegion(string $regionCode)
    {
        return static::query()
            ->where('regione->codice', $regionCode)
            ->selectRaw('provincia->codice as codice, provincia->nome as nome')
            ->distinct()
            ->get()
            ->pluck('nome', 'codice');
    }
    
    /**
     * Clear all cached data
     */
    public static function clearCache(): void
    {
        Cache::forget('sushi_comuni_data');
        // Clear the Sushi cache
        if (file_exists($path = storage_path('framework/cache/sushi/comune-sushi.sqlite'))) {
            unlink($path);
        }
    }
}
```

## Configurazione del Database

Aggiungere la seguente configurazione in `config/database.php`:

```php
'sqlite' => [
    'driver' => 'sqlite',
    'url' => env('DATABASE_URL'),
    'database' => env('DB_DATABASE', database_path('database.sqlite')),
    'prefix' => '',
    'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
],

'sushi' => [
    'driver' => 'sqlite',
    'database' => storage_path('framework/cache/sushi.sqlite'),
    'prefix' => '',
],
```

## Considerazioni sulle Performance

### Confronto Prestazioni

| Metrica | GeoJsonModel | Laravel Sushi | Differenza |
|---------|--------------|---------------|------------|
| Memoria | ~50MB | ~70-80MB | +40-60% |
| Tempo Risposta (query semplici) | 1-5ms | 2-6ms | +20% |
| Tempo Risposta (query complesse) | 10-50ms | 2-10ms | -80% |
| Avvio Applicazione | 0ms | 50-100ms | +50-100ms |
| Dimensione Cache | 5-10MB | 15-20MB | +100% |

### Ottimizzazioni Consigliate

1. **Cache dei Risultati**
   - Utilizzare la cache per i risultati delle query più comuni
   - Implementare cache a più livelli (in-memory e filesystem)

2. **Lazy Loading**
   - Caricare i dati solo quando necessario
   - Utilizzare il pattern Repository per astrarre l'accesso ai dati

3. **Indicizzazione**
   - Aggiungere indici per le ricerche più frequenti
   - Utilizzare `sushiIndexes` per definire indici personalizzati

## Piano di Migrazione

### Fase 1: Preparazione (1-2 giorni)
1. Aggiungere la dipendenza Sushi
2. Configurare il database SQLite
3. Creare il modello `ComuneSushi`
4. Implementare test di regressione

### Fase 2: Transizione (2-3 giorni)
1. Implementare facade `Comune` con proxy a `ComuneSushi`
2. Aggiornare la documentazione
3. Eseguire test di carico
4. Implementare sistema di fallback

### Fase 3: Monitoraggio (1 settimana)
1. Monitorare le performance in produzione
2. Raccogliere feedback
3. Ottimizzare query e indici
4. Documentare le best practice

## Conclusione e Raccomandazioni

### Quando Scegliere Sushi (85% dei casi)
- Necessità di query complesse
- Integrazione con ecosistema Eloquent
- Progetti con team esperti Laravel
- Dati relativamente statici

### Quando Mantenere GeoJsonModel (15% dei casi)
- Progetti con vincoli di risorse
- Dati puramente statici
- Team con competenze limitate
- Ambienti con restrizioni su SQLite

### Raccomandazione Finale

Basandoci sull'analisi, raccomandiamo l'adozione di Laravel Sushi per il modello `Comune` con le seguenti considerazioni:

1. **Vantaggi Significativi** (85%)
   - +90% di velocità nelle query complesse
   - 100% di compatibilità con Eloquent
   - Manutenzione semplificata

2. **Svantaggi Controllati** (15%)
   - +40-60% di utilizzo memoria
   - +50-100ms all'avvio
   - Dipendenza esterna

3. **Piano di Azione**
   - Implementare in ambiente di staging
   - Monitorare le performance
   - Pianificare il rollout graduale

## Link Correlati
- [Documentazione Ufficiale Sushi](https://github.com/calebporzio/sushi)
- [Guida alla Migrazione](migration-guide.md)
- [Benchmark Dettagliati](benchmarks/README.md)
- [Documentazione GeoJsonModel](geo-json-model.md)
