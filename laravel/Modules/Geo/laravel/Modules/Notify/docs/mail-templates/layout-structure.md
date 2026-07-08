# Struttura Layout Email

## 1. Separazione dei File

### 1.1 Layout HTML
I file in `/resources/mail-layouts` devono essere SOLO file HTML statici (`.html`). Questi file:
- NON devono contenere logica Blade
- NON devono avere estensione `.blade.php`
- Devono usare il placeholder `{{{ body }}}` per il contenuto
- Sono file di layout base per tutte le email

### 1.2 Template Blade
I template Blade (`.blade.php`) devono essere in:
- `/resources/views/mail/`: Per le viste email standard
- `/database/mail-templates/`: Per i template del database

## 2. Struttura Directory Corretta
```
resources/
├── mail-layouts/           # SOLO file .html
│   ├── base/
│   │   └── default.html    # Layout base
│   └── themes/
│       ├── light.html      # Tema chiaro
│       └── dark.html       # Tema scuro
└── views/
    └── mail/              # File .blade.php
        ├── welcome.blade.php
        └── order.blade.php

database/
└── mail-templates/        # Template per il database
    ├── welcome.json
    └── order.json
```

## 3. Layout HTML Base
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>{{ $subject }}</title>
</head>
<body>
    <table role="presentation">
        <tr>
            <td>
                {{{ body }}}
            </td>
        </tr>
    </table>
</body>
</html>
```

## 4. Template Database
I contenuti dinamici devono essere definiti nel campo `html_template` della tabella `mail_templates`:

```php
MailTemplate::create([
    'mailable' => WelcomeMail::class,
    'subject' => 'Welcome, {{ name }}',
    'html_template' => '<h1>Hello, {{ name }}!</h1>',
    'text_template' => 'Hello, {{ name }}!',
]);
```

## 5. Integrazione con Spatie Mail Templates

### 5.1 Layout
```php
class WelcomeMail extends TemplateMailable
{
    public function getHtmlLayout(): string
    {
        return file_get_contents(resource_path('mail-layouts/base/default.html'));
    }
}
```

### 5.2 Template
```php
// Nel database
{
    "mailable": "App\\Mail\\WelcomeMail",
    "subject": "Welcome, {{ name }}",
    "html_template": "<h1>Hello, {{ name }}!</h1>",
    "text_template": "Hello, {{ name }}!"
}
```

## 6. Best Practices

### 6.1 Layout HTML
- Mantenere i layout HTML semplici e statici
- Usare il placeholder `{{{ body }}}` per il contenuto
- Evitare logica dinamica nei layout
- Includere solo stili base e struttura
- NON usare estensioni `.blade.php`

### 6.2 Template
- Definire tutto il contenuto dinamico nel database
- Usare le variabili del mailable nel template
- Mantenere la compatibilità con i client email
- Testare su vari dispositivi

## 7. Note Importanti

1. **Separazione**: Mantenere sempre separati i layout HTML dai template Blade
2. **Estensioni**: Usare `.html` per i layout, `.blade.php` per i template
3. **Posizione**: Rispettare la struttura delle directory
4. **Compatibilità**: Assicurarsi che i layout siano compatibili con i client email
5. **Manutenibilità**: Mantenere i layout semplici e riutilizzabili

## 8. Esempi

### 8.1 Layout Base
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>{{ $subject }}</title>
</head>
<body>
    <table role="presentation" width="100%">
        <tr>
            <td align="center">
                <table role="presentation" width="600">
                    <tr>
                        <td>
                            {{{ body }}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
```

### 8.2 Template Database
```php
{
    "mailable": "App\\Mail\\OrderConfirmation",
    "subject": "Order #{{ order_id }} Confirmed",
    "html_template": "
        <h1>Order Confirmed</h1>
        <p>Thank you for your order #{{ order_id }}</p>
        <table>
            <tr>
                <td>Total:</td>
                <td>{{ total }}</td>
            </tr>
        </table>
    ",
    "text_template": "Order #{{ order_id }} confirmed. Total: {{ total }}"
}
``` 
