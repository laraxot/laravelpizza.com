# Componente Section

## Descrizione
Il componente Section è un elemento strutturale che permette di organizzare il contenuto della pagina in sezioni logiche e riutilizzabili. Ogni sezione può contenere diversi tipi di blocchi di contenuto ed è completamente personalizzabile attraverso attributi e classi.

## Utilizzo Base
```php
<x-cms::section slug="about" />
```

## Struttura JSON
```json
{
    "name": {
        "it": "Sezione About",
        "en": "About Section"
    },
    "slug": "about",
    "blocks": {
        "it": [
            {
                "type": "content",
                "data": {
                    "content": "Contenuto della sezione"
                }
            }
        ],
        "en": [...]
    },
    "attributes": {
        "class": "py-12 bg-white dark:bg-gray-900",
        "id": "about-section"
    }
}
```

## Proprietà
- `slug`: string - Identificatore univoco della sezione
- `section`: ?object - Oggetto sezione con le proprietà della sezione
- `blocks`: array - Array di blocchi da renderizzare nella sezione
- `class`: string - Classi CSS aggiuntive da applicare alla sezione

## Best Practices
1. Utilizzare slug descrittivi e unici per ogni sezione
2. Definire sempre gli attributi class e id per facilitare styling e targeting
3. Mantenere la coerenza dei blocchi tra le diverse lingue
4. Seguire le convenzioni di accessibilità WCAG
5. Organizzare le sezioni in modo logico e semantico

## Collegamenti
- [Documentazione Componenti](./README.md)
- [Documentazione Blocchi](../blocks/README.md)
- [Convenzioni Layout](../../../docs/laravel-conventions.md) 
