# Indice della Documentazione - Sezioni CMS

## Collegamenti Correlati
- [Indice CMS](../INDEX.md)
- [README CMS](../README.md)
- [Sezioni](../sections.md)
- [Gestione Sezioni](../section-management.md)
- [Documentazione Generale](../../../../../docs/README.md)
- [Documentazione Generale <nome progetto>](../../../../../docs/README.md)
- [Collegamenti Documentazione](../../../../../docs/collegamenti-documentazione.md)
- [Implementazione nell'UI](../../../UI/docs/sections/INDEX.md)
- [Implementazione nel Tema One](../../../../Themes/One/docs/sections/INDEX.md)

## Panoramica
Le sezioni sono componenti strutturali che compongono le pagine del sito. Ogni sezione può contenere diversi blocchi e viene definita tramite file JSON di configurazione.
Le sezioni sono componenti strutturali che compongono le pagine del sito <nome progetto>. Ogni sezione può contenere diversi blocchi e viene definita tramite file JSON di configurazione.

## Sezioni Principali

### Header
- [Header](./header.md) - Documentazione generale dell'header
- [Header Section](./header-section.md) - Struttura e implementazione della sezione header
- [Header con Lingua e Dropdown Utente](./HEADER_LANGUAGE_USER_DROPDOWN.md) - Implementazione completa del dropdown utente e selettore lingua
- [Header con Lingua e Avatar](./HEADER_LANGUAGE_AVATAR_IMPLEMENTATION.md) - Implementazione dell'avatar utente e selettore lingua
- [Selettore Lingua con Bandiere](./HEADER_LANGUAGE_SELECTOR_WITH_FLAGS.md) - Implementazione del selettore lingua con bandiere

### Footer
- [Footer Section](./footer-section.md) - Struttura e implementazione della sezione footer

## Struttura delle Sezioni

Ogni sezione segue una struttura standardizzata:

1. **File di Configurazione**: `config/local/<directory progetto>/database/content/sections/[id].json`
1. **File di Configurazione**: `config/local/<nome progetto>/database/content/sections/[id].json`
2. **Blocchi**: Componenti riutilizzabili che compongono la sezione
3. **Stili**: Definiti nei file CSS del tema

## Implementazione JSON

La struttura JSON tipica di una sezione include:

```json
{
  "id": 1,
  "name": {
    "it": "Nome Sezione",
    "en": "Section Name"
  },
  "slug": "nome-sezione",
  "blocks": [
    {
      "name": "Blocco 1",
      "type": "blocco1",
      "view": "cms::blocks.blocco1",
      "data": {
        "it": {
          // Contenuti in italiano
        },
        "en": {
          // Contenuti in inglese
        }
      }
    }
  ],
  "attributes": {
    "class": "classe-css",
    "id": "id-html"
  }
}
```

## Best Practices

1. **Localizzazione**: Raggruppare i contenuti per lingua usando le chiavi di lingua (it, en)
2. **Struttura Coerente**: Mantenere una struttura coerente tra le sezioni
3. **Blocchi Riutilizzabili**: Utilizzare blocchi riutilizzabili per massimizzare l'efficienza
4. **Validazione**: Validare i file JSON prima dell'utilizzo
5. **Performance**: Ottimizzare le prestazioni limitando la complessità delle sezioni

## Note Importanti

- Le sezioni vengono caricate dinamicamente in base alla richiesta
- La lingua corrente viene utilizzata per filtrare i contenuti visibili
- I blocchi devono esistere come view Blade nella directory `Modules/Cms/resources/views/blocks`
- Tutte le modifiche alle strutture JSON devono essere documentate

## Regole di Implementazione

- **MAI utilizzare percorsi assoluti** nei file JSON
- Utilizzare sempre percorsi relativi per i collegamenti
- I riferimenti ai blocchi devono sempre utilizzare la notazione `cms::blocks.nome-blocco`
- I valori tradotti devono essere organizzati per lingua come nell'esempio sopra

Ultimo aggiornamento: 14 Maggio 2025
