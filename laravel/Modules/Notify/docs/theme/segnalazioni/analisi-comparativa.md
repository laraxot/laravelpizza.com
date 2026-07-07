# Analisi Comparativa: Pagine Segnalazioni

## Obiettivo
Rendere le pagine locali (`http://127.0.0.1:8000/it/tests/<pagina>`) visivamente identiche alle pagine di riferimento (`https://italia.github.io/design-comuni-pagine-statiche/sito/<pagina>.html`) utilizzando Tailwind CSS + Alpine.js (NO Bootstrap Italia).

## Pagine Analizzate

### 1. segnalazione-disservizio
- **Stato**: ✅ GIA' IMPLEMENTATO
- **Note**: La pagina è già ben strutturata e allineata al reference

### 2. segnalazione-01-privacy
- **Stato**: 🔄 DA IMPLEMENTARE
- **Pagina Reference**: `segnalazione-01-privacy.html`
- **Contenuto**: Step 1 - Informativa privacy e consenso

### 3. segnalazione-02-dati
- **Stato**: 🔄 DA IMPLEMENTARE
- **Pagina Reference**: `segnalazione-02-dati.html`
- **Contenuto**: Step 2 - Inserimento dati segnalazione

### 4. segnalazione-03-riepilogo
- **Stato**: 🔄 DA IMPLEMENTARE
- **Pagina Reference**: `segnalazione-03-riepilogo.html`
- **Contenuto**: Step 3 - Riepilogo e conferma

### 5. segnalazione-04-conferma
- **Stato**: 🔄 DA IMPLEMENTARE
- **Pagina Reference**: `segnalazione-04-conferma.html`
- **Contenuto**: Step 4 - Conferma invio

### 6. segnalazioni-elenco
- **Stato**: 🔄 DA IMPLEMENTARE
- **Pagina Reference**: `segnalazioni-elenco.html`
- **Contenuto**: Lista segnalazioni con filtri e mappa

### 7. segnalazione-dettaglio
- **Stato**: 🔄 DA IMPLEMENTARE
- **Pagina Reference**: `segnalazione-dettaglio.html`
- **Contenuto**: Dettaglio singola segnalazione

## Struttura HTML Reference (Pattern Comune)

### Header
- `.it-header-wrapper` - Header completo con
  - `.it-header-slim-wrapper` - Top bar con nome regione e lingua
  - `.it-nav-wrapper` - Navigazione principale con
    - `.it-header-center-wrapper` - Logo e branding
    - `.it-header-navbar-wrapper` - Menu navigazione

### Main Content
- Container con `.row` e `.col-lg-10` per centraggio
- Breadcrumb per navigazione
- Servizio header con:
  - Titolo h1
  - Chip stato (Servizio attivo)
  - Descrizione
  - Bottoni azione (Segnala disservizio, Tutte le segnalazioni)
  - Dropdown Condividi e Vedi azioni
- Indice laterale (sticky)
- Sezioni contenuto con ID per navigazione
- Card contatti finali

### Footer
- Rating section (stelle feedback)
- Contenuti correlati (carousel)
- Footer standard

## Differenze CSS Identificate

### 1. Typography
- `.title-xxxlarge` - Dimensione e peso titoli
- `.text-paragraph lora` - Font serif per contenuti
- `.subtitle-small` - Sottotitoli

### 2. Spacing
- `.mb-30` - Margin bottom 30px
- `.mt-lg-80` - Margin top 80px su desktop
- `.p-3` - Padding standard
- `.has-bg-grey` - Background grigio chiaro (#f8f9fa)

### 3. Components
- **Chips**: Badge per stato servizio
- **Accordion**: Indice laterale espandibile
- **Card Teaser**: Card per contatti
- **Icon Links**: Link con icone per download
- **Button Stack**: Stack di bottoni

### 4. Layout
- Sidebar sticky per indice
- Two-column layout (sidebar + content)
- Centered content con `col-lg-10`

## Azioni Necessarie

### CSS
1. Aggiungere classi mancanti in `tailwind-bootstrap-mapping.css`
2. Verificare responsività (mobile/tablet/desktop)
3. Allineare colori e spacing esatti

### JS/Alpine
1. Gestione accordion indice laterale
2. Dropdown menu (Condividi, Vedi azioni)
3. Toggle mobile navigation

### Componenti Blade
1. Creare/modificare block per ogni tipo di contenuto
2. Allineare struttura JSON con reference

## File CSS da Modificare
- `laravel/Themes/Sixteen/resources/css/tailwind-bootstrap-mapping.css`
- `laravel/Themes/Sixteen/resources/css/design-comuni.css`

## Riferimenti
- Reference: https://italia.github.io/design-comuni-pagine-statiche/sito/
- Local: http://127.0.0.1:8000/it/tests/

## Ultimo Aggiornamento
- Data: 2026-04-07
- Autore: AI Agent