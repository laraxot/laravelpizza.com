# Tema Meetup - Laravel Pizza

Tema frontend per Laravel Pizza utilizzando Tailwind CSS e Vite.

## 📋 Panoramica

Il tema Meetup è il tema pubblico per il sito Laravel Pizza, progettato per essere moderno, responsive e performante.

## 🎨 Caratteristiche

- **Laravel Folio**: File-based routing per pagine pubbliche (NO controllers/routes in web.php/api.php)
- **Laravel Volt**: Componenti dichiarativi con PHP e Blade nello stesso file
- **Tailwind CSS v4**: Utility-first CSS framework
- **Vite**: Build tool veloce e moderno
- **Responsive Design**: Mobile-first approach
- **Componenti Riutilizzabili**: Card, button, form, navigation
- **JavaScript Interattivo**: Carrello, filtri, form validation
- **MCP Ready**: Integrato con Model Context Protocol per sviluppo assistito

## 📁 Struttura

```
Themes/Meetup/
├── resources/
│   ├── html/              # Versione HTML statica
│   │   ├── index.html     # Homepage
│   │   ├── menu.html      # Menu completo
│   │   ├── events.html    # Eventi e meetup
│   │   ├── contact.html   # Pagina contatti
│   │   ├── cart.html      # Carrello
│   │   ├── css/
│   │   │   └── app.css    # Stili Tailwind
│   │   ├── js/
│   │   │   └── app.js     # JavaScript principale
│   │   └── images/        # Immagini tema
│   └── views/             # Blade templates (da implementare)
├── vite.config.js         # Configurazione Vite
├── tailwind.config.js     # Configurazione Tailwind
└── package.json          # Dipendenze npm
```

## 🚀 Setup

### ⚠️ REGOLA CRITICA: Esecuzione Comandi NPM

**I comandi NPM DEVONO essere eseguiti SEMPRE nella directory del tema:**

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
```

**Perché?**
- `vite.config.js` usa `__dirname` per risolvere path relativi
- `package.json` deve essere nella directory corrente
- `node_modules` viene creato nella directory corrente

Vedi [Regola Esecuzione Comandi NPM](./docs/npm-commands-execution-rule.md) per dettagli.

### Installazione Dipendenze

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install
```

### Sviluppo

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
# Avvia dev server Vite con hot reload
npm run dev
```

### Build Produzione

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
# Compila assets per produzione
npm run build
```

Gli assets compilati verranno salvati in `resources/html/dist/`.

## 🎨 Palette Colori

- **Primary** (Rosso Pizza): `#dc2626` - Colore principale per CTA e elementi importanti
- **Secondary** (Giallo Formaggio): `#f59e0b` - Colore secondario per evidenziare
- **Accent** (Verde Basilico): `#16a34a` - Colore accent per elementi speciali

## 📄 Pagine HTML

### Homepage (index.html)
- Hero section con CTA
- Pizze in evidenza
- Features section
- About section
- Footer completo

### Menu (menu.html)
- Filtri per categoria (Classiche, Speciali, Vegetariane)
- Grid responsive pizze
- Aggiunta al carrello
- Navigazione smooth scroll

### Eventi (events.html)
- 4 categorie eventi (Developer Meetup, Pizza Classes, Tasting Events, Special Events)
- Sistema filtri interattivo JavaScript
- Card eventi con informazioni dettagliate
- Badge categorizzati (🚀 Meetup, 👨‍🍳 Class, 🍷 Tasting, 🎉 Special)
- Sezione CTA per prenotazioni eventi privati

### Contatti (contact.html)
- Informazioni contatto
- Form contatto completo
- Mappa (placeholder)
- Social media links

### Carrello (cart.html)
- Lista ordini con localStorage
- Riepilogo ordine
- Calcolo totale automatico
- Checkout button

Vedi [README HTML](./resources/html/readme.md) per dettagli completi.

## 🔧 Configurazione

### Vite

Il file `vite.config.js` è configurato per:
- Compilare CSS e JS da `resources/html/`
- Output in `public/build-meetup/`
- Hot reload durante sviluppo

### Tailwind

Il file `tailwind.config.js` include:
- Palette colori personalizzata
- Font Inter
- Content paths per HTML e Blade

## 🎯 Utilizzo MCP

Il tema è configurato per utilizzare i server MCP:
- **puppeteer**: Per screenshot e test visuali
- **filesystem**: Per gestione file assets
- **memory**: Per memorizzare decisioni design

Vedi [Configurazione MCP UI/UX](../../modules/meetup/docs/ui-ux-mcp-configuration.md).

## 📚 Best Practices

- Usa sempre utility-first approach di Tailwind
- Mantieni consistenza con design system
- Testa responsive su dispositivi reali
- Documenta componenti custom
- Segui pattern mobile-first

Vedi [Best Practices Tailwind](../../modules/meetup/docs/tailwind-best-practices.md).

## 🔗 Collegamenti

- [Documentazione Modulo Meetup](../../modules/meetup/docs/readme.md)
- [Configurazione UI/UX MCP](../../modules/meetup/docs/ui-ux-mcp-configuration.md)
- [Best Practices Tailwind](../../modules/meetup/docs/tailwind-best-practices.md)
- [README HTML](./resources/html/readme.md)

## 📝 Note

- Le immagini usano placeholder da Unsplash (sostituire con immagini reali)
- Il carrello usa localStorage (implementare backend per produzione)
- I form sono statici (aggiungere endpoint backend)
- MCP integration per sviluppo assistito

## ⚠️ Regola Architetturale Critica

**Front Office Architecture:**
- **Folio + Volt**: Usa SOLO Laravel Folio per routing e Laravel Volt per componenti
- **NO Controllers**: Mai creare controllers per pagine front office
- **NO Routes in web.php/api.php**: Per funzionalità front office, usa sempre Folio
- **Approccio DRY + KISS + SOLID + Robust + Laraxot**
