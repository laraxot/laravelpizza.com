# Approfondimento: spatie/laravel-database-mail-templates

**Repository:** https://github.com/spatie/laravel-database-mail-templates

## Funzionalità principali
- Gestione template email da database (CRUD)
- Versioning, override runtime
- Supporto mustache tag per variabili dinamiche
- TemplateMailable: tutte le proprietà pubbliche disponibili nel template
- Seeder per template base

## Vantaggi
- Override e personalizzazione senza deploy
- Ideale per multi-tenant e SaaS
- Fallback su file statici
- Possibilità di layout HTML custom

## Svantaggi
- Richiede migrazioni e gestione DB
- Più complesso da integrare rispetto a soluzioni file-based
- Potenziale overhead performance

## Pattern utili per <nome progetto>
- CRUD template da backend Filament
- Fallback automatico su file statici se DB non disponibile
- Versioning e audit dei template

## Esempio di utilizzo
```php
MailTemplate::create([
    'mailable' => \App\Mail\WelcomeMail::class,
    'subject' => 'Welcome, {{ name }}',
    'html_template' => '<h1>Hello, {{ name }}!</h1>',
    'text_template' => 'Hello, {{ name }}!',
]);
Mail::to($user->email)->send(new WelcomeMail($user));
```

## Raccomandazioni
- Consigliato per <nome progetto> come base per CRUD template
- Integrare UI Filament per gestione template
