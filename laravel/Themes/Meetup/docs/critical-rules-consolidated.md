# Regole Critiche Consolidate - Tema Meetup

## Data
2025-11-30

## ⚠️ REGOLE CRITICHE OBBLIGATORIE

### 1. Frontend Asset Management (CSS/JS)

**REGOLA**: Ogni modifica a `resources/css/app.css` o `resources/js/app.js` richiede `npm run build && npm run copy`.

**Comando**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm run build && npm run copy
```

**Perché**:
- Vite compila i file source in asset ottimizzati
- Gli asset devono essere copiati in `public_html/themes/Meetup/` per essere accessibili via web
- Senza build e copy, le modifiche NON sono visibili nel browser

**Quando**:
- ✅ Dopo modifiche CSS/JS
- ✅ Prima di testare nel browser (`http://127.0.0.1:8000/it`)
- ✅ Prima di commitare modifiche frontend
- ❌ NON serve durante `npm run dev` (hot reload automatico)

**Riferimenti**:
- `Themes/Meetup/docs/development-workflow-css-js-changes.md`
- `Modules/Meetup/docs/development-workflow-css-js-changes.md`

---

### 2. Componenti Blade Anonimi con Namespace

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

**Perché**:
- `CmsServiceProvider::registerNamespaces()` registra componenti anonimi con `Blade::anonymousComponentPath()`
- I componenti anonimi funzionano solo con sintassi semplice `<x-component-name>`
- La sintassi namespace esplicita cerca classi componenti o view namespace, non componenti anonimi

**Riferimenti**:
- `Themes/Meetup/docs/pub-theme-component-namespace-error-analysis.md`
- `Modules/Meetup/docs/pub-theme-component-namespace-error-analysis.md`

---

### 3. Vite Configuration per Temi

**REGOLA**: Il comando `@vite` deve specificare il path del tema.

**✅ CORRETTO**:
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
```

**Perché**:
- Vite deve sapere dove trovare i file source relativi al tema
- Il secondo parametro indica la directory base del tema
- Senza questo parametro, Vite cerca nella root Laravel

**Riferimenti**:
- `Themes/Meetup/docs/vite-theme-asset-loading-fix.md`
- `Themes/Meetup/docs/metatags-component-usage.md`

---

### 4. Metatags Component

**REGOLA**: Usare SEMPRE `<x-metatags>` invece di tag `<head>` manuale.

**❌ ERRATO**:
```blade
<head>
    <title>...</title>
    <meta ...>
    @vite(...)
</head>
```

**✅ CORRETTO**:
```blade
<x-metatags>
    <!-- Contenuti aggiuntivi se necessario -->
</x-metatags>
```

**Perché**:
- Il componente include automaticamente SEO, Open Graph, Twitter Card
- Gestisce automaticamente Vite assets e Filament styles
- Centralizza tutta la gestione del `<head>`

**Riferimenti**:
- `Themes/Meetup/docs/metatags-component-usage.md`
- `Themes/Meetup/docs/metatags-component-structure-analysis.md`

---

## Checklist Regole Critiche

- [x] Frontend Asset Management (build e copy)
- [x] Componenti Blade Anonimi (sintassi corretta)
- [x] Vite Configuration (path tema)
- [x] Metatags Component (sempre usare)

## Aggiornamenti Recenti

- **2025-11-30**: Aggiunta regola Frontend Asset Management
- **2025-11-30**: Aggiunta regola Componenti Blade Anonimi
- **2025-11-30**: Consolidata Vite Configuration
- **2025-11-30**: Consolidata Metatags Component
