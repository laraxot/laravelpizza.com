# Componente Footer

## Descrizione
Il componente Footer è un elemento fondamentale dell'interfaccia utente che fornisce la navigazione secondaria e le informazioni di contatto del sito. Include il logo, menu di navigazione multipli, copyright e link ai social media.

## Utilizzo Base
```php
<x-cms::section slug="footer" />
```

## Struttura JSON
```json
{
    "name": {
        "it": "Footer Principale",
        "en": "Main Footer"
    },
    "slug": "footer",
    "blocks": {
        "it": [
            {
                "type": "navigation",
                "data": {
                    "title": "Titolo Menu",
                    "items": [...]
                }
            }
        ],
        "en": [...]
    },
    "attributes": {
        "class": "border-t border-gray-200 dark:border-gray-800",
        "id": "main-footer"
    }
}
```

## Proprietà
- `section`: ?object - Oggetto sezione con le proprietà della sezione
- `blocks`: array - Array di blocchi da renderizzare nel componente
- `class`: string - Classi CSS aggiuntive da applicare al componente

## Blocchi Supportati
- `navigation`: Blocco per la navigazione con titolo
  - Vedi [NavigationBlock](../blocks/navigation.md)

## Best Practices
1. Mantenere la struttura di navigazione coerente tra le lingue
2. Utilizzare URL localizzati per le diverse lingue
3. Organizzare i link in categorie logiche
4. Includere informazioni di contatto e social media
5. Seguire le convenzioni di accessibilità WCAG

## Collegamenti
- [Documentazione Componenti](./README.md)
- [Documentazione Blocchi](../blocks/README.md)
- [Convenzioni Layout](../../../docs/laravel-conventions.md) 

## Collegamenti tra versioni di footer.md
* [footer.md](docs/laravel-app/themes/one/components/footer.md)
* [footer.md](docs/sections/footer.md)
* [footer.md](laravel/Modules/UI/docs/components/footer.md)
* [footer.md](laravel/Modules/Cms/docs/blocks/footer.md)
* [footer.md](laravel/Modules/Cms/docs/themes/one/footer.md)
* [footer.md](laravel/Modules/Cms/docs/components/footer.md)
* [footer.md](laravel/Themes/One/docs/components/layouts/footer.md)
* [footer.md](laravel/Themes/One/docs/sections/footer.md)

