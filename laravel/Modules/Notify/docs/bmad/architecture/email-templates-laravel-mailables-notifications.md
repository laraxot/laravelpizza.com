---
title: "Approfondimento: Mailables & Notifications Laravel"
type: concept
tags: [email, templates, laravel, mailables]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-templates-laravel-mailables-notifications-1 approfondimento: mailables & notifications laravel"
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
superseded_by: ../../email-templates-laravel-mailables-notifications.md
---

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
