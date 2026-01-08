# Architettura Frontend

## Panoramica

L'architettura frontend del modulo CMS è progettata per essere modulare, performante e facilmente personalizzabile. Si basa su componenti riutilizzabili e un sistema di theming flessibile.

## Stack Tecnologico

### Core
- Laravel Volt per componenti dinamici
- Laravel Folio per il routing basato su file
- Filament per l'interfaccia amministrativa
- Laraxot per l'estensione delle funzionalità base

### Frontend
- TailwindCSS per lo styling
- Alpine.js per interazioni lato client
- HTMX per richieste AJAX progressive
- Livewire per componenti dinamici

## Flusso di Rendering

1. **Richiesta**: Il browser richiede una pagina
2. **Routing**: Laravel Folio identifica il componente corretto
3. **Composizione**: Il ThemeComposer assembla i blocchi della pagina
4. **Rendering**: I componenti Volt renderizzano il contenuto
5. **Risposta**: La pagina HTML viene inviata al browser

## Sistema di Theming

### Struttura dei Temi
```
themes/
  ├── default/
  │   ├── components/
  │   ├── layouts/
  │   └── pages/
  └── custom/
      ├── components/
      ├── layouts/
      └── pages/
```

### Personalizzazione
- Override dei componenti base
- Stili personalizzati per tenant
- Layout specifici per sezione
- Componenti riutilizzabili

## Componenti

### Tipi di Componenti
- **Layout**: Struttura base delle pagine
- **Blocchi**: Sezioni di contenuto modulari
- **Widget**: Componenti interattivi
- **UI**: Elementi di interfaccia riutilizzabili

### Gestione dei Blocchi
I blocchi sono l'unità base di contenuto. Ogni blocco:
- Ha un proprio file di configurazione
- Può essere personalizzato per tenant
- Supporta il rendering condizionale
- Gestisce i propri stati e dati

## Ottimizzazione

### Performance
- Lazy loading dei componenti
- Caching dei contenuti
- Minificazione degli asset
- Compressione delle immagini

### SEO
- Meta tag dinamici
- Sitemap automatica
- Schema.org markup
- Open Graph tags

## Sicurezza

### Misure Implementate
- CSRF protection
- XSS prevention
- Content Security Policy
- Rate limiting

### Autenticazione
- Multi-tenant auth
- Ruoli e permessi
- 2FA opzionale
- Session management

## Testing

### Tipi di Test
- Unit test per componenti
- Feature test per pagine
- Browser test per UI
- Performance test

### Strumenti
- PHPUnit per test unitari
- Laravel Dusk per browser test
- Lighthouse per performance
- Jest per JavaScript

## Documentazione Correlata

- [Gestione dei Temi](../themes/README.md)
- [Componenti UI](../components/README.md)
- [Configurazione Blocchi](../blocks/README.md)
- [Ottimizzazione Performance](../performance/README.md)

## Collegamenti tra versioni di architecture.md
* [architecture.md](docs/tecnico/filament/architecture.md)
* [architecture.md](docs/rules/architecture.md)
* [architecture.md](laravel/Modules/Gdpr/docs/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/frontoffice/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/architecture.md)
* [architecture.md](laravel/Themes/One/docs/roadmap/inspiration/architecture.md)

