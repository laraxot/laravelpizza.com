# Indice della Documentazione - Blocchi CMS

## Collegamenti Correlati
- [Indice CMS](../index.md)
- [README CMS](../readme.md)
- [Blocchi](../blocks.md)
- [Componenti Blocchi Contenuto](../componenti-blocchi-contenuto.md)
- [Namespace Componenti Blocchi](../namespace-componenti-blocchi.md)
- [Documentazione Generale](../../../../../docs/readme.md)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)

## Panoramica
I blocchi sono componenti riutilizzabili che compongono le sezioni del sito. Ogni blocco ha uno scopo specifico e può essere inserito in diverse sezioni tramite i file JSON di configurazione.
- [Documentazione Generale <nome progetto>](../../../../../docs/readme.md)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)

## Panoramica
I blocchi sono componenti riutilizzabili che compongono le sezioni del sito <nome progetto>. Ogni blocco ha uno scopo specifico e può essere inserito in diverse sezioni tramite i file JSON di configurazione.

## Blocchi Disponibili

### Navigazione e Layout
- [Header](./header.md) - Blocco header con logo, navigazione e dropdown utente
- [Footer](./footer.md) - Blocco footer con copyright, link e contatti
- [Navigation](./navigation.md) - Blocco di navigazione personalizzabile
- [Container](./container.md) - Blocco container per strutturare il layout

### Contenuti
- [Hero](./hero.md) - Blocco hero per sezioni in evidenza
- [Text](./text.md) - Blocco testo per contenuti testuali
- [CTA](./cta.md) - Blocco call-to-action per conversioni
- [Features](./features.md) - Blocco per elencare caratteristiche/servizi
- [Testimonials](./testimonials.md) - Blocco per testimonianze
- [Team](./team.md) - Blocco per presentare il team
- [FAQ](./faq.md) - Blocco per domande frequenti
- [Pricing](./pricing.md) - Blocco per piani tariffari

### Media
- [Image](./image.md) - Blocco per immagini singole
- [Gallery](./gallery.md) - Blocco per gallerie di immagini
- [Video](./video.md) - Blocco per contenuti video
- [Slider](./slider.md) - Blocco per carousel/slider

### Interattivi
- [Form](./form.md) - Blocco per form di contatto
- [Map](./map.md) - Blocco per mappe
- [Social](./social.md) - Blocco per link social
- [Search](./search.md) - Blocco per ricerca

## Struttura dei Blocchi

Ogni blocco segue una struttura standardizzata:

1. **View Blade**: `Modules/Cms/resources/views/blocks/[nome-blocco].blade.php`
2. **Configurazione JSON**: Definita nei file `config/local/<directory progetto>/database/content/sections/[id].json`
2. **Configurazione JSON**: Definita nei file `config/local/<nome progetto>/database/content/sections/[id].json`
3. **Stili CSS**: Definiti in `Themes/One/resources/css/blocks/[nome-blocco].css`

## Implementazione

L'implementazione di un blocco richiede:

1. Creazione della view Blade
2. Definizione della struttura JSON
3. Creazione degli stili CSS
4. Documentazione del blocco

## Best Practices

1. Mantenere i blocchi modulari e riutilizzabili
2. Evitare dipendenze tra blocchi
3. Supportare la responsività
4. Garantire l'accessibilità
5. Ottimizzare le performance
6. Documentare ogni blocco con esempi

## Note Importanti

- Ogni blocco deve essere autocontenuto e non dipendere da altri blocchi
- I blocchi devono supportare la localizzazione tramite le chiavi del file JSON
- L'implementazione deve seguire le convenzioni di naming del progetto

