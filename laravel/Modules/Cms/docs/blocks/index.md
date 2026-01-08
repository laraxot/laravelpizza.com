# Indice della Documentazione - Blocchi CMS

## Collegamenti Correlati
- [Indice CMS](../INDEX.md)
- [README CMS](../README.md)
- [Blocchi](../blocks.md)
- [Componenti Blocchi Contenuto](../componenti-blocchi-contenuto.md)
- [Namespace Componenti Blocchi](../namespace-componenti-blocchi.md)
- [Documentazione Generale](../../../../../docs/README.md)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)

## Panoramica
I blocchi sono componenti riutilizzabili che compongono le sezioni del sito. Ogni blocco ha uno scopo specifico e può essere inserito in diverse sezioni tramite i file JSON di configurazione.
- [Documentazione Generale <nome progetto>](../../../../../docs/README.md)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)

## Panoramica
I blocchi sono componenti riutilizzabili che compongono le sezioni del sito <nome progetto>. Ogni blocco ha uno scopo specifico e può essere inserito in diverse sezioni tramite i file JSON di configurazione.

## Blocchi Disponibili

### Navigazione e Layout
- [Header](./HEADER.md) - Blocco header con logo, navigazione e dropdown utente
- [Footer](./FOOTER.md) - Blocco footer con copyright, link e contatti
- [Navigation](./NAVIGATION.md) - Blocco di navigazione personalizzabile
- [Container](./CONTAINER.md) - Blocco container per strutturare il layout

### Contenuti
- [Hero](./HERO.md) - Blocco hero per sezioni in evidenza
- [Text](./TEXT.md) - Blocco testo per contenuti testuali
- [CTA](./CTA.md) - Blocco call-to-action per conversioni
- [Features](./FEATURES.md) - Blocco per elencare caratteristiche/servizi
- [Testimonials](./TESTIMONIALS.md) - Blocco per testimonianze
- [Team](./TEAM.md) - Blocco per presentare il team
- [FAQ](./FAQ.md) - Blocco per domande frequenti
- [Pricing](./PRICING.md) - Blocco per piani tariffari

### Media
- [Image](./IMAGE.md) - Blocco per immagini singole
- [Gallery](./GALLERY.md) - Blocco per gallerie di immagini
- [Video](./VIDEO.md) - Blocco per contenuti video
- [Slider](./SLIDER.md) - Blocco per carousel/slider

### Interattivi
- [Form](./FORM.md) - Blocco per form di contatto
- [Map](./MAP.md) - Blocco per mappe
- [Social](./SOCIAL.md) - Blocco per link social
- [Search](./SEARCH.md) - Blocco per ricerca

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

Ultimo aggiornamento: 14 Maggio 2025
