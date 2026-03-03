# Implementazione del Modello Comune

## Scelta Architetturale

Il modello `Comune` implementa direttamente il trait `Sushi` di Laravel per gestire i dati dei comuni italiani. Questa scelta è stata fatta per i seguenti motivi:

1. **Semplicità**: L'implementazione diretta è più semplice e trasparente rispetto all'uso di un trait personalizzato
2. **Manutenibilità**: Meno livelli di astrazione da gestire
3. **Performance**: Accesso diretto ai dati senza overhead di trait aggiuntivi
4. **Chiarezza**: Il codice è più facile da comprendere e debuggare

## Caratteristiche Principali

- Utilizzo diretto del trait `Sushi` per la gestione dei dati
- Caricamento dei dati da file JSON con caching
- Supporto completo per l'API Eloquent
- Gestione efficiente della memoria tramite SQLite in memoria

## Vantaggi dell'Implementazione Diretta

1. **API Eloquent Completa**
   - Query builder avanzato
   - Relazioni e eager loading
   - Scope e local query
   - Compatibilità con Filament

2. **Performance Ottimizzate**
   - Caching dei dati in SQLite
   - Query ottimizzate
   - Caricamento efficiente dei dati

3. **Manutenibilità**
   - Codice più semplice e diretto
   - Meno livelli di astrazione
   - Più facile da testare e debuggare

## Considerazioni Tecniche

### Caricamento Dati
```php
public function getRows(): array
{
    $cacheKey = 'sushi_comuni_data';
    
    return Cache::remember($cacheKey, 604800, function () {
        $path = module_path('Geo', 'resources/json/comuni.json');
        return json_decode(File::get($path), true);
    });
}
```

### Schema e Cast
```php
protected $fillable = [
    'id',
    'codice',
    'nome',
    'regione',
    'provincia',
    'sigla_provincia',
    'cap',
    'codice_catastale',
    'popolazione',
    'zona_altimetrica',
    'altitudine',
];

protected $casts = [
    'popolazione' => 'integer',
    'altitudine' => 'integer',
];
```

## Best Practices

1. **Caching**
   - Utilizzare cache per i dati statici
   - Invalidare la cache quando il file JSON viene modificato
   - Impostare TTL appropriato (1 settimana per dati geografici)

2. **Performance**
   - Monitorare l'utilizzo della memoria
   - Ottimizzare le query frequenti
   - Utilizzare indici appropriati

3. **Manutenzione**
   - Mantenere il file JSON aggiornato
   - Documentare le modifiche allo schema
   - Testare regolarmente le performance

## Collegamenti Correlati

- [Documentazione Sushi](https://github.com/calebporzio/sushi)
- [GeoJsonModel vs Sushi](geo-sushi-comparison.md)
- [Analisi Implementazione](comune-sushi-analisi.md) 