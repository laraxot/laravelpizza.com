# Gestione Traduzioni Contenuti JSON

Questo documento descrive come gestire le traduzioni per i contenuti JSON nel progetto quaeris, con particolare attenzione ai file di contenuto delle pagine.

## Struttura dei Contenuti Traducibili

### File di Contenuto delle Pagine

I contenuti delle pagine sono memorizzati in file JSON nella directory:
```
config/local/quaeris/database/content/pages/
```

### Struttura Standard

Ogni file JSON può contenere sezioni traducibili seguendo questo pattern:

```json
{
    "id": "8",
    "title": {
        "it": "Titolo in Italiano",
        "en": "Title in English"
    },
    "slug": "page-slug",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Titolo del blocco",
                    "subtitle": "Sottotitolo del blocco",
                    "cta_text": "Testo del pulsante"
                }
            }
        ],
        "en": [
            {
                "type": "hero",
                "data": {
                    "title": "Block title",
                    "subtitle": "Block subtitle",
                    "cta_text": "Button text"
                }
            }
        ]
    }
}
```

## Regole per la Traduzione

### ✅ Elementi da Tradurre

- **title**: Titoli delle pagine e dei blocchi
- **subtitle**: Sottotitoli e descrizioni
- **cta_text**: Testi dei pulsanti call-to-action
- **description**: Descrizioni e testi esplicativi
- **content**: Contenuti testuali principali
- **meta_description**: Descrizioni meta per SEO
- **meta_title**: Titoli meta per SEO

### ❌ Elementi da NON Tradurre

- **view**: Percorsi delle viste Blade
- **image**: Percorsi delle immagini
- **widget**: Namespace dei widget Filament
- **cta_link**: URL dei link
- **type**: Tipi di blocco
- **id**: Identificatori univoci
- **slug**: Slug delle pagine
- **created_at/updated_at**: Timestamp
- **created_by/updated_by**: ID degli utenti

### Esempio Pratico

```json
{
    "title": {
        "it": "Area Dottore - Quaeris",
        "en": "Doctor Area - Quaeris"
    },
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "pub_theme::components.blocks.hero.dettaglio-dottore",
                    "title": "Benvenuto nella tua Area Dottore",
                    "subtitle": "Gestisci le tue pazienti e monitora i loro percorsi di salute",
                    "image": "/img/odontoiatra.jpg",
                    "cta-buttons": [],
                    "cta_text": "Continua la registrazione",
                    "cta_link": "/doctor/patients",
                    "widget": "Modules\\User\\Filament\\Widgets\\DoctorCalendarWidget"
                }
            }
        ],
        "en": [
            {
                "type": "hero",
                "data": {
                    "view": "pub_theme::components.blocks.hero.dettaglio-dottore",
                    "title": "Welcome to your Doctor Area",
                    "subtitle": "Manage your patients and monitor their oral health pathways",
                    "image": "/img/odontoiatra.jpg",
                    "cta-buttons": [],
                    "cta_text": "Continue registration",
                    "cta_link": "/doctor/patients",
                    "widget": "Modules\\User\\Filament\\Widgets\\DoctorCalendarWidget"
                }
            }
        ]
    }
}
```

## Best Practices

### 1. Coerenza Strutturale

- Mantenere sempre la stessa struttura tra le diverse lingue
- Replicare esattamente la struttura del blocco "it" per le altre lingue
- Non aggiungere o rimuovere campi tra le diverse versioni

### 2. Traduzioni Appropriate

- Adattare il contenuto al contesto culturale della lingua target
- Evitare traduzioni letterali quando possibile
- Mantenere il tono e lo stile del contenuto originale

### 3. Validazione

- Verificare che tutti i campi traducibili siano presenti in tutte le lingue
- Controllare la coerenza dei link e dei percorsi
- Testare il rendering delle pagine in tutte le lingue

### 4. Manutenzione

- Aggiornare tutte le lingue quando si modifica il contenuto
- Documentare le modifiche nelle traduzioni
- Mantenere un glossario di termini tecnici

## Processo di Traduzione

### 1. Identificazione

Identificare i file JSON che necessitano di traduzione:
```bash
find config/local/quaeris/database/content/pages/ -name "*.json"
```

### 2. Analisi

Analizzare la struttura del file per identificare:
- Campi traducibili (title, subtitle, cta_text, etc.)
- Campi non traducibili (view, image, widget, etc.)
- Struttura dei blocchi di contenuto

### 3. Traduzione

Per ogni campo traducibile:
1. Creare la sezione per la nuova lingua
2. Tradurre il contenuto mantenendo il significato
3. Verificare la coerenza con il contesto

### 4. Validazione

Dopo la traduzione:
1. Verificare la sintassi JSON
2. Testare il rendering della pagina
3. Controllare che tutti i link funzionino
4. Validare la coerenza visiva

## Strumenti di Supporto

### Validazione JSON

```bash

# Validare la sintassi JSON
cat file.json | jq .

# Verificare la presenza di tutte le lingue
jq '.title | keys' file.json
```

### Script di Controllo

```bash
#!/bin/bash

# Controlla che tutti i file JSON abbiano le traduzioni complete

for file in config/local/quaeris/database/content/pages/*.json; do
    echo "Checking $file..."
    
    # Verifica presenza sezioni it e en
    if ! jq -e '.title.it' "$file" > /dev/null 2>&1; then
        echo "❌ Missing Italian title in $file"
    fi
    
    if ! jq -e '.title.en' "$file" > /dev/null 2>&1; then
        echo "❌ Missing English title in $file"
    fi
    
    # Verifica presenza content_blocks per entrambe le lingue
    if ! jq -e '.content_blocks.it' "$file" > /dev/null 2>&1; then
        echo "❌ Missing Italian content_blocks in $file"
    fi
    
    if ! jq -e '.content_blocks.en' "$file" > /dev/null 2>&1; then
        echo "❌ Missing English content_blocks in $file"
    fi
done
```

## Collegamenti

- [Implementazione nel Progetto](./implementazione-nel-progetto.md)
- [Best Practices](./best-practices.md)
- [Gestione Traduzioni Mancanti](./gestione-traduzioni-mancanti.md)
- [Documentazione Plugin Filament](https://filamentphp.com/plugins/filament-spatie-translatable)

## Note Importanti

- I contenuti JSON sono utilizzati dal sistema CMS per generare pagine dinamiche
- Le traduzioni devono essere mantenute sincronizzate con le modifiche al contenuto
- Il sistema utilizza il fallback alla lingua italiana per contenuti mancanti
