# Frontend e Sistema di Componenti

## Struttura della Homepage

La homepage del sito è costruita utilizzando un sistema di componenti modulare basato su blocchi. La configurazione della homepage si trova in:

```
config/local/<nome progetto>/database/content/pages/1.json
config/local/<nome progetto>/database/content/pages/1.json
config/local/<nome progetto>/database/content/pages/1.json
config/local/<nome progetto>/database/content/pages/1.json
config/local/<nome progetto>/database/content/pages/1.json
config/local/<nome progetto>/database/content/pages/1.json
```

### Componenti Disponibili

Il modulo UI fornisce i seguenti blocchi per la costruzione delle pagine:

1. **Hero**
   - Sezione principale con titolo, sottotitolo e immagine di sfondo
   - Supporto per CTA (Call to Action)

2. **Feature Sections**
   - Sezioni con icone e descrizioni
   - Ideale per presentare caratteristiche o servizi

3. **Stats**
   - Visualizzazione di statistiche e numeri
   - Supporto per icone e etichette

4. **Testimonials**
   - Testimonianze di utenti o professionisti
   - Supporto per immagini e citazioni

5. **Blog**
   - Lista di articoli del blog
   - Supporto per immagini e preview

6. **Newsletter**
   - Form di iscrizione alla newsletter
   - Personalizzabile con titolo e descrizione

7. **CTA (Call to Action)**
   - Sezioni di invito all'azione
   - Supporto per pulsanti e link

8. **Image Gallery**
   - Galleria di immagini
   - Supporto per lightbox e filtri

9. **Slider**
   - Carosello di contenuti
   - Supporto per immagini e testo

10. **Paragraph**
    - Blocchi di testo
    - Supporto per formattazione

### Come Funziona

1. **Configurazione JSON**
   - Ogni pagina è definita in un file JSON
   - I blocchi sono organizzati in `content_blocks`
   - Supporto multilingua con chiavi per ogni lingua

2. **Rendering**
   - Il tema One (`../Themes/One`) gestisce il rendering
   - Il tema One (`../Themes/One`) gestisce il rendering
   - Il tema One (`../Themes/One`) gestisce il rendering
   - Il tema One (`../Themes/One`) gestisce il rendering
   - Il tema One (`../Themes/One`) gestisce il rendering
   - Il tema One (`../Themes/One`) gestisce il rendering
   - I componenti sono caricati dinamicamente dal modulo UI
   - Il layout è gestito da `x-layouts.marketing`

3. **Personalizzazione**
   - Ogni blocco può essere personalizzato tramite il JSON
   - Supporto per stili e classi CSS
   - Possibilità di aggiungere nuovi blocchi

### Best Practices

1. **Struttura**
   - Mantenere una gerarchia logica dei blocchi
   - Usare titoli e sottotitoli appropriati
   - Includere CTA strategici

2. **Contenuti**
   - Mantenere i testi concisi e chiari
   - Usare immagini di alta qualità
   - Assicurare la coerenza del messaggio

3. **Performance**
   - Ottimizzare le immagini
   - Minimizzare il numero di blocchi
   - Usare lazy loading quando possibile

### Esempio di Configurazione

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

## Manutenzione

### Aggiungere Nuovi Blocchi

1. Creare il componente in `laravel/Modules/UI/resources/views/components/blocks/`
2. Aggiungere la logica nel service provider del modulo UI
3. Aggiornare la documentazione

### Modificare Blocchi Esistenti

1. Modificare il componente nel modulo UI
2. Aggiornare la configurazione JSON
3. Testare la retrocompatibilità

### Debugging

1. Verificare i log di Laravel
2. Controllare la console del browser
3. Verificare la struttura JSON
