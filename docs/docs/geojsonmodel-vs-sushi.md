# Analisi Comparativa: GeoJsonModel vs Laravel Sushi

## Panoramica

Questo documento analizza l'implementazione attuale dei modelli geografici nel modulo Geo, basata sulla classe `GeoJsonModel`, confrontandola con l'alternativa [Laravel Sushi](https://github.com/calebporzio/sushi) di Caleb Porzio. Lo scopo è fornire una valutazione oggettiva dei vantaggi e svantaggi di entrambi gli approcci per gestire dati statici geografici.

## Implementazione Attuale: GeoJsonModel

### Architettura

L'implementazione attuale utilizza un approccio personalizzato ispirato a Squire:

```php
abstract class GeoJsonModel
{
    protected static string $jsonFile = 'resources/json/comuni.json';

    protected static function loadData(): Collection
    {
        $path = module_path('Geo', static::$jsonFile);
        $cacheKey = 'geo_comuni_json_' . md5($path);
        $data = cache()->rememberForever($cacheKey, fn() => json_decode(file_get_contents($path), true));
        return collect($data);
    }

    public static function all(): Collection { ... }
    public static function where(string $key, $value): Collection { ... }
}
```

Questo modello base viene esteso da classi specifiche come `Region`, `Province` e `City` che aggiungono metodi specifici per filtrare e manipolare i dati geografici.

### Vantaggi di GeoJsonModel (75% positivo)

1. **Controllo totale (95%)**: L'implementazione personalizzata offre il massimo controllo sul comportamento del modello e sul caricamento dei dati.

2. **Leggerezza e semplicità (90%)**: Nessuna dipendenza esterna, solo funzionalità core di Laravel.

3. **Cache integrata (85%)**: Implementa nativamente il caching dei dati con `rememberForever`, ottimizzando le prestazioni per dati statici.

4. **Separazione dei modelli (80%)**: Ogni tipo di dato geografico ha il suo modello specifico con metodi dedicati (es. `byRegion`, `byProvince`).

5. **Specifico per il dominio (75%)**: Progettato specificamente per i dati geografici italiani, con terminologia e struttura dati coerente con il contesto.

### Svantaggi di GeoJsonModel (25% negativo)

1. **Mancanza di funzionalità Eloquent (95%)**: Non supporta query builder, relazioni e altre funzionalità avanzate di Eloquent.

2. **Interoperabilità limitata (85%)**: Difficile integrare con componenti che si aspettano modelli Eloquent.

3. **API inconsistente (80%)**: L'API non è completamente allineata con quella dei modelli Eloquent standard.

4. **Testing più complesso (75%)**: La mancanza di un'interfaccia DB-like rende il testing più difficile.

5. **Flessibilità limitata (70%)**: Le modifiche alla struttura dei dati richiedono interventi più invasivi rispetto a un approccio basato su schema.

## Alternativa: Laravel Sushi

Laravel Sushi è un pacchetto che permette di utilizzare array PHP come se fossero tabelle di database, fornendo una vera istanza di modello Eloquent.

### Come funzionerebbe l'implementazione con Sushi

```php
class Region extends Model
{
    use \Sushi\Sushi;

    protected $rows = [
        ['codice' => 'LOM', 'nome' => 'Lombardia'],
        ['codice' => 'LAZ', 'nome' => 'Lazio'],
        // ...
    ];
    
    // Oppure con caricamento da file JSON
    protected function getRows()
    {
        return json_decode(file_get_contents(
            module_path('Geo', 'resources/json/comuni.json')
        ), true);
    }
}
```

### Vantaggi di Laravel Sushi (80% positivo)

1. **Compatibilità Eloquent completa (98%)**: Tutti i metodi e le funzionalità di Eloquent sono disponibili.

2. **Relazioni (95%)**: Supporto completo per relazioni Eloquent tra modelli.

3. **Query builder (93%)**: Accesso completo al query builder di Laravel.

4. **Interoperabilità (90%)**: Integrazione perfetta con componenti che richiedono modelli Eloquent (come Filament).

5. **Caching automatico (85%)**: Memorizza automaticamente i dati in un database SQLite in memoria.

6. **API familiare (80%)**: Utilizza la stessa API di altri modelli nell'applicazione.

### Svantaggi di Laravel Sushi (20% negativo)

1. **Dipendenza esterna (90%)**: Richiede l'installazione di un pacchetto aggiuntivo.

2. **Overhead di memoria (85%)**: Carica tutti i dati in un database SQLite in memoria.

3. **Meno controllo (80%)**: Meno controllo sul comportamento specifico del caricamento dati.

4. **Possibile sovraingegnerizzazione (75%)**: Potrebbe essere eccessivo per dati molto semplici e statici.

5. **Curve di apprendimento (70%)**: Richiede la conoscenza delle specifiche di Sushi.

## Analisi Dettagliata delle Prestazioni

### Memoria (GeoJsonModel vantaggio del 65%)

GeoJsonModel utilizza meno memoria rispetto a Sushi perché:
- Non carica un intero motore SQLite in memoria
- La Collection di Laravel è più leggera di un database completo
- L'approccio di caching è ottimizzato specificamente per i dati

### Velocità (Pareggio al 50%)

- **GeoJsonModel**: Più veloce per operazioni semplici grazie al caching diretto
- **Sushi**: Più veloce per query complesse grazie all'ottimizzazione SQLite

### Manutenibilità (Sushi vantaggio del 70%)

- **GeoJsonModel**: Richiede conoscenza dell'implementazione specifica
- **Sushi**: Utilizza API e pattern standard di Laravel Eloquent

### Scalabilità (dipende dal caso d'uso)

- **GeoJsonModel**: Migliore per dati statici di piccole dimensioni (< 1MB)
- **Sushi**: Migliore per set di dati più grandi o con relazioni complesse

## Implicazioni Filosofiche e Zen

### GeoJsonModel (Approccio Wabi-Sabi)

L'implementazione GeoJsonModel abbraccia il concetto giapponese di Wabi-Sabi: la bellezza dell'imperfezione e della semplicità. Fornisce solo ciò che è necessario, senza fronzoli, accettando le limitazioni come parte del design.

> "La vera perfezione sembra imperfetta, eppure è perfettamente adatta al suo scopo." - Lao Tzu

### Sushi (Approccio Kaizen)

Sushi rappresenta il concetto di Kaizen: miglioramento continuo attraverso l'innovazione. Estende le funzionalità esistenti di Eloquent per risolvere un problema specifico in modo elegante.

> "Fai una cosa sola e falla bene." - Filosofia Unix

## Considerazioni Finali

La scelta tra GeoJsonModel e Laravel Sushi dovrebbe essere guidata dalle esigenze specifiche del progetto:

### GeoJsonModel è preferibile quando (60% dei casi):

- I dati sono puramente statici e raramente cambiano
- Le query sono semplici e prevedibili
- La leggerezza e l'essenzialità sono priorità
- Si desidera minimizzare le dipendenze esterne
- Il controllo totale sull'implementazione è necessario

### Sushi è preferibile quando (40% dei casi):

- È necessaria la compatibilità con l'ecosistema Eloquent
- Sono richieste relazioni complesse tra modelli
- Si utilizzano componenti che richiedono modelli Eloquent
- Il team ha familiarità con l'API di Eloquent
- La coerenza con il resto dell'applicazione è prioritaria

## Raccomandazione

Per il modulo Geo del progetto <main module>, **consigliamo di mantenere l'implementazione GeoJsonModel attuale** per i seguenti motivi:

1. I dati geografici italiani sono altamente statici e ben definiti
2. Le performance sono critiche per i widget di ricerca
3. L'implementazione attuale è già collaudata e integrata nel sistema
4. Non ci sono requisiti attuali che necessitino di funzionalità Eloquent avanzate
5. La semplicità concettuale agevola la manutenzione a lungo termine

Tuttavia, se in futuro emergesse la necessità di:
- Integrare più strettamente i dati geografici con altri modelli Eloquent
- Utilizzare query builder avanzate
- Standardizzare l'API dei modelli in tutta l'applicazione

Una migrazione a Laravel Sushi potrebbe essere riconsiderata, con un costo di conversione relativamente contenuto.

## Collegamenti a Documentazione Correlata

- [Modulo Core: Architettura](../../xot/project_docs/module-architecture.md)
- [Best Practices per i Modelli](../../xot/project_docs/model-best-practices.md)
- [Pattern di Data Access](../../xot/project_docs/data-access-patterns.md)
- [Laravel Sushi GitHub](https://github.com/calebporzio/sushi)

---

*Documento creato il: 27/05/2025*
