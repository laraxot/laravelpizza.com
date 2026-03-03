# Componenti e Blocchi di Contenuto in il progetto

## Introduzione

Questo documento descrive i componenti e i blocchi di contenuto disponibili in il progetto per la gestione dei contenuti statici tramite file JSON. È fondamentale utilizzare solo i componenti esistenti e rispettare la struttura corretta per evitare errori di rendering.

## Struttura dei File JSON

I contenuti statici in il progetto sono gestiti tramite file JSON nella directory:
```
/laravel/config/local/<directory progetto>/database/content/
```

Ogni pagina ha un file JSON corrispondente con la seguente struttura:
```json
{
    "id": "1",
    "title": {
        "it": "Titolo della pagina"
    },
    "slug": "slug-pagina",
    "content": null,
    "content_blocks": {
        "it": [
            // Blocchi di contenuto
        ]
    },
    "sidebar_blocks": {
        "it": []
    },
    "footer_blocks": null
}
```

## Componenti Disponibili

### 1. Hero
```json
{
    "type": "hero",
    "data": {
        "view": "ui::components.blocks.hero.simple",
        "title": "Titolo",
        "subtitle": "Sottotitolo",
        "image": "/img/hero-bg.jpg",
        "cta_text": "Testo pulsante",
        "cta_link": "/link",
        "background_color": "bg-white",
        "text_color": "text-gray-900",
        "cta_color": "bg-indigo-600 hover:bg-indigo-700"
    }
}
```

### 2. Paragraph
```json
{
    "type": "paragraph",
    "data": {
        "content": "Testo del paragrafo"
    }
}
```

### 3. Feature Sections
```json
{
    "type": "feature_sections",
    "data": {
        "view": "ui::components.blocks.feature_sections.v1",
        "title": "Titolo sezione",
        "sections": [
            {
                "title": "Titolo feature",
                "description": "Descrizione",
                "icon": "nome-icona"
            }
        ]
    }
}
```

### 4. Stats
```json
{
    "type": "stats",
    "data": {
        "view": "ui::components.blocks.stats.v1",
        "title": "Titolo statistiche",
        "stats": [
            {
                "number": "100+",
                "label": "Etichetta"
            }
        ]
    }
}
```

### 5. CTA (Call to Action)
```json
{
    "type": "cta",
    "data": {
        "view": "ui::components.blocks.cta.v1",
        "title": "Titolo CTA",
        "description": "Descrizione",
        "button_text": "Testo pulsante",
        "button_link": "/link"
    }
}
```

## Errori Comuni e Come Evitarli

### 1. Utilizzo di Componenti Non Esistenti

**Errore**: Utilizzare un componente view che non esiste nel sistema, come `ui::components.blocks.text.v1`.

**Soluzione**: Verificare sempre i componenti disponibili esaminando i file JSON esistenti o la documentazione del sistema. Utilizzare solo componenti confermati.

**Esempio di errore**:
```json
{
    "type": "text_block",
    "data": {
        "view": "ui::components.blocks.text.v1",  // Questo componente non esiste!
        "content": "Testo"
    }
}
```

**Correzione**:
```json
{
    "type": "paragraph",
    "data": {
        "content": "Testo"
    }
}
```

### 2. Struttura Errata dei Blocchi

**Errore**: Non rispettare la struttura richiesta per un determinato tipo di blocco.

**Soluzione**: Seguire esattamente la struttura dei blocchi esistenti, prestando attenzione ai campi obbligatori e ai loro tipi.

### 3. Riferimenti a Risorse Non Esistenti

**Errore**: Fare riferimento a immagini, icone o altri asset che non esistono nel sistema.

**Soluzione**: Verificare l'esistenza delle risorse prima di fare riferimento ad esse nei blocchi di contenuto.

## Processo di Verifica

Prima di implementare modifiche ai file JSON:

1. **Analizzare i componenti esistenti**: Esaminare i file JSON esistenti per identificare i componenti disponibili.
2. **Verificare la struttura**: Assicurarsi che la struttura del blocco sia corretta e contenga tutti i campi necessari.
3. **Testare le modifiche**: Dopo aver modificato un file JSON, verificare che la pagina si carichi correttamente.

## Conclusione

Rispettare la struttura dei blocchi di contenuto e utilizzare solo componenti esistenti è fondamentale per garantire il corretto funzionamento del sistema di gestione dei contenuti di il progetto. In caso di dubbio, è sempre meglio esaminare i file JSON esistenti per comprendere la struttura e i componenti disponibili.
