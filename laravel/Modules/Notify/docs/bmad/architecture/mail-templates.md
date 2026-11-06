---
title: "Mail Templates in Notify Module"
type: concept
tags: [mail, templates]
created: 2026-07-14
updated: 2026-07-14
qmd: "mail-templates-1 mail templates in notify module"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: superseded
superseded_by: ../../mail-templates.md
---

# Mail Templates in Notify Module

## Panoramica
Il modulo Notify utilizza `spatie/laravel-database-mail-templates` per gestire i template delle email nel database. Questo permette di:
- Memorizzare i template nel database
- Utilizzare layout HTML personalizzati
- Supportare variabili nei template
- Gestire versioni multiple dei template

## Struttura Directory
```
Modules/Notify/
├── resources/
│   ├── mail-layouts/           # Layout HTML per le email
│   │   ├── default.html       # Layout predefinito
│   │   ├── marketing.html     # Layout per email marketing
│   │   └── notification.html  # Layout per notifiche
│   └── views/
│       └── mails/             # View Blade per le email
```

## Layout HTML
I layout HTML sono memorizzati in `resources/mail-layouts/` e definiscono la struttura base delle email. Ogni layout deve:
- Contenere un placeholder `{{{ $content }}}` per il contenuto
- Essere un file HTML valido
- Supportare responsive design
- Seguire le best practices per email HTML

### Layout Predefinito (default.html)
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Stili CSS inline per compatibilità client email */
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
        .header {
            background: #1a56db;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background: #ffffff;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50">
        </div>
        <div class="content">
            {{{ $content }}}
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Tutti i diritti riservati.
        </div>
    </div>
</body>
</html>
```

### Layout Marketing (marketing.html)
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Stili per email marketing */
        /* ... */
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Header marketing con CTA -->
        </div>
        <div class="content">
            {{{ $content }}}
        </div>
        <div class="footer">
            <!-- Footer con social links e unsubscribe -->
        </div>
    </div>
</body>
</html>
```

## Utilizzo nel Codice

### Configurazione Layout
```php
use Spatie\MailTemplates\Models\MailTemplate;

class AppointmentConfirmation extends MailTemplate
{
    public function getHtmlLayout(): string
    {
        return file_get_contents(
            module_path('Notify', 'resources/mail-layouts/default.html')
        );
    }
}
```

### Variabili Disponibili
- `$subject`: Oggetto dell'email
- `$content`: Contenuto dell'email
- `$user`: Utente destinatario (se disponibile)
- `$tenant`: Tenant corrente (se disponibile)

## Best Practices
1. **Layout**:
   - Usare CSS inline per massima compatibilità
   - Testare su diversi client email
   - Mantenere il design responsive
   - Ottimizzare le immagini

2. **Contenuto**:
   - Usare variabili per contenuto dinamico
   - Evitare JavaScript (non supportato)
   - Limitare l'uso di CSS avanzato
   - Testare con dati reali

3. **Manutenzione**:
   - Documentare le variabili disponibili
   - Mantenere i layout aggiornati
   - Testare regolarmente
   - Seguire le best practices email

## Screenshot
![Mail Layout Preview](../resources/images/mail-layout-preview.png)

## Note Importanti
- I layout devono essere HTML valido
- Il placeholder `{{{ $content }}}` è obbligatorio
- Testare su diversi client email
- Mantenere la documentazione aggiornata 