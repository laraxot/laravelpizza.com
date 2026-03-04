# Implementazione Sushi per il Modello Comune

## Descrizione
Questo documento descrive l'implementazione del modello `Comune` utilizzando il trait `Sushi` di Laravel, con supporto per la persistenza dei dati in file JSON.

## Contesto
Il modello `Comune` attualmente utilizza `GeoJsonModel` per gestire i dati dei comuni italiani. La migrazione a Sushi permetterà di:
1. Utilizzare l'API Eloquent completa
2. Mantenere la persistenza dei dati in JSON
3. Migliorare l'integrazione con Filament
4. Supportare relazioni e query avanzate

## Implementazione

### 1. Schema del Modello
```php
protected $schema = [
    'id' => 'integer',
    'regione' => 'string',
    'provincia' => 'string',
    'comune' => 'string',
    'cap' => 'string',
    'lat' => 'float',
    'lng' => 'float',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
```

### 2. Trait SushiToJsons
Il modello utilizzerà un trait personalizzato `SushiToJsons` che:
- Carica i dati da file JSON
- Gestisce la persistenza in JSON
- Supporta operazioni CRUD
- Mantiene la compatibilità con Eloquent

### 3. Metodi Principali
```php
public function getSushiRows(): array
{
    return $this->loadFromJson();
}

protected function loadFromJson(): array
{
    $path = base_path('database/content/comuni.json');
    return json_decode(file_get_contents($path), true);
}

public function getJsonFile(): string
{
    return base_path('database/content/comuni.json');
}
```

### 4. Gestione Cache
- I dati vengono caricati in una tabella SQLite temporanea
- La cache viene invalidata quando il file JSON viene modificato
- Supporto per operazioni CRUD con persistenza in JSON

## Best Practices

### 1. Gestione ID
- Utilizzare ID stabili basati su codici ISTAT
- Evitare ID autoincrement che potrebbero cambiare

### 2. Performance
- Implementare caching appropriato per dataset grandi
- Utilizzare indici per query frequenti
- Monitorare l'uso di memoria

### 3. Validazione
- Validare i dati durante il caricamento
- Implementare regole di validazione per operazioni CRUD
- Gestire errori di formato JSON

### 4. Testing
- Test unitari per operazioni CRUD
- Test di integrazione con Filament
- Test di performance con dataset reali

## Migrazione da GeoJsonModel

### 1. Passi di Migrazione
1. Creare backup del file JSON esistente
2. Implementare il nuovo modello con Sushi
3. Testare la compatibilità con codice esistente
4. Aggiornare le dipendenze
5. Deployare in ambiente di test

### 2. Breaking Changes
- Alcuni metodi statici potrebbero richiedere refactoring
- Query builder potrebbe comportarsi diversamente
- Relazioni potrebbero richiedere aggiornamenti

## Documentazione Correlata
- [Sushi Documentation](https://github.com/calebporzio/sushi)
- [GeoJsonModel Documentation](geo-json-model.md)
- [Filament Integration](filament-integration.md)

## Checklist
- [ ] Implementare schema del modello
- [ ] Creare trait SushiToJsons
- [ ] Implementare metodi di caricamento JSON
- [ ] Aggiungere validazione dati
- [ ] Implementare caching
- [ ] Scrivere test
- [ ] Aggiornare documentazione
- [ ] Testare in ambiente di sviluppo
- [ ] Preparare piano di rollback

## Note
- Mantenere compatibilità con codice esistente
- Documentare tutte le modifiche
- Testare in tutti gli ambienti
- Monitorare performance

## Conversione modello Comune a Sushi

### Motivazione
- Performance: caricamento ultra-rapido dei dati geografici statici (comuni, regioni, province)
- Semplificazione: nessuna dipendenza da database relazionale per dati statici
- Coerenza: dati sempre consistenti, versionabili, facilmente aggiornabili

### Strategia
- Utilizzo del package [calebporzio/sushi](https://github.com/calebporzio/sushi)
- I dati dei comuni sono caricati da file JSON (come già avviene) e forniti a Sushi tramite il metodo `getRows()`
- Ispirazione dal trait `SushiToJsons` del modulo Tenant per la gestione di più file JSON e serializzazione custom

### Implementazione

```php
use Sushi\Sushi;

class Comune extends Model
{
    use Sushi;

    public function getRows(): array
    {
        // Carica i dati da comuni.json o da più file se necessario
        $jsonPath = base_path('database/content/comuni.json');
        $data = json_decode(file_get_contents($jsonPath), true);
        return $data;
    }
}
```

#### Variante multi-file (ispirata a SushiToJsons)

```php
use Sushi\Sushi;
use Illuminate\Support\Facades\File;

class Comune extends Model
{
    use Sushi;

    public function getRows(): array
    {
        $files = File::glob(base_path('database/content/comuni/*.json'));
        $rows = [];
        foreach ($files as $file) {
            $rows[] = File::json($file);
        }
        return $rows;
    }
}
```

### Vantaggi
- Query Eloquent su dati statici senza database
- Performance elevata per select, pluck, where, ecc.
- Aggiornamento dati tramite deploy dei file JSON

### Collegamenti
- Vedi anche: [sushi-to-jsons-analysis.md](sushi-to-jsons-analysis.md), [laravel-sushi-analysis.md](laravel-sushi-analysis.md)

## Regola: evitare trait inutili e non riusabili
Non ha senso creare un trait come ComuneSushiTrait se viene usato solo in un modello. I trait vanno creati solo se riutilizzati in più classi. Se la logica è specifica di un solo modello, va implementata direttamente nella classe. Motivazione: semplicità, KISS, manutenibilità, evitare complessità inutile. Collegamento a docs/structure.md e best practices.
