# Deep Dive: Soluzioni di Template Email in Laravel

Un'analisi dettagliata delle risorse, pacchetti, editor e tecniche per gestire i template email in Laravel.

---
## 1. Core Laravel Mail System

### 1.1 Blade Templates
- **Architettura**: un `Mailable` chiama `$this->view('notify::emails.name')` per caricare una view Blade.
- **Personalizzazione**: utilizzare `php artisan vendor:publish --tag=laravel-mail` per pubblicare gli stub e modificarli.

```php
class NotifyMail extends Mailable
{
    public function build()
    {
        return $this->from('noreply@<nome progetto>.it')
                    ->subject(__('notify::mail.subject'))
                    ->view('notify::emails.template', ['data' => $this->data]);
    }
}
```

### 1.2 Markdown Mailables
- Active via `$this->markdown('notify::emails.markdown')`. Genera HTML responsive con Tailwind CSS.
- **Vantaggi**: struttura semplice, supporto per componenti (`@component('mail::button')`).
- **Svantaggi**: limitazioni di stile inline.

```php
public function build()
{
    return $this->markdown('notify::emails.markdown', ['data' => $this->data]);
}
```

---
## 2. Pacchetti GitHub

### 2.1 simplepleb/laravel-email-templates
Link: https://github.com/simplepleb/laravel-email-templates
- **Struttura**: view in `resources/views/vendor/mail/templates`
- **Provider**: registra un `ViewFinder` custom per caricare file `.blade.php`
- **Use-case**: facili override via filesystem

### 2.2 spatie/laravel-database-mail-templates
Link: https://github.com/spatie/laravel-database-mail-templates
- **Database**: tabella `mail_templates` con campi `key`, `subject`, `html`, `locale`
- **ServiceProvider**: pubblica migrazioni e configura il renderer
- **Filament**: si integra con un `Filamentesources	emplateResource`

```php
$template = Template::where('key', 'welcome')->first();
$mail = new Mailable;
$mail->html($template->html);
```

### 2.3 mlanin/laravel-email-templates-optimization
Link: https://github.com/mlanin/laravel-email-templates-optimization
- **Focus**: caching e minificazione delle email
- **Strategia**: `CssInliner` e compressione HTML
- **Limitazioni**: configurazione manuale di folder e cache driver

### 2.4 Qoraiche/laravel-mail-editor
Link: https://github.com/Qoraiche/laravel-mail-editor
- **Editor WYSIWYG**: usa GrapesJS in Filament
- **Anteprima live**: avvia un iframe con il template
- **Blocchi**: drag-and-drop di componenti email

### 2.5 Filament Visual Builder Email Templates
Link: https://filamentphp.com/plugins/visual-builder-email-templates
- **Plugin ufficiale**: integrazione diretta con Filament
- **Builder**: componenti Blade riutilizzabili e configurabili
- **Svante**: dipendente da Filament core e licenza plugin

---
## 3. Editor e Servizi Esterni

| Strumento  | Scopo                                   | Pro                              | Contro                       |
| ---------- | --------------------------------------- | -------------------------------- | ---------------------------- |
| Stripo     | Drag & drop HTML                        | molti template, preview          | piano a pagamento            |
| Beefree    | Editor email WYSIWYG                    | gratuito, integrazione API       | limite feature free          |
| Unlayer    | Builder integrabile                     | API flessibile                   | documentazione frammentaria  |
| Mailersend | SMTP + gestione template               | analytics, A/B testing           | costo                        |
| Mailjet    | SMTP + template manager                | UI ricca                         | lock-in 
| Mailtrap   | sandbox test email                     | zero invii reali, easy setup     | non per produzione          |

---
## 4. Template Engine & CSS Inlining

- **MJML** (https://mjml.io)
  - Traduce tag MJML in HTML email responsive
  - Integrare con `npm install mjml`
  - Comando: `mjml resources/mjml/template.mjml -o public/mjml.html`
- **CSS To Inline Styles**
  - Package: `tijsverkoyen/css-to-inline-styles`
  - Inline CSS in fase di build, migliora compatibilità client

---
## 5. Tutorial e Articoli Selezionati

- **StackOverflow**: come creare nuovi componenti email (63791532)
- **Medium / LaravelDaily / Laracasts**: best practice per template personalizzati e responsive
- **CleanCommit**: guida a Mailable classes e versioning
- **Dev.to / Mailtrap Blog**: esempi pratici di invio HTML e configurazione SMTP

Ogni risorsa include snippet di codice, guida alla configurazione `.env` e note sui client email supportati.

---
## 6. Integrazione via Queueable Actions
Tutte le operazioni asincrone (invio email, anteprima, azioni Filament) utilizzano il package [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action) anziché ServiceProvider.
Vedi [Queueable Actions con Spatie](queueable-actions.md) per definizione delle azioni, dispatch sincrono/asincrono e testing.

---
*Documento generato il 2025-05-05T21:45:20+02:00*
