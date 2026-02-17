# Gestione della Homepage

## Struttura e Modifica Corretta

La homepage del portale è gestita attraverso un file JSON che definisce i blocchi di contenuto visualizzati. Per modificare la homepage è necessario intervenire sul seguente file:

```
/laravel/config/local/database/content/pages/1.json
```

### Struttura del file JSON

Il file JSON della homepage ha la seguente struttura:

```json
{
    "id": "1",
    "title": {
        "it": "Promozione della <slogan> per le gestanti"
    },
    "slug": "home",
    "content": null,
    "content_blocks": {
        "it": [
            // Qui sono definiti i blocchi di contenuto
            // Ogni blocco ha un "type" e dei "data" specifici
        ]
    },
    "sidebar_blocks": {
        "it": []
    },
    "footer_blocks": null
}
```

### Tipi di blocchi disponibili

I blocchi attualmente implementati includono:

1. **hero** - Banner principale con titolo, sottotitolo e immagine
2. **feature_sections** - Sezioni con caratteristiche del servizio
3. **stats** - Statistiche del progetto
4. **cta** - Call to action

### Come modificare la homepage

Per modificare la homepage, è necessario:

1. Identificare il blocco che si desidera modificare nel file JSON
2. Aggiornare i valori nei campi "data" del blocco
3. Aggiungere nuovi blocchi se necessario, seguendo la struttura esistente

### Esempio di modifica per aggiornare il testo principale

Per aggiornare il testo principale della homepage:

```json
{
    "type": "text_block",
    "data": {
        "view": "ui::components.blocks.text.v1",
        "content": "Benvenuta nel portale che vuole garantire alle pazienti vulnerabili in stato di gravidanza la possibilità di accedere a servizi odontoiatrici di prevenzione a titolo completamente gratuito.\n\nSe sei una donna in stato di gravidanza residente in Italia o in attesa di permesso di soggiorno, con un valore ISEE pari a euro 20,000 o inferiore, e vuoi partecipare a questa iniziativa clicca il pulsante qui sotto:",
        "alignment": "left",
        "background_color": "bg-white",
        "text_color": "text-gray-900"
    }
}
```

### Esempio di modifica per aggiungere un pulsante "INIZIA ORA"

```json
{
    "type": "cta",
    "data": {
        "view": "ui::components.blocks.cta.v1",
        "title": "",
        "description": "",
        "button_text": "INIZIA ORA",
        "button_link": "/register",
        "background_color": "bg-white",
        "text_color": "text-gray-900",
        "button_color": "bg-indigo-600 hover:bg-indigo-700"
    }
}
```

## Analisi dell'Errore Commesso

### Errore identificato

Nell'approccio precedente, ho commesso un errore fondamentale: ho proposto modifiche concettuali all'interfaccia utente senza considerare l'architettura tecnica del sistema. Ho ignorato completamente che:

1. I contenuti sono gestiti tramite file JSON strutturati
2. Esiste un percorso specifico per questi file (`/laravel/config/local/database/content/`)
3. La modifica deve avvenire rispettando la struttura dei blocchi esistenti

### Cause dell'errore

1. **Mancata analisi dell'architettura**: Non ho esaminato come i contenuti vengono effettivamente gestiti nel sistema
2. **Approccio superficiale**: Ho proposto modifiche generiche senza considerare l'implementazione tecnica
3. **Ignoranza del pattern di gestione dei contenuti**: Non ho considerato che il sistema utilizza un sistema di gestione dei contenuti basato su JSON

### Come evitare questo errore in futuro

1. **Analizzare sempre la struttura dei dati**: Prima di proporre modifiche, esaminare come i contenuti sono strutturati e gestiti
2. **Verificare i file di configurazione**: Controllare i file JSON nella directory `/laravel/config/local/database/content/`
3. **Rispettare la struttura dei blocchi**: Utilizzare i tipi di blocchi esistenti o crearne di nuovi seguendo lo stesso pattern
4. **Testare le modifiche**: Dopo aver modificato i file JSON, verificare che le modifiche siano visualizzate correttamente

## Regola Fondamentale

> **IMPORTANTE**: I contenuti delle pagine sono gestiti tramite file JSON nella directory `/laravel/config/local/database/content/`. Qualsiasi modifica ai contenuti deve essere effettuata modificando questi file, rispettando la struttura dei blocchi esistenti. Non proporre mai modifiche concettuali senza considerare l'implementazione tecnica sottostante.

# Gestione Homepage

## Struttura della Homepage

La homepage del progetto è gestita attraverso un sistema di temi che permette una gestione flessibile e dinamica del contenuto.

### File Principali

- `laravel/Themes/One/resources/views/home.blade.php`: Template principale della homepage
- `laravel/Themes/One/resources/views/welcome.blade.php`: Template di benvenuto
- `public_html/index.php`: Punto di ingresso dell'applicazione

### Sistema di Temi

La homepage utilizza un sistema di temi che permette di:
- Caricare contenuti dinamicamente
- Personalizzare l'aspetto in base al tema selezionato
- Gestire diversi layout per diverse sezioni

Il contenuto principale viene caricato attraverso:
```php
{{ $_theme->showPageContent('home') }}
```

### Componenti della Homepage

La homepage include:
1. Header con logo e menu di navigazione
2. Sezione principale con contenuto dinamico
3. Footer con informazioni di sistema

### Personalizzazione

Per personalizzare la homepage:
1. Modificare il template nel tema corrente
2. Aggiornare i contenuti attraverso il sistema di gestione
3. Configurare il tema desiderato nel pannello di amministrazione

## Best Practices

- Mantenere il codice pulito e ben organizzato
- Utilizzare componenti riutilizzabili
- Seguire le convenzioni di naming
- Documentare tutte le modifiche
- Testare su diversi dispositivi e browser
