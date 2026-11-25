---
title: "Topic content-json"
type: digest
status: active
qmd: "digest ceiling 100 content-json"
---

# Topic content-json

Sintesi automatica di 3 documenti (chiave `content-json`).

## Mappatura tra Slug e File JSON

_Fonte: `content-json-mapping-1-2.md`_

# Mappatura tra Slug e File JSON

## Indice
- [Introduzione](#introduzione)
- [Architettura del Sistema](#architettura-del-sistema)
- [Il Trait SushiToJsons](#il-trait-sushitojsons)
- [Flusso di Caricamento dei Contenuti](#flusso-di-caricamento-dei-contenuti)
- [Perché lo Slug "home" è Collegato al File 1.json](#perché-lo-slug-home-è-collegato-al-file-1json)
- [Vantaggi di Questa Architettura](#vantaggi-di-questa-architettura)
- [Personalizzazione e Estensione](#personalizzazione-e-estensione)

## Introduzione

In questo sistema, i contenuti delle pagine sono gestiti tramite file JSON memorizzati in una directory specifica. Questo documento spiega in dettaglio come funziona il meccanismo che collega uno slug di pagina (come "home") a un file JSON specifico (come `1.json`).

## Architettura del Sistema

Il sistema di gestione dei contenuti si basa su diversi componenti chiave:

1. **Modello Page**: Definito in `Modules/Cms/app/Models/Page.php`, rappresenta una pagina del sito
2. **Trait SushiToJsons**: Definito in `Modules/Tenant/app/Models/Traits/SushiToJsons.php`, gestisce il caricamento dei dati dai file JSON
3. **ThemeComposer**: Definito in `Modules/Cms/app/View/Composers/ThemeComposer.php`, fornisce metodi per visualizzare i contenuti delle pagine
4. **TenantService**: Definito in `Modules/Tenant/app/Services/TenantService.php`, gestisce i percorsi dei file specifici del tenant

Questa architettura implementa un pattern di "database virtuale" basato su file JSON, utilizz

## Mappatura tra Slug e File JSON

_Fonte: `content-json-mapping-1.md`_

# Mappatura tra Slug e File JSON

## Indice
- [Introduzione](#introduzione)
- [Architettura del Sistema](#architettura-del-sistema)
- [Il Trait SushiToJsons](#il-trait-sushitojsons)
- [Flusso di Caricamento dei Contenuti](#flusso-di-caricamento-dei-contenuti)
- [Perché lo Slug "home" è Collegato al File 1.json](#perché-lo-slug-home-è-collegato-al-file-1json)
- [Vantaggi di Questa Architettura](#vantaggi-di-questa-architettura)
- [Personalizzazione e Estensione](#personalizzazione-e-estensione)

## Introduzione

In questo sistema, i contenuti delle pagine sono gestiti tramite file JSON memorizzati in una directory specifica. Questo documento spiega in dettaglio come funziona il meccanismo che collega uno slug di pagina (come "home") a un file JSON specifico (come `1.json`).

## Architettura del Sistema

Il sistema di gestione dei contenuti si basa su diversi componenti chiave:

1. **Modello Page**: Definito in `Modules/Cms/app/Models/Page.php`, rappresenta una pagina del sito
2. **Trait SushiToJsons**: Definito in `Modules/Tenant/app/Models/Traits/SushiToJsons.php`, gestisce il caricamento dei dati dai file JSON
3. **ThemeComposer**: Definito in `Modules/Cms/app/View/Composers/ThemeComposer.php`, fornisce metodi per visualizzare i contenuti delle pagine
4. **TenantService**: Definito in `Modules/Tenant/app/Services/TenantService.php`, gestisce i percorsi dei file specifici del tenant

Questa architettura implementa un pattern di "database virtuale" basato su file JSON, utilizz

## Mappatura tra Slug e File JSON

_Fonte: `content-json-mapping.md`_

# Mappatura tra Slug e File JSON

> **Aggiornato 12/11/2026.** Il caricamento oggi legge anche le sottocartelle (`File::allFiles`, non `glob('*.json')`):
> `pages/events/my.json` con `"slug": "my"` diventa la pagina `events.my` (URL `/events/my`). Le sotto-pagine di un
> contenitore vanno sempre nella sua cartella: [cms-subpages-folders.md](cms-subpages-folders.md). Il resto di questo
> documento descrive la versione precedente ed è tenuto per storia.

## Indice
- [Introduzione](#introduzione)
- [Architettura del Sistema](#architettura-del-sistema)
- [Il Trait SushiToJsons](#il-trait-sushitojsons)
- [Flusso di Caricamento dei Contenuti](#flusso-di-caricamento-dei-contenuti)
- [Perché lo Slug "home" è Collegato al File 1.json](#perché-lo-slug-home-è-collegato-al-file-1json)
- [Vantaggi di Questa Architettura](#vantaggi-di-questa-architettura)
- [Personalizzazione e Estensione](#personalizzazione-e-estensione)

## Introduzione

In questo sistema, i contenuti delle pagine sono gestiti tramite file JSON memorizzati in una directory specifica. Questo documento spiega in dettaglio come funziona il meccanismo che collega uno slug di pagina (come "home") a un file JSON specifico (come `1.json`).

## Architettura del Sistema

Il sistema di gestione dei contenuti si basa su diversi componenti chiave:

1. **Modello Page**: Definito in `Modules/Cms/app/Models/Page.php`, rappresenta una pagina del sito
2. **Trait SushiToJsons**: Definito in `Modules/Tenant/app/Models/Traits/SushiToJsons.p
