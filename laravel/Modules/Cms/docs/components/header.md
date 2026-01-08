# Componente Header

## Descrizione
Il componente Header è un elemento fondamentale dell'interfaccia utente che fornisce la navigazione principale del sito. Include il logo, il menu di navigazione e un menu mobile responsive.

## Utilizzo Base
```php
<x-cms::section slug="header" />
```

## Struttura JSON
```json
{
    "name": {
        "it": "Header Principale",
        "en": "Main Header"
    },
    "slug": "header",
    "blocks": {
        "it": [
            {
                "type": "navigation",
                "data": {
                    "items": [...]
                }
            }
        ],
        "en": [...]
    },
    "attributes": {
        "class": "sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800",
        "id": "main-header"
    }
}
```

## Proprietà
- `section`: ?object - Oggetto sezione con le proprietà della sezione
- `blocks`: array - Array di blocchi da renderizzare nel componente
- `class`: string - Classi CSS aggiuntive da applicare al componente

## Blocchi Supportati
- `navigation`: Blocco per la navigazione principale
  - Vedi [NavigationBlock](../blocks/navigation.md)

## Best Practices
1. Mantenere la struttura di navigazione coerente tra le lingue
2. Utilizzare URL localizzati per le diverse lingue
3. Implementare la navigazione mobile in modo accessibile
4. Seguire le convenzioni di accessibilità WCAG

## Collegamenti
- [Documentazione Componenti](./README.md)
- [Documentazione Blocchi](../blocks/README.md)
- [Convenzioni Layout](../../../docs/laravel-conventions.md) 

## Collegamenti tra versioni di header.md
* [header.md](docs/sections/header.md)
* [header.md](laravel/Modules/Cms/docs/components/header.md)
* [header.md](laravel/Modules/Cms/docs/sections/header.md)
* [header.md](laravel/Themes/One/docs/sections/header.md)

