# Convenzioni di Naming nel Modulo Geo

## Principi Guida

Questo documento descrive le convenzioni di naming adottate nel modulo Geo, con particolare attenzione alla rimozione dei prefissi ridondanti e all'allineamento con gli standard internazionali.

## Evitare Prefissi Ridondanti

### Il Problema

In molti database è comune vedere prefissi ridondanti nei nomi dei campi, ad esempio:
- Tabella `addresses` con campi come `address_locality`, `address_region`, ecc.
- Tabella `users` con campi come `user_name`, `user_email`, ecc.

Questo approccio viola il principio DRY (Don't Repeat Yourself) e crea diverse problematiche:

1. **Ridondanza semantica**: Il prefisso non aggiunge informazioni significative
2. **Verbosità**: Nomi più lunghi senza valore aggiunto
3. **Inconsistenza**: Spesso alcuni campi hanno il prefisso e altri no
4. **Difficoltà di refactoring**: Cambiare il nome della tabella richiede cambiare tutti i nomi dei campi

### La Soluzione

Nel modulo Geo, seguiamo la best practice di **omettere il prefisso del nome della tabella nei nomi dei campi**:

```php
// ❌ Con prefissi ridondanti (da evitare)
$table->string('address_locality', 100);
$table->string('address_region', 100);
$table->string('address_country', 2);

// ✅ Senza prefissi ridondanti (corretto)
$table->string('locality', 100);
$table->string('administrative_area_level_2', 100); // Regione
$table->string('country', 2);
```

## Allineamento con API Esterne

### Google Maps API

Per massimizzare la compatibilità con Google Maps Geocoding API, utilizziamo la stessa nomenclatura per i componenti dell'indirizzo:

```php
// Campi allineati con Google Maps API address_components
'street_number'               // Numero civico
'route'                       // Via/Piazza
'locality'                    // Comune/Città
'administrative_area_level_3' // Provincia
'administrative_area_level_2' // Regione
'administrative_area_level_1' // Stato/Paese
'country'                     // Codice paese
'postal_code'                 // CAP
```

Questo permette:
1. Mappatura diretta dei dati dall'API ai nostri modelli
2. Interoperabilità con altre librerie geocoding
3. Chiarezza semantica universale

### Schema.org

Per supportare lo standard Schema.org PostalAddress, forniamo una mappatura diretta tramite il metodo `toSchemaOrg()`:

```php
// Mappatura da campi del database a Schema.org
'route' + 'street_number'      → 'streetAddress'
'locality'                     → 'addressLocality'
'administrative_area_level_3'  → 'addressSubregion' (estensione per province italiane)
'administrative_area_level_2'  → 'addressRegion'
'country'                      → 'addressCountry'
'postal_code'                  → 'postalCode'
```

## Convenzioni per Relazioni Polimorfiche

Per le relazioni polimorfiche, utilizziamo `model_type` e `model_id` invece dei tradizionali `{nome}_type` e `{nome}_id`:

```php
$table->nullableMorphs('model');
// Crea:
// - model_type (string)
// - model_id (bigint)
```

Vantaggi:
1. Standardizzazione delle relazioni polimorfiche in tutto il progetto
2. Chiarezza sul ruolo della relazione (è sempre un "modello" collegato)
3. Convenzione riconosciuta nell'ecosistema Laravel

## Gerarchia Geografica Italiana

Per gli indirizzi italiani, seguiamo questa mappatura specifica:

```
Comune/Città              → locality
Provincia                 → administrative_area_level_3
Regione                   → administrative_area_level_2
Italia (nome esteso)      → administrative_area_level_1
IT (codice ISO del paese) → country
```

## Esempi Pratici

### Esempio 1: Indirizzo italiano completo

```php
$address = new Address();
$address->route = 'Via Roma';
$address->street_number = '123';
$address->locality = 'Milano';
$address->administrative_area_level_3 = 'Milano'; // Provincia
$address->administrative_area_level_2 = 'Lombardia'; // Regione
$address->administrative_area_level_1 = 'Italia'; // Paese (nome esteso)
$address->country = 'IT'; // Codice ISO
$address->postal_code = '20100';
```

### Esempio 2: Indirizzo estero

```php
$address = new Address();
$address->route = 'Broadway';
$address->street_number = '123';
$address->locality = 'New York';
$address->administrative_area_level_2 = 'New York'; // Stato USA
$address->administrative_area_level_1 = 'United States'; // Paese (nome esteso)
$address->country = 'US'; // Codice ISO
$address->postal_code = '10001';
```

## Considerazioni di Migrazione

Quando si migra da vecchi schemi che utilizzano prefissi ridondanti, è importante:

1. Aggiornare tutte le query esistenti
2. Verificare la compatibilità con i form esistenti
3. Aggiornare eventuali validazioni
4. Creare una migrazione che rinomini i campi in modo appropriato