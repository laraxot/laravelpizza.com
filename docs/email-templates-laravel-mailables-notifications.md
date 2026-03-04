# Approfondimento: Mailables & Notifications Laravel

## Funzionalità principali
- Componenti `<x-mail::message>`, `<x-mail::layout>`, `<x-mail::button>` per email responsive
- Supporto markdown, theming, localizzazione
- Mailables per email, Notifications per canali multipli
- Possibilità di override template vendor (`php artisan vendor:publish --tag=laravel-mail`)
- Chaining metodi (`->line()`, `->action()`, `->view()`, `->markdown()`)

## Vantaggi
- Standard Laravel, documentazione ampia
- Facile override di layout, header, footer
- Supporto nativo a markdown e Blade
- Theming via `config/mail.php` e cartelle dedicate

## Svantaggi
- Customizzazione profonda richiede conoscenza Blade
- Aggiornamenti framework possono sovrascrivere template vendor
- Complessità per override avanzato

## Pattern utili per <nome progetto>
- Usare componenti nativi `<x-mail::...>` per compatibilità
- Separare layout, header, footer, body
- Theming via cartelle e config
- Override template solo in `resources/views/vendor/mail`

## Esempio di utilizzo
```php
return (new MailMessage)
    ->subject('Welcome')
    ->markdown('mail.welcome', ['user' => $user]);
```

## Raccomandazioni
- Usare sempre componenti nativi per coerenza
- Documentare override e fallback
