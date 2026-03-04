# Entità Geografiche

## Filosofia e Principi

### 1. Separazione dei Domini
- Le entità geografiche (Regioni, Province, Città, CAP) sono state spostate dal modulo <main module> al modulo Geo
- Questo segue il principio di Single Responsibility (SRP) dei principi SOLID
- Ogni modulo deve gestire solo il proprio dominio specifico

### 2. DRY (Don't Repeat Yourself)
- Le entità geografiche sono utilizzate in più contesti (indirizzi, zone di copertura, etc.)
- Centralizzandole nel modulo Geo, evitiamo duplicazione di codice e logica
- Migliora la manutenibilità e riduce la possibilità di errori

### 3. KISS (Keep It Simple, Stupid)
- Struttura semplice e intuitiva
- Relazioni chiare e dirette tra le entità
- Naming esplicito e auto-documentante

### 4. Clean Code
- Ogni classe ha una singola responsabilità
- Nomi significativi e descrittivi
- Codice ben documentato
- Type hinting completo

## Struttura delle Entità

### Region
```php
class Region extends Model
{
    protected $fillable = ['name', 'code'];
    public function provinces(): HasMany
}
```
- Rappresenta una regione italiana
- Codice univoco di 2 caratteri
- Relazione one-to-many con Province

### Province
```php
class Province extends Model
{
    protected $fillable = ['name', 'code', 'region_id'];
    public function region(): BelongsTo
    public function cities(): HasMany
}
```
- Rappresenta una provincia italiana
- Codice univoco di 2 caratteri
- Appartiene a una Regione
- Relazione one-to-many con Cities

### City
```php
class City extends Model
{
    protected $fillable = ['name', 'province_id'];
    public function province(): BelongsTo
    public function caps(): HasMany
}
```
- Rappresenta un comune italiano
- Appartiene a una Provincia
- Relazione one-to-many con CAP

### Cap
```php
class Cap extends Model
{
    protected $fillable = ['code', 'city_id'];
    public function city(): BelongsTo
}
```
- Rappresenta un codice di avviamento postale
- Appartiene a una Città

## Migrazioni

### regions
```php
Schema::create('regions', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code', 2)->unique();
    $table->timestamps();
});
```

### provinces
```php
Schema::create('provinces', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code', 2)->unique();
    $table->foreignId('region_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

### cities
```php
Schema::create('cities', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('province_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

### caps
```php
Schema::create('caps', function (Blueprint $table) {
    $table->id();
    $table->string('code', 5);
    $table->foreignId('city_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```

## Best Practices

### 1. Utilizzo
- Importare i modelli dal namespace `Modules\Geo\Models`
- Utilizzare le relazioni per navigare tra le entità
- Mantenere l'integrità referenziale con le foreign keys

### 2. Performance
- Utilizzare eager loading per evitare N+1 queries
- Aggiungere indici appropriati per le ricerche frequenti
- Considerare il caching per dati raramente modificati

### 3. Sicurezza
- Validare sempre i dati in input
- Utilizzare i fillable per il mass assignment
- Implementare controlli di accesso appropriati

### 4. Testing
- Test unitari per ogni modello
- Test di integrazione per le relazioni
- Test delle migrazioni

## Esempi di Utilizzo

### Recupero Gerarchico
```php
$region = Region::with(['provinces.cities.caps'])->find(1);
```

### Ricerca per CAP
```php
$city = Cap::where('code', '20100')->first()->city;
```

### Creazione Gerarchica
```php
$region = Region::create(['name' => 'Lombardia', 'code' => 'LO']);
$province = $region->provinces()->create(['name' => 'Milano', 'code' => 'MI']);
```

## Esempio pratico: utilizzo del modello Comune

```php
use Modules\Geo\Models\Comune;

// Tutti i comuni di una regione
$comuniLombardia = Comune::byRegion('LO');

// Tutte le province uniche
$province = Comune::allProvinces();

// Tutte le città di una provincia
$cittaMilano = Comune::byProvince('MI')->pluck('comune');

// Tutti i CAP di una città
$capsMilano = Comune::byCity('Milano')->pluck('cap');
```

- I modelli separati (Region, Province, City, Cap) sono deprecati e possono essere mantenuti solo come facciata/proxy per compatibilità legacy.
- Tutte le select dinamiche e i filtri devono usare il modello Comune.
- Vedi anche [geo-json-model.md](./geo-json-model.md) per dettagli implementativi.

## Manutenzione

### 1. Aggiornamenti
- Mantenere sincronizzati i dati con fonti ufficiali
- Documentare eventuali modifiche alla struttura
- Versionare le migrazioni

### 2. Monitoraggio
- Tracciare le performance delle query
- Monitorare l'utilizzo della memoria
- Loggare gli errori significativi

### 3. Backup
- Backup regolari dei dati
- Test di ripristino
- Documentazione delle procedure

## Troubleshooting

### Problemi Comuni
1. **Errori di Foreign Key**
   - Verificare l'ordine delle migrazioni
   - Controllare l'integrità dei dati

2. **Performance Lente**
   - Verificare gli indici
   - Ottimizzare le query
   - Utilizzare il caching

3. **Dati Inconsistenti**
   - Validare i dati in input
   - Implementare controlli di integrità
   - Eseguire controlli periodici

## Analisi: Unificare Region, Province, City, Cap in un unico modello Comune?

### 1. Stato attuale
- Attualmente abbiamo 4 modelli distinti: `Region`, `Province`, `City`, `Cap` (tutti readonly, basati su GeoJsonModel, ispirati a Squire)
- Ogni modello espone solo metodi di filtro/estrazione specifici (es: byRegion, byProvince, byCity)
- Il file json di base (`comuni.json`) contiene già tutte le informazioni annidate: regione, provincia, città, cap, istat, ecc.

### 2. Ipotesi: modello unico `Comune`
- Un unico modello `Comune` che rappresenta la riga base del json (con tutte le info: regione, provincia, città, cap, istat, ecc.)
- Tutti i filtri diventano metodi statici su `Comune` (es: byRegion, byProvince, byCap, byIstat, ecc.)
- Le select dinamiche in Filament usano sempre il modello `Comune` e filtrano per campo

### 3. Vantaggi della fusione (modello unico)
- **90% DRY**: una sola classe, una sola fonte di verità, nessuna duplicazione di logica
- **95% KISS**: meno codice, meno manutenzione, meno rischio di divergenza tra modelli
- **100% coerenza**: tutti i dati sono sempre disponibili in ogni istanza (region, province, city, cap, istat)
- **80% performance**: nessun overhead di join/fetch multipli, una sola collection in memoria
- **100% facilità di refactoring**: aggiungere nuovi filtri/campi è immediato
- **90% facilità di test**: testare un solo modello, mock semplice

### 4. Svantaggi della fusione
- **60% perdita di astrazione**: se in futuro servono metodi/relazioni specifiche per regioni/province, serve reintrodurre classi/trait
- **70% rischio di overfetch**: se servono solo le regioni, carichi comunque tutto il json (ma con cache è trascurabile per <50k record)
- **60% naming**: alcune select potrebbero richiedere map/filter extra per estrarre solo i valori unici (es: tutte le regioni/province/cap)
- **50% minor chiarezza per chi si aspetta modelli separati (ma la doc risolve)**

### 5. Percentuali di adozione consigliata
- **Unico modello Comune**: consigliato nell'85% dei casi in progetti Laravel modulari, multi-tenant, dove la struttura del dato è stabile e serve massima semplicità e coerenza.
- **Modelli separati**: consigliati solo se:
  - Serve compatibilità con Squire o altri package che richiedono modelli distinti (10%)
  - Si prevede di aggiungere metodi/relazioni specifiche per ogni livello (5%)

### 6. Consigli pratici
- Se il file json contiene già tutte le info (region, province, city, cap, istat), **passa a un unico modello Comune** e depreca i modelli separati.
- Implementa metodi statici di filtro su Comune: `byRegion`, `byProvince`, `byCity`, `byCap`, `byIstat`, ecc.
- Aggiorna la doc e le select Filament per usare sempre il modello Comune.
- Se serve compatibilità legacy, mantieni i modelli separati come facciata (proxy) che delegano a Comune.

### 7. Considerazioni finali
- **Un unico modello Comune** semplifica la manutenzione, riduce la duplicazione, migliora la coerenza e la performance per il 90% dei casi d'uso reali.
- **La struttura flat e ricca del json** rende naturale questa scelta.
- **La documentazione e i metodi statici** garantiscono comunque chiarezza e facilità d'uso.
- **Se in futuro servono modelli separati, si possono reintrodurre facilmente come wrapper.** 
