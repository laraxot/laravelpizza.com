# Blocchi UI in il progetto

I blocchi UI sono componenti riutilizzabili per la costruzione delle pagine. Ogni blocco è un componente Blade che può essere utilizzato in qualsiasi vista del tema.

## Struttura dei Blocchi

Ogni blocco deve seguire questa struttura:

```json
{
    "type": "block_type",
    "view": "theme::components.blocks.block_type.simple",
    "data": {
        // dati specifici del blocco
    }
}
```

## Blocchi Disponibili

### Hero
```json
{
    "type": "hero",
    "view": "one::components.blocks.hero.simple",
    "data": {
        "title": "Titolo",
        "subtitle": "Sottotitolo",
        "image": "path/to/image.jpg",
        "cta_text": "Call to Action",
        "cta_link": "/action",
        "background_color": "#ffffff",
        "text_color": "#000000",
        "cta_color": "#4f46e5"
    }
}
```

### Feature Sections
```json
{
    "type": "feature_sections",
    "view": "one::components.blocks.feature_sections.simple",
    "data": {
        "title": "Titolo",
        "description": "Descrizione",
        "sections": [
            {
                "title": "Sezione 1",
                "description": "Descrizione 1",
                "icon": "heroicon-o-check"
            }
        ]
    }
}
```

### Stats
```json
{
    "type": "stats",
    "view": "one::components.blocks.stats.simple",
    "data": {
        "title": "Titolo",
        "description": "Descrizione",
        "stats": [
            {
                "value": "100",
                "label": "Statistica 1"
            }
        ]
    }
}
```

### CTA
```json
{
    "type": "cta",
    "view": "one::components.blocks.cta.simple",
    "data": {
        "title": "Titolo",
        "description": "Descrizione",
        "cta_text": "Call to Action",
        "cta_link": "/action",
        "background_color": "#4f46e5",
        "text_color": "#ffffff"
    }
}
```

## Best Practices

1. **View**: Specifica sempre la view corretta
2. **Namespace**: Usa il namespace del tema (es. `one::`)
3. **Props**: Definisci solo i props necessari
4. **Validazione**: Valida sempre i dati in input
5. **Accessibilità**: Assicurati che i blocchi siano accessibili
6. **Responsive**: Rendi i blocchi responsive
7. **Performance**: Ottimizza le performance
8. **Codice**: Mantieni il codice pulito e documentato

## Collegamenti tra versioni di blocks.md
* [blocks.md](../../../Xot/docs/blocks.md)
* [blocks.md](../../../User/docs/blocks.md)
* [blocks.md](../../../UI/docs/blocks.md)
* [blocks.md](../../../Cms/docs/blocks.md)
* [blocks.md](../../../../Themes/One/docs/blocks.md)
* [blocks.md](../../../../Themes/One/docs/components/blocks.md)

