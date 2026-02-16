# Modello Comune

## Introduzione

Il modello `Comune` è il punto di accesso unificato per tutti i dati geografici del sistema. Sostituisce i precedenti modelli separati per Regioni, Province, Città e CAP, offrendo un'interfaccia più coerente e performante.

## Caratteristiche Principali

- **Dati Unificati**: Tutte le informazioni geografiche in un unico modello
- **Performance Ottimizzate**: Cache integrata per le query più comuni
- **API Semplice**: Metodi chiari e intuitivi per accedere ai dati
- **Tipo Forte**: PHPStan e analisi statica di alto livello
- **Documentazione Completa**: Ogni metodo è ben documentato

## Utilizzo di Base

### Ottenere Tutti i Comuni

```php
use Modules\Geo\Models\Comune;

$comuni = Comune::all();
```

### Ricerca per Regione

```php
// Per codice regione (es. '05' per Veneto)
$comuni = Comune::byRegion('05');

// Per nome regione
$regione = Comune::allRegions()->search('Veneto');
$comuni = Comune::byRegion($regione);
```

### Ricerca per Provincia

```php
// Per codice provincia (es. '028' per Padova)
$comuni = Comune::byProvince('028');
```

### Ricerca per Nome Comune

```php
// Ricerca case-insensitive con corrispondenza parziale
$risultati = Comune::searchByName('pad');
```

### Ricerca per CAP

```php
$comuni = Comune::byCap('35121');
```

## Metodi Utili

### Elenco di Tutte le Regioni

```php
$regioni = Comune::allRegions();
// Restituisce Collection di [codice => nome]
```

### Elenco di Tutte le Province

```php
$province = Comune::allProvinces();
// Restituisce Collection di [codice => nome]
```

### Province per Regione

```php
$province = Comune::getProvincesByRegion('05');
// Restituisce Collection di [codice => nome] per la regione specificata
```

### CAP per Comune

```php
$cap = Comune::getCapsByCity('Padova');
// Restituisce Collection di CAP per il comune specificato
```

## Gestione della Cache

Tutte le query sono memorizzate nella cache per 7 giorni. Per svuotare manualmente la cache:

```php
Comune::clearCache();
```

## Best Practices

1. **Utilizzare i Metodi di Ricerca** invece di filtrare manualmente le collezioni
2. **Sfruttare la Cache** - I risultati sono già ottimizzati
3. **Ordinamento** - I risultati sono già ordinati per nome
4. **Tipo Forte** - Utilizzare i tipi corretti per i codici

## Esempio Completo

```php
use Modules\Geo\Models\Comune;

// 1. Ottieni tutte le regioni
$regioni = Comune::allRegions();

// 2. Seleziona una regione
$codiceRegione = '05'; // Veneto

// 3. Ottieni le province della regione
$province = Comune::getProvincesByRegion($codiceRegione);

// 4. Seleziona una provincia
$codiceProvincia = '028'; // Padova

// 5. Ottieni i comuni della provincia
$comuni = Comune::byProvince($codiceProvincia);

// 6. Cerca un comune specifico
$risultati = Comune::searchByName('padova');
```

## Note sulla Performance

- Le query più comuni sono memorizzate nella cache
- I dati sono caricati in modo lazy
- Le operazioni di filtraggio sono ottimizzate

## Aggiornamento Dati

Per aggiornare i dati geografici, sostituire il file `resources/json/comuni.json` ed eseguire:

```php
Comune::clearCache();
```

## Requisiti

- PHP 8.1+
- Laravel 10.x+
- Estensione JSON di PHP abilitata

## Sicurezza

- Tutti i metodi sono `readonly`
- I dati in input vengono validati
- Le query sono protette da injection SQL (usando collezioni)

## Link Correlati

- [GeoJsonModel](geo-json-model.md)
- [Struttura Dati Geografici](geo-entities.md)
- [Guida alla Migrazione](migration-guide.md)
