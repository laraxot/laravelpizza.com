# Guida alla Migrazione del Modello Address

## Struttura della Tabella Indirizzi

Quando progettiamo la tabella per il modello `Address`, è importante considerare le convenzioni di naming e l'ottimizzazione della struttura.

### Migrazione Proposta

```php
public function up(): void
{
    Schema::create('addresses', function (Blueprint $table) {
        $table->id();
        $table->nullableMorphs('addressable'); // Relazione polimorfica
        $table->string('name')->nullable()->comment('Nome identificativo dell\'indirizzo');
        $table->text('description')->nullable()->comment('Descrizione dell\'indirizzo');
        $table->string('type', 20)->nullable()->comment('Tipo di indirizzo (casa, lavoro, ecc.)');
        $table->boolean('is_primary')->default(false)->comment('Indica se è l\'indirizzo principale');
        
        // Componenti dell'indirizzo
        $table->string('street_number', 20)->nullable()->comment('Numero civico');
        $table->string('route', 100)->nullable()->comment('Via/Strada');
        $table->string('locality', 100)->nullable()->comment('Località/Città');
        $table->string('administrative_area_level_3', 50)->nullable()->comment('Provincia');
        $table->string('administrative_area_level_2', 50)->nullable()->comment('Regione');
        $table->string('administrative_area_level_1', 50)->nullable()->comment('Paese/Stato');
        $table->string('country', 2)->nullable()->comment('Codice paese ISO 3166-1 alpha-2');
        $table->string('postal_code', 20)->nullable()->comment('Codice postale');
        
        // Dati di geolocalizzazione
        $table->string('formatted_address')->nullable()->comment('Indirizzo formattato completo');
        $table->string('place_id')->nullable()->comment('ID del luogo (es. Google Place ID)');
        $table->decimal('latitude', 10, 8)->nullable()->comment('Latitudine');
        $table->decimal('longitude', 11, 8)->nullable()->comment('Longitudine');
        
        // Dati aggiuntivi
        $table->json('extra_data')->nullable()->comment('Dati aggiuntivi in formato JSON');
        
        // Timestamp standard
        $table->timestamps();
    });
}
```

## Convenzioni di Naming

### Perché Evitare il Prefisso "address_" nei Campi?

Nella tua domanda hai giustamente notato:

> poi perché `$table->string('address_locality', 100)->nullable()->comment('Località/Città');
> $table->string('address_region', 100)->nullable()->comment('Regione/Provincia');
> $table->string('postal_code', 20)->nullable()->comment('Codice postale');
> $table->string('address_country', 2)->nullable()->comment('Codice paese ISO 3166-1 alpha-2');`
> 
> ripetere "address" quando siamo già nella tabella address?

Hai perfettamente ragione. Esistono diverse considerazioni riguardo alle convenzioni di naming:

1. **Evitare la ridondanza**: Quando un campo è già nella tabella `addresses`, aggiungere il prefisso `address_` è ridondante e va contro il principio DRY (Don't Repeat Yourself).

2. **Contesto implicito**: Il nome della tabella fornisce già il contesto che questi campi sono relativi a un indirizzo.

3. **Query più pulite**: Nelle query, è più elegante scrivere `addresses.locality` piuttosto che `addresses.address_locality`.

4. **Compatibilità con Google Maps API**: I campi senza il prefisso `address_` si allineano meglio con la struttura dei dati restituiti dalle API di Google Maps e altre API di geocoding.

5. **Convenzioni Laravel**: Nelle convenzioni Laravel, i nomi dei campi sono generalmente semplici e descrittivi, senza ridondanze.

### Alternativa Schema.org

Se vogliamo seguire strettamente la nomenclatura di Schema.org per i campi PostalAddress, potremmo utilizzare:

```php
$table->string('streetAddress', 100)->nullable();
$table->string('addressLocality', 100)->nullable();
$table->string('addressRegion', 100)->nullable();
$table->string('postalCode', 20)->nullable();
$table->string('addressCountry', 2)->nullable();
```

Tuttavia, anche in questo caso è consigliabile personalizzare i nomi per:

1. **Supportare la struttura amministrativa italiana**: Aggiungere campi specifici per provincia, regione, ecc.
2. **Compatibilità con le API**: Facilitare l'integrazione con Google Maps e altre API
3. **Flessibilità**: Adattare lo schema alle esigenze specifiche dell'applicazione

## Scelta del Campo `nullableMorphs('addressable')`

La scelta di utilizzare `nullableMorphs('addressable')` per la relazione polimorfica è ottima per diversi motivi:

1. **Riutilizzabilità**: Un indirizzo può essere associato a diversi tipi di entità (persone, negozi, ordini)
2. **Flessibilità**: Il campo nullable permette di avere indirizzi non associati (utile per indirizzi temporanei o di sistema)
3. **Convenzione Laravel**: Segue le convenzioni standard di Laravel per le relazioni polimorfiche
4. **Indici automatici**: Crea automaticamente gli indici necessari sui campi `addressable_type` e `addressable_id`

Questa implementazione permette di utilizzare il modello Address in vari contesti:

```php
// Esempio di utilizzo
$user->addresses()->create([
    'type' => 'home',
    'street_number' => '123',
    'route' => 'Via Roma',
    'locality' => 'Milano',
    'administrative_area_level_3' => 'MI',
    'administrative_area_level_2' => 'Lombardia',
    'postal_code' => '20100',
    'country' => 'IT',
]);
```

## Migrazione da Campi con Prefisso a Campi Senza Prefisso

Se stai migrando da un sistema esistente che utilizza campi con prefisso `address_`, puoi utilizzare questa strategia:

1. **Crea la nuova tabella** con i campi senza prefisso
2. **Migra i dati** dalla vecchia tabella alla nuova, mappando i campi
3. **Aggiorna il codice** per utilizzare i nuovi nomi dei campi
4. **Depreca e rimuovi** la vecchia tabella dopo un periodo di transizione

## Conclusione

La scelta di evitare il prefisso `address_` nei campi della tabella `addresses` è una decisione di design solida che:

1. **Riduce la ridondanza**
2. **Migliora la leggibilità**
3. **Facilita l'integrazione con API esterne**
4. **Segue le convenzioni Laravel**
5. **Rende il codice più manutenibile**

Questa struttura, combinata con l'uso di `nullableMorphs('addressable')` per la relazione polimorfica, fornisce un modello Address flessibile e riutilizzabile in diversi contesti applicativi.
