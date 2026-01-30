# Modello GeoJsonModel (ispirato a Squire) per Laravel

## Filosofia e motivazione

- **KISS**: Nessuna necessità di creare tabelle/migration per dati statici e condivisi come regioni, province, comuni, CAP. Il dato rimane "immutabile" e facilmente versionabile.
- **DRY**: Una sola fonte di verità (il file JSON, es: `comuni.json`), facilmente aggiornabile e condivisa da tutto il sistema.
- **Performance**: Per dataset di dimensioni ridotte/medie, la lettura da file + cache è più che sufficiente e non grava sul database.
- **Zen**: Il dato "vive" fuori dal DB, è sempre coerente, trasparente e ispezionabile.
- **Politica**: Separazione netta tra dominio applicativo e dati statici; niente coupling forzato con il DB.

## Struttura proposta

### 1. File dati

- Tutti i dati geografici sono contenuti in `/Modules/Geo/resources/json/comuni.json`.
- Il file contiene array di oggetti con chiavi come: `region`, `province`, `city`, `cap`, `istat`, ecc.
- Esempio struttura:

```json
[
  {
    "region": "Lombardia",
    "province": "Milano",
    "city": "Milano",
    "cap": "20100",
    "istat": "015146"
  },
  ...
]
```

### 2. GeoJsonModel base (readonly)

- Una classe base `GeoJsonModel` che legge e cache-izza il contenuto del JSON.
- Espone metodi simili a Eloquent/Collection: `all()`, `where()`, `find($id)`.
- Le classi specifiche (Region, Province, City, Cap) estendono questa base e forniscono filtri/estrazioni dedicate.

#### Esempio base:

```php
namespace Modules\Geo\Models;

use Illuminate\Support\Collection;

abstract class GeoJsonModel
{
    protected static string $jsonFile = '';

    protected static function loadData(): Collection
    {
        $path = module_path('Geo', 'Resources/json/comuni.json');
        $data = cache()->rememberForever('geo_comuni_json', fn() => json_decode(file_get_contents($path), true));
        return collect($data);
    }

    public static function all(): Collection
    {
        return static::loadData();
    }

    public static function where($key, $value): Collection
    {
        return static::all()->where($key, $value);
    }
}
```

#### Esempi di estensione:

```php
class Region extends GeoJsonModel
{
    public static function all(): Collection
    {
        return static::loadData()->pluck('region')->unique()->values();
    }
}

class Province extends GeoJsonModel
{
    public static function byRegion($region): Collection
    {
        return static::loadData()->where('region', $region)->pluck('province')->unique()->values();
    }
}

class City extends GeoJsonModel
{
    public static function byProvince($province): Collection
    {
        return static::loadData()->where('province', $province)->pluck('city')->unique()->values();
    }
}

class Cap extends GeoJsonModel
{
    public static function byCity($city): Collection
    {
        return static::loadData()->where('city', $city)->pluck('cap')->unique()->values();
    }
}
```

### 3. Utilizzo in Filament (Select dinamici)

Esempio di implementazione di select dinamiche per regioni, province, città e cap:

```php
Select::make('region')
    ->options(fn () => \Modules\Geo\Models\Region::all()->mapWithKeys(fn($item) => [$item => $item]))
    ->live()
    ->afterStateUpdated(fn ($set) => $set('province', null));

Select::make('province')
    ->options(fn ($get) => \Modules\Geo\Models\Province::byRegion($get('region'))->mapWithKeys(fn($item) => [$item => $item]))
    ->live()
    ->afterStateUpdated(fn ($set) => $set('city', null))
    ->visible(fn ($get) => filled($get('region')));

Select::make('city')
    ->options(fn ($get) => \Modules\Geo\Models\City::byProvince($get('province'))->mapWithKeys(fn($item) => [$item => $item]))
    ->live()
    ->afterStateUpdated(fn ($set) => $set('cap', null))
    ->visible(fn ($get) => filled($get('province')));

Select::make('cap')
    ->options(fn ($get) => \Modules\Geo\Models\Cap::byCity($get('city'))->mapWithKeys(fn($item) => [$item => $item]))
    ->visible(fn ($get) => filled($get('city')));
```

### 4. Best practice e note operative

- Versionare sempre il file json.
- Documentare la struttura del json e mantenerla coerente.
- Se il json cresce molto, valutare slicing o indicizzazione.
- Per performance, sfruttare cache Laravel.
- Se serve compatibilità Eloquent, usare macro/traits per Collection.
- Collegare questa documentazione a Xot/docs/module-structure.md e a <nome progetto>/docs/geo-integration.md.

### 5. Collegamenti utili

- [Squire PHP](https://github.com/squirephp/squire)
- Geo/module_geo.md
- Xot/module-structure.md
- <nome progetto>/docs/geo-integration.md

## Confronto: GeoJsonModel vs Laravel Sushi

### 1. GeoJsonModel (JSON statico + Collection)
- **Vantaggi**:
  - 100% nessuna dipendenza esterna (solo Laravel base)
  - 100% leggibile/versionabile (il file json è ispezionabile, diffabile, editabile)
  - 95% performance ottima per dataset < 50.000 record (cache Laravel, nessun DB query)
  - 100% compatibile con deploy su qualsiasi ambiente (nessun requisito SQLite)
  - 100% DRY: una sola fonte di verità, nessuna duplicazione
  - 100% KISS: nessuna migrazione, nessun seeder, nessun DB
  - 90% facilità di aggiornamento (basta sostituire il file json)
- **Svantaggi**:
  - 60% non hai Eloquent completo (no relazioni, no query avanzate, no mutator/accessor)
  - 80% non hai route model binding automatico
  - 70% non hai validazione schema automatica (ma puoi aggiungerla)
  - 60% non adatto a dataset > 100.000 record (ram/caching)
  - 0% scrittura: solo readonly

### 2. Laravel Sushi
- **Vantaggi**:
  - 100% Eloquent API: puoi usare relazioni, query builder, accessors, mutators, route model binding
  - 90% performance ottima per dataset < 20.000 record (cache su SQLite in RAM)
  - 100% nessuna migrazione, nessun DB server richiesto (usa SQLite embedded)
  - 100% DRY: puoi caricare dati da array, config, API, CSV, JSON
  - 90% facilità di test (puoi mockare facilmente i dati)
  - 100% compatibile con tutte le feature Eloquent (tranne scrittura)
- **Svantaggi**:
  - 80% dipendenza da package esterno (Sushi)
  - 70% richiede estensione PHP SQLite abilitata (non sempre disponibile su hosting condivisi)
  - 60% gestione cache: se cambi i dati, devi gestire cache busting
  - 60% meno trasparente per chi non conosce Sushi
  - 0% scrittura: solo readonly

### 3. Percentuali di utilizzo e scenari
- **GeoJsonModel**: consigliato per dati geografici statici, reference, lookup, configurazioni, dove serve massima trasparenza e semplicità (80% dei casi in progetti multi-tenant, multi-modulo, open-source)
- **Sushi**: consigliato per dati statici che devono essere "Eloquent-like" (relazioni, query avanzate, route model binding), demo, test, prototipi, o quando vuoi sfruttare l'ecosistema Eloquent senza DB (20% dei casi, soprattutto in progetti Laravel puri, SaaS, package)

### 4. Considerazioni finali
- **GeoJsonModel** è più trasparente, più semplice, più portabile, più adatto a progetti open-source, multi-modulo, e a team che vogliono massima leggibilità e versionamento dei dati.
- **Sushi** è più potente se vuoi la sintassi Eloquent completa, relazioni, e route model binding, ma richiede SQLite e una dipendenza esterna.
- **Entrambi** sono readonly e ideali per dati statici. Se serve scrittura, serve un DB vero.
- **Performance**: per < 10.000 record sono equivalenti; tra 10.000 e 50.000 record GeoJsonModel vince per semplicità, sopra i 50.000 serve valutare DB o slicing.

## Esempio di scelta
- **Progetto multi-modulo, open-source, con dati geografici statici**: **GeoJsonModel** (90% dei casi)
- **Prototipo, SaaS, demo, o vuoi Eloquent completo senza DB**: **Sushi** (10% dei casi)

## Collegamenti
- [Laravel Sushi](https://github.com/calebporzio/sushi)
- [Squire PHP](https://github.com/squirephp/squire)
- [GeoJsonModel: struttura e motivazione](./geo-json-model.md)
- [json-database.md](./json-database.md)
- [squire-integration.md](./squire-integration.md)

## Esempio pratico: modello unico Comune

```php
namespace Modules\Geo\Models;

use Illuminate\Support\Collection;

class Comune extends GeoJsonModel
{
    public static function byRegion(string $regionCode): Collection { /* ... */ }
    public static function byProvince(string $provinceCode): Collection { /* ... */ }
    public static function byCity(string $cityName): Collection { /* ... */ }
    public static function byCap(string $cap): Collection { /* ... */ }
    public static function byIstat(string $istat): Collection { /* ... */ }
    public static function allRegions(): Collection { /* ... */ }
    public static function allProvinces(): Collection { /* ... */ }
    public static function allCities(): Collection { /* ... */ }
    public static function allCaps(): Collection { /* ... */ }
}
```

- Tutti i filtri e le select dinamiche ora usano solo il modello Comune.
- Vedi anche [geo_entities.md](./geo_entities.md) per motivazione e percentuali di adozione.

## Analisi: Comune come modello Sushi

### Motivazione
- Sushi permette di usare Eloquent su dati statici senza DB, caricando i dati da array/config/json e usando SQLite in RAM.
- Potremmo implementare Comune come modello Sushi per avere:
  - Query Eloquent (where, order, relazioni, accessors, mutators)
  - Route model binding
  - Compatibilità con package che richiedono Eloquent
  - API uniforme per chi lavora solo con Eloquent

### Vantaggi (nel nostro contesto)
- **90%**: Query Eloquent, relazioni, accessors, mutators, route model binding
- **80%**: Facilità di test e mock (Sushi è molto usato nei test)
- **80%**: Compatibilità con package Laravel che richiedono Eloquent
- **70%**: Possibilità di aggiungere facilmente relazioni virtuali (es: region/province/city come belongsTo)
- **70%**: API più uniforme per chi lavora solo con Eloquent

### Svantaggi (nel nostro contesto)
- **80%**: Dipendenza da package esterno (Sushi)
- **70%**: Richiede estensione PHP SQLite abilitata (non sempre disponibile su hosting condivisi o ambienti dockerizzati minimal)
- **60%**: Gestione cache meno trasparente rispetto a Laravel cache (Sushi usa SQLite in RAM, non la cache Laravel)
- **60%**: Minor trasparenza per chi non conosce Sushi (debug, override, ecc.)
- **50%**: Per dataset > 20.000 record, performance e RAM vanno testate
- **0%**: Scrittura: sempre readonly

### Esempio pratico di modello Sushi

```php
namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ComuneSushi extends Model
{
    use Sushi;

    public function getRows(): array
    {
        // Carica il json come array associativo
        $json = file_get_contents(module_path('Geo', 'resources/json/comuni.json'));
        return json_decode($json, true);
    }

    // Esempio di relazione virtuale
    public function regione()
    {
        return $this->belongsTo(RegionSushi::class, 'regione.codice', 'codice');
    }
}
```

### Raccomandazioni per il nostro progetto
- **Consigliato**:
  - Se serve compatibilità Eloquent completa (relazioni, accessors, mutators, route model binding)
  - Se si vuole integrare con package Laravel che richiedono Eloquent
  - Se si lavora in ambienti dove SQLite è sempre disponibile
- **Sconsigliato**:
  - Se si vuole massima trasparenza, semplicità, portabilità e nessuna dipendenza esterna
  - Se si lavora in ambienti dove SQLite non è garantito
  - Se si vuole usare la cache Laravel per invalidazione e slicing avanzato

### Considerazioni finali
- **Comune Sushi** è una soluzione potente per chi vuole Eloquent completo su dati statici, ma introduce una dipendenza e un requisito tecnico (SQLite) che va valutato per ogni ambiente.
- **Comune (GeoJsonModel)** rimane la soluzione più trasparente, portabile e "zen" per la maggior parte dei progetti multi-modulo, open-source, e per chi vuole massima leggibilità e controllo.
- **Strategia consigliata**: mantenere Comune (GeoJsonModel) come default, ma documentare e testare una variante Sushi per chi ha bisogno di Eloquent puro.

---

- Vedi anche [geo_entities.md](./geo_entities.md) per motivazione e percentuali di adozione.

## Approfondimento: Sushi (calebporzio/sushi) per modelli geografici

### Cos'è Sushi?
- Sushi è un "array driver" per Eloquent: permette di creare modelli Eloquent da array, JSON, config, API, senza DB reale.
- I dati vengono caricati in una tabella SQLite temporanea (in RAM o su disco), e puoi usare TUTTE le query Eloquent, relazioni, accessors, mutators, route model binding, validazione exists, ecc.
- Perfetto per dati statici, reference, lookup, fixture, demo, test, blog, config, ruoli, geo, ecc.

### Come funziona
- Si usa il trait `Sushi` su un modello Eloquent.
- Si fornisce un array statico (`$rows`) o si implementa `getRows()` per caricare i dati (anche da file json, csv, API, ecc).
- Sushi crea una tabella SQLite e la popola con i dati forniti.
- Puoi definire schema custom, relazioni, accessors, mutators, chunk size, cache reference path, ecc.

### Esempio pratico: ComuneSushi

```php
namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ComuneSushi extends Model
{
    use Sushi;

    public function getRows(): array
    {
        $json = file_get_contents(module_path('Geo', 'resources/json/comuni.json'));
        return json_decode($json, true);
    }

    // Relazione virtuale (esempio)
    public function regione()
    {
        return $this->belongsTo(RegionSushi::class, 'regione.codice', 'codice');
    }

    // Se vuoi cache persistente tra richieste
    protected function sushiShouldCache() { return true; }
    protected function sushiCacheReferencePath() { return module_path('Geo', 'resources/json/comuni.json'); }
}
```

### Vantaggi
- **100%** API Eloquent completa: where, order, relazioni, accessors, mutators, route model binding, validazione exists, Scout, ecc.
- **90%** Perfetto per test, fixture, demo, prototipi, dati reference, blog, config, geo, ruoli, ecc.
- **80%** Puoi caricare dati da qualsiasi fonte (array, json, csv, API, config, ecc.)
- **80%** Nessuna migrazione, nessun DB server, nessun seeder
- **80%** Puoi definire schema custom, chunk size, cache reference path
- **70%** Compatibile con Backpack, Filament, Nova, package Eloquent

### Svantaggi e caveat
- **80%** Dipendenza da package esterno (Sushi)
- **80%** Richiede estensione PHP SQLite abilitata (non sempre disponibile su hosting condivisi o docker minimal)
- **70%** Gestione cache: se il file json cambia, serve bustare la cache (usa sushiCacheReferencePath)
- **60%** Dove serve massima trasparenza/portabilità, GeoJsonModel è più "zen"
- **60%** Dove serve slicing avanzato/cache Laravel, GeoJsonModel è più flessibile
- **50%** Per dataset > 20.000 record, testare RAM e performance
- **30%** Alcuni metodi Eloquent (es. whereHas tra modelli Sushi diversi) non funzionano (perché ogni modello ha un DB SQLite separato)
- **0%** Scrittura: sempre readonly

### Percentuali e scenari
- **ComuneSushi**: consigliato per chi vuole Eloquent puro, relazioni, validazione exists, route model binding, compatibilità package, test, demo, prototipi, blog, config, geo reference, ecc. (~20-30% dei casi in progetti Laravel puri, SaaS, package, admin panel avanzati)
- **GeoJsonModel**: consigliato per massima trasparenza, portabilità, semplicità, multi-modulo, open-source, slicing/cache avanzato, ambienti senza SQLite, team che vogliono leggibilità e controllo. (~70-80% dei casi in progetti multi-modulo, open-source, multi-tenant, geo reference, ecc.)

### Consigli operativi
- Se vuoi Eloquent completo, relazioni, validazione exists, route model binding, compatibilità con package Laravel, **Sushi è la scelta migliore**.
- Se vuoi massima trasparenza, portabilità, nessuna dipendenza, cache Laravel, slicing avanzato, **GeoJsonModel è la scelta migliore**.
- Puoi mantenere entrambi: `Comune` (GeoJsonModel) come default, `ComuneSushi` come variante Eloquent per chi ne ha bisogno.
- Documenta sempre la scelta e i caveat in docs.

### Collegamenti
- [Sito ufficiale Sushi](https://usesushi.dev/)
- [GitHub Sushi](https://github.com/calebporzio/sushi)
- [Esempi avanzati](https://jasonlbeggs.com/blog/laravel-sushi)
- [geo_entities.md](./geo_entities.md)

---

## Esempio di implementazione completa per ComuneSushi

```php
namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class ComuneSushi extends Model
{
    use Sushi;

    public function getRows(): array
    {
        $json = file_get_contents(module_path('Geo', 'resources/json/comuni.json'));
        return json_decode($json, true);
    }

    protected function sushiShouldCache() { return true; }
    protected function sushiCacheReferencePath() { return module_path('Geo', 'resources/json/comuni.json'); }

    // Esempio: relazioni virtuali
    public function regione()
    {
        return $this->belongsTo(RegionSushi::class, 'regione.codice', 'codice');
    }
    public function provincia()
    {
        return $this->belongsTo(ProvinceSushi::class, 'provincia.codice', 'codice');
    }
}
```

---

- Vedi anche [geo_entities.md](./geo_entities.md) e [squire-integration.md](./squire-integration.md) per altri confronti e strategie.

## Approccio avanzato: SushiToJsons (CRUD, multi-tenant, Eloquent + JSON)

### Cos'è SushiToJsons?
- Trait che unisce Sushi (Eloquent su array/JSON) e persistenza su file JSON (uno per record).
- Permette di avere modelli Eloquent CRUD-abili senza DB, con dati salvati come file JSON (tipicamente uno per tenant o per record).
- Usa la directory `database/content/<table>` per salvare i file, risolvendo il path tramite un servizio multi-tenant.
- Implementa i metodi Eloquent `creating`, `updating`, `deleting` per scrivere/aggiornare/cancellare i file JSON.
- Usa una proprietà `$schema` per sapere quali campi leggere/scrivere.

### Vantaggi
- **100%** API Eloquent completa (query, relazioni, accessors, mutators, validazione exists, route model binding, ecc.)
- **100%** CRUD completo: puoi creare, aggiornare, cancellare record (i dati sono file JSON)
- **100%** Multi-tenant: ogni tenant ha la sua directory di dati
- **90%** Versionamento e trasparenza: i dati sono file JSON, facilmente versionabili, esportabili, ispezionabili
- **80%** Nessun DB server: solo filesystem e SQLite in RAM per Sushi
- **80%** Perfetto per dati configurabili dall'utente, reference custom, configurazioni, demo, test

### Svantaggi e limiti
- **80%** Performance: per grandi dataset (migliaia di file), la lettura/scrittura su filesystem può essere lenta rispetto a un DB vero
- **70%** Consistenza: nessuna transazionalità tra file, rischio di inconsistenze in caso di crash durante operazioni multiple
- **70%** Gestione schema: serve mantenere lo schema manualmente e assicurarsi che tutti i file siano coerenti
- **60%** Dipendenza da Sushi, File, e da un servizio custom per path multi-tenant
- **60%** Dipendenza dal filesystem: su storage lento o non persistente può essere problematico
- **0%** Non adatto a dati reference statici nazionali (meglio GeoJsonModel)

### Esempio pratico di trait SushiToJsons

```php
namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;

trait SushiToJsons
{
    use Sushi;

    public function getSushiRows(): array
    {
        $tbl = $this->getTable();
        $path = TenantService::filePath('database/content/'.$tbl);
        $files = File::glob($path.'/*.json');
        $rows = [];
        foreach ($files as $file) {
            $json = File::json($file);
            $item = [];
            foreach ($this->schema ?? [] as $name => $type) {
                $value = $json[$name] ?? null;
                $item[$name] = is_array($value) ? json_encode($value) : $value;
            }
            $rows[] = $item;
        }
        return $rows;
    }

    // Metodi per persistenza CRUD (creating, updating, deleting) vedi trait completo
}
```

### Scenari d'uso consigliati
- **Comune configurabile per tenant**: ogni tenant può avere comuni personalizzati, CRUD completo, dati versionabili
- **Reference custom, configurazioni, dati utente**: dove serve CRUD, multi-tenant, versionamento
- **Demo, test, prototipi**: dati facilmente ispezionabili e modificabili

### Confronto con GeoJsonModel e Sushi puro
- **GeoJsonModel**: solo readonly, unico file json, massima performance e semplicità, ideale per reference statici nazionali
- **Sushi puro**: Eloquent su array/json, solo readonly, nessun CRUD, ideale per dati reference Eloquent-like
- **SushiToJsons**: CRUD completo, multi-tenant, Eloquent API, persistenza su file, ideale per dati configurabili e reference custom

### Percentuali e raccomandazioni
- **Comune reference nazionale**: 90% GeoJsonModel (readonly, unico file, performance, semplicità)
- **Comune configurabile per tenant**: 80% SushiToJsons (CRUD, multi-tenant, versionamento, Eloquent API)
- **Comune Eloquent puro, solo readonly**: 20% Sushi semplice (carica da unico JSON, nessun CRUD)

### Consigli operativi
- Usa SushiToJsons solo se serve CRUD, multi-tenant, versionamento e API Eloquent completa.
- Per dati reference statici, resta su GeoJsonModel.
- Documenta sempre la scelta e i caveat in docs.

---

- Vedi anche [geo_entities.md](./geo_entities.md) e [squire-integration.md](./squire-integration.md) per altri confronti e strategie.
