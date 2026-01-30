# Mappatura dei Contenuti in Base

## Indice
- [Introduzione](#introduzione)
- [Come Funziona la Mappatura](#come-funziona-la-mappatura)
- [Struttura dei File JSON](#struttura-dei-file-json)
- [Perché Questa Architettura](#perché-questa-architettura)
- [Documentazione Dettagliata](#documentazione-dettagliata)

## Introduzione

Base utilizza un sistema innovativo per la gestione dei contenuti delle pagine, basato su file JSON memorizzati in una directory specifica. Questo documento fornisce una panoramica di come funziona la mappatura tra gli slug delle pagine (come "home") e i file JSON specifici (come `1.json`).

## Come Funziona la Mappatura

In Base, la mappatura tra uno slug di pagina e un file JSON avviene attraverso un meccanismo basato sul trait `SushiToJsons` e sulla libreria [Sushi](https://github.com/calebporzio/sushi). Ecco i passaggi principali:

1. Quando viene richiesta una pagina (ad esempio la homepage), il sistema cerca una pagina con lo slug corrispondente (ad esempio "home")
2. Il modello `Page` utilizza il trait `SushiToJsons` per caricare i dati dai file JSON in `database/content/pages/`
3. Il sistema cerca tra i file JSON caricati quello che contiene `"slug": "home"`
4. Se trova una corrispondenza (in questo caso nel file `1.json`), utilizza quel file per caricare i contenuti della pagina

È importante notare che **non è il nome del file** (1.json) a determinare lo slug, ma il **contenuto del file** stesso. Il nome del file corrisponde all'ID della pagina nel "database virtuale" creato da Sushi.

## Struttura dei File JSON

I file JSON dei contenuti sono strutturati in questo modo:

```json
{
    "id": "1",
    "title": {
        "it": "Base - Promozione della salute orale per le gestanti"
    },
    "slug": "home",
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "ui::components.blocks.hero.simple",
                    "title": "Benvenuta su Salute Orale,",
                    "subtitle": "...",
                    "image": "/img/hero-bg.jpg",
                    "cta_text": "INIZIA ORA",
                    "cta_link": "{{ route('register') }}"
                }
            },
            // Altri blocchi di contenuto...
        ]
    }
}
```

Ogni file contiene:
- Un `id` che corrisponde al nome del file
- Un `title` multilingua
- Uno `slug` che identifica la pagina
- Un array di `content_blocks` organizzati per lingua

## Perché Questa Architettura

Questa architettura è stata scelta per diversi motivi:

1. **Semplicità**: I contenuti sono memorizzati in file JSON facilmente modificabili
2. **Versionamento**: I file JSON possono essere versionati con Git
3. **Portabilità**: I contenuti possono essere facilmente trasferiti tra ambienti
4. **Flessibilità**: Nuove pagine possono essere aggiunte semplicemente creando nuovi file JSON
5. **Interfaccia Familiare**: Grazie a Sushi, i dati possono essere manipolati utilizzando l'API di Eloquent
6. **Multi-tenancy**: Il `TenantService` permette di avere contenuti specifici per ogni tenant

Questo approccio consente di separare completamente i contenuti dal codice, facilitando la manutenzione e l'aggiornamento del sito.

## Documentazione Dettagliata

Per una documentazione più approfondita sulla mappatura tra slug e file JSON, consulta:

- [Mappatura tra Slug e File JSON](../laravel/Modules/Cms/docs/content_json_mapping.md) - Analisi dettagliata del meccanismo di mappatura
- [Architettura della Homepage](../laravel/Modules/Cms/docs/homepage_architecture.md) - Come la homepage utilizza questo sistema

## Riferimenti

- [Homepage di Base](./homepage.md) - Panoramica della struttura e del funzionamento della homepage
- [Architettura del Frontoffice](./architettura_frontoffice.md) - Panoramica dell'architettura del frontoffice
