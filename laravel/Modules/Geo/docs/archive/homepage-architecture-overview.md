# Architettura Homepage - Panoramica Sistema

## Panoramica
Il sistema <nome progetto> implementa un'architettura moderna per la gestione della homepage basata su Filament Blocks, Laravel Folio e Livewire Volt, con separazione chiara delle responsabilità tra moduli.

## Architettura Generale

### Stack Tecnologico
- **Laravel Folio**: Routing e gestione pagine
- **Livewire Volt**: Componenti reattivi frontend
- **Filament Builder**: Sistema di blocchi per contenuti
- **Tema One**: Template e styling
- **JSON Storage**: Contenuti dinamici

### Moduli Coinvolti
1. **<nome progetto>**: Modulo principale, logica business
2. **CMS**: Gestione contenuti e blocchi
3. **UI**: Componenti blocchi riutilizzabili
4. **User**: Autenticazione e gestione utenti

## Struttura File Critici

### Homepage Blade
**Percorso**: `/laravel/Themes/One/resources/views/pages/index.blade.php`

**Caratteristiche**:
- Layout `x-layouts.app`
- Componente Volt `@volt('home')`
- Integrazione CMS `<x-page>`
- Routing Folio per rotta `/`

### Contenuto JSON
**Percorso**: `/laravel/config/local/<nome progetto>/database/content/pages/home.json`

**Struttura**:
- Titoli multilingua
- Blocchi contenuto dinamici
- Configurazioni UI/UX
- Metadati e tracking

## Flusso di Rendering

### 1. Routing (Laravel Folio)
```
GET / → Folio → index.blade.php
```

### 2. Template Rendering
```blade
<x-layouts.app>
    @volt('home')
        <x-page side="content" slug="home" :type="auth()->user()?->type?->value" />
    @endvolt
</x-layouts.app>
```

### 3. Content Loading
- Componente `<x-page>` carica contenuto JSON
- Parsing blocchi e configurazioni
- Rendering blocchi tramite view specifiche

### 4. Block Rendering
- Ogni blocco ha view dedicata
- Supporto multilingua
- Responsive design
- Performance ottimizzate

## Sistema Filament Blocks

### Architettura Blocchi
- **Auto-Discovery**: Scan automatico moduli
- **Context Support**: Form, display, preview
- **Validation**: Regole business integrate
- **Localization**: Supporto multilingua completo

### Tipi Blocchi Disponibili
- **Hero**: Sezioni principali con CTA
- **Content**: Testi e formattazione
- **Media**: Immagini, video, gallerie
- **Navigation**: Menu e breadcrumb
- **Forms**: Contatti e interazioni

## Responsabilità Moduli

### Modulo <nome progetto>
- **Business Logic**: Regole specifiche <slogan>
- **Frontend Integration**: Coordinamento componenti
- **Performance**: Ottimizzazioni frontend
- **SEO**: Meta tags e struttura semantica

### Modulo CMS
- **Content Management**: CRUD contenuti
- **Block System**: Configurazione blocchi
- **Filament Admin**: Interfaccia amministrativa
- **Content Storage**: Gestione JSON e database

### Modulo UI
- **Block Components**: Implementazione blocchi
- **View Templates**: Template rendering
- **Block Actions**: Azioni gestione blocchi
- **Design System**: Componenti riutilizzabili

## Testing Strategy

### Test <nome progetto> (Frontend)
- Rendering homepage
- Integrazione componenti
- Business logic
- Performance e SEO

### Test CMS (Backend)
- Gestione contenuti
- CRUD operazioni
- Validazione blocchi
- Integrazione Filament

### Test UI (Components)
- Rendering blocchi
- Responsive design
- Accessibilità
- Performance componenti

## Best Practices

### 1. Separazione Responsabilità
- Ogni modulo ha responsabilità specifiche
- Interfacce chiare tra moduli
- Dependency injection per accoppiamento
- Testing isolato per ogni modulo

### 2. Content Management
- Struttura JSON coerente
- Validazione robusta
- Versioning contenuti
- Cache intelligente

### 3. Performance
- Lazy loading blocchi
- Ottimizzazione immagini
- CDN per assets
- Cache contenuti

### 4. SEO e Accessibilità
- Meta tags dinamici
- Struttura semantica
- Alt text per immagini
- Navigazione keyboard

## Configurazione e Deployment

### Ambiente Sviluppo
- JSON contenuti in `config/local/`
- Hot reload per modifiche
- Debug mode attivo
- Logging dettagliato

### Ambiente Produzione
- JSON contenuti ottimizzati
- Cache attivo
- CDN per assets
- Monitoring performance

## Collegamenti
- [Modulo <nome progetto>](laravel/Modules/<nome progetto>/docs/homepage-architecture.md)
- [Modulo CMS](laravel/Modules/Cms/docs/filament-blocks-system.md)
- [Modulo UI](laravel/Modules/UI/docs/blocks-system.md)
- [Tema One](laravel/Themes/One/docs/homepage-structure.md)

*Ultimo aggiornamento: Dicembre 2024*



