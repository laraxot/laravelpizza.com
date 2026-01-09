# Analisi Struttura Componente Metatags

## Data
2025-11-30

## ⚠️ IMPORTANTE - Struttura Componente

Il componente `<x-metatags>` **già include il tag `<head>` completo** nel suo template. Non è un componente da inserire dentro un `<head>`, ma **sostituisce completamente** il tag `<head>`.

## Struttura Componente

### Template: `Modules/Cms/resources/views/components/metatags.blade.php`

```blade
<head>
    <title>{{ $meta->getTitle() }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Basics --}}
    <!-- ... metatag SEO ... -->

    {{-- Open Graph / Facebook --}}
    <!-- ... metatag Open Graph ... -->

    {{-- Twitter Card --}}
    <!-- ... metatag Twitter ... -->

    {{-- Favicon --}}
    <!-- ... favicon multi-size ... -->

    {{ $slot }}  {{-- Slot per contenuti aggiuntivi --}}
    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/' . $meta->getPubTheme())
</head>
```

**Punti Chiave:**
1. ✅ Il componente **inizia con `<head>`** e **termina con `</head>`**
2. ✅ Include già `@vite` con il tema corretto
3. ✅ Include già `@filamentStyles`
4. ✅ Lo slot `{{ $slot }}` è **prima** di `@vite` e `@filamentStyles`

## Uso Corretto

### ✅ CORRETTO - Layout Base

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

**Problemi:**
- ❌ `@vite` viene chiamato due volte (duplicazione)
- ❌ `@livewireStyles` non esiste in Livewire 3
- ❌ Duplicazione di asset CSS/JS

## Cosa Include Automaticamente

Il componente `<x-metatags>` include automaticamente:

1. **Tag `<head>` completo** (apertura e chiusura)
2. **SEO Basics**: title, description, keywords, author, robots, canonical
3. **Open Graph**: og:type, og:site_name, og:title, og:description, og:url, og:image, og:locale
4. **Twitter Card**: twitter:card, twitter:url, twitter:title, twitter:description, twitter:image
5. **Favicon multi-size**: 16x16, 32x32, 180x180 (apple-touch-icon)
6. **Manifest**: Web app manifest
7. **Preload resources**: Google Fonts preconnect, DNS prefetch
8. **Vite assets**: `@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/' . $meta->getPubTheme())`
9. **Filament styles**: `@filamentStyles`

## Cosa Aggiungere nello Slot

Lo slot `{{ $slot }}` serve **solo** per contenuti aggiuntivi che **NON sono già inclusi**:

### ✅ Contenuti Aggiuntivi Permessi

```blade
<x-metatags>
    {{-- Font personalizzati --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Schema.org markup --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Laravel Pizza Meetups"
    }
    </script>

    {{-- Script aggiuntivi --}}
    <script src="https://example.com/script.js"></script>

    {{-- Meta tags aggiuntivi --}}
    <meta name="custom-meta" content="value">
</x-metatags>
```

### ❌ Contenuti NON Permessi (Già Inclusi)

```blade
<x-metatags>
    {{-- ❌ NON aggiungere: @vite (già incluso) --}}
    {{-- ❌ NON aggiungere: @filamentStyles (già incluso) --}}
    {{-- ❌ NON aggiungere: <meta charset> (già incluso) --}}
    {{-- ❌ NON aggiungere: <meta name="viewport"> (già incluso) --}}
    {{-- ❌ NON aggiungere: <title> (già incluso) --}}
</x-metatags>
```

## Livewire Scripts

**IMPORTANTE**: In Livewire 3, non esiste `@livewireStyles`. Gli script Livewire vanno nel `<body>`:

```blade
<body>
    {{ $slot }}
    @livewireScripts  {{-- ✅ CORRETTO: Nel body, non nel head --}}
</body>
```

## Esempio Completo Corretto

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <x-metatags>
        {{-- Solo contenuti aggiuntivi specifici del tema --}}
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Organization",
          "name": "Laravel Pizza Meetups",
          "description": "Community of Laravel developers who meet for pizza and knowledge sharing",
          "url": "https://laravelpizza.com"
        }
        </script>
    </x-metatags>
    <body class="font-sans antialiased bg-slate-900 text-white">
        {{ $slot }}
        @livewireScripts
    </body>
</html>
```

## Verifica

### Controllo HTML Generato

Dopo il rendering, l'HTML dovrebbe essere:

```html
<!DOCTYPE html>
<html lang="it" class="scroll-smooth">
<head>
    <title>Laravel Pizza Meetups</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ... metatag SEO ... -->
    <!-- ... Open Graph ... -->
    <!-- ... Twitter Card ... -->
    <!-- ... favicon ... -->

    <!-- Slot content (font, schema.org, etc.) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script type="application/ld+json">...</script>

    <!-- Vite assets (automatico) -->
    <link rel="stylesheet" href="/build/assets/app.css">
    <script type="module" src="/build/assets/app.js"></script>

    <!-- Filament styles (automatico) -->
    <link rel="stylesheet" href="/filament/styles.css">
</head>
<body class="font-sans antialiased bg-slate-900 text-white">
    <!-- Page content -->
    <script src="/livewire/livewire.js"></script>
</body>
</html>
```

## Troubleshooting

### Problema: Doppio `<head>`

**Causa**: Uso di `<head>` manuale insieme a `<x-metatags>`

**Soluzione**: Rimuovere il tag `<head>` manuale, usare solo `<x-metatags>`

### Problema: Asset duplicati

**Causa**: `@vite` chiamato sia nel componente che nello slot

**Soluzione**: Rimuovere `@vite` dallo slot, è già incluso nel componente

### Problema: `@livewireStyles` non funziona

**Causa**: `@livewireStyles` non esiste in Livewire 3

**Soluzione**: Usare `@livewireScripts` nel `<body>`

## Best Practices

1. ✅ **Usa `<x-metatags>` come sostituto completo di `<head>`**
2. ✅ **Non duplicare contenuti già inclusi** (`@vite`, `@filamentStyles`, metatag base)
3. ✅ **Usa lo slot solo per contenuti aggiuntivi** (font, schema.org, script personalizzati)
4. ✅ **Metti `@livewireScripts` nel `<body>`, non nel `<head>`**
5. ✅ **Verifica l'HTML generato** per assicurarti che non ci siano duplicazioni

## Riferimenti

- Template: `Modules/Cms/resources/views/components/metatags.blade.php`
- Componente: `Modules/Cms/app/View/Components/Metatags.php`
- Data Object: `Modules/Xot/app/Datas/MetatagData.php`
- Documentazione: `Themes/Meetup/docs/metatags-component-usage.md`

## Checklist

- [x] Documentata struttura componente (include `<head>` completo)
- [x] Spiegato uso corretto vs errato
- [x] Elencato cosa include automaticamente
- [x] Documentato cosa aggiungere nello slot
- [x] Aggiunto troubleshooting
- [x] Aggiunte best practices
