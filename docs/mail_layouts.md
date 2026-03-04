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