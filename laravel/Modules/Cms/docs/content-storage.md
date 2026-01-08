# Sistema di Archiviazione dei Contenuti JSON

## Introduzione

Il sistema utilizza un innovativo approccio di archiviazione dei contenuti basato su file JSON anziché database tradizionali. Questo documento fornisce una panoramica del sistema e rimanda alla documentazione tecnica più dettagliata.

## Concetti Fondamentali

### Database JSON-based

Invece di utilizzare tabelle in un database relazionale, i contenuti vengono archiviati in file JSON strutturati, organizzati in directory che riflettono la struttura delle tabelle di un database tradizionale.

Vantaggi principali:
- **Versionamento**: I contenuti possono essere versionati con Git
- **Portabilità**: Facilità nel trasferire contenuti tra ambienti
- **Semplicità**: Non richiede configurazione di database complessi
- **Multi-tenant**: Supporto nativo per contenuti specifici per tenant

### Integrazione con Laravel Eloquent

Grazie all'utilizzo del pacchetto [Sushi](https://github.com/calebporzio/sushi) e del trait personalizzato `SushiToJsons`, il sistema offre una piena integrazione con l'ORM Eloquent di Laravel, consentendo di manipolare i contenuti JSON come se fossero record di database.

## Struttura dei File JSON

I file JSON sono organizzati in questa struttura:

```
laravel/config/local/{tenant}/database/content/{tabella}/{id}.json
```

Dove:
- `{tenant}` è l'identificatore del tenant
- `{tabella}` è il nome della tabella (es. "pages")
- `{id}` è l'identificatore univoco del record (es. "1")

Esempio per la homepage:
```
laravel/config/local/tenant1/database/content/pages/1.json
```

## Collegamento tra Slug e File JSON

Uno degli aspetti più importanti di questo sistema è come viene gestito il collegamento tra gli slug delle pagine (come "home" per la homepage) e i file JSON corrispondenti.

Il processo è il seguente:
1. La richiesta per una pagina include uno slug (es. "home")
2. Il `ThemeComposer` cerca una pagina con quello slug usando Eloquent
3. Sushi carica i dati dal file JSON corrispondente (es. "1.json")
4. I contenuti vengono renderizzati a partire dai blocchi definiti nel JSON

Per approfondimenti tecnici su questo meccanismo, consulta la [documentazione dettagliata nel modulo CMS](../laravel/Modules/Cms/project_docs/content-storage.md).

## Sezioni del FrontOffice

Le sezioni riutilizzabili del sito, come l'header e il footer, sono definite in file JSON nella directory:
```
laravel/config/local/{tenant}/database/content/sections/{id}.json
```
Ad esempio, il file `sections/1.json` contiene i blocchi (`logo`, `navigation`, `actions`) e gli attributi (`class`, `id`, `style`) per l'header principale del FrontOffice.

## Modifica dei Contenuti

### Tramite Interfaccia Amministrativa

Il modo consigliato per modificare i contenuti è utilizzare l'interfaccia amministrativa Filament, che offre:
- Editor visuale per i blocchi di contenuto
- Validazione dei dati
- Gestione delle traduzioni
- Interfaccia user-friendly

### Modifica Diretta dei JSON

In ambiente di sviluppo, è possibile modificare direttamente i file JSON. Questo può essere utile per modifiche massive o per debug, ma non è consigliato in produzione.

## Contenuti Multilingua

I contenuti possono essere tradotti in più lingue grazie al trait `HasTranslations`. I campi traducibili vengono memorizzati come oggetti JSON con chiavi per ciascuna lingua.

## Pagine a Blocchi

Una caratteristica fondamentale del sistema è la gestione delle pagine tramite blocchi di contenuto, che consente:
- Riutilizzo di componenti di UI
- Flessibilità nella composizione delle pagine
- Facilità di manutenzione e aggiornamento

Per maggiori dettagli sulla struttura dei blocchi di contenuto, consulta la [documentazione dei blocchi nel modulo CMS](../laravel/Modules/Cms/project_docs/content.md).

## Esempi Pratici

### Struttura del File JSON della Homepage

```json
{
    "id": "1",
    "title": {
        "it": "il progetto - Homepage"
    },
    "slug": "home",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "ui::components.blocks.hero.simple",
                    "title": "Benvenuti",
                    "subtitle": "Piattaforma per la <slogan>"
                }
            },
            // Altri blocchi...
        ]
    }
}
```

### Come Modificare la Homepage

Per modificare la homepage:

1. Accedere al pannello amministrativo Filament
2. Navigare alla sezione "Pagine"
3. Selezionare la pagina con slug "home"
4. Modificare i blocchi di contenuto come necessario
5. Salvare le modifiche

## Risorse Tecniche

Per approfondire il funzionamento tecnico del sistema:

- [Sistema di Archiviazione dei Contenuti](../laravel/Modules/Cms/project_docs/content-storage.md) - Documentazione tecnica completa
- [Gestione dei Blocchi di Contenuto](../laravel/Modules/Cms/project_docs/content.md) - Come funzionano i blocchi di contenuto
- [Struttura delle Pagine](../laravel/Modules/Cms/project_docs/page-resource.md) - Informazioni sulle risorse Page
