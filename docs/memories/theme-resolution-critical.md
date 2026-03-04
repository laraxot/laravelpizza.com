# Theme Resolution Critical Memory

## REGOLA CRITICA - Separazione Tema

Il **tema pubblico** non è hardcodat: si ricava dalla configurazione tenant.

### 0. Workflow di Risoluzione Tema (CRITICAL)

1. **`.env`** → `APP_URL` (es. `http://laravelpizza.local`)
2. **Cartella config** → da `APP_URL` il modulo Tenant ricava il nome tenant (es. `local/laravelpizza`) → **`laravel/config/local/laravelpizza`**
3. **`config/local/laravelpizza/xra.php`** → chiave **`pub_theme`** (es. `'Meetup'`)
4. **Tema** → **`laravel/Themes/Meetup`**; view namespace **`pub_theme::`**

### 1. Comandi Tema (OBBLIGATORI dopo modifiche CSS/JS)

```bash
# Dalla cartella del tema
cd laravel/Themes/Meetup

# 1. Install dependencies
composer update -W

# 2. Install NPM dependencies  
npm install

# 3. Build assets
npm run build

# 4. Copia in public_html (CRUCIALE!)
npm run copy
```

**IMPORTANTE**: `npm run copy` è FONDAMENTALE altrimenti le modifiche CSS/JS non sono visibili!

### 2. Struttura Tema Meetup

```
laravel/Themes/Meetup/
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   ├── blocks/          # Blocchi CMS
│   │   │   ├── sections/        # Header, Footer
│   │   │   ├── layouts/         # Layout base
│   │   │   └── ui/            # Componenti UI
│   │   ├── pages/              # Folio routing
│   │   └── partials/           # Parziali
│   ├── css/
│   │   └── app.css             # Tailwind styles
│   └── js/
│       └── app.js              # Alpine.js components
├── public_html/                # Assets pubblici (copiati dal build)
├── package.json
├── tailwind.config.js
├── vite.config.js
└── composer.json
```

### 3. Filament Integration

Studio approfondito Filament 5.x documentazione:

- **Filament 5.x**: Nuova architettura reactive
- **Panel Configuration**: `PanelProvider` classes
- **Resources**: Estensione `XotBaseResource`
- **Actions**: Business logic separation
- **Forms**: Advanced validation e custom fields

### 4. Tema Attuale: Meetup

**Configurazione verificata**:
- `APP_URL` = `http://laravelpizza.local`
- `pub_theme` = `'Meetup'` ✅
- Path tema = `laravel/Themes/Meetup` ✅
- Namespace = `pub_theme::` ✅

### 5. Processo di Sviluppo Tema

1. **Modifica componenti Blade** in `resources/views/`
2. **Modifica stili** in `resources/css/app.css`
3. **Modifica JavaScript** in `resources/js/app.js`
4. **Esegui build**: `npm run build`
5. **Copia assets**: `npm run copy` ❗ FONDAMENTALE
6. **Test nel browser**: `php artisan serve`

### 6. Risoluzione Problemi Comuni

#### Problema: Assets non si vedono
**Causa**: `npm run copy` non eseguito dopo build
**Soluzione**: Eseguire sempre `npm run copy` dopo `npm run build`

#### Problema: Namespace non trovato
**Causa**: Configurazione tenant errata
**Soluzione**: Verificare `config/local/{tenant}/xra.php` → `pub_theme`

#### Problema: Componenti non aggiornati
**Causa**: Cache Blade
**Soluzione**: `php artisan view:clear` e `php artisan cache:clear`

### 7. Best Practices Tema

1. **Sempre** eseguire build + copy dopo modifiche
2. **Usare** namespace `pub_theme::` per i componenti tema
3. **Seguire** architettura Folio + Volt per front-end
4. **Documentare** componenti complessi in `docs/`
5. **Testare** responsive design su tutti i dispositivi
6. **Validare** HTML5 e accessibilità (WCAG)

### 8. Filo Filosofico: DRY + Modularità

**DRY (Don't Repeat Yourself)**:
- Componenti riutilizzabili
- Mixins Tailwind per stili comuni
- Helper functions per logiche ripetute

**Modularità**:
- Separazione responsabilità (blocks, sections, layouts)
- Componenti indipendenti
- Architettura a componenti

**KISS (Keep It Simple, Stupid)**:
- Semplificare dove possibile
- Evitare over-engineering
- Priorizzare performance

---

**AGGIORNATO**: 2026-02-02  
**STATO**: ✅ Processo tema verificato e documentato  
**PRIORITÀ**: MASSIMA - Regola fondamentale per funzionamento progetto