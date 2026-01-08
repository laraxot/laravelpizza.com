# Integrazione con Spatie Laravel Database Mail Templates

Questa guida documenta l'uso del pacchetto [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates) all'interno del modulo **Notify**.

## Installazione
```bash
composer require spatie/laravel-database-mail-templates
php artisan vendor:publish --provider="Spatie\MailTemplates\MailTemplatesServiceProvider"
```

## Configurazione
Il pacchetto utilizza la tabella `mail_templates` per memorizzare i template. Il modello di base è `Spatie\MailTemplates\Models\MailTemplate`.

## Uso di `SpatieEmail`
La classe `SpatieEmail` estende `TemplateMailable` e carica i dati:
```php
public function __construct(Model $record)
{
    $this->setAdditionalData($record->toArray());
}
```

### Layout HTML
Il metodo `getHtmlLayout(): string` deve restituire il markup del layout:
- I file HTML con il layout devono essere posizionati in:
  `Modules/Notify/resources/mail-layouts/`
- Il placeholder `{{{ body }}}` indica dove inserire il contenuto del template.

```php
public function getHtmlLayout(): string
{
    return file_get_contents(base_path('Modules/Notify/resources/mail-layouts/main.html'));
}
```

## Creazione di nuovi layout
Nella cartella `resources/mail-layouts/` creare file HTML, ad esempio `main.html`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Template</title>
  <style>
    /* Inserisci qui gli stili CSS inline */
  </style>
</head>
<body>
  <header style="background:#f5f5f5;padding:20px;text-align:center;">
    <h1>Il Tuo Sito</h1>
  </header>

  {{{ body }}}

  <footer style="background:#f5f5f5;padding:20px;text-align:center;font-size:12px;">
    &copy; {{ date('Y') }} Il Tuo Sito. Tutti i diritti riservati.
  </footer>
</body>
</html>
```

> ![Anteprima Layout Email](mail-layouts/main-preview.png)

