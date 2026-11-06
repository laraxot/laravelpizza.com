---
qmd: "database consolidated"
issues: []
discussions: []
title: "database: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# database: Consolidated Documentation

Consolidated from **15** individual files.

## Table of Contents

- [Deprecated](#database-mail-1)
- [---](#database-mail-2)
- [---](#database-mail-enhancement-1)
- [Database Mail Enhancement (Open Source)](#database-mail-enhancement)
- [Deprecated](#database-mail-queue-1)
- [---](#database-mail-queue-2)
- [Sistema di Code per Email - il progetto](#database-mail-queue)
- [Sistema di Gestione Email Basato su Database - il progetto](#database-mail-system-1)
- [---](#database-mail-system-2)
- [Sistema di Gestione Email Basato su Database - il progetto](#database-mail-system)
- [Database Mail System](#database-mail)
- [Database Mail System](#database_mail)
- [Database Mail Enhancement (Open Source)](#database_mail_enhancement)
- [Sistema di Code per Email - il progetto](#database_mail_queue)
- [Sistema di Gestione Email Basato su Database - il progetto](#database_mail_system)

---

## database-mail-1

*Consolidated from: `database-mail.md`*
*Consolidated from: `database-mail-deprecated.md`*


This file is deprecated.

Use:

- [database-mail](./database-mail.md)
- [database-mail](../../database-mail.md)

---

## database-mail-2

*Consolidated from: `database-mail.md`*

title: "Database Mail System"
type: concept
tags: [database, mail]
created: 2026-07-14
updated: 2026-07-14
qmd: "database-mail-2 database mail system"
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

# Database Mail System

## Regola sulle rotte

Il file `routes/web.php` del modulo Notify **deve rimanere vuoto**.
- Tutta la gestione backoffice avviene tramite Filament, che registra le proprie rotte internamente.
- Il frontoffice è gestito tramite Volt/Folio, che ha i propri controller/rotte.
- **Non vanno mai aggiunte rotte custom in questo file**: aggiungerle è un errore grave che rompe la separazione tra backoffice e frontoffice.

**Vedi anche:**
- [structure.md](structure.md#regola-sulle-rotte)
- [grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)
- [grapesjs-filament.md](../../grapesjs-filament.md#regola-sulle-rotte)

---

## Collegamenti correlati
- [Regola sulle rotte vuote in structure.md](structure.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in grapesjs-filament.md](../../grapesjs-filament.md#regola-sulle-rotte)

## Panoramica

Un sistema di gestione email basato su database che permette di:
- Memorizzare i template delle email nel database
- Gestire i template tramite interfaccia Filament
- Associare i template a eventi Laravel
- Supportare traduzioni multiple
- Utilizzare un editor WYSIWYG per la creazione dei template
- Gestire variabili dinamiche nei template
- Tracciare lo stato di invio delle email
- Personalizzare layout, branding e allegati
- Gestire log invii, errori e retry

---

## Analisi comparativa plugin & pacchetti

### Plugin/Packages studiati:
- **hugomyb/filament-error-mailer**: invio notifiche errori via mail, log errori, configurazione base.
- **vormkracht10/filament-mails**: gestione e preview email inviate, log, visualizzazione stato, nessun editor template.
- **visualbuilder/email-templates**: editor WYSIWYG per template email integrato in Filament, supporto variabili e preview, multi-lingua, open source.
- **martin-petricko/database-mail**: gestione template email da Filament, associazione eventi, preview, a pagamento.
- **spatie/laravel-database-mail-templates**: rendering mailables da template in DB, variabili, localizzazione, estendibile, no UI.
- **spatie/laravel-mailcoach-mailer**: driver per invio massivo/newsletter, log avanzato, gestione code.
- **soluzioni custom**: guide su logo, branding, allegati, log, fallback blade.

### Limiti delle soluzioni esistenti
- Nessuna soluzione open source integra **tutti** i seguenti aspetti:
  - UI moderna per editing/preview template
  - Supporto completo multi-lingua, variabili, layout personalizzati
  - Log invii dettagliato e gestione errori
  - Branding (logo, header/footer custom) e allegati
  - Associazione flessibile a eventi Laravel e supporto multi-tenant

---

## Proposta architetturale: Database Mail evoluto

### Obiettivi
- UI Filament moderna per CRUD, editing e preview template (base: visualbuilder/email-templates)
- Modello EmailTemplate esteso, compatibile con Spatie (variabili, localizzazione, layout, allegati)
- Event Listener flessibili: trigger su eventi Laravel, selezione template, popolamento variabili, invio
- Rendering con Spatie/laravel-database-mail-templates (fallback blade)
- Log invii: tabella dedicata con stato, destinatario, errori, retry
- Branding: supporto logo, header/footer custom, allegati
- Multi-lingua e multi-tenant ready

### Componenti principali
- **Model**: `EmailTemplate` (estende Spatie\MailTemplate)
- **Filament Resource**: CRUD, editor WYSIWYG, gestione variabili, preview, localizzazione
- **Event Listener**: intercetta eventi, seleziona template, popola variabili, invia email
- **Mailer**: rendering Spatie, fallback blade, gestione allegati
- **Log**: tabella `email_logs` per tracciamento invii, stato, errori
- **Branding**: personalizzazione header/footer/logo via configurazione o editor

### Esempio di flusso
```php
// Listener generico
Event::listen(UserRegistered::class, function ($event) {
    $template = EmailTemplate::active()->forEvent('user_registered')->first();
    if ($template) {
        $template->send([
            'user' => $event->user,
            // altre variabili...
        ]);
    }
});
```

---

## Vantaggi rispetto ai plugin esistenti
- **Open source e componibile**: nessun vendor lock-in, massima estendibilità
- **UI moderna**: editor visuale, preview, gestione variabili e lingue
- **Log avanzato**: stato invio, errori, retry, storico
- **Branding e allegati**: logo, header/footer, allegati integrati
- **Flessibilità eventi**: trigger su qualunque evento Laravel, multi-tenant ready

---

## Roadmap di implementazione
1. Integrare visualbuilder/email-templates come base UI Filament
2. Estendere EmailTemplate model per compatibilità Spatie e gestione variabili/allegati
3. Implementare Event Listener generici e configurabili
4. Aggiungere tabella e UI per log invii email
5. Gestire branding (logo, header, footer) e allegati
6. Scrivere test end-to-end e documentazione esempi
7. Allineare naming, localizzazione, best practice di sicurezza

---

## Link e riferimenti utili
- [visualbuilder/email-templates (GitHub)](https://github.com/visualbuilder/email-templates)
- [spatie/laravel-database-mail-templates (GitHub)](https://github.com/spatie/laravel-database-mail-templates)
- [filamentphp.com/plugins](https://filamentphp.com/plugins)
- [Guida logo email Laravel (Medium)](https://medium.com/@python-javascript-php-html-css/how-to-customize-laravel-email-templates-with-a-logo-3dc862fba8d0)
- [Esempi invio email Spatie](https://laraveldaily.com/code-examples/example/spatie-be/send-email)

---

**Questa architettura permette di avere un sistema di email transazionali robusto, moderno, estendibile e conforme alle best practice Laravel/Filament/Spatie.**

## Architettura

### Models

```php
class EmailTemplate extends Model
{
    use HasTranslations;
    
    protected $fillable = [
        'name',
        'description', 
        'event',
        'subject',
        'body',
        'layout',
        'variables',
        'is_active',
        'delay',
        'cc',
        'bcc'
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
        'delay' => 'integer'
    ];

    public $translatable = [
        'subject',
        'body'
    ];
}

class EmailLog extends Model 
{
    protected $fillable = [
        'template_id',
        'event',
        'recipient',
        'subject',
        'body',
        'variables',
        'status',
        'error',
        'sent_at'
    ];

    protected $casts = [
        'variables' => 'array',
        'sent_at' => 'datetime'
    ];
}
```

### Filament Resources

```php
class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required(),
                    
                Select::make('event')
                    ->options(EventRegistry::getEvents())
                    ->required(),
                    
                TinyMCE::make('body')
                    ->toolbarButtons([
                        'bold', 'italic', 'link', 
                        'bulletList', 'orderedList',
                        'table', 'image'
                    ])
                    ->fileAttachments()
                    ->required(),
                    
                KeyValue::make('variables')
                    ->keyLabel('Variable')
                    ->valueLabel('Description')
                    ->reorderable(),
                    
                Toggle::make('is_active'),
                
                TextInput::make('delay')
                    ->numeric()
                    ->suffix('minutes'),
                    
                TagsInput::make('cc'),
                TagsInput::make('bcc')
            ])
        ]);
    }
}
```

### Services

```php
class EmailService
{
    public function __construct(
        private EventRegistry $events,
        private TemplateRenderer $renderer,
        private MailQueue $queue
    ) {}

    public function sendMail(string $event, array $data = []): void
    {
        $template = EmailTemplate::where('event', $event)
            ->where('is_active', true)
            ->first();
            
        if (!$template) {
            return;
        }
        
        $variables = $this->events->getVariables($event, $data);
        
        $mail = new TemplateMail(
            $template,
            $variables
        );
        
        if ($template->delay) {
            $this->queue->later(
                $mail,
                now()->addMinutes($template->delay)
            );
        } else {
            $this->queue->send($mail);
        }
    }
}

class TemplateRenderer
{
    public function render(EmailTemplate $template, array $variables): string
    {
        return Blade::render(
            $template->body,
            $variables
        );
    }
}
```

### Events

```php
class EventRegistry
{
    protected array $events = [];
    
    public function register(string $event, array $variables = []): void
    {
        $this->events[$event] = $variables;
    }
    
    public function getEvents(): array
    {
        return array_keys($this->events);
    }
    
    public function getVariables(string $event, array $data): array
    {
        $variables = $this->events[$event] ?? [];
        
        return collect($variables)
            ->mapWithKeys(fn ($var) => [
                $var => data_get($data, $var)
            ])
            ->toArray();
    }
}
```

### Mailable

```php
class TemplateMail extends Mailable
{
    public function __construct(
        private EmailTemplate $template,
        private array $variables
    ) {}
    
    public function build()
    {
        return $this
            ->subject($this->template->subject)
            ->cc($this->template->cc)
            ->bcc($this->template->bcc)
            ->html(
                app(TemplateRenderer::class)->render(
                    $this->template,
                    $this->variables
                )
            );
    }
}
```

## Utilizzo

### Registrazione Eventi

```php
// AppServiceProvider
public function boot()
{
    app(EventRegistry::class)->register(
        'DoctorRegistrationApproved',
        [
            'doctor.name',
            'doctor.email',
            'approval_date',
            'approval_notes'
        ]
    );
}
```

### Invio Email

```php
class ProcessDoctorModerationAction
{
    public function __construct(
        private EmailService $emailService
    ) {}
    
    public function execute(Doctor $doctor, bool $approved): void
    {
        if ($approved) {
            $this->emailService->sendMail(
                'DoctorRegistrationApproved',
                [
                    'doctor' => $doctor,
                    'approval_date' => now(),
                    'approval_notes' => 'Congratulazioni!'
                ]
            );
        }
    }
}
```

### Template Example

```html
<x-mail::message>
# Registrazione Approvata

Gentile {{ $doctor->name }},

La sua registrazione è stata approvata in data {{ $approval_date->format('d/m/Y') }}.

{{ $approval_notes }}

<x-mail::button :url="$url">
Accedi al Portale
</x-mail::button>

Cordiali saluti,<br>
{{ config('app.name') }}
</x-mail::message>
```

## Miglioramenti Rispetto a Database Mail

1. **Traduzioni Native**
   - Supporto per traduzioni multiple dei template
   - Interfaccia di gestione traduzioni integrata
   - Fallback automatico alla lingua di default

2. **Editor Avanzato**
   - TinyMCE con supporto per immagini e file
   - Preview in tempo reale
   - Validazione HTML
   - Supporto per template Markdown

3. **Gestione Eventi**
   - Registry centralizzato degli eventi
   - Validazione automatica delle variabili
   - Documentazione automatica delle variabili disponibili

4. **Logging e Monitoring**
   - Log dettagliato di ogni email inviata
   - Tracciamento dello stato di invio
   - Gestione errori e retry
   - Dashboard di monitoraggio

5. **Performance**
   - Caching dei template compilati
   - Code di invio ottimizzate
   - Batch sending per invii massivi

6. **Sicurezza**
   - Validazione input
   - Sanitizzazione HTML
   - Rate limiting
   - Protezione da spam

## Vedi Anche

- [Laravel Mail](https://laravel.com/docs/mail)
- [Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [TinyMCE](https://www.tiny.cloud)
- [Filament Forms](https://filamentphp.com/docs/forms)

---

## database-mail-enhancement-1

*Consolidated from: `database-mail-enhancement.md`*

title: "Database Mail Enhancement (Open Source)"
type: concept
tags: [database, mail, enhancement]
created: 2026-07-14
updated: 2026-07-14
qmd: "database-mail-enhancement-1 database mail enhancement (open source)"
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

# Database Mail Enhancement (Open Source)

Questo documento descrive un approccio in-house per la gestione e l'invio di email da database, ispirato al plugin a pagamento `martin-petricko-database-mail` per Filament e alle soluzioni open source di Spatie.

## Analisi del plugin commerciale

- **martin-petricko-database-mail** fornisce UI Filament per definire template email nel DB
- Supporto per variabili dinamiche, anteprima, versioning
- Integrazione con invio mail, ma è un pacchetto a pagamento

## Obiettivi della nostra versione

1. Gestire template email nel DB con interfaccia Filament
2. Utilizzare soluzioni gratuite e open source
3. Supportare variabili dinamiche, anteprima, versioning
4. Invio tramite queue e log delle attività
5. Facile estensione e manutenzione

## Pacchetti Open Source

- **spatie/laravel-database-mail-templates**: gestione template in DB, parsing markdown
- **spatie/laravel-mailcoach-mailer**: invio massivo e transazionale con Mailcoach
- **spatie/laravel-queueable-action**: action queueable per logica di invio
- **spatie/laravel-model-states**: gestione stato dei messaggi (draft, sent, failed)

## Architettura proposta

1. **Database**: tabella `email_templates` (id, name, subject, body, variables)
2. **Modello**: `EmailTemplate` casted con ModelStates per `status`
3. **Filament Resource**: gestione CRUD di template con anteprima live (MarkdownEditor)
4. **Action**: `SendEmailTemplateAction` queueable che:
   - carica il template
   - sostituisce variabili dinamiche
   - invia con Mailable o MailcoachMailer
   - aggiorna stato e log
5. **Job / Queue**: invio asincrono, retry, fallback su failure
6. **Log**: tabella `email_logs` con destinatario, stato, template_id, errori

## Implementazione in sintesi

```php
// 1. Migrazione template
table->create('email_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('body');
    $table->json('variables')->nullable();
    $table->timestamps();
});

// 2. Model con ModelStates
class EmailTemplate extends Model {
    use HasStates;
    protected $casts = ['status' => EmailStatus::class];
}

// 3. Filament Resource
class EmailTemplateResource extends XotBaseResource {
    public static function form(Form $form): Form {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('subject')->required(),
            MarkdownEditor::make('body')->required(),
            KeyValue::make('variables'),
        ]);
    }
}

// 4. Action queueable
testable class SendEmailTemplateAction {
    use QueueableAction;
    public function execute(EmailTemplate $template, string $to, array $data = []): void {
        $content = $this->render($template->body, $data);
        Mail::to($to)->send(new GenericHtmlMail($template->subject, $content));
        $template->status->transitionTo(Sent::class);
    }
}
```

## Vantaggi

- Nessun costo licence
- Elevata personalizzazione e integrazione con Spatie
- Testabilità e scalabilità
- Allineato alle convenzioni di progetto

---

**Collegamenti**:

- [martin-petricko Database Mail](https://filamentphp.com/plugins/martin-petricko-database-mail)
- [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates)
- [spatie/laravel-mailcoach-mailer](https://github.com/spatie/laravel-mailcoach-mailer)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)

---

## database-mail-enhancement

*Consolidated from: `database-mail-enhancement.md`*


Questo documento descrive un approccio in-house per la gestione e l'invio di email da database, ispirato al plugin a pagamento `martin-petricko-database-mail` per Filament e alle soluzioni open source di Spatie.

## Analisi del plugin commerciale

- **martin-petricko-database-mail** fornisce UI Filament per definire template email nel DB
- Supporto per variabili dinamiche, anteprima, versioning
- Integrazione con invio mail, ma è un pacchetto a pagamento

## Obiettivi della nostra versione

1. Gestire template email nel DB con interfaccia Filament
2. Utilizzare soluzioni gratuite e open source
3. Supportare variabili dinamiche, anteprima, versioning
4. Invio tramite queue e log delle attività
5. Facile estensione e manutenzione

## Pacchetti Open Source

- **spatie/laravel-database-mail-templates**: gestione template in DB, parsing markdown
- **spatie/laravel-mailcoach-mailer**: invio massivo e transazionale con Mailcoach
- **spatie/laravel-queueable-action**: action queueable per logica di invio
- **spatie/laravel-model-states**: gestione stato dei messaggi (draft, sent, failed)

## Architettura proposta

1. **Database**: tabella `email_templates` (id, name, subject, body, variables)
2. **Modello**: `EmailTemplate` casted con ModelStates per `status`
3. **Filament Resource**: gestione CRUD di template con anteprima live (MarkdownEditor)
4. **Action**: `SendEmailTemplateAction` queueable che:
   - carica il template
   - sostituisce variabili dinamiche
   - invia con Mailable o MailcoachMailer
   - aggiorna stato e log
5. **Job / Queue**: invio asincrono, retry, fallback su failure
6. **Log**: tabella `email_logs` con destinatario, stato, template_id, errori

## Implementazione in sintesi

```php
// 1. Migrazione template
table->create('email_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('body');
    $table->json('variables')->nullable();
    $table->timestamps();
});

// 2. Model con ModelStates
class EmailTemplate extends Model {
    use HasStates;
    protected $casts = ['status' => EmailStatus::class];
}

// 3. Filament Resource
class EmailTemplateResource extends XotBaseResource {
    public static function form(Form $form): Form {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('subject')->required(),
            MarkdownEditor::make('body')->required(),
            KeyValue::make('variables'),
        ]);
    }
}

// 4. Action queueable
testable class SendEmailTemplateAction {
    use QueueableAction;
    public function execute(EmailTemplate $template, string $to, array $data = []): void {
        $content = $this->render($template->body, $data);
        Mail::to($to)->send(new GenericHtmlMail($template->subject, $content));
        $template->status->transitionTo(Sent::class);
    }
}
```

## Vantaggi

- Nessun costo licence
- Elevata personalizzazione e integrazione con Spatie
- Testabilità e scalabilità
- Allineato alle convenzioni di progetto

---

**Collegamenti**:

- [martin-petricko Database Mail](https://filamentphp.com/plugins/martin-petricko-database-mail)
- [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates)
- [spatie/laravel-mailcoach-mailer](https://github.com/spatie/laravel-mailcoach-mailer)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)

---

## database-mail-queue-1

*Consolidated from: `database-mail-queue.md`*
*Consolidated from: `database-mail-queue-deprecated.md`*


This file is deprecated.

Use:

- [database-mail-queue](./database-mail-queue.md)
- [database-mail-queue](../../database-mail-queue.md)

---

## database-mail-queue-2

*Consolidated from: `database-mail-queue.md`*

title: "Sistema di Code per Email - il progetto"
type: concept
tags: [database, mail, queue]
created: 2026-07-14
updated: 2026-07-14
qmd: "database-mail-queue-2 sistema di code per email - il progetto"
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

# Sistema di Code per Email - il progetto

## Panoramica

Implementazione del sistema di code per l'invio di email in il progetto, con integrazione completa con il nostro sistema di template basato su database.

## Componenti

### 1. Job di Invio Email

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateManager;

class SendTemplatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Numero di tentativi massimi.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Timeout del job in secondi.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * Costruttore del job.
     *
     * @param string $to Email destinatario
     * @param string $mailable Classe mailable
     * @param array<string, mixed> $data Dati per il template
     * @param string|null $locale Lingua del template
     */
    public function __construct(
        protected string $to,
        protected string $mailable,
        protected array $data = [],
        protected ?string $locale = null
    ) {}

    /**
     * Esegue il job.
     */
    public function handle(MailTemplateManager $manager): void
    {
        $template = $manager->getTemplate($this->mailable, $this->locale);

        if (!$template) {
            throw new TemplateNotFoundException($this->mailable, $this->locale);
        }

        Mail::to($this->to)
            ->send(new DatabaseTemplateMailable($template, $this->data));

        // Traccia statistiche
        $this->trackMailStats($template);
    }

    /**
     * Gestisce il fallimento del job.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Email sending failed', [
            'to' => $this->to,
            'mailable' => $this->mailable,
            'exception' => $exception->getMessage(),
        ]);

        // Notifica amministratori
        Notification::route('slack', config('notify.error_channel'))
            ->notify(new FailedMailNotification($this->to, $this->mailable));
    }

    /**
     * Traccia le statistiche di invio.
     */
    protected function trackMailStats(MailTemplate $template): void
    {
        $template->stats()->create([
            'email' => $this->to,
            'sent_at' => now(),
            'status' => 'sent',
            'metadata' => [
                'locale' => $this->locale,
                'data_keys' => array_keys($this->data),
            ],
        ]);
    }
}
```

### 2. Configurazione Code

```php
// config/queue.php

return [
    'default' => env('QUEUE_CONNECTION', 'redis'),

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
```

### 3. Worker Manager

```php
namespace Modules\Notify\Services;

class QueueWorkerManager
{
    /**
     * Avvia i worker necessari.
     */
    public function startWorkers(): void
    {
        $workerCount = config('notify.queue.workers', 2);
        
        for ($i = 0; $i < $workerCount; $i++) {
            Process::run('php artisan queue:work --queue=emails --tries=3');
        }
    }

    /**
     * Monitora lo stato dei worker.
     */
    public function monitorWorkers(): array
    {
        return [
            'active_workers' => $this->getActiveWorkers(),
            'processed_jobs' => $this->getProcessedJobs(),
            'failed_jobs' => $this->getFailedJobs(),
        ];
    }
}
```

## Utilizzo

### 1. Accodamento Email

```php
// Invio singolo
SendTemplatedEmailJob::dispatch(
    'user@example.com',
    WelcomeEmail::class,
    ['user' => $user]
);

// Invio multiplo
$users->each(function ($user) {
    SendTemplatedEmailJob::dispatch(
        $user->email,
        WelcomeEmail::class,
        ['user' => $user]
    )->onQueue('emails');
});
```

### 2. Gestione Worker

```bash
# Avvia worker dedicato
php artisan queue:work --queue=emails

# Monitora code
php artisan queue:monitor

# Gestione failed jobs
php artisan queue:failed
php artisan queue:retry all
```

## Best Practices

### 1. Configurazione Code

```php
// Priorità code
'queues' => [
    'emails-high',    // Email critiche
    'emails-normal',  // Email standard
    'emails-bulk',    // Email massive
],

// Limiti rate
'throttle' => [
    'emails-high' => 100,  // 100/min
    'emails-normal' => 50, // 50/min
    'emails-bulk' => 10,   // 10/min
],
```

### 2. Monitoraggio

```php
// Prometheus metrics
$counter = Counter::create('emails_sent_total', 'Total emails sent')
    ->inc();

$histogram = Histogram::create('email_sending_duration_seconds', 'Time spent sending emails')
    ->observe($duration);
```

### 3. Retry Strategy

```php
public function backoff(): array
{
    return [
        10,  // 10 secondi
        30,  // 30 secondi
        60,  // 1 minuto
    ];
}

public function retryUntil(): \DateTime
{
    return now()->addHours(24);
}
```

## Gestione Errori

### 1. Logging

```php
Log::channel('mail')->error('Email sending failed', [
    'to' => $this->to,
    'template' => $this->template->id,
    'error' => $e->getMessage(),
    'trace' => $e->getTraceAsString(),
]);
```

### 2. Notifiche

```php
Notification::route('slack', config('notify.error_channel'))
    ->notify(new FailedMailNotification([
        'to' => $this->to,
        'error' => $e->getMessage(),
    ]));
```

### 3. Cleanup

```php
// Rimuovi job falliti vecchi
$this->call('queue:prune-failed', [
    '--hours' => 168 // 1 settimana
]);

// Rimuovi job completati
$this->call('queue:prune-batches', [
    '--hours' => 24
]);
```

## Scaling

### 1. Orizzontale

```bash
# Supervisor config
[program:<nome progetto>-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/_bases/base_<nome progetto>/laravel/artisan queue:work redis --queue=emails
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
```

### 2. Rate Limiting

```php
// Rate limiter per dominio
RateLimiter::for('mail-domain', function ($job) {
    return Limit::perMinute(100)->by($job->getDomain());
});

// Rate limiter globale
RateLimiter::for('mail-global', function () {
    return Limit::perMinute(1000);
});
```

### 3. Sharding

```php
// Distribuzione su multiple code
$queue = 'emails-' . ($user->id % 4); // 4 code

SendTemplatedEmailJob::dispatch($user->email, $template)
    ->onQueue($queue);
```

## Monitoraggio

### 1. Metriche

```php
// Prometheus metrics
$metrics = [
    'emails_sent_total' => [
        'type' => 'counter',
        'help' => 'Total emails sent',
    ],
    'email_sending_duration' => [
        'type' => 'histogram',
        'help' => 'Email sending duration',
    ],
    'failed_jobs_total' => [
        'type' => 'counter',
        'help' => 'Total failed jobs',
    ],
];
```

### 2. Dashboard

```php
// Horizon metrics
Horizon::metrics([
    'emails' => [
        'total' => fn() => MailStats::count(),
        'sent' => fn() => MailStats::sent()->count(),
        'failed' => fn() => MailStats::failed()->count(),
    ],
]);
```

### 3. Alerting

```php
// Alert su errori
if ($failedJobs > $threshold) {
    Alert::channel('slack')
        ->error("High email failure rate detected")
        ->send();
}
```

## Manutenzione

### 1. Pulizia

```bash
# Pulizia job vecchi
php artisan queue:prune-failed --hours=168
php artisan queue:prune-batches --hours=24

# Pulizia statistiche
php artisan notify:prune-mail-stats --days=30
```

### 2. Backup

```php
// Backup configurazione
php artisan backup:run --only-db --filename=queue_backup

// Backup failed jobs
php artisan queue:failed-table > failed_jobs_backup.sql
```

### 3. Ripristino

```php
// Ripristino job falliti
php artisan queue:retry all
php artisan queue:restart
```

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Database Mail System](../../database-mail-system.md)
- [Mail Templates](database-mail-templates.md)
- [Queue Configuration](../../../../docs/queue-configuration.md)

## Vedi Anche
- [Laravel Queues](https://laravel.com/docs/queues)
- [Horizon Documentation](https://laravel.com/docs/horizon)
- [Redis Documentation](https://redis.io/documentation)
---

## database-mail-queue

*Consolidated from: `database-mail-queue.md`*


## Panoramica

Implementazione del sistema di code per l'invio di email in il progetto, con integrazione completa con il nostro sistema di template basato su database.

## Componenti

### 1. Job di Invio Email

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateManager;

class SendTemplatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Numero di tentativi massimi.
     *
     * @var int
     */
    public $tries = 3;

     * Timeout del job in secondi.
    public $timeout = 60;

     * Costruttore del job.
     * @param string $to Email destinatario
     * @param string $mailable Classe mailable
     * @param array<string, mixed> $data Dati per il template
     * @param string|null $locale Lingua del template
    public function __construct(
        protected string $to,
        protected string $mailable,
        protected array $data = [],
        protected ?string $locale = null
    ) {}

    /**
     * Esegue il job.
     */
    public function handle(MailTemplateManager $manager): void
    {
        $template = $manager->getTemplate($this->mailable, $this->locale);

        if (!$template) {
            throw new TemplateNotFoundException($this->mailable, $this->locale);
        }

        Mail::to($this->to)
            ->send(new DatabaseTemplateMailable($template, $this->data));

        // Traccia statistiche
        $this->trackMailStats($template);
    }

    /**
     * Gestisce il fallimento del job.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Email sending failed', [
            'to' => $this->to,
            'mailable' => $this->mailable,
            'exception' => $exception->getMessage(),
        ]);

        // Notifica amministratori
        Notification::route('slack', config('notify.error_channel'))
            ->notify(new FailedMailNotification($this->to, $this->mailable));
    }

    /**
     * Traccia le statistiche di invio.
     */
    protected function trackMailStats(MailTemplate $template): void
    {
        $template->stats()->create([
            'email' => $this->to,
            'sent_at' => now(),
            'status' => 'sent',
            'metadata' => [
                'locale' => $this->locale,
                'data_keys' => array_keys($this->data),
            ],
        ]);
    }
}
```

### 2. Configurazione Code

```php
// config/queue.php

return [
    'default' => env('QUEUE_CONNECTION', 'redis'),

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
        ],

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
];
```

### 3. Worker Manager

```php
namespace Modules\Notify\Services;

class QueueWorkerManager
{
    /**
     * Avvia i worker necessari.
     */
    public function startWorkers(): void
    {
        $workerCount = config('notify.queue.workers', 2);

        for ($i = 0; $i < $workerCount; $i++) {
            Process::run('php artisan queue:work --queue=emails --tries=3');
        }
    }

     * Monitora lo stato dei worker.
    public function monitorWorkers(): array
    {
        return [
            'active_workers' => $this->getActiveWorkers(),
            'processed_jobs' => $this->getProcessedJobs(),
            'failed_jobs' => $this->getFailedJobs(),
        ];
    }
}
```

## Utilizzo

### 1. Accodamento Email

```php
// Invio singolo
SendTemplatedEmailJob::dispatch(
    'user@example.com',
    WelcomeEmail::class,
    ['user' => $user]
);

// Invio multiplo
$users->each(function ($user) {
        $user->email,
    )->onQueue('emails');
});
```

### 2. Gestione Worker

```bash

# Avvia worker dedicato
php artisan queue:work --queue=emails

# Monitora code
php artisan queue:monitor

# Gestione failed jobs
php artisan queue:failed
php artisan queue:retry all

## Best Practices

### 1. Configurazione Code

```php
// Priorità code
'queues' => [
    'emails-high',    // Email critiche
    'emails-normal',  // Email standard
    'emails-bulk',    // Email massive
],

// Limiti rate
'throttle' => [
    'emails-high' => 100,  // 100/min
    'emails-normal' => 50, // 50/min
    'emails-bulk' => 10,   // 10/min
```

### 2. Monitoraggio

```php
// Prometheus metrics
$counter = Counter::create('emails_sent_total', 'Total emails sent')
    ->inc();

$histogram = Histogram::create('email_sending_duration_seconds', 'Time spent sending emails')
    ->observe($duration);

### 3. Retry Strategy

public function backoff(): array
{
    return [
        10,  // 10 secondi
        30,  // 30 secondi
        60,  // 1 minuto
    ];
}

public function retryUntil(): \DateTime
{
    return now()->addHours(24);
}
```

## Gestione Errori

### 1. Logging

```php
Log::channel('mail')->error('Email sending failed', [
    'to' => $this->to,
    'template' => $this->template->id,
    'error' => $e->getMessage(),
    'trace' => $e->getTraceAsString(),
]);

### 2. Notifiche

Notification::route('slack', config('notify.error_channel'))
    ->notify(new FailedMailNotification([
    ]));
```

### 3. Cleanup

```php
// Rimuovi job falliti vecchi
$this->call('queue:prune-failed', [
    '--hours' => 168 // 1 settimana
]);

// Rimuovi job completati
$this->call('queue:prune-batches', [
    '--hours' => 24

## Scaling

### 1. Orizzontale

```bash
# Supervisor config
[program:<nome progetto>-worker]
process_name=%(program_name)s_%(process_num)02d
command=php artisan queue:work redis --queue=emails

command=php artisan queue:work redis --queue=emails
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
```

### 2. Rate Limiting

```php
// Rate limiter per dominio
RateLimiter::for('mail-domain', function ($job) {
    return Limit::perMinute(100)->by($job->getDomain());
});

// Rate limiter globale
RateLimiter::for('mail-global', function () {
    return Limit::perMinute(1000);

### 3. Sharding

// Distribuzione su multiple code
$queue = 'emails-' . ($user->id % 4); // 4 code

SendTemplatedEmailJob::dispatch($user->email, $template)
    ->onQueue($queue);
```

## Monitoraggio

### 1. Metriche

```php
// Prometheus metrics
$metrics = [
    'emails_sent_total' => [
        'type' => 'counter',
        'help' => 'Total emails sent',
    ],
    'email_sending_duration' => [
        'type' => 'histogram',
        'help' => 'Email sending duration',
    'failed_jobs_total' => [
        'help' => 'Total failed jobs',
];
```

### 2. Dashboard

```php
// Horizon metrics
Horizon::metrics([
    'emails' => [
        'total' => fn() => MailStats::count(),
        'sent' => fn() => MailStats::sent()->count(),
        'failed' => fn() => MailStats::failed()->count(),
    ],
]);
```

### 3. Alerting

```php
// Alert su errori
if ($failedJobs > $threshold) {
    Alert::channel('slack')
        ->error("High email failure rate detected")
        ->send();
}

## Manutenzione

### 1. Pulizia

```bash

# Pulizia job vecchi
php artisan queue:prune-failed --hours=168
php artisan queue:prune-batches --hours=24

# Pulizia statistiche
php artisan notify:prune-mail-stats --days=30
```

### 2. Backup

```php
// Backup configurazione
php artisan backup:run --only-db --filename=queue_backup

// Backup failed jobs
php artisan queue:failed-table > failed_jobs_backup.sql

### 3. Ripristino

// Ripristino job falliti
php artisan queue:retry all
php artisan queue:restart
```

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Mail Templates](database-mail-templates.md)
- [Queue Configuration](../../../../docs/queue-configuration.md)

## Vedi Anche
- [Laravel Queues](https://laravel.com/docs/queues)
- [Horizon Documentation](https://laravel.com/docs/horizon)
- [Redis Documentation](https://redis.io/documentation)
# Sistema di Code per Email - il progetto

## Panoramica

Implementazione del sistema di code per l'invio di email in il progetto, con integrazione completa con il nostro sistema di template basato su database.

## Componenti

### 1. Job di Invio Email

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateManager;

class SendTemplatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Numero di tentativi massimi.
     *
     * @var int
     */
    public $tries = 3;

     * Timeout del job in secondi.
    public $timeout = 60;

     * Costruttore del job.
     * @param string $to Email destinatario
     * @param string $mailable Classe mailable
     * @param array<string, mixed> $data Dati per il template
     * @param string|null $locale Lingua del template
    public function __construct(
        protected string $to,
        protected string $mailable,
        protected array $data = [],
        protected ?string $locale = null
    ) {}

    /**
     * Esegue il job.
     */
    public function handle(MailTemplateManager $manager): void
    {
        $template = $manager->getTemplate($this->mailable, $this->locale);

        if (!$template) {
            throw new TemplateNotFoundException($this->mailable, $this->locale);
        }

        Mail::to($this->to)
            ->send(new DatabaseTemplateMailable($template, $this->data));

        // Traccia statistiche
        $this->trackMailStats($template);
    }

    /**
     * Gestisce il fallimento del job.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Email sending failed', [
            'to' => $this->to,
            'mailable' => $this->mailable,
            'exception' => $exception->getMessage(),
        ]);

        // Notifica amministratori
        Notification::route('slack', config('notify.error_channel'))
            ->notify(new FailedMailNotification($this->to, $this->mailable));
    }

    /**
     * Traccia le statistiche di invio.
     */
    protected function trackMailStats(MailTemplate $template): void
    {
        $template->stats()->create([
            'email' => $this->to,
            'sent_at' => now(),
            'status' => 'sent',
            'metadata' => [
                'locale' => $this->locale,
                'data_keys' => array_keys($this->data),
            ],
        ]);
    }
}
```

### 2. Configurazione Code

```php
// config/queue.php

return [
    'default' => env('QUEUE_CONNECTION', 'redis'),

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
        ],

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
];
```

### 3. Worker Manager

```php
namespace Modules\Notify\Services;

class QueueWorkerManager
{
    /**
     * Avvia i worker necessari.
     */
    public function startWorkers(): void
    {
        $workerCount = config('notify.queue.workers', 2);

        for ($i = 0; $i < $workerCount; $i++) {
            Process::run('php artisan queue:work --queue=emails --tries=3');
        }
    }

     * Monitora lo stato dei worker.
    public function monitorWorkers(): array
    {
        return [
            'active_workers' => $this->getActiveWorkers(),
            'processed_jobs' => $this->getProcessedJobs(),
            'failed_jobs' => $this->getFailedJobs(),
        ];
    }
}
```

## Utilizzo

### 1. Accodamento Email

```php
// Invio singolo
SendTemplatedEmailJob::dispatch(
    'user@example.com',
    WelcomeEmail::class,
    ['user' => $user]
);

// Invio multiplo
$users->each(function ($user) {
        $user->email,
    )->onQueue('emails');
});
```

### 2. Gestione Worker

```bash

# Avvia worker dedicato
php artisan queue:work --queue=emails

# Monitora code
php artisan queue:monitor

# Gestione failed jobs
php artisan queue:failed
php artisan queue:retry all

## Best Practices

### 1. Configurazione Code

```php
// Priorità code
'queues' => [
    'emails-high',    // Email critiche
    'emails-normal',  // Email standard
    'emails-bulk',    // Email massive
],

// Limiti rate
'throttle' => [
    'emails-high' => 100,  // 100/min
    'emails-normal' => 50, // 50/min
    'emails-bulk' => 10,   // 10/min
```

### 2. Monitoraggio

```php
// Prometheus metrics
$counter = Counter::create('emails_sent_total', 'Total emails sent')
    ->inc();

$histogram = Histogram::create('email_sending_duration_seconds', 'Time spent sending emails')
    ->observe($duration);

### 3. Retry Strategy

public function backoff(): array
{
    return [
        10,  // 10 secondi
        30,  // 30 secondi
        60,  // 1 minuto
    ];
}

public function retryUntil(): \DateTime
{
    return now()->addHours(24);
}
```

## Gestione Errori

### 1. Logging

```php
Log::channel('mail')->error('Email sending failed', [
    'to' => $this->to,
    'template' => $this->template->id,
    'error' => $e->getMessage(),
    'trace' => $e->getTraceAsString(),
]);

### 2. Notifiche

Notification::route('slack', config('notify.error_channel'))
    ->notify(new FailedMailNotification([
    ]));
```

### 3. Cleanup

```php
// Rimuovi job falliti vecchi
$this->call('queue:prune-failed', [
    '--hours' => 168 // 1 settimana
]);

// Rimuovi job completati
$this->call('queue:prune-batches', [
    '--hours' => 24

## Scaling

### 1. Orizzontale

```bash
# Supervisor config

[program:<nome progetto>-worker]
process_name=%(program_name)s_%(process_num)02d
command=php artisan queue:work redis --queue=emails
[program:ptv-worker]
command=php artisan queue:work redis --queue=emails

command=php artisan queue:work redis --queue=emails

autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
```

### 2. Rate Limiting

```php
// Rate limiter per dominio
RateLimiter::for('mail-domain', function ($job) {
    return Limit::perMinute(100)->by($job->getDomain());
});

// Rate limiter globale
RateLimiter::for('mail-global', function () {
    return Limit::perMinute(1000);

### 3. Sharding

// Distribuzione su multiple code
$queue = 'emails-' . ($user->id % 4); // 4 code

SendTemplatedEmailJob::dispatch($user->email, $template)
    ->onQueue($queue);
```

## Monitoraggio

### 1. Metriche

```php
// Prometheus metrics
$metrics = [
    'emails_sent_total' => [
        'type' => 'counter',
        'help' => 'Total emails sent',
    ],
    'email_sending_duration' => [
        'type' => 'histogram',
        'help' => 'Email sending duration',
    'failed_jobs_total' => [
        'help' => 'Total failed jobs',
];
```

### 2. Dashboard

```php
// Horizon metrics
Horizon::metrics([
    'emails' => [
        'total' => fn() => MailStats::count(),
        'sent' => fn() => MailStats::sent()->count(),
        'failed' => fn() => MailStats::failed()->count(),
    ],
]);
```

### 3. Alerting

```php
// Alert su errori
if ($failedJobs > $threshold) {
    Alert::channel('slack')
        ->error("High email failure rate detected")
        ->send();
}

## Manutenzione

### 1. Pulizia

```bash

# Pulizia job vecchi
php artisan queue:prune-failed --hours=168
php artisan queue:prune-batches --hours=24

# Pulizia statistiche
php artisan notify:prune-mail-stats --days=30
```

### 2. Backup

```php
// Backup configurazione
php artisan backup:run --only-db --filename=queue_backup

// Backup failed jobs
php artisan queue:failed-table > failed_jobs_backup.sql

### 3. Ripristino

// Ripristino job falliti
php artisan queue:retry all
php artisan queue:restart
```

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Database Mail System](../../database-mail-system.md)
- [Mail Templates](database-mail-templates.md)
- [Queue Configuration](../../../../docs/queue-configuration.md)

## Vedi Anche
- [Laravel Queues](https://laravel.com/docs/queues)
- [Horizon Documentation](https://laravel.com/docs/horizon)
- [Queue Configuration](../../../../docs/project/queue-configuration.md)

- [Laravel Queues](https://laravel.com/project_docs/queues)
- [Horizon Documentation](https://laravel.com/project_docs/horizon)
- [Redis Documentation](https://redis.io/documentation)

---

## database-mail-system-1

*Consolidated from: `database-mail-system.md`*


## Panoramica

Implementazione personalizzata di un sistema di gestione email basato su database per il progetto, ispirato a Spatie/laravel-database-mail-templates ma con funzionalità aggiuntive e integrazione completa con il nostro ecosistema.

## Caratteristiche Principali

- Template email memorizzati nel database
- Supporto multilingua
- Editor WYSIWYG integrato con Filament
- Sistema di placeholder avanzato
- Versionamento dei template
- Preview in tempo reale
- Test di invio
- Statistiche di apertura/click
- Integrazione con il sistema di code
- Supporto per allegati dinamici
- Gestione layout personalizzati
- Backup automatico dei template

## Struttura Database

```php
// Template Email
Schema::create('notify_mail_templates', function (Blueprint $table) {
    $table->id();
    $table->string('mailable'); // Classe Mailable associata
    $table->string('name');     // Nome template
    $table->string('locale');   // Lingua (it, en, etc.)
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->json('variables')->nullable(); // Variabili disponibili
    $table->json('layout')->nullable();    // Layout personalizzato
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// Versioni Template
Schema::create('notify_mail_template_versions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->string('created_by');
    $table->text('change_notes')->nullable();
    $table->timestamps();
});

// Statistiche Invio
Schema::create('notify_mail_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->string('email');
    $table->timestamp('sent_at');
    $table->timestamp('opened_at')->nullable();
    $table->json('clicked_links')->nullable();
    $table->string('status'); // sent, delivered, opened, clicked, bounced
    $table->json('metadata')->nullable();
});
```

## Componenti del Sistema

### 1. Template Manager

```php
namespace Modules\Notify\Services;

class MailTemplateManager
{
    public function getTemplate(string $mailable, string $locale = null): ?MailTemplate
    {
        $locale = $locale ?? app()->getLocale();
        return MailTemplate::where('mailable', $mailable)
            ->where('locale', $locale)
            ->where('is_active', true)
            ->first();
    }

    public function renderTemplate(MailTemplate $template, array $data): string
    {
        // Rendering con Blade + gestione placeholder
        return view()
            ->make('notify::mail.template', [
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $data
            ])
            ->render();
    }
}
```

### 2. Trait per Mailables

```php
namespace Modules\Notify\Traits;

trait UseDatabaseTemplate
{
    public function build()
    {
        $template = app(MailTemplateManager::class)
            ->getTemplate(static::class);

        if (!$template) {
            return parent::build();
        }

        return $this->view('notify::mail.template')
            ->with([
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $this->data
            ]);
    }
}
```

### 3. Filament Resource

```php
namespace Modules\Notify\Filament\Resources;

class MailTemplateResource extends XotBaseResource
{
    protected static ?string $model = MailTemplate::class;

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    public static function form(Form $form): Form

    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('mailable')
                    ->options(static::getMailableClasses())
                    ->required(),
                Select::make('locale')
                    ->options(static::getAvailableLocales())
                    ->required(),
                RichEditor::make('html_template')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'orderedList',
                        'unorderedList',
                        'h2',
                        'h3',
                    ]),
                Toggle::make('is_active')
                    ->default(true),
            ])
        ]);
    }
}
```

## Utilizzo

### 1. Creazione Template

```php
use Modules\Notify\Models\MailTemplate;

MailTemplate::create([
    'mailable' => WelcomeEmail::class,
    'name' => 'Welcome Email',
    'locale' => 'it',
    'html_template' => '<h1>Benvenuto {{ $user->name }}!</h1>',
    'variables' => ['user' => 'App\Models\User'],
]);
```

### 2. Utilizzo in Mailable

```php
use Modules\Notify\Traits\UseDatabaseTemplate;

class WelcomeEmail extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public User $user)
    {
        //
    }
}
```

### 3. Invio Email

```php
Mail::to($user)->send(new WelcomeEmail($user));
```

## Best Practices

1. **Versionamento Template**
   - Mantenere storico modifiche
   - Possibilità di rollback
   - Note di cambiamento

2. **Testing**
   - Test automatici per rendering
   - Validazione variabili
   - Preview multi-device

3. **Performance**
   - Cache dei template
   - Ottimizzazione query
   - Code per invio massivo

4. **Sicurezza**
   - Sanitizzazione input
   - Escape variabili
   - Protezione XSS

## Integrazione con Altri Moduli

### 1. Module Patient
```php
// Esempio notifica appuntamento
class AppointmentReminder extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Appointment $appointment)
    {
        //
    }
}
```

### 2. Module Dental
```php
// Esempio notifica trattamento
class TreatmentComplete extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Treatment $treatment)
    {
        //
    }
}
```

## Comandi Artisan

```bash

# Gestione template
php artisan notify:mail-template:list
php artisan notify:mail-template:create
php artisan notify:mail-template:update
php artisan notify:mail-template:delete

# Utilità
php artisan notify:mail-template:export
php artisan notify:mail-template:import
php artisan notify:mail-template:test
```

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor WYSIWYG
   - [x] Supporto multilingua

2. **Fase 2 - Avanzato**
   - [ ] A/B Testing
   - [ ] Analytics avanzate
   - [ ] Template condizionali

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni esterne

## Troubleshooting

### Problemi Comuni

1. **Template non trovato**
   - Verificare mailable class
   - Controllare locale
   - Verificare is_active

2. **Variabili non renderizzate**
   - Controllare sintassi
   - Verificare escape
   - Debug dati passati

3. **Performance**
   - Ottimizzare query
   - Implementare cache
   - Monitorare tempi

## Collegamenti
- [Notify Module](../README.md)
- [Email Templates](email-templates.md)
- [Email Templates](../../email-templates.md)
- [Mail Queue](mail-queue.md)

## Vedi Anche

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)

- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Filament Forms](https://filamentphp.com/project_docs/forms)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Filament Forms](https://filamentphp.com/project_docs/forms)

- [Laravel Mail](https://laravel.com/project_docs/mail)
- [Filament Forms](https://filamentphp.com/project_docs/forms)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

---

## database-mail-system-2

*Consolidated from: `database-mail-system.md`*

title: "Sistema di Gestione Email Basato su Database - il progetto"
type: concept
tags: [database, mail, system]
created: 2026-07-14
updated: 2026-07-14
qmd: "database-mail-system-2 sistema di gestione email basato su database - il progetto"
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

# Sistema di Gestione Email Basato su Database - il progetto

## Panoramica

Implementazione personalizzata di un sistema di gestione email basato su database per il progetto, ispirato a Spatie/laravel-database-mail-templates ma con funzionalità aggiuntive e integrazione completa con il nostro ecosistema.

## Caratteristiche Principali

- Template email memorizzati nel database
- Supporto multilingua
- Editor WYSIWYG integrato con Filament
- Sistema di placeholder avanzato
- Versionamento dei template
- Preview in tempo reale
- Test di invio
- Statistiche di apertura/click
- Integrazione con il sistema di code
- Supporto per allegati dinamici
- Gestione layout personalizzati
- Backup automatico dei template

## Struttura Database

```php
// Template Email
Schema::create('notify_mail_templates', function (Blueprint $table) {
    $table->id();
    $table->string('mailable'); // Classe Mailable associata
    $table->string('name');     // Nome template
    $table->string('locale');   // Lingua (it, en, etc.)
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->json('variables')->nullable(); // Variabili disponibili
    $table->json('layout')->nullable();    // Layout personalizzato
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// Versioni Template
Schema::create('notify_mail_template_versions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->string('created_by');
    $table->text('change_notes')->nullable();
    $table->timestamps();
});

// Statistiche Invio
Schema::create('notify_mail_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->string('email');
    $table->timestamp('sent_at');
    $table->timestamp('opened_at')->nullable();
    $table->json('clicked_links')->nullable();
    $table->string('status'); // sent, delivered, opened, clicked, bounced
    $table->json('metadata')->nullable();
});
```

## Componenti del Sistema

### 1. Template Manager

```php
namespace Modules\Notify\Services;

class MailTemplateManager
{
    public function getTemplate(string $mailable, string $locale = null): ?MailTemplate
    {
        $locale = $locale ?? app()->getLocale();
        return MailTemplate::where('mailable', $mailable)
            ->where('locale', $locale)
            ->where('is_active', true)
            ->first();
    }

    public function renderTemplate(MailTemplate $template, array $data): string
    {
        // Rendering con Blade + gestione placeholder
        return view()
            ->make('notify::mail.template', [
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $data
            ])
            ->render();
    }
}
```

### 2. Trait per Mailables

```php
namespace Modules\Notify\Traits;

trait UseDatabaseTemplate
{
    public function build()
    {
        $template = app(MailTemplateManager::class)
            ->getTemplate(static::class);

        if (!$template) {
            return parent::build();
        }

        return $this->view('notify::mail.template')
            ->with([
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $this->data
            ]);
    }
}
```

### 3. Filament Resource

```php
namespace Modules\Notify\Filament\Resources;

class MailTemplateResource extends XotBaseResource
{
    protected static ?string $model = MailTemplate::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('mailable')
                    ->options(static::getMailableClasses())
                    ->required(),
                Select::make('locale')
                    ->options(static::getAvailableLocales())
                    ->required(),
                RichEditor::make('html_template')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'orderedList',
                        'unorderedList',
                        'h2',
                        'h3',
                    ]),
                Toggle::make('is_active')
                    ->default(true),
            ])
        ]);
    }
}
```

## Utilizzo

### 1. Creazione Template

```php
use Modules\Notify\Models\MailTemplate;

MailTemplate::create([
    'mailable' => WelcomeEmail::class,
    'name' => 'Welcome Email',
    'locale' => 'it',
    'html_template' => '<h1>Benvenuto {{ $user->name }}!</h1>',
    'variables' => ['user' => 'App\Models\User'],
]);
```

### 2. Utilizzo in Mailable

```php
use Modules\Notify\Traits\UseDatabaseTemplate;

class WelcomeEmail extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public User $user)
    {
        //
    }
}
```

### 3. Invio Email

```php
Mail::to($user)->send(new WelcomeEmail($user));
```

## Best Practices

1. **Versionamento Template**
   - Mantenere storico modifiche
   - Possibilità di rollback
   - Note di cambiamento

2. **Testing**
   - Test automatici per rendering
   - Validazione variabili
   - Preview multi-device

3. **Performance**
   - Cache dei template
   - Ottimizzazione query
   - Code per invio massivo

4. **Sicurezza**
   - Sanitizzazione input
   - Escape variabili
   - Protezione XSS

## Integrazione con Altri Moduli

### 1. Module Patient
```php
// Esempio notifica appuntamento
class AppointmentReminder extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Appointment $appointment)
    {
        //
    }
}
```

### 2. Module Dental
```php
// Esempio notifica trattamento
class TreatmentComplete extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Treatment $treatment)
    {
        //
    }
}
```

## Comandi Artisan

```bash
# Gestione template
php artisan notify:mail-template:list
php artisan notify:mail-template:create
php artisan notify:mail-template:update
php artisan notify:mail-template:delete

# Utilità
php artisan notify:mail-template:export
php artisan notify:mail-template:import
php artisan notify:mail-template:test
```

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor WYSIWYG
   - [x] Supporto multilingua

2. **Fase 2 - Avanzato**
   - [ ] A/B Testing
   - [ ] Analytics avanzate
   - [ ] Template condizionali

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni esterne

## Troubleshooting

### Problemi Comuni

1. **Template non trovato**
   - Verificare mailable class
   - Controllare locale
   - Verificare is_active

2. **Variabili non renderizzate**
   - Controllare sintassi
   - Verificare escape
   - Debug dati passati

3. **Performance**
   - Ottimizzare query
   - Implementare cache
   - Monitorare tempi

## Collegamenti
- [Notify Module](../README.md)
- [Notify Module](../readme.md)
- [Email Templates](email-templates.md)
- [Email Templates](../../email-templates.md)
- [Mail Queue](mail-queue.md)

## Vedi Anche
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
---

## database-mail-system

*Consolidated from: `database-mail-system.md`*


## Panoramica

Implementazione personalizzata di un sistema di gestione email basato su database per il progetto, ispirato a Spatie/laravel-database-mail-templates ma con funzionalità aggiuntive e integrazione completa con il nostro ecosistema.

## Caratteristiche Principali

- Template email memorizzati nel database
- Supporto multilingua
- Editor WYSIWYG integrato con Filament
- Sistema di placeholder avanzato
- Versionamento dei template
- Preview in tempo reale
- Test di invio
- Statistiche di apertura/click
- Integrazione con il sistema di code
- Supporto per allegati dinamici
- Gestione layout personalizzati
- Backup automatico dei template

## Struttura Database

```php
// Template Email
Schema::create('notify_mail_templates', function (Blueprint $table) {
    $table->id();
    $table->string('mailable'); // Classe Mailable associata
    $table->string('name');     // Nome template
    $table->string('locale');   // Lingua (it, en, etc.)
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->json('variables')->nullable(); // Variabili disponibili
    $table->json('layout')->nullable();    // Layout personalizzato
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// Versioni Template
Schema::create('notify_mail_template_versions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->string('created_by');
    $table->text('change_notes')->nullable();
    $table->timestamps();
});

// Statistiche Invio
Schema::create('notify_mail_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->string('email');
    $table->timestamp('sent_at');
    $table->timestamp('opened_at')->nullable();
    $table->json('clicked_links')->nullable();
    $table->string('status'); // sent, delivered, opened, clicked, bounced
    $table->json('metadata')->nullable();
});
```

## Componenti del Sistema

### 1. Template Manager

```php
namespace Modules\Notify\Services;

class MailTemplateManager
{
    public function getTemplate(string $mailable, string $locale = null): ?MailTemplate
    {
        $locale = $locale ?? app()->getLocale();
        return MailTemplate::where('mailable', $mailable)
            ->where('locale', $locale)
            ->where('is_active', true)
            ->first();
    }

    public function renderTemplate(MailTemplate $template, array $data): string
    {
        // Rendering con Blade + gestione placeholder
        return view()
            ->make('notify::mail.template', [
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $data
            ])
            ->render();
    }
}
```

### 2. Trait per Mailables

```php
namespace Modules\Notify\Traits;

trait UseDatabaseTemplate
{
    public function build()
    {
        $template = app(MailTemplateManager::class)
            ->getTemplate(static::class);

        if (!$template) {
            return parent::build();
        }

        return $this->view('notify::mail.template')
            ->with([
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $this->data
            ]);
    }
}
```

### 3. Filament Resource

```php
namespace Modules\Notify\Filament\Resources;

class MailTemplateResource extends XotBaseResource
{
    protected static ?string $model = MailTemplate::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('mailable')
                    ->options(static::getMailableClasses())
                    ->required(),
                Select::make('locale')
                    ->options(static::getAvailableLocales())
                    ->required(),
                RichEditor::make('html_template')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'orderedList',
                        'unorderedList',
                        'h2',
                        'h3',
                    ]),
                Toggle::make('is_active')
                    ->default(true),
            ])
        ]);
    }
}
```

## Utilizzo

### 1. Creazione Template

```php
use Modules\Notify\Models\MailTemplate;

MailTemplate::create([
    'mailable' => WelcomeEmail::class,
    'name' => 'Welcome Email',
    'locale' => 'it',
    'html_template' => '<h1>Benvenuto {{ $user->name }}!</h1>',
    'variables' => ['user' => 'App\Models\User'],
]);
```

### 2. Utilizzo in Mailable

```php
use Modules\Notify\Traits\UseDatabaseTemplate;

class WelcomeEmail extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public User $user)
    {
        //
    }
}
```

### 3. Invio Email

```php
Mail::to($user)->send(new WelcomeEmail($user));
```

## Best Practices

1. **Versionamento Template**
   - Mantenere storico modifiche
   - Possibilità di rollback
   - Note di cambiamento

2. **Testing**
   - Test automatici per rendering
   - Validazione variabili
   - Preview multi-device

3. **Performance**
   - Cache dei template
   - Ottimizzazione query
   - Code per invio massivo

4. **Sicurezza**
   - Sanitizzazione input
   - Escape variabili
   - Protezione XSS

## Integrazione con Altri Moduli

### 1. Module Patient
```php
// Esempio notifica appuntamento
class AppointmentReminder extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Appointment $appointment)
    {
        //
    }
}
```

### 2. Module Dental
```php
// Esempio notifica trattamento
class TreatmentComplete extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Treatment $treatment)
    {
        //
    }
}
```

## Comandi Artisan

```bash

# Gestione template
php artisan notify:mail-template:list
php artisan notify:mail-template:create
php artisan notify:mail-template:update
php artisan notify:mail-template:delete

# Utilità
php artisan notify:mail-template:export
php artisan notify:mail-template:import
php artisan notify:mail-template:test
```

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor WYSIWYG
   - [x] Supporto multilingua

2. **Fase 2 - Avanzato**
   - [ ] A/B Testing
   - [ ] Analytics avanzate
   - [ ] Template condizionali

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni esterne

## Troubleshooting

### Problemi Comuni

1. **Template non trovato**
   - Verificare mailable class
   - Controllare locale
   - Verificare is_active

2. **Variabili non renderizzate**
   - Controllare sintassi
   - Verificare escape
   - Debug dati passati

3. **Performance**
   - Ottimizzare query
   - Implementare cache
   - Monitorare tempi

## Collegamenti
- [Notify Module](../readme.md)
- [Email Templates](email-templates.md)
- [Email Templates](../../email-templates.md)
- [Mail Queue](mail-queue.md)

## Vedi Anche
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

---

## database-mail

*Consolidated from: `database-mail.md`*


## Regola sulle rotte

Il file `routes/web.php` del modulo Notify **deve rimanere vuoto**.
- Tutta la gestione backoffice avviene tramite Filament, che registra le proprie rotte internamente.
- Il frontoffice è gestito tramite Volt/Folio, che ha i propri controller/rotte.
- **Non vanno mai aggiunte rotte custom in questo file**: aggiungerle è un errore grave che rompe la separazione tra backoffice e frontoffice.

**Vedi anche:**
- [structure.md](structure.md#regola-sulle-rotte)
- [grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)
- [grapesjs-filament.md](../../grapesjs-filament.md#regola-sulle-rotte)

---

## Collegamenti correlati
- [Regola sulle rotte vuote in structure.md](structure.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in grapesjs-filament.md](../../grapesjs-filament.md#regola-sulle-rotte)

## Panoramica

Un sistema di gestione email basato su database che permette di:
- Memorizzare i template delle email nel database
- Gestire i template tramite interfaccia Filament
- Associare i template a eventi Laravel
- Supportare traduzioni multiple
- Utilizzare un editor WYSIWYG per la creazione dei template
- Gestire variabili dinamiche nei template
- Tracciare lo stato di invio delle email
- Personalizzare layout, branding e allegati
- Gestire log invii, errori e retry

---

## Analisi comparativa plugin & pacchetti

### Plugin/Packages studiati:
- **hugomyb/filament-error-mailer**: invio notifiche errori via mail, log errori, configurazione base.
- **vormkracht10/filament-mails**: gestione e preview email inviate, log, visualizzazione stato, nessun editor template.
- **visualbuilder/email-templates**: editor WYSIWYG per template email integrato in Filament, supporto variabili e preview, multi-lingua, open source.
- **martin-petricko/database-mail**: gestione template email da Filament, associazione eventi, preview, a pagamento.
- **spatie/laravel-database-mail-templates**: rendering mailables da template in DB, variabili, localizzazione, estendibile, no UI.
- **spatie/laravel-mailcoach-mailer**: driver per invio massivo/newsletter, log avanzato, gestione code.
- **soluzioni custom**: guide su logo, branding, allegati, log, fallback blade.

### Limiti delle soluzioni esistenti
- Nessuna soluzione open source integra **tutti** i seguenti aspetti:
  - UI moderna per editing/preview template
  - Supporto completo multi-lingua, variabili, layout personalizzati
  - Log invii dettagliato e gestione errori
  - Branding (logo, header/footer custom) e allegati
  - Associazione flessibile a eventi Laravel e supporto multi-tenant

---

## Proposta architetturale: Database Mail evoluto

### Obiettivi
- UI Filament moderna per CRUD, editing e preview template (base: visualbuilder/email-templates)
- Modello EmailTemplate esteso, compatibile con Spatie (variabili, localizzazione, layout, allegati)
- Event Listener flessibili: trigger su eventi Laravel, selezione template, popolamento variabili, invio
- Rendering con Spatie/laravel-database-mail-templates (fallback blade)
- Log invii: tabella dedicata con stato, destinatario, errori, retry
- Branding: supporto logo, header/footer custom, allegati
- Multi-lingua e multi-tenant ready

### Componenti principali
- **Model**: `EmailTemplate` (estende Spatie\MailTemplate)
- **Filament Resource**: CRUD, editor WYSIWYG, gestione variabili, preview, localizzazione
- **Event Listener**: intercetta eventi, seleziona template, popola variabili, invia email
- **Mailer**: rendering Spatie, fallback blade, gestione allegati
- **Log**: tabella `email_logs` per tracciamento invii, stato, errori
- **Branding**: personalizzazione header/footer/logo via configurazione o editor

### Esempio di flusso
```php
// Listener generico
Event::listen(UserRegistered::class, function ($event) {
    $template = EmailTemplate::active()->forEvent('user_registered')->first();
    if ($template) {
        $template->send([
            'user' => $event->user,
            // altre variabili...
        ]);
    }
});
```

---

## Vantaggi rispetto ai plugin esistenti
- **Open source e componibile**: nessun vendor lock-in, massima estendibilità
- **UI moderna**: editor visuale, preview, gestione variabili e lingue
- **Log avanzato**: stato invio, errori, retry, storico
- **Branding e allegati**: logo, header/footer, allegati integrati
- **Flessibilità eventi**: trigger su qualunque evento Laravel, multi-tenant ready

---

## Roadmap di implementazione
1. Integrare visualbuilder/email-templates come base UI Filament
2. Estendere EmailTemplate model per compatibilità Spatie e gestione variabili/allegati
3. Implementare Event Listener generici e configurabili
4. Aggiungere tabella e UI per log invii email
5. Gestire branding (logo, header, footer) e allegati
6. Scrivere test end-to-end e documentazione esempi
7. Allineare naming, localizzazione, best practice di sicurezza

---

## Link e riferimenti utili
- [visualbuilder/email-templates (GitHub)](https://github.com/visualbuilder/email-templates)
- [spatie/laravel-database-mail-templates (GitHub)](https://github.com/spatie/laravel-database-mail-templates)
- [filamentphp.com/plugins](https://filamentphp.com/plugins)
- [Guida logo email Laravel (Medium)](https://medium.com/@python-javascript-php-html-css/how-to-customize-laravel-email-templates-with-a-logo-3dc862fba8d0)
- [Esempi invio email Spatie](https://laraveldaily.com/code-examples/example/spatie-be/send-email)

---

**Questa architettura permette di avere un sistema di email transazionali robusto, moderno, estendibile e conforme alle best practice Laravel/Filament/Spatie.**

## Architettura

### Models

```php
class EmailTemplate extends Model
{
    use HasTranslations;
    
    protected $fillable = [
        'name',
        'description', 
        'event',
        'subject',
        'body',
        'layout',
        'variables',
        'is_active',
        'delay',
        'cc',
        'bcc'
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
        'delay' => 'integer'
    ];

    public $translatable = [
        'subject',
        'body'
    ];
}

class EmailLog extends Model 
{
    protected $fillable = [
        'template_id',
        'event',
        'recipient',
        'subject',
        'body',
        'variables',
        'status',
        'error',
        'sent_at'
    ];

    protected $casts = [
        'variables' => 'array',
        'sent_at' => 'datetime'
    ];
}
```

### Filament Resources

```php
class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required(),
                    
                Select::make('event')
                    ->options(EventRegistry::getEvents())
                    ->required(),
                    
                TinyMCE::make('body')
                    ->toolbarButtons([
                        'bold', 'italic', 'link', 
                        'bulletList', 'orderedList',
                        'table', 'image'
                    ])
                    ->fileAttachments()
                    ->required(),
                    
                KeyValue::make('variables')
                    ->keyLabel('Variable')
                    ->valueLabel('Description')
                    ->reorderable(),
                    
                Toggle::make('is_active'),
                
                TextInput::make('delay')
                    ->numeric()
                    ->suffix('minutes'),
                    
                TagsInput::make('cc'),
                TagsInput::make('bcc')
            ])
        ]);
    }
}
```

### Services

```php
class EmailService
{
    public function __construct(
        private EventRegistry $events,
        private TemplateRenderer $renderer,
        private MailQueue $queue
    ) {}

    public function sendMail(string $event, array $data = []): void
    {
        $template = EmailTemplate::where('event', $event)
            ->where('is_active', true)
            ->first();
            
        if (!$template) {
            return;
        }
        
        $variables = $this->events->getVariables($event, $data);
        
        $mail = new TemplateMail(
            $template,
            $variables
        );
        
        if ($template->delay) {
            $this->queue->later(
                $mail,
                now()->addMinutes($template->delay)
            );
        } else {
            $this->queue->send($mail);
        }
    }
}

class TemplateRenderer
{
    public function render(EmailTemplate $template, array $variables): string
    {
        return Blade::render(
            $template->body,
            $variables
        );
    }
}
```

### Events

```php
class EventRegistry
{
    protected array $events = [];
    
    public function register(string $event, array $variables = []): void
    {
        $this->events[$event] = $variables;
    }
    
    public function getEvents(): array
    {
        return array_keys($this->events);
    }
    
    public function getVariables(string $event, array $data): array
    {
        $variables = $this->events[$event] ?? [];
        
        return collect($variables)
            ->mapWithKeys(fn ($var) => [
                $var => data_get($data, $var)
            ])
            ->toArray();
    }
}
```

### Mailable

```php
class TemplateMail extends Mailable
{
    public function __construct(
        private EmailTemplate $template,
        private array $variables
    ) {}
    
    public function build()
    {
        return $this
            ->subject($this->template->subject)
            ->cc($this->template->cc)
            ->bcc($this->template->bcc)
            ->html(
                app(TemplateRenderer::class)->render(
                    $this->template,
                    $this->variables
                )
            );
    }
}
```

## Utilizzo

### Registrazione Eventi

```php
// AppServiceProvider
public function boot()
{
    app(EventRegistry::class)->register(
        'DoctorRegistrationApproved',
        [
            'doctor.name',
            'doctor.email',
            'approval_date',
            'approval_notes'
        ]
    );
}
```

### Invio Email

```php
class ProcessDoctorModerationAction
{
    public function __construct(
        private EmailService $emailService
    ) {}
    
    public function execute(Doctor $doctor, bool $approved): void
    {
        if ($approved) {
            $this->emailService->sendMail(
                'DoctorRegistrationApproved',
                [
                    'doctor' => $doctor,
                    'approval_date' => now(),
                    'approval_notes' => 'Congratulazioni!'
                ]
            );
        }
    }
}
```

### Template Example

```html
<x-mail::message>

# Registrazione Approvata

Gentile {{ $doctor->name }},

La sua registrazione è stata approvata in data {{ $approval_date->format('d/m/Y') }}.

{{ $approval_notes }}

<x-mail::button :url="$url">
Accedi al Portale
</x-mail::button>

Cordiali saluti,<br>
{{ config('app.name') }}
</x-mail::message>
```

## Miglioramenti Rispetto a Database Mail

1. **Traduzioni Native**
   - Supporto per traduzioni multiple dei template
   - Interfaccia di gestione traduzioni integrata
   - Fallback automatico alla lingua di default

2. **Editor Avanzato**
   - TinyMCE con supporto per immagini e file
   - Preview in tempo reale
   - Validazione HTML
   - Supporto per template Markdown

3. **Gestione Eventi**
   - Registry centralizzato degli eventi
   - Validazione automatica delle variabili
   - Documentazione automatica delle variabili disponibili

4. **Logging e Monitoring**
   - Log dettagliato di ogni email inviata
   - Tracciamento dello stato di invio
   - Gestione errori e retry
   - Dashboard di monitoraggio

5. **Performance**
   - Caching dei template compilati
   - Code di invio ottimizzate
   - Batch sending per invii massivi

6. **Sicurezza**
   - Validazione input
   - Sanitizzazione HTML
   - Rate limiting
   - Protezione da spam

## Vedi Anche

- [Laravel Mail](https://laravel.com/docs/mail)
- [Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [TinyMCE](https://www.tiny.cloud)
- [Filament Forms](https://filamentphp.com/docs/forms)

---

## database_mail

*Consolidated from: `database_mail.md`*


## Regola sulle rotte

Il file `routes/web.php` del modulo Notify **deve rimanere vuoto**.
- Tutta la gestione backoffice avviene tramite Filament, che registra le proprie rotte internamente.
- Il frontoffice è gestito tramite Volt/Folio, che ha i propri controller/rotte.
- **Non vanno mai aggiunte rotte custom in questo file**: aggiungerle è un errore grave che rompe la separazione tra backoffice e frontoffice.

**Vedi anche:**
- [structure.md](structure.md#regola-sulle-rotte)
- [grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)
- [grapesjs-filament.md](../../grapesjs-filament.md#regola-sulle-rotte)

---

## Collegamenti correlati
- [Regola sulle rotte vuote in structure.md](structure.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in grapesjs-filament.md](../../grapesjs-filament.md#regola-sulle-rotte)

## Panoramica

Un sistema di gestione email basato su database che permette di:
- Memorizzare i template delle email nel database
- Gestire i template tramite interfaccia Filament
- Associare i template a eventi Laravel
- Supportare traduzioni multiple
- Utilizzare un editor WYSIWYG per la creazione dei template
- Gestire variabili dinamiche nei template
- Tracciare lo stato di invio delle email
- Personalizzare layout, branding e allegati
- Gestire log invii, errori e retry

---

## Analisi comparativa plugin & pacchetti

### Plugin/Packages studiati:
- **hugomyb/filament-error-mailer**: invio notifiche errori via mail, log errori, configurazione base.
- **vormkracht10/filament-mails**: gestione e preview email inviate, log, visualizzazione stato, nessun editor template.
- **visualbuilder/email-templates**: editor WYSIWYG per template email integrato in Filament, supporto variabili e preview, multi-lingua, open source.
- **martin-petricko/database-mail**: gestione template email da Filament, associazione eventi, preview, a pagamento.
- **spatie/laravel-database-mail-templates**: rendering mailables da template in DB, variabili, localizzazione, estendibile, no UI.
- **spatie/laravel-mailcoach-mailer**: driver per invio massivo/newsletter, log avanzato, gestione code.
- **soluzioni custom**: guide su logo, branding, allegati, log, fallback blade.

### Limiti delle soluzioni esistenti
- Nessuna soluzione open source integra **tutti** i seguenti aspetti:
  - UI moderna per editing/preview template
  - Supporto completo multi-lingua, variabili, layout personalizzati
  - Log invii dettagliato e gestione errori
  - Branding (logo, header/footer custom) e allegati
  - Associazione flessibile a eventi Laravel e supporto multi-tenant

---

## Proposta architetturale: Database Mail evoluto

### Obiettivi
- UI Filament moderna per CRUD, editing e preview template (base: visualbuilder/email-templates)
- Modello EmailTemplate esteso, compatibile con Spatie (variabili, localizzazione, layout, allegati)
- Event Listener flessibili: trigger su eventi Laravel, selezione template, popolamento variabili, invio
- Rendering con Spatie/laravel-database-mail-templates (fallback blade)
- Log invii: tabella dedicata con stato, destinatario, errori, retry
- Branding: supporto logo, header/footer custom, allegati
- Multi-lingua e multi-tenant ready

### Componenti principali
- **Model**: `EmailTemplate` (estende Spatie\MailTemplate)
- **Filament Resource**: CRUD, editor WYSIWYG, gestione variabili, preview, localizzazione
- **Event Listener**: intercetta eventi, seleziona template, popola variabili, invia email
- **Mailer**: rendering Spatie, fallback blade, gestione allegati
- **Log**: tabella `email_logs` per tracciamento invii, stato, errori
- **Branding**: personalizzazione header/footer/logo via configurazione o editor

### Esempio di flusso
```php
// Listener generico
Event::listen(UserRegistered::class, function ($event) {
    $template = EmailTemplate::active()->forEvent('user_registered')->first();
    if ($template) {
        $template->send([
            'user' => $event->user,
            // altre variabili...
        ]);
    }
});
```

---

## Vantaggi rispetto ai plugin esistenti
- **Open source e componibile**: nessun vendor lock-in, massima estendibilità
- **UI moderna**: editor visuale, preview, gestione variabili e lingue
- **Log avanzato**: stato invio, errori, retry, storico
- **Branding e allegati**: logo, header/footer, allegati integrati
- **Flessibilità eventi**: trigger su qualunque evento Laravel, multi-tenant ready

---

## Roadmap di implementazione
1. Integrare visualbuilder/email-templates come base UI Filament
2. Estendere EmailTemplate model per compatibilità Spatie e gestione variabili/allegati
3. Implementare Event Listener generici e configurabili
4. Aggiungere tabella e UI per log invii email
5. Gestire branding (logo, header, footer) e allegati
6. Scrivere test end-to-end e documentazione esempi
7. Allineare naming, localizzazione, best practice di sicurezza

---

## Link e riferimenti utili
- [visualbuilder/email-templates (GitHub)](https://github.com/visualbuilder/email-templates)
- [spatie/laravel-database-mail-templates (GitHub)](https://github.com/spatie/laravel-database-mail-templates)
- [filamentphp.com/plugins](https://filamentphp.com/plugins)
- [Guida logo email Laravel (Medium)](https://medium.com/@python-javascript-php-html-css/how-to-customize-laravel-email-templates-with-a-logo-3dc862fba8d0)
- [Esempi invio email Spatie](https://laraveldaily.com/code-examples/example/spatie-be/send-email)

---

**Questa architettura permette di avere un sistema di email transazionali robusto, moderno, estendibile e conforme alle best practice Laravel/Filament/Spatie.**

## Architettura

### Models

```php
class EmailTemplate extends Model
{
    use HasTranslations;
    
    protected $fillable = [
        'name',
        'description', 
        'event',
        'subject',
        'body',
        'layout',
        'variables',
        'is_active',
        'delay',
        'cc',
        'bcc'
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
        'delay' => 'integer'
    ];

    public $translatable = [
        'subject',
        'body'
    ];
}

class EmailLog extends Model 
{
    protected $fillable = [
        'template_id',
        'event',
        'recipient',
        'subject',
        'body',
        'variables',
        'status',
        'error',
        'sent_at'
    ];

    protected $casts = [
        'variables' => 'array',
        'sent_at' => 'datetime'
    ];
}
```

### Filament Resources

```php
class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required(),
                    
                Select::make('event')
                    ->options(EventRegistry::getEvents())
                    ->required(),
                    
                TinyMCE::make('body')
                    ->toolbarButtons([
                        'bold', 'italic', 'link', 
                        'bulletList', 'orderedList',
                        'table', 'image'
                    ])
                    ->fileAttachments()
                    ->required(),
                    
                KeyValue::make('variables')
                    ->keyLabel('Variable')
                    ->valueLabel('Description')
                    ->reorderable(),
                    
                Toggle::make('is_active'),
                
                TextInput::make('delay')
                    ->numeric()
                    ->suffix('minutes'),
                    
                TagsInput::make('cc'),
                TagsInput::make('bcc')
            ])
        ]);
    }
}
```

### Services

```php
class EmailService
{
    public function __construct(
        private EventRegistry $events,
        private TemplateRenderer $renderer,
        private MailQueue $queue
    ) {}

    public function sendMail(string $event, array $data = []): void
    {
        $template = EmailTemplate::where('event', $event)
            ->where('is_active', true)
            ->first();
            
        if (!$template) {
            return;
        }
        
        $variables = $this->events->getVariables($event, $data);
        
        $mail = new TemplateMail(
            $template,
            $variables
        );
        
        if ($template->delay) {
            $this->queue->later(
                $mail,
                now()->addMinutes($template->delay)
            );
        } else {
            $this->queue->send($mail);
        }
    }
}

class TemplateRenderer
{
    public function render(EmailTemplate $template, array $variables): string
    {
        return Blade::render(
            $template->body,
            $variables
        );
    }
}
```

### Events

```php
class EventRegistry
{
    protected array $events = [];
    
    public function register(string $event, array $variables = []): void
    {
        $this->events[$event] = $variables;
    }
    
    public function getEvents(): array
    {
        return array_keys($this->events);
    }
    
    public function getVariables(string $event, array $data): array
    {
        $variables = $this->events[$event] ?? [];
        
        return collect($variables)
            ->mapWithKeys(fn ($var) => [
                $var => data_get($data, $var)
            ])
            ->toArray();
    }
}
```

### Mailable

```php
class TemplateMail extends Mailable
{
    public function __construct(
        private EmailTemplate $template,
        private array $variables
    ) {}
    
    public function build()
    {
        return $this
            ->subject($this->template->subject)
            ->cc($this->template->cc)
            ->bcc($this->template->bcc)
            ->html(
                app(TemplateRenderer::class)->render(
                    $this->template,
                    $this->variables
                )
            );
    }
}
```

## Utilizzo

### Registrazione Eventi

```php
// AppServiceProvider
public function boot()
{
    app(EventRegistry::class)->register(
        'DoctorRegistrationApproved',
        [
            'doctor.name',
            'doctor.email',
            'approval_date',
            'approval_notes'
        ]
    );
}
```

### Invio Email

```php
class ProcessDoctorModerationAction
{
    public function __construct(
        private EmailService $emailService
    ) {}
    
    public function execute(Doctor $doctor, bool $approved): void
    {
        if ($approved) {
            $this->emailService->sendMail(
                'DoctorRegistrationApproved',
                [
                    'doctor' => $doctor,
                    'approval_date' => now(),
                    'approval_notes' => 'Congratulazioni!'
                ]
            );
        }
    }
}
```

### Template Example

```html
<x-mail::message>
# Registrazione Approvata

Gentile {{ $doctor->name }},

La sua registrazione è stata approvata in data {{ $approval_date->format('d/m/Y') }}.

{{ $approval_notes }}

<x-mail::button :url="$url">
Accedi al Portale
</x-mail::button>

Cordiali saluti,<br>
{{ config('app.name') }}
</x-mail::message>
```

## Miglioramenti Rispetto a Database Mail

1. **Traduzioni Native**
   - Supporto per traduzioni multiple dei template
   - Interfaccia di gestione traduzioni integrata
   - Fallback automatico alla lingua di default

2. **Editor Avanzato**
   - TinyMCE con supporto per immagini e file
   - Preview in tempo reale
   - Validazione HTML
   - Supporto per template Markdown

3. **Gestione Eventi**
   - Registry centralizzato degli eventi
   - Validazione automatica delle variabili
   - Documentazione automatica delle variabili disponibili

4. **Logging e Monitoring**
   - Log dettagliato di ogni email inviata
   - Tracciamento dello stato di invio
   - Gestione errori e retry
   - Dashboard di monitoraggio

5. **Performance**
   - Caching dei template compilati
   - Code di invio ottimizzate
   - Batch sending per invii massivi

6. **Sicurezza**
   - Validazione input
   - Sanitizzazione HTML
   - Rate limiting
   - Protezione da spam

## Vedi Anche

- [Laravel Mail](https://laravel.com/docs/mail)
- [Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [TinyMCE](https://www.tiny.cloud)
- [Filament Forms](https://filamentphp.com/docs/forms)

---

## database_mail_enhancement

*Consolidated from: `database_mail_enhancement.md`*


Questo documento descrive un approccio in-house per la gestione e l'invio di email da database, ispirato al plugin a pagamento `martin-petricko-database-mail` per Filament e alle soluzioni open source di Spatie.

## Analisi del plugin commerciale

- **martin-petricko-database-mail** fornisce UI Filament per definire template email nel DB
- Supporto per variabili dinamiche, anteprima, versioning
- Integrazione con invio mail, ma è un pacchetto a pagamento

## Obiettivi della nostra versione

1. Gestire template email nel DB con interfaccia Filament
2. Utilizzare soluzioni gratuite e open source
3. Supportare variabili dinamiche, anteprima, versioning
4. Invio tramite queue e log delle attività
5. Facile estensione e manutenzione

## Pacchetti Open Source

- **spatie/laravel-database-mail-templates**: gestione template in DB, parsing markdown
- **spatie/laravel-mailcoach-mailer**: invio massivo e transazionale con Mailcoach
- **spatie/laravel-queueable-action**: action queueable per logica di invio
- **spatie/laravel-model-states**: gestione stato dei messaggi (draft, sent, failed)

## Architettura proposta

1. **Database**: tabella `email_templates` (id, name, subject, body, variables)
2. **Modello**: `EmailTemplate` casted con ModelStates per `status`
3. **Filament Resource**: gestione CRUD di template con anteprima live (MarkdownEditor)
4. **Action**: `SendEmailTemplateAction` queueable che:
   - carica il template
   - sostituisce variabili dinamiche
   - invia con Mailable o MailcoachMailer
   - aggiorna stato e log
5. **Job / Queue**: invio asincrono, retry, fallback su failure
6. **Log**: tabella `email_logs` con destinatario, stato, template_id, errori

## Implementazione in sintesi

```php
// 1. Migrazione template
table->create('email_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('body');
    $table->json('variables')->nullable();
    $table->timestamps();
});

// 2. Model con ModelStates
class EmailTemplate extends Model {
    use HasStates;
    protected $casts = ['status' => EmailStatus::class];
}

// 3. Filament Resource
class EmailTemplateResource extends XotBaseResource {
    public static function form(Form $form): Form {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('subject')->required(),
            MarkdownEditor::make('body')->required(),
            KeyValue::make('variables'),
        ]);
    }
}

// 4. Action queueable
testable class SendEmailTemplateAction {
    use QueueableAction;
    public function execute(EmailTemplate $template, string $to, array $data = []): void {
        $content = $this->render($template->body, $data);
        Mail::to($to)->send(new GenericHtmlMail($template->subject, $content));
        $template->status->transitionTo(Sent::class);
    }
}
```

## Vantaggi

- Nessun costo licence
- Elevata personalizzazione e integrazione con Spatie
- Testabilità e scalabilità
- Allineato alle convenzioni di progetto

---

**Collegamenti**:

- [martin-petricko Database Mail](https://filamentphp.com/plugins/martin-petricko-database-mail)
- [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates)
- [spatie/laravel-mailcoach-mailer](https://github.com/spatie/laravel-mailcoach-mailer)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)

---

## database_mail_queue

*Consolidated from: `database_mail_queue.md`*


## Panoramica

Implementazione del sistema di code per l'invio di email in il progetto, con integrazione completa con il nostro sistema di template basato su database.

## Componenti

### 1. Job di Invio Email

```php
namespace Modules\Notify\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Services\MailTemplateManager;

class SendTemplatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Numero di tentativi massimi.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Timeout del job in secondi.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * Costruttore del job.
     *
     * @param string $to Email destinatario
     * @param string $mailable Classe mailable
     * @param array<string, mixed> $data Dati per il template
     * @param string|null $locale Lingua del template
     */
    public function __construct(
        protected string $to,
        protected string $mailable,
        protected array $data = [],
        protected ?string $locale = null
    ) {}

    /**
     * Esegue il job.
     */
    public function handle(MailTemplateManager $manager): void
    {
        $template = $manager->getTemplate($this->mailable, $this->locale);

        if (!$template) {
            throw new TemplateNotFoundException($this->mailable, $this->locale);
        }

        Mail::to($this->to)
            ->send(new DatabaseTemplateMailable($template, $this->data));

        // Traccia statistiche
        $this->trackMailStats($template);
    }

    /**
     * Gestisce il fallimento del job.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Email sending failed', [
            'to' => $this->to,
            'mailable' => $this->mailable,
            'exception' => $exception->getMessage(),
        ]);

        // Notifica amministratori
        Notification::route('slack', config('notify.error_channel'))
            ->notify(new FailedMailNotification($this->to, $this->mailable));
    }

    /**
     * Traccia le statistiche di invio.
     */
    protected function trackMailStats(MailTemplate $template): void
    {
        $template->stats()->create([
            'email' => $this->to,
            'sent_at' => now(),
            'status' => 'sent',
            'metadata' => [
                'locale' => $this->locale,
                'data_keys' => array_keys($this->data),
            ],
        ]);
    }
}
```

### 2. Configurazione Code

```php
// config/queue.php

return [
    'default' => env('QUEUE_CONNECTION', 'redis'),

    'connections' => [
        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
        ],
    ],

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],
];
```

### 3. Worker Manager

```php
namespace Modules\Notify\Services;

class QueueWorkerManager
{
    /**
     * Avvia i worker necessari.
     */
    public function startWorkers(): void
    {
        $workerCount = config('notify.queue.workers', 2);
        
        for ($i = 0; $i < $workerCount; $i++) {
            Process::run('php artisan queue:work --queue=emails --tries=3');
        }
    }

    /**
     * Monitora lo stato dei worker.
     */
    public function monitorWorkers(): array
    {
        return [
            'active_workers' => $this->getActiveWorkers(),
            'processed_jobs' => $this->getProcessedJobs(),
            'failed_jobs' => $this->getFailedJobs(),
        ];
    }
}
```

## Utilizzo

### 1. Accodamento Email

```php
// Invio singolo
SendTemplatedEmailJob::dispatch(
    'user@example.com',
    WelcomeEmail::class,
    ['user' => $user]
);

// Invio multiplo
$users->each(function ($user) {
    SendTemplatedEmailJob::dispatch(
        $user->email,
        WelcomeEmail::class,
        ['user' => $user]
    )->onQueue('emails');
});
```

### 2. Gestione Worker

```bash
# Avvia worker dedicato
php artisan queue:work --queue=emails

# Monitora code
php artisan queue:monitor

# Gestione failed jobs
php artisan queue:failed
php artisan queue:retry all
```

## Best Practices

### 1. Configurazione Code

```php
// Priorità code
'queues' => [
    'emails-high',    // Email critiche
    'emails-normal',  // Email standard
    'emails-bulk',    // Email massive
],

// Limiti rate
'throttle' => [
    'emails-high' => 100,  // 100/min
    'emails-normal' => 50, // 50/min
    'emails-bulk' => 10,   // 10/min
],
```

### 2. Monitoraggio

```php
// Prometheus metrics
$counter = Counter::create('emails_sent_total', 'Total emails sent')
    ->inc();

$histogram = Histogram::create('email_sending_duration_seconds', 'Time spent sending emails')
    ->observe($duration);
```

### 3. Retry Strategy

```php
public function backoff(): array
{
    return [
        10,  // 10 secondi
        30,  // 30 secondi
        60,  // 1 minuto
    ];
}

public function retryUntil(): \DateTime
{
    return now()->addHours(24);
}
```

## Gestione Errori

### 1. Logging

```php
Log::channel('mail')->error('Email sending failed', [
    'to' => $this->to,
    'template' => $this->template->id,
    'error' => $e->getMessage(),
    'trace' => $e->getTraceAsString(),
]);
```

### 2. Notifiche

```php
Notification::route('slack', config('notify.error_channel'))
    ->notify(new FailedMailNotification([
        'to' => $this->to,
        'error' => $e->getMessage(),
    ]));
```

### 3. Cleanup

```php
// Rimuovi job falliti vecchi
$this->call('queue:prune-failed', [
    '--hours' => 168 // 1 settimana
]);

// Rimuovi job completati
$this->call('queue:prune-batches', [
    '--hours' => 24
]);
```

## Scaling

### 1. Orizzontale

```bash
# Supervisor config
[program:<nome progetto>-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/_bases/base_<nome progetto>/laravel/artisan queue:work redis --queue=emails
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
```

### 2. Rate Limiting

```php
// Rate limiter per dominio
RateLimiter::for('mail-domain', function ($job) {
    return Limit::perMinute(100)->by($job->getDomain());
});

// Rate limiter globale
RateLimiter::for('mail-global', function () {
    return Limit::perMinute(1000);
});
```

### 3. Sharding

```php
// Distribuzione su multiple code
$queue = 'emails-' . ($user->id % 4); // 4 code

SendTemplatedEmailJob::dispatch($user->email, $template)
    ->onQueue($queue);
```

## Monitoraggio

### 1. Metriche

```php
// Prometheus metrics
$metrics = [
    'emails_sent_total' => [
        'type' => 'counter',
        'help' => 'Total emails sent',
    ],
    'email_sending_duration' => [
        'type' => 'histogram',
        'help' => 'Email sending duration',
    ],
    'failed_jobs_total' => [
        'type' => 'counter',
        'help' => 'Total failed jobs',
    ],
];
```

### 2. Dashboard

```php
// Horizon metrics
Horizon::metrics([
    'emails' => [
        'total' => fn() => MailStats::count(),
        'sent' => fn() => MailStats::sent()->count(),
        'failed' => fn() => MailStats::failed()->count(),
    ],
]);
```

### 3. Alerting

```php
// Alert su errori
if ($failedJobs > $threshold) {
    Alert::channel('slack')
        ->error("High email failure rate detected")
        ->send();
}
```

## Manutenzione

### 1. Pulizia

```bash
# Pulizia job vecchi
php artisan queue:prune-failed --hours=168
php artisan queue:prune-batches --hours=24

# Pulizia statistiche
php artisan notify:prune-mail-stats --days=30
```

### 2. Backup

```php
// Backup configurazione
php artisan backup:run --only-db --filename=queue_backup

// Backup failed jobs
php artisan queue:failed-table > failed_jobs_backup.sql
```

### 3. Ripristino

```php
// Ripristino job falliti
php artisan queue:retry all
php artisan queue:restart
```

## Collegamenti
- [Database Mail System](database-mail-system.md)
- [Database Mail System](../../database-mail-system.md)
- [Mail Templates](database-mail-templates.md)
- [Queue Configuration](../../../docs/queue-configuration.md)

## Vedi Anche
- [Laravel Queues](https://laravel.com/docs/queues)
- [Horizon Documentation](https://laravel.com/docs/horizon)
- [Redis Documentation](https://redis.io/documentation)

---

## database_mail_system

*Consolidated from: `database_mail_system.md`*


## Panoramica

Implementazione personalizzata di un sistema di gestione email basato su database per il progetto, ispirato a Spatie/laravel-database-mail-templates ma con funzionalità aggiuntive e integrazione completa con il nostro ecosistema.

## Caratteristiche Principali

- Template email memorizzati nel database
- Supporto multilingua
- Editor WYSIWYG integrato con Filament
- Sistema di placeholder avanzato
- Versionamento dei template
- Preview in tempo reale
- Test di invio
- Statistiche di apertura/click
- Integrazione con il sistema di code
- Supporto per allegati dinamici
- Gestione layout personalizzati
- Backup automatico dei template

## Struttura Database

```php
// Template Email
Schema::create('notify_mail_templates', function (Blueprint $table) {
    $table->id();
    $table->string('mailable'); // Classe Mailable associata
    $table->string('name');     // Nome template
    $table->string('locale');   // Lingua (it, en, etc.)
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->json('variables')->nullable(); // Variabili disponibili
    $table->json('layout')->nullable();    // Layout personalizzato
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

// Versioni Template
Schema::create('notify_mail_template_versions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->string('created_by');
    $table->text('change_notes')->nullable();
    $table->timestamps();
});

// Statistiche Invio
Schema::create('notify_mail_stats', function (Blueprint $table) {
    $table->id();
    $table->foreignId('template_id')->constrained('notify_mail_templates');
    $table->string('email');
    $table->timestamp('sent_at');
    $table->timestamp('opened_at')->nullable();
    $table->json('clicked_links')->nullable();
    $table->string('status'); // sent, delivered, opened, clicked, bounced
    $table->json('metadata')->nullable();
});
```

## Componenti del Sistema

### 1. Template Manager

```php
namespace Modules\Notify\Services;

class MailTemplateManager
{
    public function getTemplate(string $mailable, string $locale = null): ?MailTemplate
    {
        $locale = $locale ?? app()->getLocale();
        return MailTemplate::where('mailable', $mailable)
            ->where('locale', $locale)
            ->where('is_active', true)
            ->first();
    }

    public function renderTemplate(MailTemplate $template, array $data): string
    {
        // Rendering con Blade + gestione placeholder
        return view()
            ->make('notify::mail.template', [
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $data
            ])
            ->render();
    }
}
```

### 2. Trait per Mailables

```php
namespace Modules\Notify\Traits;

trait UseDatabaseTemplate
{
    public function build()
    {
        $template = app(MailTemplateManager::class)
            ->getTemplate(static::class);

        if (!$template) {
            return parent::build();
        }

        return $this->view('notify::mail.template')
            ->with([
                'content' => $template->html_template,
                'layout' => $template->layout,
                'data' => $this->data
            ]);
    }
}
```

### 3. Filament Resource

```php
namespace Modules\Notify\Filament\Resources;

class MailTemplateResource extends XotBaseResource
{
    protected static ?string $model = MailTemplate::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('mailable')
                    ->options(static::getMailableClasses())
                    ->required(),
                Select::make('locale')
                    ->options(static::getAvailableLocales())
                    ->required(),
                RichEditor::make('html_template')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'orderedList',
                        'unorderedList',
                        'h2',
                        'h3',
                    ]),
                Toggle::make('is_active')
                    ->default(true),
            ])
        ]);
    }
}
```

## Utilizzo

### 1. Creazione Template

```php
use Modules\Notify\Models\MailTemplate;

MailTemplate::create([
    'mailable' => WelcomeEmail::class,
    'name' => 'Welcome Email',
    'locale' => 'it',
    'html_template' => '<h1>Benvenuto {{ $user->name }}!</h1>',
    'variables' => ['user' => 'App\Models\User'],
]);
```

### 2. Utilizzo in Mailable

```php
use Modules\Notify\Traits\UseDatabaseTemplate;

class WelcomeEmail extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public User $user)
    {
        //
    }
}
```

### 3. Invio Email

```php
Mail::to($user)->send(new WelcomeEmail($user));
```

## Best Practices

1. **Versionamento Template**
   - Mantenere storico modifiche
   - Possibilità di rollback
   - Note di cambiamento

2. **Testing**
   - Test automatici per rendering
   - Validazione variabili
   - Preview multi-device

3. **Performance**
   - Cache dei template
   - Ottimizzazione query
   - Code per invio massivo

4. **Sicurezza**
   - Sanitizzazione input
   - Escape variabili
   - Protezione XSS

## Integrazione con Altri Moduli

### 1. Module Patient
```php
// Esempio notifica appuntamento
class AppointmentReminder extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Appointment $appointment)
    {
        //
    }
}
```

### 2. Module Dental
```php
// Esempio notifica trattamento
class TreatmentComplete extends Mailable
{
    use UseDatabaseTemplate;

    public function __construct(public Treatment $treatment)
    {
        //
    }
}
```

## Comandi Artisan

```bash
# Gestione template
php artisan notify:mail-template:list
php artisan notify:mail-template:create
php artisan notify:mail-template:update
php artisan notify:mail-template:delete

# Utilità
php artisan notify:mail-template:export
php artisan notify:mail-template:import
php artisan notify:mail-template:test
```

## Roadmap

1. **Fase 1 - Base**
   - [x] Template database
   - [x] Editor WYSIWYG
   - [x] Supporto multilingua

2. **Fase 2 - Avanzato**
   - [ ] A/B Testing
   - [ ] Analytics avanzate
   - [ ] Template condizionali

3. **Fase 3 - Enterprise**
   - [ ] API REST
   - [ ] Webhook
   - [ ] Integrazioni esterne

## Troubleshooting

### Problemi Comuni

1. **Template non trovato**
   - Verificare mailable class
   - Controllare locale
   - Verificare is_active

2. **Variabili non renderizzate**
   - Controllare sintassi
   - Verificare escape
   - Debug dati passati

3. **Performance**
   - Ottimizzare query
   - Implementare cache
   - Monitorare tempi

## Collegamenti
- [Notify Module](../README.md)
- [Email Templates](email-templates.md)
- [Email Templates](../../email-templates.md)
- [Mail Queue](mail-queue.md)

## Vedi Anche
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
