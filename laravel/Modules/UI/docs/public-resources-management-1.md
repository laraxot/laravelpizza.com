# Gestione delle Risorse Pubbliche

## Indice
- [Panoramica](#panoramica)
- [Struttura delle Cartelle](#struttura-delle-cartelle)
- [Tipi di Risorse](#tipi-di-risorse)
- [Best Practices](#best-practices)
- [Esempi di Utilizzo](#esempi-di-utilizzo)

## Panoramica

Questo documento descrive la corretta gestione delle risorse pubbliche (immagini, CSS, JavaScript, ecc.) , con particolare attenzione alla struttura delle cartelle e alle best practices da seguire.

## Struttura delle Cartelle

La struttura corretta per le risorse pubbliche  è la seguente:

```

├── public_html/           # Directory pubblica principale
│   ├── images/            # Immagini pubbliche
│   ├── css/               # File CSS
│   ├── js/                # File JavaScript
│   ├── fonts/             # Font
│   └── assets/            # Altre risorse statiche
└── laravel/               # Applicazione Laravel (NON contiene file pubblici)
```

> **IMPORTANTE**: MAI utilizzare `public/` per i file pubblici. Questa cartella non è accessibile via web nel setup di <nome progetto>.

## Tipi di Risorse

### Immagini

Le immagini devono essere posizionate in `public_html/images/` e organizzate in sottocartelle per tipologia:

- `/images/avatars/` - Avatar utenti
- `/images/logos/` - Loghi
- `/images/icons/` - Icone
- `/images/backgrounds/` - Sfondi

### CSS e JavaScript

I file CSS e JavaScript compilati devono essere posizionati in:

- `/public_html/css/` - File CSS
- `/public_html/js/` - File JavaScript

### Font

I font devono essere posizionati in `/public_html/fonts/` e organizzati per famiglia.

## Best Practices

1. **Utilizzo nei Template Blade**

   ```blade
   <img src="{{ asset('images/default-avatar.svg') }}" alt="Avatar utente">
   ```

   > **Nota**: La funzione `asset()` punta automaticamente alla directory pubblica corretta.

2. **Generazione di URL per Risorse Pubbliche**

   ```php
   $avatarUrl = asset('images/default-avatar.svg');
   ```

3. **Risorse Localizzate**

   Per risorse che variano in base alla lingua, utilizzare la struttura:

   ```
   /public_html/images/localized/{locale}/image.svg
   ```

   E accedervi con:

   ```php
   $localizedImage = asset('images/localized/' . LaravelLocalization::getCurrentLocale() . '/image.svg');
   ```

4. **Versionamento delle Risorse**

   Per gestire la cache del browser, aggiungere un parametro di versione:

   ```php
   $cssWithVersion = asset('css/app.css') . '?v=' . config('app.version');
   ```

5. **SVG vs Raster**

   - Preferire SVG per icone, loghi e illustrazioni vettoriali
   - Utilizzare WebP o JPEG ottimizzati per fotografie
   - Fornire fallback per browser più vecchi

## Esempi di Utilizzo

### Avatar Utente

```blade
<img
    src="{{ $user->avatar ? asset('images/avatars/' . $user->avatar) : asset('images/default-avatar.svg') }}"
    alt="{{ $user->name }}"
    class="h-10 w-10 rounded-full"
>
```

### Logo nell'Header

```blade
<a href="{{ LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), route('home')) }}">
    <img
        src="{{ asset('images/logos/<nome progetto>-logo.svg') }}"
        alt="<nome progetto>"
        class="h-8"
    >
</a>
```

### CSS e JavaScript

```blade
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>
```

## Conclusione

Seguendo queste linee guida per la gestione delle risorse pubbliche, si garantisce che tutte le risorse siano correttamente accessibili via web e organizzate in modo coerente, facilitando la manutenzione e l'evoluzione del progetto <nome progetto>.
