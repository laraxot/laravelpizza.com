# Filosofia del Progetto LaravelPizza.com - Tema Meetup

## Data
[DATE]

## Obiettivo del Tema

**Replicare pixel-perfect `laravelpizza.com` dentro il Meetup Theme** (home, events, menu, pagina contatti, auth, ecc.), con **Folio + Volt** come architettura obbligatoria.

## Principi Fondamentali del Tema

### Frontend Asset Management

**REGOLA CRITICA**: Ogni modifica a `resources/css/app.css` o `resources/js/app.js` richiede `npm run build && npm run copy`.

**Comando**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
```

**Perché**:
- Vite compila i file source in asset ottimizzati
- Gli asset devono essere copiati in `public_html/themes/Meetup/` per essere accessibili via web
- Senza build e copy, le modifiche NON sono visibili nel browser (`http://127.0.0.1:8000/it`)

**Quando**:
- ✅ Dopo modifiche CSS/JS
- ✅ Prima di testare nel browser
- ✅ Prima di commitare modifiche frontend
- ❌ NON serve durante `npm run dev` (hot reload automatico)

Vedi: [Development Workflow CSS/JS Changes](./development-workflow-css-js-changes.md)

### Layout Usage

- **`x-layouts.main`** → shell HTML base (no header/footer), NON usare direttamente nelle pagine
- **`x-layouts.app`** → layout completo con header nav + footer (pagina pubblica frontoffice)
  - Include già `<x-section slug="header" tpl="v1" />` e `<x-section slug="footer" />`
  - Wrapper `div` con `bg-slate-900 text-white min-h-screen`
- **`x-layouts.guest`** → layout per login/registrazione/password (auth frontoffice)

**REGOLA**: Le Folio pages pubbliche devono usare sempre `x-layouts.app` come entry point.

Vedi: [Layout System Analysis](./layout-system-analysis.md)

### Componenti Blade Anonimi

**REGOLA**: I componenti anonimi registrati con `Blade::anonymousComponentPath()` NON supportano la sintassi namespace esplicita.

**❌ ERRATO**:
```blade
<x-pub_theme::components.layouts.main>
    {{ $slot }}
</x-pub_theme::components.layouts.main>
```

**✅ CORRETTO**:
```blade
<x-layouts.main>
    {{ $slot }}
</x-layouts.main>
```

Vedi: [Pub Theme Component Namespace Error Analysis](./pub-theme-component-namespace-error-analysis.md)

### Metatags Component

**REGOLA**: Usare SEMPRE `<x-metatags>` invece di tag `<head>` manuale.

Il componente `x-metatags` contiene già il tag `<head>` completo, quindi NON va wrappato in un `<head>` manuale.

Vedi: [Metatags Component Usage](./metatags-component-usage.md)

### Vite Configuration

**REGOLA**: Il comando `@vite` deve specificare il path del tema.

**✅ CORRETTO**:
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
```

Vedi: [Vite Theme Asset Loading Fix](./vite-theme-asset-loading-fix.md)

## Struttura del Tema

```
Themes/Meetup/
├── resources/
│   ├── views/
│   │   ├── pages/          # Folio pages (routing automatico)
│   │   ├── components/     # Componenti Blade
│   │   └── layouts/        # Layout components
│   ├── css/
│   │   └── app.css         # Tailwind CSS principale
│   ├── js/
│   │   └── app.js          # JavaScript principale
│   └── html/               # Versione statica HTML (reference)
├── public/                 # Output Vite build
├── docs/                   # Documentazione tema
├── package.json            # NPM scripts
├── vite.config.js          # Configurazione Vite
└── tailwind.config.js      # Configurazione Tailwind
```

## Workflow di Sviluppo

1. **Modifica CSS/JS** in `resources/css/app.css` o `resources/js/app.js`
2. **Build e Copy**:
   ```bash
   npm run build && npm run copy
   ```
3. **Test** nel browser: `http://127.0.0.1:8000/it`
4. **Confronta** con `https://laravelpizza.com` per verificare allineamento
5. **Documenta** eventuali differenze o decisioni in `docs/`

## Allineamento con laravelpizza.com

Il tema Meetup deve replicare **pixel-perfect** il design di `laravelpizza.com`:

- **Homepage** (`/it`) → `pages/index.blade.php` + `home.json`
- **Events** (`/it/events`) → `pages/[slug].blade.php` + `events.json`
- **Menu** (`/it/menu`) → da implementare
- **Contact** (`/it/contact`) → da implementare
- **About** (`/it/about`) → da implementare
- **Cart** (`/it/cart`) → da implementare
- **Auth pages** (`/it/auth/*`) → `Modules/User/resources/views/pages/auth/*.blade.php` con `x-layouts.guest`

## Riferimenti

- [README Principale](../../../../README.md)
- [Regole Critiche Consolidate](./critical-rules-consolidated.md)
- [Project Philosophy - Module](../../../Meetup/docs/project-philosophy.md)
- [Layout System Analysis](./layout-system-analysis.md)

---

**Ultimo aggiornamento**: [DATE]
**Versione**: 1.0
**Compatibilità**: LaravelPizza.com base_laravelpizza
