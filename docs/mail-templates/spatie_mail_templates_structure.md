# Spatie Mail Templates: Struttura Corretta

Questa documentazione spiega la struttura corretta dell'implementazione di `spatie/laravel-database-mail-templates` nel modulo Notify.

## Indice

- [Panoramica dell'Architettura](#panoramica-dellarchitettura)
- [Struttura delle Directory](#struttura-delle-directory)
- [Layout Base vs Contenuto dei Template](#layout-base-vs-contenuto-dei-template)
- [Implementazione Corretta](#implementazione-corretta)
- [Errori Comuni da Evitare](#errori-comuni-da-evitare)
- [Riferimenti](#riferimenti)

## Panoramica dell'Architettura

Il sistema di email  utilizza `spatie/laravel-database-mail-templates` per separare il layout HTML di base dal contenuto dei template, consentendo:

1. **Separazione dei Concetti**: Layout HTML di base vs contenuto specifico
2. **Modifica tramite Database**: I contenuti dei template sono memorizzati nel database e possono essere modificati senza cambiare il codice
3. **Versionamento**: Supporto per diverse versioni dei template
4. **Traduzioni**: Supporto multilingua per i template

## Struttura delle Directory

```
/Modules/Notify/
├── resources/
│   ├── mail-layouts/        # Layout HTML di base (non contengono contenuto specifico)
│   │   ├── README.md        # Documentazione per i layout
│   │   ├── base/            # Layout base
│   │   │   ├── default.html # Layout minimo
│   │   │   └── responsive.html # Layout responsive
│   │   └── themes/          # Varianti di temi
│   │       ├── light.html   # Tema chiaro
│   │       └── dark.html    # Tema scuro
│   └── views/
│       └── emails/          # Template Blade standard (non correlati a spatie/mail-templates)
└── app/
    ├── Mail/                # Classi Mailable
    │   ├── WelcomeMail.php  # Estende TemplateMailable
    │   └── ...
    └── Models/
        └── MailTemplate.php # Estende SpatieMailTemplate
```

## Layout Base vs Contenuto dei Template

### Layout Base (`resources/mail-layouts/`)

I file nella directory `mail-layouts/` sono **esclusivamente layout HTML di base** che forniscono la struttura del documento email. Questi file:

- Contengono **solo il layout HTML strutturale** (DOCTYPE, head, body, tabelle di base)
- Includono un placeholder `{{{ body }}}` dove verrà inserito il contenuto dinamico
- Non contengono contenuto specifico di un particolare tipo di messaggio
- Non includono testo reale, solo struttura HTML

Esempio di layout base corretto (`base/default.html`):

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
</head>
<body>
    <table>
        <tr>
            <td>
                {{{ body }}}
            </td>
        </tr>
    </table>
</body>
</html>
```

### Contenuto del Template (nel Database)

Il contenuto specifico di ogni template viene memorizzato nel database nella tabella `mail_templates`:

- La colonna `html_template` contiene il **contenuto HTML specifico** che verrà inserito nel placeholder `{{{ body }}}`
- La colonna `subject` contiene l'oggetto dell'email
- La colonna `text_template` può contenere una versione di testo semplice

Esempio di contenuto HTML per un template di benvenuto (memorizzato nel database):

```html
<h1>Benvenuto in {{ $app_name }}, {{ $name }}!</h1>
<p>Grazie per esserti registrato.</p>
<p>Clicca sul link qui sotto per verificare il tuo account:</p>
<p><a href="{{ $action_url }}">Verifica Email</a></p>
```

## Implementazione Corretta

### 1. Definire un Layout Base

Creare un layout HTML di base in `resources/mail-layouts/base/`:

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $subject }}</title>
</head>
<body>
    {{{ body }}}
</body>
</html>
```

### 2. Creare una Classe Mailable

```php
<?php

namespace Modules\Notify\Mail;

use Spatie\MailTemplates\TemplateMailable;

class WelcomeMail extends TemplateMailable
{
    public $name;
    public $app_name;
    public $action_url;

    public function __construct($name, $action_url)
    {
        $this->name = $name;
        $this->app_name = config('app.name');
        $this->action_url = $action_url;
    }

    public function getHtmlLayout(): string
    {
        return file_get_contents(module_path('Notify', 'resources/mail-layouts/base/responsive.html'));
    }
}
```

### 3. Inserire il Contenuto del Template nel Database

```php
use Modules\Notify\Models\MailTemplate;

MailTemplate::create([
    'mailable' => WelcomeMail::class,
    'subject' => 'Benvenuto ',
    'html_template' => '<h1>Benvenuto in {{ $app_name }}, {{ $name }}!</h1>
                        <p>Grazie per esserti registrato.</p>
                        <p>Clicca sul link qui sotto per verificare il tuo account:</p>
                        <p><a href="{{ $action_url }}">Verifica Email</a></p>',
]);
```

### 4. Inviare l'Email

```php
use Modules\Notify\Mail\WelcomeMail;

Mail::to($user->email)->send(new WelcomeMail($user->name, $verificationUrl));
```

## Errori Comuni da Evitare

1. **NON creare template completi in `resources/mail-layouts/`**: Questa directory contiene solo layout di base, non template completi.

2. **NON includere contenuto specifico nei layout**: I layout devono contenere solo struttura HTML, non contenuto specifico.

3. **NON creare file `.blade.php` in `resources/mail-layouts/`**: Questa directory deve contenere solo file HTML puri con il placeholder `{{{ body }}}`.

4. **NON dimenticare di includere `{{{ body }}}`**: Questo placeholder è essenziale per il funzionamento dei template.

5. **NON confondere i layout con i template**: I layout sono la struttura, i template sono il contenuto.

## Riferimenti

- [Documentazione ufficiale spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates)
- [Laravel Mail](https://laravel.com/docs/10.x/mail)
- [Spatie Translatable](https://github.com/spatie/laravel-translatable)
