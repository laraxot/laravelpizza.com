# Regole Critiche Consolidate - Modulo Meetup

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
- ✅ Prima di testare nel browser
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

### 3. Architettura Frontoffice (Folio + Volt)

**REGOLA CRITICA**: Nel frontoffice NON usare controller né scrivere rotte in `web.php` o `api.php`.

**✅ OBBLIGATORIO**:
- **Folio** per routing file-based: `resources/views/pages/*.blade.php` = rotte automatiche
- **Volt** per interattività: `@volt('component-name')` direttamente nelle pagine
- **Filament** SOLO per admin panel (backend)
- **Actions** chiamate da componenti Volt, non da controller

**Pattern Architetturale**:
```
Request → Folio (routing) → Blade Page → Volt Component → Action → Service/Model
```

**Riferimenti**:
- `Modules/Meetup/docs/architecture-reference.md`
- `Modules/Meetup/docs/folio-volt-repositories-analysis.md`

---

## Checklist Regole Critiche

- [x] Frontend Asset Management (build e copy)
- [x] Componenti Blade Anonimi (sintassi corretta)
- [x] Architettura Frontoffice (Folio + Volt)

## Aggiornamenti Recenti

- **2025-11-30**: Aggiunta regola Frontend Asset Management
- **2025-11-30**: Aggiunta regola Componenti Blade Anonimi
- **2025-11-30**: Consolidata Architettura Frontoffice
