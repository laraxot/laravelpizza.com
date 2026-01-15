# Analisi Mailpace Templates

## Introduzione
Mailpace (precedentemente Mailtrap) offre una collezione di template email professionali che possono essere utilizzati come base per il nostro sistema di template email.

## Struttura dei Template Mailpace

### 1. Layout Base
I template Mailpace seguono una struttura standard:
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ subject }}</title>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <img src="{{ logo_url }}" alt="Logo">
        </header>

        <!-- Content -->
        <main>
            {{ content }}
        </main>

        <!-- Footer -->
        <footer>
            <p>{{ footer_text }}</p>
            <div class="social-links">
                {{ social_links }}
            </div>
        </footer>
    </div>
</body>
</html>
```

### 2. Caratteristiche Principali
- Design responsive
- Supporto per variabili dinamiche
- Stili inline per compatibilità email
- Struttura modulare
- Supporto multilingua

## Integrazione con il Nostro Sistema

### 1. Struttura Directory
```
resources/
└── mail-layouts/
    ├── base/
    │   ├── default.blade.php
    │   ├── modern.blade.php
    │   └── minimal.blade.php
    ├── components/
    │   ├── header.blade.php
    │   ├── footer.blade.php
    │   └── buttons.blade.php
    └── themes/
        ├── light/
        └── dark/
```

### 2. Layout Base
Il file `resources/mail-layouts/base/default.blade.php` dovrebbe contenere:
```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Stili base */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        /* Altri stili... */
    </style>
</head>
<body>
    <div class="container">
        @include('notify::mail-layouts.components.header')
        
        <main>
            @yield('content')
        </main>

        @include('notify::mail-layouts.components.footer')
    </div>
</body>
</html>
```

### 3. Componenti Riutilizzabili
I componenti in `resources/mail-layouts/components/` dovrebbero essere modulari e riutilizzabili:

#### Header (`header.blade.php`)
```php
<header class="email-header">
    <img src="{{ config('notify.logo_url') }}" alt="{{ config('app.name') }}" class="logo">
    @if(isset($header_text))
        <h1>{{ $header_text }}</h1>
    @endif
</header>
```

#### Footer (`footer.blade.php`)
```php
<footer class="email-footer">
    <p>{{ config('notify.footer_text') }}</p>
    @if(config('notify.social_links'))
        <div class="social-links">
            @foreach(config('notify.social_links') as $platform => $url)
                <a href="{{ $url }}">{{ $platform }}</a>
            @endforeach
        </div>
    @endif
</footer>
```

## Best Practices

### 1. Struttura Template
- Mantenere una struttura coerente
- Utilizzare componenti riutilizzabili
- Separare stili e contenuto
- Supportare temi chiari e scuri

### 2. Stili
- Utilizzare stili inline
- Evitare CSS esterno
- Supportare client email principali
- Testare su diversi dispositivi

### 3. Variabili
- Utilizzare variabili di configurazione
- Supportare override per template
- Documentare tutte le variabili disponibili
- Gestire fallback appropriati

## Implementazione

### 1. Configurazione
```php
// config/notify.php
return [
    'mail_layouts' => [
        'default' => 'notify::mail-layouts.base.default',
        'themes' => [
            'light' => 'notify::mail-layouts.themes.light',
            'dark' => 'notify::mail-layouts.themes.dark',
        ],
    ],
    'logo_url' => env('MAIL_LOGO_URL'),
    'footer_text' => env('MAIL_FOOTER_TEXT'),
    'social_links' => [
        'twitter' => env('MAIL_SOCIAL_TWITTER'),
        'facebook' => env('MAIL_SOCIAL_FACEBOOK'),
        'linkedin' => env('MAIL_SOCIAL_LINKEDIN'),
    ],
];
```

### 2. Utilizzo nei Template
```php
@extends('notify::mail-layouts.base.default')

@section('content')
    <div class="email-content">
        <h2>{{ $title }}</h2>
        <p>{{ $content }}</p>
        @include('notify::mail-layouts.components.buttons', ['buttons' => $buttons])
    </div>
@endsection
```

## Note Importanti

1. **Compatibilità**
   - Testare su vari client email
   - Verificare la responsività
   - Controllare il rendering delle immagini

2. **Performance**
   - Ottimizzare le immagini
   - Minimizzare il codice HTML
   - Utilizzare CDN per risorse statiche

3. **Manutenzione**
   - Documentare le modifiche
   - Versionare i template
   - Mantenere un changelog

## Collegamenti
- [Mailpace Templates](https://github.com/mailpace/templates)
- [Email Best Practices](./EMAIL_BEST_PRACTICES.md)
- [Template Management](./template-management.md) 
