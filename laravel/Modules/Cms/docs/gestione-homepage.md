# Gestione della Homepage in il progetto

Questo documento fornisce una panoramica generale della gestione della homepage in il progetto. Per i dettagli tecnici dell'implementazione, consultare la [documentazione tecnica nel modulo CMS](../laravel/Modules/Cms/project_docs/homepage.md).

## Panoramica

La homepage di il progetto è il punto di ingresso principale per gli utenti del portale. È progettata per:

1. Fornire informazioni chiare sui servizi offerti
2. Facilitare l'accesso ai servizi per le pazienti vulnerabili in stato di gravidanza
3. Presentare statistiche e informazioni sul progetto

## Struttura dei File

La homepage di il progetto è gestita attraverso due componenti principali:

1. **File di Configurazione JSON**:
   ```
   /var/www/html/<directory progetto>/laravel/config/local/<directory progetto>/database/content/pages/1.json
   ```
   Questo file contiene la definizione completa dei contenuti della homepage.

2. **Template Blade**:
   ```
   /laravel/Themes/One/resources/views/pages/index.blade.php
   ```
   Questo file gestisce il rendering dei contenuti.

## Configurazione dei Contenuti

Il file `1.json` contiene la struttura completa della homepage:

```json
{
    "id": "1",
    "title": {
        "it": "il progetto - Promozione della <slogan> per le gestanti"
    },
    "slug": "home",
    "content_blocks": {
        "it": [
            // Blocchi di contenuto
        ]
    }
}
```

### Struttura dei Blocchi

Ogni blocco ha una struttura standard:
```json
{
    "type": "tipo_blocco",
    "data": {
        "view": "percorso_componente_blade",
        // Altri dati specifici del blocco
    }
}
```

## Tipi di Blocchi Disponibili

1. **Hero** (`type: "hero"`):
   - Sezione principale con immagine di sfondo
   - Titolo e sottotitolo
   - Call-to-action personalizzabile

2. **Paragraph** (`type: "paragraph"`):
   - Blocchi di testo semplice
   - Supporto per contenuti formattati

3. **Feature Sections** (`type: "feature_sections"`):
   - Sezioni con icone
   - Titoli e descrizioni
   - Layout personalizzabile

4. **Stats** (`type: "stats"`):
   - Visualizzazione di statistiche
   - Numeri e label personalizzabili

5. **CTA** (`type: "cta"`):
   - Call-to-action standalone
   - Pulsanti e link personalizzabili

## Personalizzazione

### Modificare i Contenuti

Per modificare i contenuti della homepage:

1. Aprire il file `1.json`
2. Modificare i blocchi esistenti o aggiungerne di nuovi
3. Rispettare la struttura JSON e i tipi di blocchi supportati

### Aggiungere Nuovi Tipi di Blocchi

Per aggiungere un nuovo tipo di blocco:

1. Creare il componente Blade corrispondente
2. Aggiungere la logica di rendering nel ThemeComposer
3. Aggiungere il nuovo blocco nel file JSON

## Gestione dei Contenuti

I contenuti della homepage sono gestiti attraverso un sistema basato su JSON che permette:
- Aggiornamenti facili e veloci
- Supporto multilingua
- Flessibilità nella struttura

Per i dettagli tecnici sulla gestione dei contenuti, consultare:
- [Documentazione Tecnica CMS](../laravel/Modules/Cms/project_docs/homepage.md)
- [Gestione dei Blocchi](../laravel/Modules/Cms/project_docs/content-blocks.md)
- [Sistema dei Temi](../laravel/Modules/Cms/project_docs/themes.md)

## Collegamenti alla Documentazione

- [Architettura del Frontoffice](./architettura_frontoffice.md)
- [Linee Guida per la Documentazione](./linee-guida-documentazione.md)
- [Standard di Codice](./standard-codice.md)
