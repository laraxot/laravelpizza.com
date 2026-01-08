# Header Section

## Struttura
L'header è una sezione che contiene vari blocchi di navigazione e contenuto.

## Esempio di Configurazione
```json
{
    "name": "Header Principale",
    "type": "header",
    "blocks": [
        {
            "name": "Logo",
            "type": "logo",
            "data": {
                "view": "pub_theme::components.blocks.logo",
                "src": "patient::images/logo.svg",
                "alt": "{{ config('app.name') }}",
                "width": 150,
                "height": 32
            }
        },
        {
            "name": "Menu di Navigazione",
            "type": "navigation",
            "data": {
                "view": "pub_theme::components.blocks.navigation",
                "items": [
                    {
                        "label": "Home",
                        "url": "/",
                        "type": "link"
                    },
                    {
                        "label": "Servizi",
                        "url": "/servizi",
                        "type": "link"
                    }
                ],
                "alignment": "start",
                "orientation": "horizontal"
            }
        },
        {
            "name": "Azioni",
            "type": "actions",
            "data": {
                "items": [
                    {
                        "label": "Area Pazienti",
                        "url": "/area-pazienti",
                        "variant": "primary"
                    },
                    {
                        "label": "Prenota",
                        "url": "/prenota",
                        "variant": "secondary"
                    }
                ],
                "alignment": "end",
                "gap": 4
            }
        }
    ]
}
```

## Best Practices

### 1. Struttura dei Dati
- Mantenere la struttura dei dati semplice e piatta
- Non includere traduzioni nei dati JSON
- Utilizzare il sistema di traduzioni di Laravel

### 2. Menu Items
- Ogni voce del menu deve avere una struttura semplice
- Le etichette devono essere gestite tramite il sistema di traduzioni
- Gli URL devono essere relativi e non includere la lingua

### 3. Accessibilità
- Utilizzare i componenti Filament per l'accessibilità
- Mantenere la coerenza con il design system
- Supportare la navigazione da tastiera

## Collegamenti
- [Documentazione Blocchi](./blocks.md)
- [Best Practices UI/UX](./guida-implementazione-ux.md)
- [Documentazione Accessibilità](./accessibility.md)
