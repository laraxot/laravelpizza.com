# Verifica Allineamento HTML con Business Logic

## Data: [DATE]

## Contesto
L'HTML statico in `resources/html/` deve essere allineato con:
- Business logic documentata in `Modules/Meetup/docs/business-logic.md`
- Database schema in `Modules/Meetup/docs/DATABASE-SCHEMA.md`
- Analisi reale sito in `Modules/Meetup/docs/real-website-analysis.md`

## Verifica Correzioni Utente

L'utente ha corretto l'HTML per riflettere una **pizzeria tradizionale** invece di un sistema di meetup:

### ✅ Correzioni Applicate
1. **Meta tags**: Cambiati da "meetup community" a "pizza artigianale, consegna"
2. **Schema.org**: Cambiato da `Organization` a `Restaurant`
3. **Navigation**:
   - Rimossi: Events, Community Chat
   - Aggiunti: Menu, Chi Siamo, Contatti, Carrello
4. **Hero Section**:
   - Titolo: "La Pizza Artigianale che ami, a casa tua"
   - CTA: "Sfoglia il Menù", "Contattaci"
   - Design: Background gradient rosso, cerchio pizza giallo con topping
5. **Features**:
   - Consegna Veloce
   - Ingredienti Freschi
   - Ricette Tradizionali
6. **Pizze Section**:
   - Card Margherita, Diavola, Quattro Formaggi
   - Prezzi in euro
   - Pulsante "Ordina"

## Allineamento con Business Logic

### ✅ Corrispondenze
- **Sistema Ordini**: HTML include carrello e pulsanti "Ordina" ✓
- **Catalogo Pizze**: Sezione "Le Nostre Pizze" con card ✓
- **Categorie**: Menzionate nel menu (da verificare in menu.html)
- **Prezzi**: Visualizzati nelle card pizza ✓
- **CTA Ordine**: Presenti in homepage e card ✓

### ⚠️ Elementi da Verificare
1. **Personalizzazione Ingredienti**: Non visibile in homepage (da implementare in menu.html)
2. **Tracking Consegna**: Non presente (da implementare dopo login)
3. **Sistema Utenti**: Link a login/signup presenti ✓
4. **Recensioni**: Non visibili in homepage (da aggiungere se necessario)

## Prossimi Passi

1. **Verificare menu.html**: Deve includere:
   - Filtri per categorie (Classiche, Speciali, Vegetariane, etc.)
   - Personalizzazione ingredienti
   - Aggiunta al carrello funzionante

2. **Verificare cart.html**: Deve includere:
   - Lista prodotti
   - Modifica quantità
   - Calcolo totale
   - Form dati consegna

3. **Convertire in Blade**:
   - Sostituire contenuto statico con dati dinamici
   - Integrare con modelli `Pizza`, `Category`, `Order`
   - Collegare carrello a backend

## Note
- L'HTML statico è ora corretto e allineato con la business logic
- Il design riflette una pizzeria tradizionale italiana
- I colori (rosso, giallo, verde) sono appropriati per il brand pizza
- La struttura è pronta per la conversione in Blade templates
