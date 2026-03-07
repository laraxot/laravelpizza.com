# Regole Critiche Consolidate - Tema Meetup

## Data

[DATE]

## ⚠️ REGOLE CRITICHE OBBLIGATORIE

### 0. Selezione del Tema Pubblico (Source of Truth)

**REGOLA**: Il tema pubblico NON si deduce “a occhio” dai Blade. La sorgente di verità è la configurazione locale.

**Dove**:

- `.env`: `APP_URL=http://laravelpizza.local`
- `laravel/config/local/laravelpizza/xra.php`: chiave `pub_theme` (es. `Meetup`)

**Esempio**:

```php
return [
    // ...
    'pub_theme' => 'Meetup',
    'register_pub_theme' => true,
];
```

**Conseguenza**:

- Il tema pubblico vive in `laravel/Themes/Meetup`
- Le modifiche frontoffice vanno fatte lì (e documentate lì)

### 1. Frontend Asset Management (CSS/JS)

**REGOLA**: Ogni modifica a `resources/css/app.css` o `resources/js/app.js` richiede `npm run build && npm run copy`.

**Comando**:

```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install
npm run build && npm run copy
```

**Nota**:

- Se cambi dipendenze PHP del tema (file `Themes/Meetup/composer.json`), prima esegui anche:

```bash
composer update -W
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

### 5. Filament 5.x – Install / Upgrade Checklist (per il tema)

Questa checklist è basata sulla documentazione ufficiale Filament `5.x`:

- https://filamentphp.com/docs/5.x/introduction/installation

#### Regole pratiche (Laraxot / Meetup theme)

- **NON usare `filament:install --scaffold` su progetti già avviati**: sovrascrive file esistenti.
- Nel tema pubblico usiamo **`<x-metatags>`** come source-of-truth del `<head>`: evitare layout Blade “manuali” copiati dalla doc Filament.

#### Package install (Filament 5)

Filament 5 è modulare: installa solo i pacchetti che ti servono. Esempio (da doc):

```bash
composer require \
    filament/tables:"~5.0" \
    filament/schemas:"~5.0" \
    filament/forms:"~5.0" \
    filament/infolists:"~5.0" \
    filament/actions:"~5.0" \
    filament/notifications:"~5.0" \
    filament/widgets:"~5.0"
```

#### Frontend assets (Filament)

```bash
php artisan filament:install
```

Se stai partendo da un progetto *nuovo* e vuoi lo scaffolding:

```bash
php artisan filament:install --scaffold
```

#### Tailwind / Vite

```bash
npm install tailwindcss @tailwindcss/vite --save-dev
```

In `vite.config.js` assicurarsi di avere `@tailwindcss/vite`:

```js
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss(),
  ],
})
```

#### CSS imports (Filament)

Nel CSS bundle (tipicamente `resources/css/app.css` del tema) importare solo i pacchetti installati.
Esempio completo (da doc Filament):

```css
@import 'tailwindcss';

/* Required by all components */
@import '../../vendor/filament/support/resources/css/index.css';

/* Required by actions and tables */
@import '../../vendor/filament/actions/resources/css/index.css';

/* Required by actions, forms and tables */
@import '../../vendor/filament/forms/resources/css/index.css';

/* Required by actions and infolists */
@import '../../vendor/filament/infolists/resources/css/index.css';

/* Required by notifications */
@import '../../vendor/filament/notifications/resources/css/index.css';

/* Required by actions, infolists, forms, schemas and tables */
@import '../../vendor/filament/schemas/resources/css/index.css';

/* Required by tables */
@import '../../vendor/filament/tables/resources/css/index.css';

/* Required by widgets */
@import '../../vendor/filament/widgets/resources/css/index.css';

@variant dark (&:where(.dark, .dark *));
```

#### Layout requirements (Filament)

La doc Filament richiede:

- `@filamentStyles` nel `<head>`
- `@filamentScripts` a fine `<body>`
- (opzionale) `@livewire('notifications')` se usi `filament/notifications`

Nel nostro progetto, queste inclusioni devono passare dal pattern del tema:

- **NON scrivere `<head>` manuale**: usare `<x-metatags>`.


---

### 6. NO `declare(strict_types=1);` nei File Blade

**REGOLA**: È assolutamente vietato usare `declare(strict_types=1);` all'interno di file `.blade.php`, inclusi i componenti Volt.

**❌ ERRATO**:
```blade
<?php
declare(strict_types=1); // ❌ ERRORE: FatalError nel file compilato
```

**✅ CORRETTO**:
Rimuovere la dichiarazione o spostare la logica in una classe PHP separata (`app/Helpers/`, `app/Actions/`, ecc.) dove `strict_types` è consentito.

**Perché**:
- Il compilatore Blade prepende codice al file PHP generato.
- PHP richiede che `declare(strict_types=1);` sia la primissima istruzione assoluta nel file.
- La presenza di codice prepensato da Blade causa un errore fatale.

**Riferimenti**:
- `Themes/Meetup/docs/blade-files-no-strict-types.md`

---

## Checklist Regole Critiche

- [x] Frontend Asset Management (build e copy)
- [x] Componenti Blade Anonimi (sintassi corretta)
- [x] Vite Configuration (path tema)
- [x] Metatags Component (sempre usare)
- [x] NO strict_types in Blade

### 7. CRITICAL DRY PATTERN - MAI usare trait duplicati nei singoli modelli

**REGOLA**: Se un trait (es. `DatabaseTransactions`) può fornire un metodo (es. `refreshDatabase`) aggiungerlo SOLO nel trait.

**REGOLA**: I modelli che usano il trait ereditano automaticamente il metodo.

**REGOLA**: NON duplicare metodi nei singoli modelli.

**Esempio**:

```php
// ❌ ERRATO - ridondante
use DatabaseTransactions; // già incluso in XotBaseTestCase

abstract class TestCase extends XotBaseTestCase
{
    // ...
}

// ✅ CORRETTO - usa solo l'ereditarietà
abstract class TestCase extends XotBaseTestCase
{
    // ...
}
```

**Perché**:

- Violare i principi DRY e KISS del progetto
- Causare confusione e manutenzione difficoltosa
- Incompatibile con l'architettura Laraxot che centralizza le funzionalità nei trait

**Riferimenti**:
- `laravel/Modules/Xot/tests/XotBaseTestCase.php` - contiene `use DatabaseTransactions;`
- `laravel/Modules/*/tests/TestCase.php` - non devono duplicare questo trait

---

## Aggiornamenti Recenti

- **2026-03-07**: Aggiunta regola CRITICAL DRY Pattern - DatabaseTransactions trait
- **2026-02-18**: Aggiunta regola NO strict_types in Blade
- **2026-02-14**: Aggiunta regola Frontend Asset Management
- **2026-02-14**: Aggiunta regola Componenti Blade Anonimi
- **2026-02-14**: Consolidata Vite Configuration
- **2026-02-14**: Consolidata Metatags Component
