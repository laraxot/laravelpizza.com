# Uso Componente Metatags - Regola Critica

## Data
2025-11-29

## ⚠️ REGOLA CRITICA

**NEVER scrivere manualmente il tag `<head>` nei layout Blade. Usa SEMPRE il componente `<x-metatags>`.**

## Perché?

### 1. Centralizzazione e DRY

Il componente `<x-metatags>` centralizza tutta la gestione dei metatag in un unico punto:
- `Modules/Cms/app/View/Components/Metatags.php` - Logica componente
- `Modules/Cms/resources/views/components/metatags.blade.php` - Template

**Vantaggi:**
- ✅ Modifiche ai metatag in un solo file
- ✅ Consistenza su tutte le pagine
- ✅ Nessuna duplicazione di codice
- ✅ Facile manutenzione

### 2. SEO Automatico

Il componente usa `MetatagData::make()` che genera automaticamente:
- **SEO Basics**: title, description, keywords, author, robots, canonical
- **Open Graph**: og:title, og:description, og:image, og:url, og:locale
- **Twitter Card**: twitter:card, twitter:title, twitter:description, twitter:image
- **Favicon multi-size**: 16x16, 32x32, 180x180 (apple-touch-icon)
- **Manifest**: Web app manifest
- **Preload resources**: Fonts, DNS prefetch

**Vantaggi:**
- ✅ SEO completo senza configurazione manuale
- ✅ Metatag dinamici basati sulla pagina corrente
- ✅ Integrazione con sistema di localizzazione
- ✅ Supporto multi-lingua automatico

### 3. Integrazione Sistema Temi

Il componente gestisce automaticamente:
- **Tema corrente**: `$meta->getPubTheme()` - risolve il tema configurato
- **Vite assets**: `@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/' . $meta->getPubTheme())`
- **Filament styles**: `@filamentStyles` già incluso
- **Asset del tema**: `$meta->getPubThemeAsset('favicon.ico')`

**Vantaggi:**
- ✅ Vite assets caricati automaticamente per il tema corretto
- ✅ Favicon e asset del tema risolti automaticamente
- ✅ Nessun hardcoding del nome tema

### 4. Manutenibilità

**Con `<head>` manuale:**
```blade
<!-- ❌ ERRATO - Duplicazione, hardcoding, manutenzione difficile -->
<head>
    <title>Laravel Pizza Meetups</title>
    <meta name="description" content="...">
    <!-- ... 50+ righe di metatag ... -->
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
</head>
```

**Con `<x-metatags>`:**
```blade
<!-- ✅ CORRETTO - Centralizzato, automatico, manutenibile -->
<x-metatags>
    <!-- Slot per contenuti aggiuntivi se necessario -->
</x-metatags>
```

## Come Usare

### ⚠️ IMPORTANTE - Struttura Componente

Il componente `<x-metatags>` **già include il tag `<head>` completo**. Non è un componente da inserire dentro un `<head>`, ma **sostituisce completamente** il tag `<head>`.

Il componente include già:
- ✅ `@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/' . $meta->getPubTheme())`
- ✅ `@filamentStyles`
- ✅ Tutti i metatag SEO, Open Graph, Twitter Card
- ✅ Favicon multi-size
- ✅ Preload resources

**Lo slot serve SOLO per contenuti aggiuntivi** (font personalizzati, Schema.org, script aggiuntivi).

### Layout Base

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <x-metatags>
        {{-- Solo contenuti aggiuntivi che NON sono già inclusi --}}
        {{-- Esempio: Font personalizzati, Schema.org, script aggiuntivi --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    </x-metatags>
    <body>
        {{ $slot }}
        @livewireScripts
    </body>
</html>
```

### ❌ ERRATO - Duplicazione

```blade
<!DOCTYPE html>
<html>
    <x-metatags>
        {{-- ❌ ERRATO: @vite è già incluso nel componente --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
        {{-- ❌ ERRATO: @livewireStyles non esiste, usa @livewireScripts nel body --}}
        @livewireStyles
    </x-metatags>
    <body>
        {{ $slot }}
    </body>
</html>
```

### Contenuti Aggiuntivi

Se devi aggiungere contenuti al `<head>`, usa lo slot:

```blade
<x-metatags>
    {{-- Scripts aggiuntivi --}}
    <script src="https://example.com/script.js"></script>
    
    {{-- Styles aggiuntivi --}}
    <link rel="stylesheet" href="https://example.com/style.css">
    
    {{-- Meta tags aggiuntivi --}}
    <meta name="custom-meta" content="value">
</x-metatags>
```

## Cosa Include Automaticamente

Il componente `<x-metatags>` include automaticamente:

1. **SEO Basics**
   - `<title>` - Dinamico basato sulla pagina
   - `<meta name="title">`
   - `<meta name="description">` (limitato a 160 caratteri)
   - `<meta name="keywords">`
   - `<meta name="author">`
   - `<meta name="robots">`
   - `<link rel="canonical">`

2. **Open Graph (Facebook)**
   - `og:type`, `og:site_name`, `og:title`, `og:description`
   - `og:url`, `og:image`, `og:locale`

3. **Twitter Card**
   - `twitter:card`, `twitter:url`, `twitter:title`
   - `twitter:description`, `twitter:image`

4. **Favicon Multi-size**
   - `favicon.ico`
   - `32x32.png`, `16x16.png`
   - `180x180.png` (apple-touch-icon)
   - `manifest.json`

5. **Preload Resources**
   - Google Fonts preconnect
   - DNS prefetch per analytics

6. **Vite Assets**
   - CSS e JS del tema corrente
   - Build name automatico: `'themes/' . $meta->getPubTheme()`

7. **Filament Styles**
   - `@filamentStyles` per admin panel

## Esempi

### ❌ ERRATO - Head Manuale

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Pizza Meetups</title>
    <meta name="description" content="...">
    <!-- ... molti altri metatag ... -->
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/Meetup')
</head>
<body>
    {{ $slot }}
</body>
</html>
```

**Problemi:**
- ❌ Duplicazione codice
- ❌ Hardcoding tema "Meetup"
- ❌ Metatag statici (non dinamici)
- ❌ Manutenzione difficile
- ❌ Nessun SEO automatico

### ✅ CORRETTO - Componente Metatags

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <x-metatags>
        <!-- Contenuti aggiuntivi se necessario -->
    </x-metatags>
    <body>
        {{ $slot }}
    </body>
</html>
```

**Vantaggi:**
- ✅ Centralizzato
- ✅ SEO automatico
- ✅ Tema dinamico
- ✅ Manutenibile
- ✅ DRY

## Configurazione

Il componente usa `MetatagData::make()` che legge:
- Configurazione da `config/`
- Dati dalla pagina corrente (se disponibili)
- Tema corrente da `config('xra.pub_theme')`
- Localizzazione da `app()->getLocale()`

## Riferimenti

- Componente: `Modules/Cms/app/View/Components/Metatags.php`
- Template: `Modules/Cms/resources/views/components/metatags.blade.php`
- Data Object: `Modules/Xot/app/Datas/MetatagData.php`
- Documentazione: `Modules/Cms/docs/metatag-population-strategy.md`

## Checklist

- [x] Documentata regola critica
- [x] Spiegato perché (centralizzazione, SEO, integrazione, manutenibilità)
- [x] Forniti esempi corretti/errati
- [x] Documentato come usare
- [x] Elencato cosa include automaticamente

