---
qmd: "mail consolidated"
issues: []
discussions: []
title: "mail: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# mail: Consolidated Documentation

Consolidated from **8** individual files.

## Table of Contents

- [---](#mail-layouts-1)
- [Guida ai Layout Email nel Modulo Notify](#mail-layouts-guide-1)
- [---](#mail-layouts-guide-2)
- [Guida ai Layout Email nel Modulo Notify](#mail-layouts-guide)
- [Mail Layouts - Integrazione con Sistema Temi](#mail-layouts-theme-integration)
- [Layout delle Email](#mail-layouts)
- [Layout delle Email](#mail_layouts)
- [Guida ai Layout Email nel Modulo Notify](#mail_layouts_guide)

---

## mail-layouts-1

*Consolidated from: `mail-layouts.md`*

title: "Layout delle Email"
type: concept
tags: [mail, layouts]
created: 2026-07-14
updated: 2026-07-14
qmd: "mail-layouts-1 layout delle email"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Layout delle Email

## Introduzione
Il modulo Notify utilizza il pacchetto `spatie/laravel-database-mail-templates` per gestire i template delle email. I layout sono file HTML che forniscono una struttura comune per tutte le email inviate dall'applicazione.

## Struttura dei Layout
I layout delle email sono memorizzati nella directory `resources/mail-layouts/` del modulo Notify. Il layout principale è `main.html`.

### Layout Principale (main.html)
Il layout principale include:
- Header con logo
- Contenitore per il contenuto dinamico
- Footer con copyright e disclaimer

## Variabili Disponibili
Nel layout sono disponibili le seguenti variabili:
- `{{{ body }}}`: Il contenuto specifico dell'email
- `{{logo_url}}`: URL del logo
- `{{year}}`: Anno corrente
- `{{app_name}}`: Nome dell'applicazione

## Personalizzazione
Per personalizzare il layout:
1. Modificare il file `main.html` nella directory `resources/mail-layouts/`
2. Aggiungere nuovi stili CSS inline
3. Aggiungere nuove sezioni o componenti

## Utilizzo con MailTemplate
Per utilizzare il layout con un MailTemplate:

```php
use Spatie\MailTemplates\TemplateMailable;

class WelcomeMail extends TemplateMailable
{
    public function getHtmlLayout(): string
    {
        return file_get_contents(
            module_path('Notify', 'resources/mail-layouts/main.html')
        );
    }
}
```

## Best Practices
1. Utilizzare CSS inline per massima compatibilità
2. Testare il layout con diversi client email
3. Mantenere il design responsive
4. Utilizzare colori e font coerenti con il brand

## Screenshot
![Layout Email](../resources/screenshots/mail-layout.png)

## Note
- Il layout è ottimizzato per la visualizzazione su dispositivi mobili
- Supporta la maggior parte dei client email moderni
- Include reset CSS per uniformità tra client 
---

## mail-layouts-guide-1

*Consolidated from: `mail-layouts-guide.md`*


## Introduzione

Questo documento descrive i layout di email disponibili nella directory `resources/mail-layouts` del modulo Notify di <nome progetto>. Questi layout sono progettati per essere compatibili con la maggior parte dei client email e forniscono una base solida per tutte le email transazionali dell'applicazione.

## Struttura dei Layout

Il modulo Notify contiene quattro layout email principali:

```
resources/mail-layouts/
├── default.html       # Layout base con header, content e footer
├── main.html          # Layout alternativo con design semplificato
├── marketing.html     # Layout ottimizzato per comunicazioni marketing
└── notification.html  # Layout specifico per notifiche di sistema
```

## Caratteristiche dei Layout

### Layout Default (`default.html`)

Il layout predefinito include:
- Header con logo dell'applicazione
- Contenitore principale per il contenuto dell'email
- Footer con copyright e disclaimer
- Stili CSS inline per massima compatibilità
- Design responsive con media queries

### Layout Main (`main.html`)

Versione minimalista del layout default con:
- Design più essenziale
- Meno elementi grafici
- Ottimizzato per messaggi diretti e concisi

### Layout Marketing (`marketing.html`)

Specializzato per comunicazioni marketing:
- Supporto per immagini di intestazione di grandi dimensioni
- Sezioni per contenuti multipli
- Call-to-action ben evidenziate
- Design accattivante

### Layout Notification (`notification.html`)

Ottimizzato per notifiche di sistema:
- Design compatto
- Enfasi su messaggi di stato
- Icone per differenziare tipi di notifica
- Visualizzazione ottimizzata anche su dispositivi mobile

## Utilizzo dei Layout

I layout possono essere utilizzati in due modi principali:

### 1. Con Blade Templates

```php
// In un Mailable Laravel
public function build()
{
    return $this->view('notify::emails.welcome')
                ->subject('Benvenuto in '.config('app.name'));
}

// Nel template welcome.blade.php
@extends('notify::emails.layouts.default')

@section('content')
    <h2>Benvenuto, {{ $user->name }}!</h2>
    <p>Grazie per esserti registrato.</p>
    <a href="{{ $activationUrl }}" class="button">Attiva il tuo account</a>
@endsection
```

### 2. Con Spatie Mail Templates

```php
// Nel modello MailTemplate
use Spatie\MailTemplates\MailTemplate as SpatieMailTemplate;

class MailTemplate extends SpatieMailTemplate
{
    // ...

    public function getHtmlLayout(): string
    {
        // Recupera il layout in base al tipo di email
        $layout = 'default';
        if ($this->isMarketing()) {
            $layout = 'marketing';
        } elseif ($this->isNotification()) {
            $layout = 'notification';
        }

        return file_get_contents(module_path('Notify', "resources/mail-layouts/{$layout}.html"));
    }
}
```

## Personalizzazione

### Variabili Supportate

I layout supportano le seguenti variabili Blade:

- `$subject` - L'oggetto dell'email
- `$content` - Il contenuto principale dell'email
- `config('app.name')` - Nome dell'applicazione
- `asset('images/logo.png')` - Percorso al logo
- `date('Y')` - Anno corrente per il copyright

### Modifica dei CSS

I CSS sono definiti inline all'interno di ciascun layout per massimizzare la compatibilità. Per modificare lo stile:

1. Individua la sezione `<style>` nel file di layout
2. Modifica le regole CSS esistenti o aggiungi nuove regole
3. Testa il risultato su diversi client email

## Best Practices

1. **Test Cross-Client** - Testa sempre su diversi client email (Gmail, Outlook, Apple Mail)
2. **Ottimizzazione Immagini** - Utilizza immagini ottimizzate e specifica dimensioni
3. **Design Responsivo** - Mantieni la struttura responsive per visualizzazione mobile
4. **Lunghezza Email** - Mantieni le email concise e focalizzate
5. **Accessibilità** - Assicurati che colori e contrasto siano accessibili

## Integrazione con MailPace

I layout attuali sono compatibili con l'approccio utilizzato da [mailpace/templates](https://github.com/mailpace/templates). Vedere [MAILPACE_TEMPLATES_INTEGRATION.md](./mail-templates/MAILPACE_TEMPLATES_INTEGRATION.md) per dettagli sull'integrazione.
I layout attuali sono compatibili con l'approccio utilizzato da [mailpace/templates](https://github.com/mailpace/templates). Vedere [MAILPACE_TEMPLATES_INTEGRATION.md](../../mail-templates/mailpace_templates_integration.md) per dettagli sull'integrazione.

## Riferimenti

- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Spatie Email Documentation](./SPATIE_EMAIL_USAGE_GUIDE.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility Guide](./mail-templates/HTML_EMAIL_COMPATIBILITY.md)
- [Spatie Email Documentation](../../spatie_email_usage_guide.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility Guide](../../mail-templates/html_email_compatibility.md)

---

## mail-layouts-guide-2

*Consolidated from: `mail-layouts-guide.md`*

title: "Guida ai Layout Email nel Modulo Notify"
type: guide
tags: [mail, layouts, guide]
created: 2026-07-14
updated: 2026-07-14
qmd: "mail-layouts-guide-2 guida ai layout email nel modulo notify"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Guida ai Layout Email nel Modulo Notify

## Introduzione

Questo documento descrive i layout di email disponibili nella directory `resources/mail-layouts` del modulo Notify di App. Questi layout sono progettati per essere compatibili con la maggior parte dei client email e forniscono una base solida per tutte le email transazionali dell'applicazione.

## Struttura dei Layout

Il modulo Notify contiene quattro layout email principali:

```
resources/mail-layouts/
├── default.html       # Layout base con header, content e footer
├── main.html          # Layout alternativo con design semplificato 
├── marketing.html     # Layout ottimizzato per comunicazioni marketing
└── notification.html  # Layout specifico per notifiche di sistema
```

## Caratteristiche dei Layout

### Layout Default (`default.html`)

Il layout predefinito include:
- Header con logo dell'applicazione
- Contenitore principale per il contenuto dell'email
- Footer con copyright e disclaimer
- Stili CSS inline per massima compatibilità
- Design responsive con media queries

### Layout Main (`main.html`)

Versione minimalista del layout default con:
- Design più essenziale
- Meno elementi grafici
- Ottimizzato per messaggi diretti e concisi

### Layout Marketing (`marketing.html`)

Specializzato per comunicazioni marketing:
- Supporto per immagini di intestazione di grandi dimensioni
- Sezioni per contenuti multipli
- Call-to-action ben evidenziate
- Design accattivante

### Layout Notification (`notification.html`)

Ottimizzato per notifiche di sistema:
- Design compatto
- Enfasi su messaggi di stato
- Icone per differenziare tipi di notifica
- Visualizzazione ottimizzata anche su dispositivi mobile

## Utilizzo dei Layout

I layout possono essere utilizzati in due modi principali:

### 1. Con Blade Templates

```php
// In un Mailable Laravel
public function build()
{
    return $this->view('notify::emails.welcome')
                ->subject('Benvenuto in '.config('app.name'));
}

// Nel template welcome.blade.php
@extends('notify::emails.layouts.default')

@section('content')
    <h2>Benvenuto, {{ $user->name }}!</h2>
    <p>Grazie per esserti registrato.</p>
    <a href="{{ $activationUrl }}" class="button">Attiva il tuo account</a>
@endsection
```

### 2. Con Spatie Mail Templates

```php
// Nel modello MailTemplate
use Spatie\MailTemplates\MailTemplate as SpatieMailTemplate;

class MailTemplate extends SpatieMailTemplate
{
    // ...
    
    public function getHtmlLayout(): string
    {
        // Recupera il layout in base al tipo di email
        $layout = 'default';
        if ($this->isMarketing()) {
            $layout = 'marketing';
        } elseif ($this->isNotification()) {
            $layout = 'notification';
        }
        
        return file_get_contents(module_path('Notify', "resources/mail-layouts/{$layout}.html"));
    }
}
```

## Personalizzazione

### Variabili Supportate

I layout supportano le seguenti variabili Blade:

- `$subject` - L'oggetto dell'email
- `$content` - Il contenuto principale dell'email
- `config('app.name')` - Nome dell'applicazione 
- `asset('images/logo.png')` - Percorso al logo
- `date('Y')` - Anno corrente per il copyright

### Modifica dei CSS

I CSS sono definiti inline all'interno di ciascun layout per massimizzare la compatibilità. Per modificare lo stile:

1. Individua la sezione `<style>` nel file di layout
2. Modifica le regole CSS esistenti o aggiungi nuove regole
3. Testa il risultato su diversi client email

## Best Practices

1. **Test Cross-Client** - Testa sempre su diversi client email (Gmail, Outlook, Apple Mail)
2. **Ottimizzazione Immagini** - Utilizza immagini ottimizzate e specifica dimensioni
3. **Design Responsivo** - Mantieni la struttura responsive per visualizzazione mobile
4. **Lunghezza Email** - Mantieni le email concise e focalizzate
5. **Accessibilità** - Assicurati che colori e contrasto siano accessibili

## Integrazione con MailPace

I layout attuali sono compatibili con l'approccio utilizzato da [mailpace/templates](https://github.com/mailpace/templates). Vedere [MAILPACE_TEMPLATES_INTEGRATION.md](../../mail-templates/mailpace-templates-integration.md) per dettagli sull'integrazione.

## Riferimenti

- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Spatie Email Documentation](../../spatie-email-usage-guide.md)
- [Email Best Practices](../../mail-templates/email-best-practices.md)
- [HTML Email Compatibility Guide](../../mail-templates/html-email-compatibility.md)
---

## mail-layouts-guide

*Consolidated from: `mail-layouts-guide.md`*


## Introduzione

Questo documento descrive i layout di email disponibili nella directory `resources/mail-layouts` del modulo Notify di . Questi layout sono progettati per essere compatibili con la maggior parte dei client email e forniscono una base solida per tutte le email transazionali dell'applicazione.
Questo documento descrive i layout di email disponibili nella directory `resources/mail-layouts` del modulo Notify di <nome progetto>. Questi layout sono progettati per essere compatibili con la maggior parte dei client email e forniscono una base solida per tutte le email transazionali dell'applicazione.

## Struttura dei Layout

Il modulo Notify contiene quattro layout email principali:

```
resources/mail-layouts/
├── default.html       # Layout base con header, content e footer
├── main.html          # Layout alternativo con design semplificato 
├── marketing.html     # Layout ottimizzato per comunicazioni marketing
└── notification.html  # Layout specifico per notifiche di sistema
```

## Caratteristiche dei Layout

### Layout Default (`default.html`)

Il layout predefinito include:
- Header con logo dell'applicazione
- Contenitore principale per il contenuto dell'email
- Footer con copyright e disclaimer
- Stili CSS inline per massima compatibilità
- Design responsive con media queries

### Layout Main (`main.html`)

Versione minimalista del layout default con:
- Design più essenziale
- Meno elementi grafici
- Ottimizzato per messaggi diretti e concisi

### Layout Marketing (`marketing.html`)

Specializzato per comunicazioni marketing:
- Supporto per immagini di intestazione di grandi dimensioni
- Sezioni per contenuti multipli
- Call-to-action ben evidenziate
- Design accattivante

### Layout Notification (`notification.html`)

Ottimizzato per notifiche di sistema:
- Design compatto
- Enfasi su messaggi di stato
- Icone per differenziare tipi di notifica
- Visualizzazione ottimizzata anche su dispositivi mobile

## Utilizzo dei Layout

I layout possono essere utilizzati in due modi principali:

### 1. Con Blade Templates

```php
// In un Mailable Laravel
public function build()
{
    return $this->view('notify::emails.welcome')
                ->subject('Benvenuto in '.config('app.name'));
}

// Nel template welcome.blade.php
@extends('notify::emails.layouts.default')

@section('content')
    <h2>Benvenuto, {{ $user->name }}!</h2>
    <p>Grazie per esserti registrato.</p>
    <a href="{{ $activationUrl }}" class="button">Attiva il tuo account</a>
@endsection
```

### 2. Con Spatie Mail Templates

```php
// Nel modello MailTemplate
use Spatie\MailTemplates\MailTemplate as SpatieMailTemplate;

class MailTemplate extends SpatieMailTemplate
{
    // ...
    
    public function getHtmlLayout(): string
    {
        // Recupera il layout in base al tipo di email
        $layout = 'default';
        if ($this->isMarketing()) {
            $layout = 'marketing';
        } elseif ($this->isNotification()) {
            $layout = 'notification';
        }
        
        return file_get_contents(module_path('Notify', "resources/mail-layouts/{$layout}.html"));
    }
}
```

## Personalizzazione

### Variabili Supportate

I layout supportano le seguenti variabili Blade:

- `$subject` - L'oggetto dell'email
- `$content` - Il contenuto principale dell'email
- `config('app.name')` - Nome dell'applicazione 
- `asset('images/logo.png')` - Percorso al logo
- `date('Y')` - Anno corrente per il copyright

### Modifica dei CSS

I CSS sono definiti inline all'interno di ciascun layout per massimizzare la compatibilità. Per modificare lo stile:

1. Individua la sezione `<style>` nel file di layout
2. Modifica le regole CSS esistenti o aggiungi nuove regole
3. Testa il risultato su diversi client email

## Best Practices

1. **Test Cross-Client** - Testa sempre su diversi client email (Gmail, Outlook, Apple Mail)
2. **Ottimizzazione Immagini** - Utilizza immagini ottimizzate e specifica dimensioni
3. **Design Responsivo** - Mantieni la struttura responsive per visualizzazione mobile
4. **Lunghezza Email** - Mantieni le email concise e focalizzate
5. **Accessibilità** - Assicurati che colori e contrasto siano accessibili

## Integrazione con MailPace

I layout attuali sono compatibili con l'approccio utilizzato da [mailpace/templates](https://github.com/mailpace/templates). Vedere [MAILPACE_TEMPLATES_INTEGRATION.md](./mail-templates/MAILPACE_TEMPLATES_INTEGRATION.md) per dettagli sull'integrazione.
I layout attuali sono compatibili con l'approccio utilizzato da [mailpace/templates](https://github.com/mailpace/templates). Vedere [MAILPACE_TEMPLATES_INTEGRATION.md](../../mail-templates/mailpace_templates_integration.md) per dettagli sull'integrazione.

## Riferimenti

- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Spatie Email Documentation](./SPATIE_EMAIL_USAGE_GUIDE.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility Guide](./mail-templates/HTML_EMAIL_COMPATIBILITY.md)
- [Spatie Email Documentation](../../spatie_email_usage_guide.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility Guide](../../mail-templates/html_email_compatibility.md)

---

## mail-layouts-theme-integration

*Consolidated from: `mail-layouts-theme-integration.md`*


## Overview

Il sistema email di PTVX supporta **layout personalizzati per tema**, permettendo a ogni tema di definire il proprio stile per le email mantenendo la logica email separata.

## Business Logic

### Perché Layout Per Tema?

**Scenario**: Installazioni multi-tenant con brand diversi

- Tenant A usa tema "Corporate" → Email con logo/colori aziendali
- Tenant B usa tema "Minimal" → Email minimal design
- Tenant C usa tema "DarkMode" → Email con tema scuro

**Soluzione**: Layout email personalizzato per tema invece di hardcoded.

## Architettura

### File System Structure

```

│
├─ laravel/
│  ├─ Modules/Notify/resources/mail-layouts/  ← Default fallback
│  │  ├─ base.html
│  │  ├─ base/
│  │  │  ├─ default.html
│  │  │  └─ responsive.html
│  │  └─ themes/
│  │     ├─ light.html
│  │     └─ dark.html
│  │
│  └─ Themes/                                  ← Temi applicazione
│     ├─ Zero/resources/mail-layouts/
│     │  └─ base.html                        # Layout tema Zero (Design Italiano)
│     │
│     ├─ One/resources/mail-layouts/
│     │  └─ base.html                        # Layout tema One
│     │
│     ├─ SbAdmin2Bs4/resources/mail-layouts/
│     │  └─ base.html                        # Layout SbAdmin2Bs4
│     │
│     └─ MetronicOne/resources/mail-layouts/
│        └─ base.html                        # Layout Metronic
```

### Configurazione Tema Attivo

```php
// config/{environment}/xra.php

return [
    'pub_theme' => 'Zero',  // ← Tema pubblico attivo
    // Altri config...
];
```

**Ambienti**:
- `config/local/tv/prov/personale2019/xra.php` → `pub_theme = 'Zero'`
- `config/local/tv/prov/personale2022/xra.php` → `pub_theme = 'Zero'`
- `config/localhost/xra.php` → `pub_theme = 'One'`
- Production può avere tema diverso

### Tema Zero

Il tema **Zero** implementa un layout email basato sul **Design System Italiano** ([italia/design-comuni-pagine-statiche](https://github.com/italia/design-comuni-pagine-statiche)) con:

- ✅ Colori istituzionali italiani (Blu Italia #0066CC, Verde #00AA66)
- ✅ Accessibilità WCAG 2.1 Level AA
- ✅ Responsive design ottimizzato
- ✅ Dark mode support
- ✅ TailwindCSS-inspired spacing e colori
- ✅ Integrazione completa con spatie/laravel-database-mail-templates

**Documentazione**: [Themes/Zero/docs/mail-layouts.md](../../../../themes/zero/docs/mail-layouts.md)

## Implementazione getHtmlLayout()

### Codice Corrente

```php
// Modules/Notify/app/Emails/SpatieEmail.php

public function getHtmlLayout(): string
{
    $xot = XotData::make();
    $pub_theme = $xot->pub_theme;  // Legge da config
    
    $pubThemePath = base_path('Themes/'.$pub_theme);
    $pathToLayout = $pubThemePath.'/resources/mail-layouts/base.html';
    
    return file_get_contents($pathToLayout);
}
```

### Strategia Fallback Migliorata

```php
public function getHtmlLayout(): string
{
    $xot = XotData::make();
    $pub_theme = $xot->pub_theme;
    
    // 1. Prova layout tema-specifico
    $themePath = base_path("Themes/{$pub_theme}/resources/mail-layouts/base.html");
    
    if (file_exists($themePath)) {
        return file_get_contents($themePath);
    }
    
    // 2. Fallback a layout default Notify responsive
    $responsivePath = module_path('Notify', 'resources/mail-layouts/base/responsive.html');
    
    if (file_exists($responsivePath)) {
        return file_get_contents($responsivePath);
    }
    
    // 3. Fallback a layout base semplice
    $basePath = module_path('Notify', 'resources/mail-layouts/base.html');
    
    return file_get_contents($basePath);
}
```

## Creazione Layout Custom per Tema

### Step-by-Step

#### 1. Crea Struttura Cartelle

```bash
mkdir -p Themes/MyBrandTheme/resources/mail-layouts
```

#### 2. Copia Layout Base come Template

```bash
cp laravel/Modules/Notify/resources/mail-layouts/base.html \
   Themes/MyBrandTheme/resources/mail-layouts/base.html
```

#### 3. Personalizza Layout

```html
<!-- Themes/MyBrandTheme/resources/mail-layouts/base.html -->

<!DOCTYPE html>
<html>
<head>
    <title>{{ subject }}</title>
    <style>
        /* Brand Colors */
        :root {
            --brand-primary: #0066CC;
            --brand-secondary: #00AA66;
            --brand-accent: #FF6600;
        }
        
        body {
            font-family: 'Brand Font', Arial, sans-serif;
            background-color: #F5F5F5;
        }
        
        .email-header {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            padding: 30px;
            text-align: center;
        }
        
        .email-button {
            background-color: var(--brand-accent);
            color: #FFFFFF;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <table role="presentation" width="100%">
        <tr>
            <td align="center">
                <table role="presentation" width="600">
                    <!-- Header Brand Custom -->
                    <tr>
                        <td class="email-header">
                            <img src="{{ logo_url }}" alt="Brand Logo" style="height: 60px;" />
                            <p style="color: #FFFFFF; margin: 10px 0 0 0;">{{ company_tagline }}</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px; background-color: #FFFFFF;">
                            {{{ body }}}
                        </td>
                    </tr>
                    
                    <!-- Footer Brand Custom -->
                    <tr>
                        <td style="padding: 30px; background-color: #E5E5E5; text-align: center;">
                            <div style="margin-bottom: 20px;">
                                <!-- Social Icons Custom -->
                                <a href="{{ facebook_url }}">
                                    <img src="{{ brand_facebook_icon }}" alt="Facebook" style="height: 32px; margin: 0 5px;" />
                                </a>
                                <a href="{{ linkedin_url }}">
                                    <img src="{{ brand_linkedin_icon }}" alt="LinkedIn" style="height: 32px; margin: 0 5px;" />
                                </a>
                            </div>
                            <p style="font-size: 12px; color: #666;">
                                © {{ year }} {{ company_name }} - {{ company_address }}
                            </p>
                            <p style="font-size: 11px; color: #999;">
                                <a href="{{ privacy_url }}" style="color: #999;">Privacy Policy</a> | 
                                <a href="{{ terms_url }}" style="color: #999;">Termini di Servizio</a> | 
                                <a href="{{ unsubscribe_url }}" style="color: #999;">Annulla iscrizione</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
```

#### 4. Aggiungi Variabili Custom

```php
// Themes/MyBrandTheme/app/Actions/PrepareEmailDataAction.php

class PrepareEmailDataAction
{
    public function execute(array $data): array
    {
        return array_merge($data, [
            'company_tagline' => 'Il tuo partner digitale',
            'brand_facebook_icon' => asset('themes/mybrand/images/social/facebook.png'),
            'brand_linkedin_icon' => asset('themes/mybrand/images/social/linkedin.png'),
            'privacy_url' => route('privacy'),
            'terms_url' => route('terms'),
        ]);
    }
}
```

#### 5. Test Layout

```bash
php artisan tinker
```

```php
config(['xra.pub_theme' => 'MyBrandTheme']);

$user = User::first();
$email = new SpatieEmail($user, 'test');

echo $email->getHtmlLayout();
// ✅ Dovrebbe mostrare layout custom!
```

## Logo vettoriale 2025

> **Aggiornamento 18 novembre 2025**  
> `Modules/Notify/resources/svg/logo.svg` racconta ora il *Notification Communication Hub* con tre canali (email, SMS, push) e palette coerente con il Design System Italiano.

- palette istituzionale: Blu Italia `#0066CC`, Verde `#00AA66`, accento `#00C7B1`
- supporto a dark mode (`prefers-color-scheme`) e rispetto di `prefers-reduced-motion`
- classi semantiche (`.ring`, `.channel`, `.hub`) sovrascrivibili nei temi white-label senza perdere la narrativa multi-tenant
- riutilizzabile via `logo_svg` / `logo_header` nei layout email o nei componenti web

Quando si crea un tema personalizzato duplicare l’SVG, aggiornare i colori di brand e mantenere la tripla metafora dei canali per preservare coerenza visiva fra tenant diversi.

## Pattern Multi-Tenant

### Scenario: Email Diverse Per Tenant

```php
// app/Mail/TenantAwareSpatieEmail.php

class TenantAwareSpatieEmail extends SpatieEmail
{
    public function getHtmlLayout(): string
    {
        $tenant = Filament::getTenant();  // Tenant corrente
        
        // Layout specifico tenant
        $tenantPath = storage_path("tenants/{$tenant->id}/mail-layouts/base.html");
        
        if (file_exists($tenantPath)) {
            return file_get_contents($tenantPath);
        }
        
        // Fallback a layout tema
        return parent::getHtmlLayout();
    }
}
```

**Business Case**: SaaS con white-label, ogni cliente ha email branded.

## Gestione Layout da Admin Panel

### Feature Request: Layout Manager

```php
// Modules/Notify/app/Filament/Resources/EmailLayoutResource.php

class EmailLayoutResource extends XotBaseResource
{
    protected static ?string $model = EmailLayout::class;
    
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name'),
            'theme' => Select::make('theme')
                ->options([
                    'Zero' => 'SbAdmin2',
                    'One' => 'Tema One',
                    'MetronicOne' => 'Metronic',
                ]),
            'html_content' => MonacoEditor::make('html_content')
                ->language('html')
                ->height('500px'),
        ];
    }
}
```

**Vantaggio**: Modifica layout email da admin panel senza accesso filesystem.

## Collegamenti

### Documentazione Interna
- [Spatie Database Mail Templates Deep Dive](./spatie-database-mail-templates-deep-dive.md)
- [Mail Layouts README](../resources/mail-layouts/readme.md)
- [SpatieEmail Class](../app/Emails/SpatieEmail.php)

### Esempi Layout
- [Base Layout](../resources/mail-layouts/base.html)
- [Default Layout](../resources/mail-layouts/base/default.html)
- [Responsive Layout](../resources/mail-layouts/base/responsive.html)
- [Spatie Database Mail Templates Deep Dive](../../spatie-database-mail-templates-deep-dive.md)
- [Mail Layouts README](../../../resources/mail-layouts/README.md)
- [SpatieEmail Class](../../../app/Emails/SpatieEmail.php)

### Esempi Layout
- [Base Layout](../../../resources/mail-layouts/base.html)
- [Default Layout](../../../resources/mail-layouts/base/default.html)
- [Responsive Layout](../../../resources/mail-layouts/base/responsive.html)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Pattern**: Layout per tema con fallback chain  
**Status**: ✅ IMPLEMENTATO


---

## mail-layouts

*Consolidated from: `mail-layouts.md`*


## Introduzione
Il modulo Notify utilizza il pacchetto `spatie/laravel-database-mail-templates` per gestire i template delle email. I layout sono file HTML che forniscono una struttura comune per tutte le email inviate dall'applicazione.

## Struttura dei Layout
I layout delle email sono memorizzati nella directory `resources/mail-layouts/` del modulo Notify. Il layout principale è `main.html`.

### Layout Principale (main.html)
Il layout principale include:
- Header con logo
- Contenitore per il contenuto dinamico
- Footer con copyright e disclaimer

## Variabili Disponibili
Nel layout sono disponibili le seguenti variabili:
- `{{{ body }}}`: Il contenuto specifico dell'email
- `{{logo_url}}`: URL del logo
- `{{year}}`: Anno corrente
- `{{app_name}}`: Nome dell'applicazione

## Personalizzazione
Per personalizzare il layout:
1. Modificare il file `main.html` nella directory `resources/mail-layouts/`
2. Aggiungere nuovi stili CSS inline
3. Aggiungere nuove sezioni o componenti

## Utilizzo con MailTemplate
Per utilizzare il layout con un MailTemplate:

```php
use Spatie\MailTemplates\TemplateMailable;

class WelcomeMail extends TemplateMailable
{
    public function getHtmlLayout(): string
    {
        return file_get_contents(
            module_path('Notify', 'resources/mail-layouts/main.html')
        );
    }
}
```

## Best Practices
1. Utilizzare CSS inline per massima compatibilità
2. Testare il layout con diversi client email
3. Mantenere il design responsive
4. Utilizzare colori e font coerenti con il brand

## Screenshot
![Layout Email](../resources/screenshots/mail-layout.png)

## Note
- Il layout è ottimizzato per la visualizzazione su dispositivi mobili
- Supporta la maggior parte dei client email moderni
- Include reset CSS per uniformità tra client 
---

## mail_layouts

*Consolidated from: `mail_layouts.md`*


## Introduzione
Il modulo Notify utilizza il pacchetto `spatie/laravel-database-mail-templates` per gestire i template delle email. I layout sono file HTML che forniscono una struttura comune per tutte le email inviate dall'applicazione.

## Struttura dei Layout
I layout delle email sono memorizzati nella directory `resources/mail-layouts/` del modulo Notify. Il layout principale è `main.html`.

### Layout Principale (main.html)
Il layout principale include:
- Header con logo
- Contenitore per il contenuto dinamico
- Footer con copyright e disclaimer

## Variabili Disponibili
Nel layout sono disponibili le seguenti variabili:
- `{{{ body }}}`: Il contenuto specifico dell'email
- `{{logo_url}}`: URL del logo
- `{{year}}`: Anno corrente
- `{{app_name}}`: Nome dell'applicazione

## Personalizzazione
Per personalizzare il layout:
1. Modificare il file `main.html` nella directory `resources/mail-layouts/`
2. Aggiungere nuovi stili CSS inline
3. Aggiungere nuove sezioni o componenti

## Utilizzo con MailTemplate
Per utilizzare il layout con un MailTemplate:

```php
use Spatie\MailTemplates\TemplateMailable;

class WelcomeMail extends TemplateMailable
{
    public function getHtmlLayout(): string
    {
        return file_get_contents(
            module_path('Notify', 'resources/mail-layouts/main.html')
        );
    }
}
```

## Best Practices
1. Utilizzare CSS inline per massima compatibilità
2. Testare il layout con diversi client email
3. Mantenere il design responsive
4. Utilizzare colori e font coerenti con il brand

## Screenshot
![Layout Email](../resources/screenshots/mail-layout.png)

## Note
- Il layout è ottimizzato per la visualizzazione su dispositivi mobili
- Supporta la maggior parte dei client email moderni
- Include reset CSS per uniformità tra client 
---

## mail_layouts_guide

*Consolidated from: `mail_layouts_guide.md`*


## Introduzione

Questo documento descrive i layout di email disponibili nella directory `resources/mail-layouts` del modulo Notify di <nome progetto>. Questi layout sono progettati per essere compatibili con la maggior parte dei client email e forniscono una base solida per tutte le email transazionali dell'applicazione.

## Struttura dei Layout

Il modulo Notify contiene quattro layout email principali:

```
resources/mail-layouts/
├── default.html       # Layout base con header, content e footer
├── main.html          # Layout alternativo con design semplificato├── marketing.html     # Layout ottimizzato per comunicazioni marketing
└── notification.html  # Layout specifico per notifiche di sistema
```

## Caratteristiche dei Layout

### Layout Default (`default.html`)

Il layout predefinito include:
- Header con logo dell'applicazione
- Contenitore principale per il contenuto dell'email
- Footer con copyright e disclaimer
- Stili CSS inline per massima compatibilità
- Design responsive con media queries

### Layout Main (`main.html`)

Versione minimalista del layout default con:
- Design più essenziale
- Meno elementi grafici
- Ottimizzato per messaggi diretti e concisi

### Layout Marketing (`marketing.html`)

Specializzato per comunicazioni marketing:
- Supporto per immagini di intestazione di grandi dimensioni
- Sezioni per contenuti multipli
- Call-to-action ben evidenziate
- Design accattivante

### Layout Notification (`notification.html`)

Ottimizzato per notifiche di sistema:
- Design compatto
- Enfasi su messaggi di stato
- Icone per differenziare tipi di notifica
- Visualizzazione ottimizzata anche su dispositivi mobile

## Utilizzo dei Layout

I layout possono essere utilizzati in due modi principali:

### 1. Con Blade Templates

```php
// In un Mailable Laravel
public function build()
{
    return $this->view('notify::emails.welcome')
                ->subject('Benvenuto in '.config('app.name'));
}

// Nel template welcome.blade.php
@extends('notify::emails.layouts.default')

@section('content')
    <h2>Benvenuto, {{ $user->name }}!</h2>
    <p>Grazie per esserti registrato.</p>
    <a href="{{ $activationUrl }}" class="button">Attiva il tuo account</a>
@endsection
```

### 2. Con Spatie Mail Templates

```php
// Nel modello MailTemplate
use Spatie\MailTemplates\MailTemplate as SpatieMailTemplate;

class MailTemplate extends SpatieMailTemplate
{
    // ...
    public function getHtmlLayout(): string
    {
        // Recupera il layout in base al tipo di email
        $layout = 'default';
        if ($this->isMarketing()) {
            $layout = 'marketing';
        } elseif ($this->isNotification()) {
            $layout = 'notification';
        }
        return file_get_contents(module_path('Notify', "resources/mail-layouts/{$layout}.html"));
    }
}
```

## Personalizzazione

### Variabili Supportate

I layout supportano le seguenti variabili Blade:

- `$subject` - L'oggetto dell'email
- `$content` - Il contenuto principale dell'email
- `config('app.name')` - Nome dell'applicazione- `asset('images/logo.png')` - Percorso al logo
- `date('Y')` - Anno corrente per il copyright

### Modifica dei CSS

I CSS sono definiti inline all'interno di ciascun layout per massimizzare la compatibilità. Per modificare lo stile:

1. Individua la sezione `<style>` nel file di layout
2. Modifica le regole CSS esistenti o aggiungi nuove regole
3. Testa il risultato su diversi client email

## Best Practices

1. **Test Cross-Client** - Testa sempre su diversi client email (Gmail, Outlook, Apple Mail)
2. **Ottimizzazione Immagini** - Utilizza immagini ottimizzate e specifica dimensioni
3. **Design Responsivo** - Mantieni la struttura responsive per visualizzazione mobile
4. **Lunghezza Email** - Mantieni le email concise e focalizzate
5. **Accessibilità** - Assicurati che colori e contrasto siano accessibili

## Integrazione con MailPace

I layout attuali sono compatibili con l'approccio utilizzato da [mailpace/templates](https://github.com/mailpace/templates). Vedere [MAILPACE_TEMPLATES_INTEGRATION.md](./mail-templates/MAILPACE_TEMPLATES_INTEGRATION.md) per dettagli sull'integrazione.
I layout attuali sono compatibili con l'approccio utilizzato da [mailpace/templates](https://github.com/mailpace/templates). Vedere [MAILPACE_TEMPLATES_INTEGRATION.md](../../mail-templates/mailpace_templates_integration.md) per dettagli sull'integrazione.

## Riferimenti

- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Spatie Email Documentation](./SPATIE_EMAIL_USAGE_GUIDE.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility Guide](./mail-templates/HTML_EMAIL_COMPATIBILITY.md)
- [Spatie Email Documentation](../../spatie_email_usage_guide.md)
- [Email Best Practices](./mail-templates/EMAIL_BEST_PRACTICES.md)
- [HTML Email Compatibility Guide](../../mail-templates/html_email_compatibility.md)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
