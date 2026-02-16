# Laravel Sushi: Guida Completa

## Cos'è Laravel Sushi?

Laravel Sushi è un pacchetto creato da Caleb Porzio che fornisce un "driver array" per Eloquent, permettendo di utilizzare modelli Eloquent popolati da array statici o dati a runtime invece che da tabelle di database. Essenzialmente, trasforma array PHP in modelli Eloquent completamente funzionanti.

## Come Funziona Sushi

Sotto il cofano, Sushi crea e memorizza nella cache un database SQLite specifico per ogni modello che utilizza il trait. Quando si definisce un modello con Sushi:

1. Sushi crea automaticamente una migrazione SQLite e una tabella
2. Popola la tabella con i dati forniti nel modello
3. Memorizza il database SQLite in cache per migliorare le performance
4. Se non può memorizzare in cache un file .sqlite, utilizza un database SQLite in memoria

## Requisiti

- Estensione PHP [pdo-sqlite](https://www.php.net/manual/en/ref.pdo-sqlite.php) installata sul server
- Laravel 5.8 o superiore

## Installazione

```bash
composer require calebporzio/sushi
```

## Utilizzo Base

L'implementazione di Sushi richiede due semplici passaggi:

1. Aggiungere il trait `\Sushi\Sushi` al modello
2. Definire una proprietà `$rows` contenente i dati o implementare un metodo `getRows()`

Esempio base:

```php
<?php

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Region extends Model
{
    use Sushi;

    protected $rows = [
        [
            'code' => 'LOM',
            'name' => 'Lombardia',
        ],
        [
            'code' => 'LAZ',
            'name' => 'Lazio',
        ],
        // Altri dati...
    ];
}
```

Ora è possibile utilizzare questo modello come qualsiasi altro modello Eloquent:

```php
$regionName = Region::whereCode('LOM')->first()->name; // "Lombardia"
```

## Caratteristiche Principali

### 1. Dati Statici vs Dinamici

**Approccio Statico** (usando `$rows`):
```php
protected $rows = [
    ['id' => 1, 'name' => 'Lombardia'],
    ['id' => 2, 'name' => 'Lazio'],
];
```

**Approccio Dinamico** (usando `getRows()`):
```php
public function getRows()
{
    // Carica dati da file JSON, API esterna o qualsiasi fonte
    return json_decode(file_get_contents(
        module_path('Geo', 'resources/json/regions.json')
    ), true);
}
```

### 2. Relazioni

I modelli Sushi possono avere relazioni con altri modelli Eloquent standard:

```php
// Un modello Sushi
class Province extends Model
{
    use Sushi;
    
    protected $rows = [
        ['id' => 1, 'code' => 'MI', 'name' => 'Milano', 'region_id' => 1],
        ['id' => 2, 'code' => 'RM', 'name' => 'Roma', 'region_id' => 2],
    ];
    
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    
    public function comuni()
    {
        return $this->hasMany(Comune::class);
    }
}
```

### 3. Schema Personalizzato

È possibile definire uno schema personalizzato per i campi:

```php
protected $schema = [
    'population' => 'integer',
    'latitude' => 'float',
    'longitude' => 'float',
    'is_active' => 'boolean',
];
```

### 4. Personalizzazione della Migrazione

Si può personalizzare la tabella SQLite generata:

```php
protected function afterMigrate(Blueprint $table)
{
    $table->index('code');
    $table->unique(['region_id', 'code']);
}
```

## Vantaggi di Sushi

1. **Semplicità**: Implementazione veloce senza necessità di migrazioni o tabelle
2. **Performance**: Eccellente per dataset piccoli e medi (fino a 10-20k record)
3. **API Eloquent Completa**: Supporta quasi tutte le funzionalità di Eloquent (query, relazioni, eager loading)
4. **Caching Automatico**: Crea e memorizza automaticamente in cache il database SQLite
5. **Nessun Database Esterno**: Ideale per dati statici o semi-statici
6. **Testabilità**: Facile da testare poiché i dati sono definiti nel codice
7. **Versionamento**: I dati vengono versionati con il codice in Git

## Limitazioni

1. **Non Adatto per Dataset Enormi**: Performance degradate con dataset molto grandi (>50k record)
2. **No Query Cross-Database**: Le query `whereHas()` tra modelli Sushi e modelli database standard non funzionano
3. **Dipendenza da SQLite**: Richiede l'estensione pdo-sqlite
4. **No Streaming**: Carica tutti i dati in memoria
5. **Limitazioni nelle Transazioni**: Non è possibile utilizzare transazioni tra modelli Sushi e modelli database standard

## Pattern di Utilizzo Consigliati

### 1. Dati di Riferimento Statici
Ideale per dati che cambiano raramente come regioni, province, comuni, CAP, codici valuta, lingue, ecc.

### 2. Dati di Configurazione
Perfetto per configurazioni di sistema, settaggi, opzioni predefinite.

### 3. Enum Avanzati
Alternativa potente agli enum PHP quando servono relazioni e query.

### 4. Dataset di Medie Dimensioni
Efficiente per dataset fino a 10-20k record che non richiedono query complesse.

### 5. Prototipi e POC
Eccellente per prototipazione rapida e proof-of-concept.

## Considerazioni sulle Performance

- **Dataset <1k records**: Performance eccellenti, praticamente istantanee
- **Dataset 1k-10k records**: Performance molto buone
- **Dataset 10k-50k records**: Performance accettabili per molti casi d'uso
- **Dataset >50k records**: Considerare alternative come database tradizionali

## Alternativa: JSON vs Sushi

| Caratteristica | JSON Diretto | Sushi |
|----------------|--------------|-------|
| Semplicità | Alta | Media |
| API Eloquent | No | Sì |
| Relazioni | No | Sì |
| Performance | Alta per lettura diretta | Media-Alta |
| Manutenibilità | Media | Alta |
| Tipizzazione | Manuale | Automatica |
| Query Complesse | No | Sì |

## Conclusioni

Laravel Sushi è un'eccellente soluzione per:
- Dati di riferimento statici o semi-statici
- Dataset di piccole e medie dimensioni
- Quando si desidera l'API completa di Eloquent
- Quando non si vuole creare e mantenere tabelle di database

Rappresenta un equilibrio ottimale tra la semplicità degli array PHP e la potenza dei modelli Eloquent, rendendo la gestione dei dati di riferimento molto più elegante e manutenibile.

## Risorse Utili

- [Repository ufficiale di Laravel Sushi](https://github.com/calebporzio/sushi)
- [Documentazione di Laravel Eloquent](https://laravel.com/project_docs/eloquent)
- [Estensione PDO SQLite](https://www.php.net/manual/en/ref.pdo-sqlite.php)
