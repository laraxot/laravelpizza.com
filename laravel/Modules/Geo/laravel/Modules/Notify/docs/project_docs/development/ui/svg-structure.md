# Struttura SVG nei Moduli

## Panoramica
Questa sezione documenta la struttura SVG standardizzata creata in tutti i moduli del sistema Laraxot.

## Struttura Standard

Ogni modulo ha la seguente struttura SVG:
```
laravel/Modules/{ModuleName}/resources/svg/
├── icon.svg           # Icona principale del modulo
├── logo.svg           # Logo del modulo
├── favicon.svg        # Favicon del modulo
├── loading.svg        # Icona di caricamento
└── {module}-icon.svg  # Icona specifica del modulo
```

## File SVG Creati

### 1. icon.svg
Icona principale del modulo utilizzata per la navigazione e identificazione del modulo.

```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
  <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
</svg>
```

### 2. logo.svg
Logo del modulo utilizzato per branding e identificazione visiva.

```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
</svg>
```

### 3. favicon.svg
Favicon del modulo utilizzato nelle schede del browser.

```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor">
  <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2" fill="none"/>
  <path d="M12 16l3 3 5-5"/>
</svg>
```

### 4. loading.svg
Icona di caricamento animata utilizzata durante le operazioni asincrone.

```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
  <circle cx="12" cy="12" r="10" stroke-dasharray="31.416" stroke-dashoffset="31.416">
    <animate attributeName="stroke-dasharray" dur="2s" values="0 31.416;15.708 15.708;0 31.416" repeatCount="indefinite"/>
    <animate attributeName="stroke-dashoffset" dur="2s" values="0;-15.708;-31.416" repeatCount="indefinite"/>
  </circle>
</svg>
```

### 5. {module}-icon.svg
Icona specifica del modulo che rappresenta la funzionalità principale.

**Esempi:**
- `user-icon.svg` per il modulo User
- `ui-icon.svg` per il modulo UI
- `tenant-icon.svg` per il modulo Tenant
- `media-icon.svg` per il modulo Media
- `blog-icon.svg` per il modulo Blog
- `cms-icon.svg` per il modulo Cms
- `chart-icon.svg` per il modulo Chart
- `notify-icon.svg` per il modulo Notify
- `geo-icon.svg` per il modulo Geo
- `gdpr-icon.svg` per il modulo Gdpr
- `seo-icon.svg` per il modulo Seo
- `rating-icon.svg` per il modulo Rating
- `comment-icon.svg` per il modulo Comment
- `job-icon.svg` per il modulo Job
- `ai-icon.svg` per il modulo AI
- `activity-icon.svg` per il modulo Activity
- `lang-icon.svg` per il modulo Lang
- `form-icon.svg` per il modulo FormBuilder
- `db-icon.svg` per il modulo DbForge
- `fixcity-icon.svg` per il modulo Fixcity

## Moduli Coperti

La struttura SVG è stata creata per i seguenti moduli:

1. **Xot** - Modulo core
2. **User** - Gestione utenti
3. **UI** - Componenti interfaccia
4. **Tenant** - Multi-tenancy
5. **Seo** - Ottimizzazione motori di ricerca
6. **Rating** - Sistema di valutazione
7. **Notify** - Notifiche
8. **Job** - Gestione lavori
9. **Geo** - Geolocalizzazione
10. **Gdpr** - Conformità GDPR
11. **Fixcity** - Modulo specifico progetto
12. **Comment** - Sistema commenti
13. **Chart** - Grafici e statistiche
14. **Blog** - Sistema blog
15. **AI** - Intelligenza artificiale
16. **Activity** - Attività e log
17. **Lang** - Gestione lingue
18. **FormBuilder** - Costruttore form
19. **Cms** - Content Management System
20. **DbForge** - Strumenti database
21. **Media** - Gestione file multimediali

## Statistiche

- **21 moduli** coperti
- **21 cartelle** `resources/svg` create
- **105 file SVG** creati (5 per modulo)
- **0 duplicati** - struttura DRY
- **100% copertura** - tutti i moduli hanno la struttura completa

## Utilizzo

### In Filament
```php
// Utilizzo delle icone SVG in Filament
use Filament\Support\Facades\FilamentIcon;

FilamentIcon::register([
    'user-icon' => Svg::make('user-icon', __DIR__.'/resources/svg/user-icon.svg'),
    'ui-icon' => Svg::make('ui-icon', __DIR__.'/resources/svg/ui-icon.svg'),
]);
```

### In Blade Templates
```blade
<!-- Utilizzo delle icone SVG in Blade -->
<x-ui::ui.icon name="user-icon" class="w-6 h-6" />
<x-ui::ui.icon name="loading" class="w-4 h-4 animate-spin" />
```

### In CSS
```css
/* Utilizzo delle icone SVG in CSS */
.icon-user {
    background-image: url('../resources/svg/user-icon.svg');
}
```

## Manutenzione

### Regole da Seguire
1. **DRY**: Non duplicare SVG tra moduli
2. **KISS**: Mantenere SVG semplici e leggibili
3. **Consistenza**: Utilizzare viewBox="0 0 24 24" per icone
4. **Accessibilità**: Includere sempre `fill="currentColor"`
5. **Performance**: Ottimizzare SVG per dimensioni ridotte

### Processo di Aggiornamento
1. **Nuove icone**: Aggiungere nella cartella appropriata
2. **Modifiche**: Aggiornare sempre la documentazione
3. **Registrazione**: Registrare nuove icone in Filament
4. **Test**: Verificare visualizzazione in tutti i contesti

## Script di Automazione

Lo script `bashscripts/create_svg_structure.sh` è stato utilizzato per creare automaticamente la struttura SVG in tutti i moduli.

### Caratteristiche dello Script
- **Creazione automatica** di cartelle `resources/svg`
- **Generazione SVG** standardizzati per ogni modulo
- **Controllo duplicati** per evitare sovrascritture
- **Report dettagliato** delle operazioni eseguite
- **Conformità DRY + KISS** per struttura pulita

## Collegamenti

- [Struttura Moduli](../architecture/modules/)
- [Componenti UI](./ui-components.md)
- [Best Practices Filament](../filament/best-practices.md)
- [Script di Automazione](../../bashscripts/create_svg_structure.sh)

---

*Struttura SVG creata: Agosto 2025*
*Responsabile: DRY + KISS SVG Structure* 