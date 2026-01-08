# Frontend e Sistema di Componenti

## Struttura della Homepage

La homepage del sito è costruita utilizzando un sistema di componenti modulare basato su blocchi. La configurazione della homepage si trova in:

```
/var/www/html/<directory progetto>/laravel/config/local/<directory progetto>/database/content/pages/1.json
.../laravel/config/<nome dominio al contrario>/database/content/pages/1.json
```

## Come Funziona

### Configurazione JSON
- Ogni pagina è definita in un file JSON
- I blocchi sono organizzati in `content_blocks`
- Supporto multilingua con chiavi per ogni lingua

### Rendering
- Il tema One (`/var/www/html/<directory progetto>/laravel/Themes/One`) gestisce il rendering
- Il tema One (`../Themes/One`) gestisce il rendering
- I componenti sono caricati dinamicamente dal modulo UI
- Il layout è gestito da `x-layouts.marketing`

### Personalizzazione
- Ogni blocco può essere personalizzato tramite il JSON
- Supporto per stili e classi CSS
- Possibilità di aggiungere nuovi blocchi

## Best Practices per i Contenuti

1. **Contenuti**
   - Mantenere i testi concisi e chiari
   - Usare immagini di alta qualità
   - Assicurare la coerenza del messaggio

## Esempio di Configurazione

```json
{
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "title": "Titolo",
                    "subtitle": "Sottotitolo",
                    "image": "/img/hero.jpg",
                    "cta_text": "Scopri di più",
                    "cta_link": "#about"
                }
            }
        ]
    }
}
```

## Debugging

1. Verificare i log di Laravel
2. Controllare la console del browser
3. Verificare la struttura JSON

## Collegamenti
- [Componenti UI](../UI/docs/components.md)
- [Documentazione Core](../Xot/docs/documentation.md) 
