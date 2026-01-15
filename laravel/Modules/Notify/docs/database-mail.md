# Database Mail System

## Regola sulle rotte

Il file `routes/web.php` del modulo Notify **deve rimanere vuoto**.
- Tutta la gestione backoffice avviene tramite Filament, che registra le proprie rotte internamente.
- Il frontoffice è gestito tramite Volt/Folio, che ha i propri controller/rotte.
- **Non vanno mai aggiunte rotte custom in questo file**: aggiungerle è un errore grave che rompe la separazione tra backoffice e frontoffice.

**Vedi anche:**
- [structure.md](structure.md#regola-sulle-rotte)
- [grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)

---

## Collegamenti correlati
- [Regola sulle rotte vuote in structure.md](structure.md#regola-sulle-rotte)
- [Regola sulle rotte vuote in grapesjs-filament.md](grapesjs-filament.md#regola-sulle-rotte)

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
