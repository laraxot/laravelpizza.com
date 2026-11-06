---
qmd: "spatie consolidated"
issues: []
discussions: []
title: "spatie: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# spatie: Consolidated Documentation

Consolidated from **8** individual files.

## Table of Contents

- [---](#spatie-email-slug-proposal-1)
- [Proposta: Aggiunta Slug a SpatieEmail e MailTemplate](#spatie-email-slug-proposal)
- [---](#spatie-email-usage-guide-1)
- [Guida all'utilizzo di SpatieEmail](#spatie-email-usage-guide)
- [Guida all'utilizzo di SpatieEmail](#spatie-email-usage)
- [Integrazione Spatie Translatable nel Modulo Notify](#spatie-translatable-integration)
- [Proposta: Aggiunta Slug a SpatieEmail e MailTemplate](#spatie_email_slug_proposal)
- [Guida all'utilizzo di SpatieEmail](#spatie_email_usage_guide)

---

## spatie-email-slug-proposal-1

*Consolidated from: `spatie-email-slug-proposal.md`*

title: "Proposta: Aggiunta Slug a SpatieEmail e MailTemplate"
type: concept
tags: [spatie, email, slug, proposal]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-email-slug-proposal-1 proposta: aggiunta slug a spatieemail e mailtemplate"
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

# Proposta: Aggiunta Slug a SpatieEmail e MailTemplate

## Introduzione

Questa proposta analizza l'aggiunta di un parametro `slug` al sistema di template email basato su Spatie, per migliorare l'identificazione e la gestione dei template.

## Struttura delle Migrazioni

Il progetto utilizza una struttura standardizzata per le migrazioni basata su `XotBaseMigration`. Le modifiche alle tabelle devono essere implementate nella sezione `tableUpdate` della migrazione originale, non creando nuove migrazioni.

### Esempio di Implementazione Corretta

```php
$this->tableUpdate(
    function (Blueprint $table): void {
        if (!$this->hasColumn('slug')) {
            $table->string('slug')->unique()->after('mailable');
        }
        // ... altri aggiornamenti
    }
);
```

### Best Practices per le Migrazioni

1. **Sempre Usare XotBaseMigration**
   - Estendere `XotBaseMigration` per tutte le migrazioni
   - Utilizzare i metodi helper forniti
   - Seguire la struttura standard

2. **Gestione degli Aggiornamenti**
   - Implementare modifiche nella sezione `tableUpdate`
   - Verificare l'esistenza delle colonne prima di modificarle
   - Utilizzare i metodi di controllo forniti

3. **Compatibilità**
   - Mantenere la retrocompatibilità
   - Gestire correttamente i rollback
   - Documentare le modifiche

## Analisi della Situazione Attuale

Attualmente, i template email sono identificati principalmente attraverso:
- La classe Mailable associata
- Il subject dell'email
- L'ID del record nel database

Questo approccio presenta alcune limitazioni:
1. Difficoltà nel riferimento programmatico ai template
2. Dipendenza dalla classe Mailable per l'identificazione
3. Possibili conflitti con subject simili
4. Complessità nella migrazione dei template

## Proposta di Modifica

### 1. Aggiunta Campo Slug

```php
// Aggiunta alla tabella mail_templates
$table->string('slug')->unique()->after('mailable');
```

### 2. Modifiche al Model MailTemplate

```php
class MailTemplate extends Model
{
    protected $fillable = [
        'mailable',
        'slug',  // Nuovo campo
        'subject',
        'html_template',
        'text_template',
        'version'
    ];

    // Validazione slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->subject);
            }
        });
    }
}
```

### 3. Modifiche a SpatieEmail

```php
class SpatieEmail extends Mailable
{
    protected $slug;

    public function __construct($notifiable, $slug = null)
    {
        $this->slug = $slug;
        // ... resto del codice
    }

    public function getTemplate()
    {
        if ($this->slug) {
            return MailTemplate::where('slug', $this->slug)->first();
        }
        // ... fallback al comportamento attuale
    }
}
```

## Vantaggi

1. **Identificazione Univoca**
   - Riferimento stabile e prevedibile ai template
   - Indipendenza dalla classe Mailable
   - Facilità di migrazione

2. **Migliore Gestione**
   - Ricerca semplificata dei template
   - Possibilità di versioning basato su slug
   - Migliore organizzazione dei template

3. **Flessibilità**
   - Possibilità di avere template multipli per la stessa classe Mailable
   - Facilità di override dei template
   - Migliore gestione delle traduzioni

4. **Manutenibilità**
   - Codice più pulito e leggibile
   - Riduzione della complessità
   - Migliore testabilità

## Svantaggi

1. **Complessità Aggiuntiva**
   - Nuovo campo da gestire
   - Necessità di migrazione dei dati esistenti
   - Possibili conflitti di slug

2. **Overhead Database**
   - Indice aggiuntivo sulla tabella
   - Leggero aumento della dimensione dei record

3. **Compatibilità**
   - Necessità di aggiornare il codice esistente
   - Possibili problemi di backward compatibility

## Implementazione Proposta

### 1. Migration

```php
public function up()
{
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->string('slug')->unique()->after('mailable');
    });

    // Popolamento slug per record esistenti
    DB::table('mail_templates')->get()->each(function ($template) {
        DB::table('mail_templates')
            ->where('id', $template->id)
            ->update(['slug' => Str::slug($template->subject)]);
    });
}
```

### 2. Aggiornamento Controller

```php
class MailTemplateController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mailable' => 'required',
            'slug' => 'required|unique:mail_templates',
            'subject' => 'required',
            // ... altri campi
        ]);

        return MailTemplate::create($validated);
    }
}
```

### 3. Esempio di Utilizzo

```php
// Invio email con slug specifico
Mail::to($user)->send(new SpatieEmail($user, 'welcome-email'));

// Invio email con slug generato automaticamente
Mail::to($user)->send(new SpatieEmail($user));
```

## Best Practices

1. **Naming Convention**
   - Utilizzare slug descrittivi e consistenti
   - Seguire il pattern `feature-name`
   - Evitare slug generici o ambigui

2. **Gestione Versioni**
   - Includere la versione nello slug se necessario
   - Mantenere uno storico delle versioni
   - Documentare i cambiamenti

3. **Validazione**
   - Verificare l'unicità dello slug
   - Sanitizzare lo slug prima del salvataggio
   - Gestire i casi di collisione

## Considerazioni sulla Migrazione

1. **Strategia**
   - Migrazione graduale
   - Supporto per entrambi i metodi di identificazione
   - Periodo di transizione

2. **Testing**
   - Test unitari per il nuovo campo
   - Test di integrazione
   - Test di performance

3. **Documentazione**
   - Aggiornamento della documentazione esistente
   - Esempi di utilizzo
   - Guida alla migrazione

## Conclusioni

L'aggiunta del parametro `slug` rappresenta un miglioramento significativo per:
- Identificazione univoca dei template
- Gestione più flessibile
- Migliore manutenibilità
- Facilità di migrazione

Nonostante i potenziali svantaggi, i benefici superano i costi di implementazione, rendendo questa modifica un'aggiunta valida al sistema.

## Collegamenti Correlati

- [Documentazione Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [Sistema di Template Email](./email-templates.md)
- [Email per i Dottori](./doctor-emails.md)
- [Sistema di Template Email](./email-templates.md)
- [Email per i Dottori](./doctor-emails.md)
- [Filament Resources](./filament-resources.md)
- [Sistema di Template Email](../../email-templates.md)
- [Email per i Dottori](../../doctor-emails.md)
- [Sistema di Template Email](../../email-templates.md)
- [Email per i Dottori](./doctor-emails.md)
- [Filament Resources](../../filament-resources.md)

## Implementazione Migrazione

### File: `2018_10_10_000002_create_mail_templates_table.php`

```php
$this->tableUpdate(
    function (Blueprint $table): void {
        if (!$this->hasColumn('slug')) {
            $table->string('slug')->unique()->after('mailable');
        }
        // ... altri aggiornamenti
    }
);
```

### Motivazioni della Scelta
1. **Struttura Standard**
   - Utilizzo di `XotBaseMigration`
   - Implementazione nella sezione `tableUpdate`
   - Verifica esistenza colonna

2. **Compatibilità**
   - Nessun impatto su dati esistenti
   - Mantenuta retrocompatibilità
   - Rollback supportato

3. **Manutenibilità**
   - Codice pulito e documentato
   - Facile da testare
   - Facile da estendere

// ... existing code ... 
---

## spatie-email-slug-proposal

*Consolidated from: `spatie-email-slug-proposal.md`*


## Introduzione

Questa proposta analizza l'aggiunta di un parametro `slug` al sistema di template email basato su Spatie, per migliorare l'identificazione e la gestione dei template.

## Struttura delle Migrazioni

Il progetto utilizza una struttura standardizzata per le migrazioni basata su `XotBaseMigration`. Le modifiche alle tabelle devono essere implementate nella sezione `tableUpdate` della migrazione originale, non creando nuove migrazioni.

### Esempio di Implementazione Corretta

```php
$this->tableUpdate(
    function (Blueprint $table): void {
        if (!$this->hasColumn('slug')) {
            $table->string('slug')->unique()->after('mailable');
        }
        // ... altri aggiornamenti
    }
);
```

### Best Practices per le Migrazioni

1. **Sempre Usare XotBaseMigration**
   - Estendere `XotBaseMigration` per tutte le migrazioni
   - Utilizzare i metodi helper forniti
   - Seguire la struttura standard

2. **Gestione degli Aggiornamenti**
   - Implementare modifiche nella sezione `tableUpdate`
   - Verificare l'esistenza delle colonne prima di modificarle
   - Utilizzare i metodi di controllo forniti

3. **Compatibilità**
   - Mantenere la retrocompatibilità
   - Gestire correttamente i rollback
   - Documentare le modifiche

## Analisi della Situazione Attuale

Attualmente, i template email sono identificati principalmente attraverso:
- La classe Mailable associata
- Il subject dell'email
- L'ID del record nel database

Questo approccio presenta alcune limitazioni:
1. Difficoltà nel riferimento programmatico ai template
2. Dipendenza dalla classe Mailable per l'identificazione
3. Possibili conflitti con subject simili
4. Complessità nella migrazione dei template

## Proposta di Modifica

### 1. Aggiunta Campo Slug

```php
// Aggiunta alla tabella mail_templates
$table->string('slug')->unique()->after('mailable');
```

### 2. Modifiche al Model MailTemplate

```php
class MailTemplate extends Model
{
    protected $fillable = [
        'mailable',
        'slug',  // Nuovo campo
        'subject',
        'html_template',
        'text_template',
        'version'
    ];

    // Validazione slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->subject);
            }
        });
    }
}
```

### 3. Modifiche a SpatieEmail

```php
class SpatieEmail extends Mailable
{
    protected $slug;

    public function __construct($notifiable, $slug = null)
    {
        $this->slug = $slug;
        // ... resto del codice
    }

    public function getTemplate()
    {
        if ($this->slug) {
            return MailTemplate::where('slug', $this->slug)->first();
        }
        // ... fallback al comportamento attuale
    }
}
```

## Vantaggi

1. **Identificazione Univoca**
   - Riferimento stabile e prevedibile ai template
   - Indipendenza dalla classe Mailable
   - Facilità di migrazione

2. **Migliore Gestione**
   - Ricerca semplificata dei template
   - Possibilità di versioning basato su slug
   - Migliore organizzazione dei template

3. **Flessibilità**
   - Possibilità di avere template multipli per la stessa classe Mailable
   - Facilità di override dei template
   - Migliore gestione delle traduzioni

4. **Manutenibilità**
   - Codice più pulito e leggibile
   - Riduzione della complessità
   - Migliore testabilità

## Svantaggi

1. **Complessità Aggiuntiva**
   - Nuovo campo da gestire
   - Necessità di migrazione dei dati esistenti
   - Possibili conflitti di slug

2. **Overhead Database**
   - Indice aggiuntivo sulla tabella
   - Leggero aumento della dimensione dei record

3. **Compatibilità**
   - Necessità di aggiornare il codice esistente
   - Possibili problemi di backward compatibility

## Implementazione Proposta

### 1. Migration

```php
public function up()
{
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->string('slug')->unique()->after('mailable');
    });

    // Popolamento slug per record esistenti
    DB::table('mail_templates')->get()->each(function ($template) {
        DB::table('mail_templates')
            ->where('id', $template->id)
            ->update(['slug' => Str::slug($template->subject)]);
    });
}
```

### 2. Aggiornamento Controller

```php
class MailTemplateController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mailable' => 'required',
            'slug' => 'required|unique:mail_templates',
            'subject' => 'required',
            // ... altri campi
        ]);

        return MailTemplate::create($validated);
    }
}
```

### 3. Esempio di Utilizzo

```php
// Invio email con slug specifico
Mail::to($user)->send(new SpatieEmail($user, 'welcome-email'));

// Invio email con slug generato automaticamente
Mail::to($user)->send(new SpatieEmail($user));
```

## Best Practices

1. **Naming Convention**
   - Utilizzare slug descrittivi e consistenti
   - Seguire il pattern `feature-name`
   - Evitare slug generici o ambigui

2. **Gestione Versioni**
   - Includere la versione nello slug se necessario
   - Mantenere uno storico delle versioni
   - Documentare i cambiamenti

3. **Validazione**
   - Verificare l'unicità dello slug
   - Sanitizzare lo slug prima del salvataggio
   - Gestire i casi di collisione

## Considerazioni sulla Migrazione

1. **Strategia**
   - Migrazione graduale
   - Supporto per entrambi i metodi di identificazione
   - Periodo di transizione

2. **Testing**
   - Test unitari per il nuovo campo
   - Test di integrazione
   - Test di performance

3. **Documentazione**
   - Aggiornamento della documentazione esistente
   - Esempi di utilizzo
   - Guida alla migrazione

## Conclusioni

L'aggiunta del parametro `slug` rappresenta un miglioramento significativo per:
- Identificazione univoca dei template
- Gestione più flessibile
- Migliore manutenibilità
- Facilità di migrazione

Nonostante i potenziali svantaggi, i benefici superano i costi di implementazione, rendendo questa modifica un'aggiunta valida al sistema.

## Collegamenti Correlati

- [Documentazione Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [Sistema di Template Email](./EMAIL_TEMPLATES.md)
- [Email per i Dottori](./DOCTOR_EMAILS.md)
- [Filament Resources](./filament-resources.md)
- [Sistema di Template Email](../../email_templates.md)
- [Email per i Dottori](../../doctor_emails.md)
- [Filament Resources](../../filament-resources.md)

## Implementazione Migrazione

### File: `2018_10_10_000002_create_mail_templates_table.php`

```php
$this->tableUpdate(
    function (Blueprint $table): void {
        if (!$this->hasColumn('slug')) {
            $table->string('slug')->unique()->after('mailable');
        }
        // ... altri aggiornamenti
    }
);
```

### Motivazioni della Scelta
1. **Struttura Standard**
   - Utilizzo di `XotBaseMigration`
   - Implementazione nella sezione `tableUpdate`
   - Verifica esistenza colonna

2. **Compatibilità**
   - Nessun impatto su dati esistenti
   - Mantenuta retrocompatibilità
   - Rollback supportato

3. **Manutenibilità**
   - Codice pulito e documentato
   - Facile da testare
   - Facile da estendere

// ... existing code ... 

---

## spatie-email-usage-guide-1

*Consolidated from: `spatie-email-usage-guide.md`*

title: "Guida all'utilizzo di SpatieEmail"
type: guide
tags: [spatie, email, usage, guide]
created: 2026-07-14
updated: 2026-07-14
qmd: "spatie-email-usage-guide-1 guida all'utilizzo di spatieemail"
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

# Guida all'utilizzo di SpatieEmail

## Introduzione

Questa guida illustra come utilizzare la classe `SpatieEmail` per inviare email personalizzate nel sistema, basandosi sul pacchetto `spatie/laravel-database-mail-templates`.

## Collegamenti correlati

- [README del modulo Notify](./README.md)
- [Documentazione Email Templates](./email-templates.md)
- [Email Specifiche per Dottori](./doctor-emails.md)
- [Implementazione Database Mail](./database-mail.md)
- [Documentazione Centrale](../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../Xot/docs/README.md)
- [Documentazione Email Templates](../../email-templates.md)
- [Email Specifiche per Dottori](../../doctor-emails.md)
- [Implementazione Database Mail](../../database-mail.md)
- [Documentazione Centrale](../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../../Xot/docs/README.md)

## Implementazione attuale

il sistema utilizza il pacchetto `spatie/laravel-database-mail-templates` per gestire i template delle email nel database. L'implementazione attuale include:

1. **MailTemplate Model**: Estende `SpatieMailTemplate` e implementa `HasTranslations` per supportare traduzioni multilingua
2. **Migration**: Tabella `mail_templates` con colonne JSON per contenuti traducibili
3. **MailTemplateResource**: Resource Filament per gestire i template nel pannello amministrativo
4. **SpatieEmail**: Classe base che utilizza `TemplateMailable` per inviare email basate su template

## Come funziona SpatieEmail

La classe `SpatieEmail` è progettata come un componente riutilizzabile per inviare diversi tipi di email utilizzando template memorizzati nel database. La classe:

```php
<?php
namespace Modules\Notify\Emails;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Spatie\MailTemplates\TemplateMailable;

class SpatieEmail extends TemplateMailable
{
    protected static $templateModelClass = MailTemplate::class;

    public function __construct(Model $record)
    {
        $data = $record->toArray();
        $this->setAdditionalData($data);
    }
    
    public function getHtmlLayout(): string
    {
        return '<header>Site name!</header>{{{ body }}}<footer>Copyright 2018</footer>';
    }
}
```

## Come utilizzare SpatieEmail per diversi tipi di email

### 1. Creare il template nel database

Prima di tutto, è necessario creare un template per ogni tipo di email nel database:

```php
use Modules\Notify\Models\MailTemplate;

// Email di benvenuto
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Benvenuto nella piattaforma, {{ first_name }}',
        'en' => 'Welcome to the application, {{ first_name }}'
    ],
    'html_template' => [
        'it' => '<p>Ciao {{ first_name }},</p><p>Grazie per esserti registrato nella piattaforma!</p>',
        'en' => '<p>Hello {{ first_name }},</p><p>Thank you for registering with the application!</p>'
    ],
    'text_template' => [
        'it' => 'Ciao {{ first_name }}, Grazie per esserti registrato nella piattaforma!',
        'en' => 'Hello {{ first_name }}, Thank you for registering with the application!'
    ]
]);

// Email per dottori (ripresa registrazione)
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Completa la tua registrazione, Dottor {{ last_name }}',
        'en' => 'Complete your registration, Dr. {{ last_name }}'
    ],
    'html_template' => [
        'it' => '<p>Gentile Dottor {{ last_name }},</p><p>La invitiamo a completare la sua registrazione sulla piattaforma cliccando sul seguente link: <a href="{{ registration_url }}">Completa Registrazione</a></p>',
        'en' => '<p>Dear Dr. {{ last_name }},</p><p>We invite you to complete your registration on the application by clicking the following link: <a href="{{ registration_url }}">Complete Registration</a></p>'
    ],
    'text_template' => [
        'it' => 'Gentile Dottor {{ last_name }}, La invitiamo a completare la sua registrazione sulla piattaforma: {{ registration_url }}',
        'en' => 'Dear Dr. {{ last_name }}, We invite you to complete your registration on the application: {{ registration_url }}'
    ]
]);
```

### 2. Inviare email specifiche

#### Email di benvenuto per nuovi utenti

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;

// In un controller o action
public function sendWelcomeEmail(User $user): void
{
    // Il sistema selezionerà automaticamente il template corretto basato sulla classe mailable
    Mail::to($user->email)
        ->locale(app()->getLocale()) // Importante: usa sempre LaravelLocalization::getCurrentLocale() in produzione
        ->send(new SpatieEmail($user));
}
```

#### Email di promemoria per i dottori

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Doctor\Models\Doctor;

// In una Queueable Action (approccio raccomandato)
public function handle(Doctor $doctor, string $registrationUrl): void
{
    // Arricchiamo il model con dati aggiuntivi per il template
    $doctor->setAttribute('registration_url', $registrationUrl);
    
    Mail::to($doctor->email)
        ->locale(LaravelLocalization::getCurrentLocale())
        ->send(new SpatieEmail($doctor));
}
```

## Best practices

1. **Utilizzo di Queueable Actions**: Seguendo le linee guida del progetto, implementare le logiche di invio email come azioni queueable:

```php
namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Spatie\QueueableAction\QueueableAction;

class SendTemplatedEmailAction
{
    use QueueableAction;

    public function execute(Model $record, string $email, string $locale = null): void
    {
        Mail::to($email)
            ->locale($locale ?? LaravelLocalization::getCurrentLocale())
            ->send(new SpatieEmail($record));
    }
}
```

2. **Layout HTML personalizzato**: Sovrascrivere il metodo `getHtmlLayout()` per utilizzare un layout HTML più sofisticato:

```php
public function getHtmlLayout(): string
{
    return view('notify::emails.layouts.main')->render();
}
```

3. **Differenziazione dei template**: Creare template specifici per ogni tipo di email, utilizzando il campo `mailable` per distinguerli.

## Esempi pratici di utilizzo

### Email di benvenuto post-registrazione

```php
namespace Modules\User\Actions;

use Modules\User\Models\User;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(User $user): void
    {
        $this->sendTemplatedEmailAction->execute($user, $user->email);
    }
}
```

### Email di promemoria per completamento registrazione dottore

```php
namespace Modules\Doctor\Actions;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendRegistrationReminderAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(Doctor $doctor): void
    {
        // Generare URL sicuro per completamento registrazione
        $registrationUrl = route(
            'doctor.registration.continue', 
            ['token' => $doctor->registration_token]
        );
        
        // Aggiungi dati temporanei al modello
        $doctor->setAttribute('registration_url', $registrationUrl);
        
        $this->sendTemplatedEmailAction->execute($doctor, $doctor->email);
    }
}
```

## Personalizzazione avanzata della classe SpatieEmail

Per necessità più complesse, è possibile estendere `SpatieEmail` per specifici casi d'uso:

```php
namespace Modules\Doctor\Emails;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Emails\SpatieEmail;

class DoctorRegistrationEmail extends SpatieEmail
{
    protected static string $templateName = 'doctor-registration';
    
    public function __construct(Doctor $doctor, string $registrationUrl)
    {
        $doctor->setAttribute('registration_url', $registrationUrl);
        parent::__construct($doctor);
    }
    
    // Override del layout per questo tipo specifico di email
    public function getHtmlLayout(): string
    {
        return view('doctor::emails.layouts.medical')->render();
    }
}
```

## Risoluzione problemi comuni

1. **Template non trovato**: Verificare che il template sia stato correttamente registrato nel database con il nome della classe mailable corretto.

2. **Variabili non disponibili nel template**: Assicurarsi che tutti i dati necessari siano presenti nel modello passato al costruttore o aggiunti tramite `setAdditionalData()`.

3. **Layout HTML non corretto**: Controllare che `{{{ body }}}` sia presente nel layout, altrimenti il contenuto dell'email non verrà inserito.

## Conclusione

L'utilizzo di `SpatieEmail` nel sistema permette di gestire in modo flessibile e centralizzato i template delle email, con supporto multilingua e personalizzazione avanzata. Seguendo le best practices e utilizzando le Queueable Actions, è possibile implementare un sistema di notifiche email robusto e manutenibile.
---

## spatie-email-usage-guide

*Consolidated from: `spatie-email-usage-guide.md`*


## Introduzione

Questa guida illustra come utilizzare la classe `SpatieEmail` per inviare email personalizzate nel sistema, basandosi sul pacchetto `spatie/laravel-database-mail-templates`.

## Collegamenti correlati

- [README del modulo Notify](./README.md)
- [Documentazione Email Templates](./EMAIL_TEMPLATES.md)
- [Email Specifiche per Dottori](./DOCTOR_EMAILS.md)
- [Implementazione Database Mail](./database-mail.md)
- [Documentazione Centrale](../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../Xot/docs/README.md)
- [Documentazione Email Templates](../../email_templates.md)
- [Email Specifiche per Dottori](../../doctor_emails.md)
- [Implementazione Database Mail](../../database-mail.md)
- [Documentazione Centrale](../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../../Xot/docs/README.md)

## Implementazione attuale

il sistema utilizza il pacchetto `spatie/laravel-database-mail-templates` per gestire i template delle email nel database. L'implementazione attuale include:

1. **MailTemplate Model**: Estende `SpatieMailTemplate` e implementa `HasTranslations` per supportare traduzioni multilingua
2. **Migration**: Tabella `mail_templates` con colonne JSON per contenuti traducibili
3. **MailTemplateResource**: Resource Filament per gestire i template nel pannello amministrativo
4. **SpatieEmail**: Classe base che utilizza `TemplateMailable` per inviare email basate su template

## Come funziona SpatieEmail

La classe `SpatieEmail` è progettata come un componente riutilizzabile per inviare diversi tipi di email utilizzando template memorizzati nel database. La classe:

```php
<?php
namespace Modules\Notify\Emails;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Spatie\MailTemplates\TemplateMailable;

class SpatieEmail extends TemplateMailable
{
    protected static $templateModelClass = MailTemplate::class;

    public function __construct(Model $record)
    {
        $data = $record->toArray();
        $this->setAdditionalData($data);
    }
    
    public function getHtmlLayout(): string
    {
        return '<header>Site name!</header>{{{ body }}}<footer>Copyright 2018</footer>';
    }
}
```

## Come utilizzare SpatieEmail per diversi tipi di email

### 1. Creare il template nel database

Prima di tutto, è necessario creare un template per ogni tipo di email nel database:

```php
use Modules\Notify\Models\MailTemplate;

// Email di benvenuto
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Benvenuto nella piattaforma, {{ first_name }}',
        'en' => 'Welcome to the application, {{ first_name }}'
    ],
    'html_template' => [
        'it' => '<p>Ciao {{ first_name }},</p><p>Grazie per esserti registrato nella piattaforma!</p>',
        'en' => '<p>Hello {{ first_name }},</p><p>Thank you for registering with the application!</p>'
    ],
    'text_template' => [
        'it' => 'Ciao {{ first_name }}, Grazie per esserti registrato nella piattaforma!',
        'en' => 'Hello {{ first_name }}, Thank you for registering with the application!'
    ]
]);

// Email per dottori (ripresa registrazione)
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Completa la tua registrazione, Dottor {{ last_name }}',
        'en' => 'Complete your registration, Dr. {{ last_name }}'
    ],
    'html_template' => [
        'it' => '<p>Gentile Dottor {{ last_name }},</p><p>La invitiamo a completare la sua registrazione sulla piattaforma cliccando sul seguente link: <a href="{{ registration_url }}">Completa Registrazione</a></p>',
        'en' => '<p>Dear Dr. {{ last_name }},</p><p>We invite you to complete your registration on the application by clicking the following link: <a href="{{ registration_url }}">Complete Registration</a></p>'
    ],
    'text_template' => [
        'it' => 'Gentile Dottor {{ last_name }}, La invitiamo a completare la sua registrazione sulla piattaforma: {{ registration_url }}',
        'en' => 'Dear Dr. {{ last_name }}, We invite you to complete your registration on the application: {{ registration_url }}'
    ]
]);
```

### 2. Inviare email specifiche

#### Email di benvenuto per nuovi utenti

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;

// In un controller o action
public function sendWelcomeEmail(User $user): void
{
    // Il sistema selezionerà automaticamente il template corretto basato sulla classe mailable
    Mail::to($user->email)
        ->locale(app()->getLocale()) // Importante: usa sempre LaravelLocalization::getCurrentLocale() in produzione
        ->send(new SpatieEmail($user));
}
```

#### Email di promemoria per i dottori

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Doctor\Models\Doctor;

// In una Queueable Action (approccio raccomandato)
public function handle(Doctor $doctor, string $registrationUrl): void
{
    // Arricchiamo il model con dati aggiuntivi per il template
    $doctor->setAttribute('registration_url', $registrationUrl);
    
    Mail::to($doctor->email)
        ->locale(LaravelLocalization::getCurrentLocale())
        ->send(new SpatieEmail($doctor));
}
```

## Best practices

1. **Utilizzo di Queueable Actions**: Seguendo le linee guida del progetto, implementare le logiche di invio email come azioni queueable:

```php
namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Spatie\QueueableAction\QueueableAction;

class SendTemplatedEmailAction
{
    use QueueableAction;

    public function execute(Model $record, string $email, string $locale = null): void
    {
        Mail::to($email)
            ->locale($locale ?? LaravelLocalization::getCurrentLocale())
            ->send(new SpatieEmail($record));
    }
}
```

2. **Layout HTML personalizzato**: Sovrascrivere il metodo `getHtmlLayout()` per utilizzare un layout HTML più sofisticato:

```php
public function getHtmlLayout(): string
{
    return view('notify::emails.layouts.main')->render();
}
```

3. **Differenziazione dei template**: Creare template specifici per ogni tipo di email, utilizzando il campo `mailable` per distinguerli.

## Esempi pratici di utilizzo

### Email di benvenuto post-registrazione

```php
namespace Modules\User\Actions;

use Modules\User\Models\User;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(User $user): void
    {
        $this->sendTemplatedEmailAction->execute($user, $user->email);
    }
}
```

### Email di promemoria per completamento registrazione dottore

```php
namespace Modules\Doctor\Actions;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendRegistrationReminderAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(Doctor $doctor): void
    {
        // Generare URL sicuro per completamento registrazione
        $registrationUrl = route(
            'doctor.registration.continue', 
            ['token' => $doctor->registration_token]
        );
        
        // Aggiungi dati temporanei al modello
        $doctor->setAttribute('registration_url', $registrationUrl);
        
        $this->sendTemplatedEmailAction->execute($doctor, $doctor->email);
    }
}
```

## Personalizzazione avanzata della classe SpatieEmail

Per necessità più complesse, è possibile estendere `SpatieEmail` per specifici casi d'uso:

```php
namespace Modules\Doctor\Emails;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Emails\SpatieEmail;

class DoctorRegistrationEmail extends SpatieEmail
{
    protected static string $templateName = 'doctor-registration';
    
    public function __construct(Doctor $doctor, string $registrationUrl)
    {
        $doctor->setAttribute('registration_url', $registrationUrl);
        parent::__construct($doctor);
    }
    
    // Override del layout per questo tipo specifico di email
    public function getHtmlLayout(): string
    {
        return view('doctor::emails.layouts.medical')->render();
    }
}
```

## Risoluzione problemi comuni

1. **Template non trovato**: Verificare che il template sia stato correttamente registrato nel database con il nome della classe mailable corretto.

2. **Variabili non disponibili nel template**: Assicurarsi che tutti i dati necessari siano presenti nel modello passato al costruttore o aggiunti tramite `setAdditionalData()`.

3. **Layout HTML non corretto**: Controllare che `{{{ body }}}` sia presente nel layout, altrimenti il contenuto dell'email non verrà inserito.

## Conclusione

L'utilizzo di `SpatieEmail` nel sistema permette di gestire in modo flessibile e centralizzato i template delle email, con supporto multilingua e personalizzazione avanzata. Seguendo le best practices e utilizzando le Queueable Actions, è possibile implementare un sistema di notifiche email robusto e manutenibile.

---

## spatie-email-usage

*Consolidated from: `spatie-email-usage.md`*


## Introduzione

Questa guida illustra come utilizzare la classe `SpatieEmail` per inviare email personalizzate nel sistema, basandosi sul pacchetto `spatie/laravel-database-mail-templates`.

## Collegamenti correlati

- [README del modulo Notify](./readme.md)
- [Documentazione Email Templates](./email_templates.md)
- [Email Specifiche per Dottori](./doctor-emails.md)
- [Implementazione Database Mail](./database-mail.md)
- [Documentazione Centrale](../../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../xot/docs/readme.md)
- [Documentazione Email Templates](../../email_templates.md)
- [Email Specifiche per Dottori](../../doctor-emails.md)
- [Implementazione Database Mail](../../database-mail.md)
- [Documentazione Centrale](../../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../../Xot/docs/README.md)

## Implementazione attuale

il sistema utilizza il pacchetto `spatie/laravel-database-mail-templates` per gestire i template delle email nel database. L'implementazione attuale include:

1. **MailTemplate Model**: Estende `SpatieMailTemplate` e implementa `HasTranslations` per supportare traduzioni multilingua
2. **Migration**: Tabella `mail_templates` con colonne JSON per contenuti traducibili
3. **MailTemplateResource**: Resource Filament per gestire i template nel pannello amministrativo
4. **SpatieEmail**: Classe base che utilizza `TemplateMailable` per inviare email basate su template

## Come funziona SpatieEmail

La classe `SpatieEmail` è progettata come un componente riutilizzabile per inviare diversi tipi di email utilizzando template memorizzati nel database. La classe:

```php
<?php
namespace Modules\Notify\Emails;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Spatie\MailTemplates\TemplateMailable;

class SpatieEmail extends TemplateMailable
{
    protected static $templateModelClass = MailTemplate::class;

    public function __construct(Model $record)
    {
        $data = $record->toArray();
        $this->setAdditionalData($data);
    }
    
    public function getHtmlLayout(): string
    {
        return '<header>Site name!</header>{{{ body }}}<footer>Copyright 2018</footer>';
    }
}
```

## Come utilizzare SpatieEmail per diversi tipi di email

### 1. Creare il template nel database

Prima di tutto, è necessario creare un template per ogni tipo di email nel database:

```php
use Modules\Notify\Models\MailTemplate;

// Email di benvenuto
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Benvenuto nella piattaforma, {{ first_name }}',
        'en' => 'Welcome to the application, {{ first_name }}'
    ],
    'html_template' => [
        'it' => '<p>Ciao {{ first_name }},</p><p>Grazie per esserti registrato nella piattaforma!</p>',
        'en' => '<p>Hello {{ first_name }},</p><p>Thank you for registering with the application!</p>'
    ],
    'text_template' => [
        'it' => 'Ciao {{ first_name }}, Grazie per esserti registrato nella piattaforma!',
        'en' => 'Hello {{ first_name }}, Thank you for registering with the application!'
    ]
]);

// Email per dottori (ripresa registrazione)
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Completa la tua registrazione, Dottor {{ last_name }}',
        'en' => 'Complete your registration, Dr. {{ last_name }}'
    ],
    'html_template' => [
        'it' => '<p>Gentile Dottor {{ last_name }},</p><p>La invitiamo a completare la sua registrazione sulla piattaforma cliccando sul seguente link: <a href="{{ registration_url }}">Completa Registrazione</a></p>',
        'en' => '<p>Dear Dr. {{ last_name }},</p><p>We invite you to complete your registration on the application by clicking the following link: <a href="{{ registration_url }}">Complete Registration</a></p>'
    ],
    'text_template' => [
        'it' => 'Gentile Dottor {{ last_name }}, La invitiamo a completare la sua registrazione sulla piattaforma: {{ registration_url }}',
        'en' => 'Dear Dr. {{ last_name }}, We invite you to complete your registration on the application: {{ registration_url }}'
    ]
]);
```

### 2. Inviare email specifiche

#### Email di benvenuto per nuovi utenti

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;

// In un controller o action
public function sendWelcomeEmail(User $user): void
{
    // Il sistema selezionerà automaticamente il template corretto basato sulla classe mailable
    Mail::to($user->email)
        ->locale(app()->getLocale()) // Importante: usa sempre LaravelLocalization::getCurrentLocale() in produzione
        ->send(new SpatieEmail($user));
}
```

#### Email di promemoria per i dottori

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Doctor\Models\Doctor;

// In una Queueable Action (approccio raccomandato)
public function handle(Doctor $doctor, string $registrationUrl): void
{
    // Arricchiamo il model con dati aggiuntivi per il template
    $doctor->setAttribute('registration_url', $registrationUrl);
    
    Mail::to($doctor->email)
        ->locale(LaravelLocalization::getCurrentLocale())
        ->send(new SpatieEmail($doctor));
}
```

## Best practices

1. **Utilizzo di Queueable Actions**: Seguendo le linee guida del progetto, implementare le logiche di invio email come azioni queueable:

```php
namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Spatie\QueueableAction\QueueableAction;

class SendTemplatedEmailAction
{
    use QueueableAction;

    public function execute(Model $record, string $email, string $locale = null): void
    {
        Mail::to($email)
            ->locale($locale ?? LaravelLocalization::getCurrentLocale())
            ->send(new SpatieEmail($record));
    }
}
```

2. **Layout HTML personalizzato**: Sovrascrivere il metodo `getHtmlLayout()` per utilizzare un layout HTML più sofisticato:

```php
public function getHtmlLayout(): string
{
    return view('notify::emails.layouts.main')->render();
}
```

3. **Differenziazione dei template**: Creare template specifici per ogni tipo di email, utilizzando il campo `mailable` per distinguerli.

## Esempi pratici di utilizzo

### Email di benvenuto post-registrazione

```php
namespace Modules\User\Actions;

use Modules\User\Models\User;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(User $user): void
    {
        $this->sendTemplatedEmailAction->execute($user, $user->email);
    }
}
```

### Email di promemoria per completamento registrazione dottore

```php
namespace Modules\Doctor\Actions;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendRegistrationReminderAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(Doctor $doctor): void
    {
        // Generare URL sicuro per completamento registrazione
        $registrationUrl = route(
            'doctor.registration.continue', 
            ['token' => $doctor->registration_token]
        );
        
        // Aggiungi dati temporanei al modello
        $doctor->setAttribute('registration_url', $registrationUrl);
        
        $this->sendTemplatedEmailAction->execute($doctor, $doctor->email);
    }
}
```

## Personalizzazione avanzata della classe SpatieEmail

Per necessità più complesse, è possibile estendere `SpatieEmail` per specifici casi d'uso:

```php
namespace Modules\Doctor\Emails;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Emails\SpatieEmail;

class DoctorRegistrationEmail extends SpatieEmail
{
    protected static string $templateName = 'doctor-registration';
    
    public function __construct(Doctor $doctor, string $registrationUrl)
    {
        $doctor->setAttribute('registration_url', $registrationUrl);
        parent::__construct($doctor);
    }
    
    // Override del layout per questo tipo specifico di email
    public function getHtmlLayout(): string
    {
        return view('doctor::emails.layouts.medical')->render();
    }
}
```

## Risoluzione problemi comuni

1. **Template non trovato**: Verificare che il template sia stato correttamente registrato nel database con il nome della classe mailable corretto.

2. **Variabili non disponibili nel template**: Assicurarsi che tutti i dati necessari siano presenti nel modello passato al costruttore o aggiunti tramite `setAdditionalData()`.

3. **Layout HTML non corretto**: Controllare che `{{{ body }}}` sia presente nel layout, altrimenti il contenuto dell'email non verrà inserito.

## Conclusione

L'utilizzo di `SpatieEmail` nel sistema permette di gestire in modo flessibile e centralizzato i template delle email, con supporto multilingua e personalizzazione avanzata. Seguendo le best practices e utilizzando le Queueable Actions, è possibile implementare un sistema di notifiche email robusto e manutenibile.

---

## spatie-translatable-integration

*Consolidated from: `spatie-translatable-integration.md`*


## Overview

Il modulo Notify usa il plugin **Lara Zeus Spatie Translatable** per supportare contenuti multilingua nelle risorse Filament.

## Versione

- **lara-zeus/spatie-translatable**: 1.0.4
- **Filament**: v4.x
- **Laravel**: v12.x

## Configurazione Panel

### Registrazione Plugin

Il plugin è registrato in `AdminPanelProvider`:

```php
// Modules/Notify/app/Providers/Filament/AdminPanelProvider.php

use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    $panel->plugins([
        SpatieTranslatablePlugin::make()
            ->defaultLocales(['it', 'en']),
    ]);
    
    return parent::panel($panel);
}
```

### Lingue Supportate

- **Italiano** (it) - predefinita
- **Inglese** (en)

## Risorse Traducibili

### MailTemplateResource

`MailTemplateResource` estende `LangBaseResource` che fornisce funzionalità multilingua.

#### Ereditarietà

```
MailTemplateResource
  └─> LangBaseResource (Modules/Lang)
       └─> trait Translatable
            └─> supporto multilingua
```

#### Page ListMailTemplates

```
ListMailTemplates
  └─> LangBaseListRecords (Modules/Lang)
       └─> trait Translatable
            └─> LocaleSwitcher in header actions
```

### Campi Traducibili

I seguenti campi di `MailTemplate` supportano traduzioni:

- `subject` - Oggetto dell'email
- `html_template` - Template HTML
- `text_template` - Template testo
- `sms_template` - Template SMS (opzionale)

## Modello MailTemplate

### Setup Traduzioni

```php
// Modules/Notify/app/Models/MailTemplate.php

use Spatie\Translatable\HasTranslations;

class MailTemplate extends BaseModel
{
    use HasTranslations;
    
    /**
     * Campi traducibili.
     *
     * @var list<string>
     */
    public array $translatable = [
        'subject',
        'html_template',
        'text_template',
        'sms_template',
    ];
}
```

### Struttura Dati Database

I campi traducibili sono salvati come JSON nel database:

```json
{
  "subject": {
    "it": "Benvenuto nel sistema",
    "en": "Welcome to the system"
  },
  "html_template": {
    "it": "<p>Ciao {{name}}</p>",
    "en": "<p>Hello {{name}}</p>"
  }
}
```

## Utilizzo nell'Interfaccia

### Locale Switcher

Nella pagina `ListMailTemplates`, l'utente può:
1. Vedere i template nella lingua corrente
2. Switchare lingua tramite `LocaleSwitcher` in header
3. Editare traduzioni per lingua selezionata

### Form Editing

Nel form di edit/create:
- I campi traducibili mostrano contenuto nella lingua attiva
- Il locale switcher permette di cambiare lingua al volo
- Le modifiche vengono salvate per la lingua selezionata

## Troubleshooting

### Errore: Plugin Not Registered

**Causa**: Plugin non registrato nel panel  
**Soluzione**: Vedere [plugin-spatie-translatable-not-registered.md](./errori/plugin-spatie-translatable-not-registered.md)
**Soluzione**: Vedere [plugin-spatie-translatable-not-registered.md](../../errori/plugin-spatie-translatable-not-registered.md)

### Errore: Undefined Method `getTranslation()`

**Causa**: Modello non ha trait `HasTranslations`  
**Soluzione**: Aggiungere trait e proprietà `$translatable`

### Switcher Non Visibile

**Causa**: Page non usa trait `Translatable`  
**Soluzione**: Verificare che Page estenda `LangBaseListRecords`

## Pattern Architetturale

### LangBase* Classes (Modules/Lang)

Le classi `LangBase*` forniscono funzionalità multilingua riutilizzabili:

- `LangBaseResource` - Resource con trait Translatable
- `LangBaseListRecords` - ListRecords con LocaleSwitcher
- `LangBaseCreateRecord` - CreateRecord con supporto lingue
- `LangBaseEditRecord` - EditRecord con supporto lingue

### Quando Estendere LangBase

✅ **Estendere** se:
- Il modello ha campi traducibili
- Il panel ha il plugin registrato
- Serve gestire contenuti multilingua

❌ **NON estendere** se:
- Il modello non è traducibile
- Plugin non registrato nel panel
- Complessità non necessaria

## Best Practice

### 1. Registrazione Plugin

```php
// SEMPRE registrare in AdminPanelProvider
$panel->plugins([
    SpatieTranslatablePlugin::make()
        ->defaultLocales(config('app.available_locales', ['it', 'en']))
        ->persist(),  // Ricorda lingua selezionata
]);
```

### 2. Modello Traducibile

```php
use Spatie\Translatable\HasTranslations;

class MyModel extends BaseModel
{
    use HasTranslations;
    
    public array $translatable = ['field1', 'field2'];
}
```

### 3. Resource Configuration

```php
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;

class MyResource extends LangBaseResource
{
    use Translatable;  // Solo se il modello è traducibile!
    
    public static function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }
}
```

## Testing

### Test Funzionale

```php
// Modules/Notify/tests/Feature/Filament/Resources/MailTemplateResourceTest.php

use Livewire\Livewire;
use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates;

test('locale switcher is visible', function () {
    Livewire::test(ListMailTemplates::class)
        ->assertActionExists('locale_switcher');
});

test('can switch locale', function () {
    Livewire::test(ListMailTemplates::class)
        ->callAction('locale_switcher', data: ['locale' => 'en'])
        ->assertSuccessful();
        
    expect(app()->getLocale())->toBe('en');
});
```

## Migration

Se il modello **NON** era precedentemente traducibile, serve migration:

```php
use Illuminate\Database\Schema\Blueprint;

Schema::table('mail_templates', function (Blueprint $table) {
    // Converti campi in JSON per supportare traduzioni
    $table->json('subject')->change();
    $table->json('html_template')->change();
    $table->json('text_template')->change();
});
```

## Collegamenti

### Documentazione Esterna
- [Lara Zeus Spatie Translatable](https://filamentphp.com/plugins/lara-zeus-spatie-translatable)
- [GitHub Repository](https://github.com/lara-zeus/spatie-translatable)
- [Spatie Laravel Translatable Docs](https://spatie.be/docs/laravel-translatable/v6/introduction)

### Documentazione Interna
- [Errore Plugin Not Registered](./errori/plugin-spatie-translatable-not-registered.md)
- [Lang Module README](../../lang/docs/readme.md)
- [Errore Plugin Not Registered](../../errori/plugin-spatie-translatable-not-registered.md)
- [Lang Module README](../../../../Lang/docs/readme.md)
- [Filament Panels Configuration](../../xot/docs/filament/panel-configuration.md)

---

**Ultimo aggiornamento**: 27 Ottobre 2025  
**Status**: ✅ PLUGIN REGISTRATO  
**Compatibilità**: Filament 4.x



---

## spatie_email_slug_proposal

*Consolidated from: `spatie_email_slug_proposal.md`*


## Introduzione

Questa proposta analizza l'aggiunta di un parametro `slug` al sistema di template email basato su Spatie, per migliorare l'identificazione e la gestione dei template.

## Struttura delle Migrazioni

Il progetto utilizza una struttura standardizzata per le migrazioni basata su `XotBaseMigration`. Le modifiche alle tabelle devono essere implementate nella sezione `tableUpdate` della migrazione originale, non creando nuove migrazioni.

### Esempio di Implementazione Corretta

```php
$this->tableUpdate(
    function (Blueprint $table): void {
        if (!$this->hasColumn('slug')) {
            $table->string('slug')->unique()->after('mailable');
        }
        // ... altri aggiornamenti
    }
);
```

### Best Practices per le Migrazioni

1. **Sempre Usare XotBaseMigration**
   - Estendere `XotBaseMigration` per tutte le migrazioni
   - Utilizzare i metodi helper forniti
   - Seguire la struttura standard

2. **Gestione degli Aggiornamenti**
   - Implementare modifiche nella sezione `tableUpdate`
   - Verificare l'esistenza delle colonne prima di modificarle
   - Utilizzare i metodi di controllo forniti

3. **Compatibilità**
   - Mantenere la retrocompatibilità
   - Gestire correttamente i rollback
   - Documentare le modifiche

## Analisi della Situazione Attuale

Attualmente, i template email sono identificati principalmente attraverso:
- La classe Mailable associata
- Il subject dell'email
- L'ID del record nel database

Questo approccio presenta alcune limitazioni:
1. Difficoltà nel riferimento programmatico ai template
2. Dipendenza dalla classe Mailable per l'identificazione
3. Possibili conflitti con subject simili
4. Complessità nella migrazione dei template

## Proposta di Modifica

### 1. Aggiunta Campo Slug

```php
// Aggiunta alla tabella mail_templates
$table->string('slug')->unique()->after('mailable');
```

### 2. Modifiche al Model MailTemplate

```php
class MailTemplate extends Model
{
    protected $fillable = [
        'mailable',
        'slug',  // Nuovo campo
        'subject',
        'html_template',
        'text_template',
        'version'
    ];

    // Validazione slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->subject);
            }
        });
    }
}
```

### 3. Modifiche a SpatieEmail

```php
class SpatieEmail extends Mailable
{
    protected $slug;

    public function __construct($notifiable, $slug = null)
    {
        $this->slug = $slug;
        // ... resto del codice
    }

    public function getTemplate()
    {
        if ($this->slug) {
            return MailTemplate::where('slug', $this->slug)->first();
        }
        // ... fallback al comportamento attuale
    }
}
```

## Vantaggi

1. **Identificazione Univoca**
   - Riferimento stabile e prevedibile ai template
   - Indipendenza dalla classe Mailable
   - Facilità di migrazione

2. **Migliore Gestione**
   - Ricerca semplificata dei template
   - Possibilità di versioning basato su slug
   - Migliore organizzazione dei template

3. **Flessibilità**
   - Possibilità di avere template multipli per la stessa classe Mailable
   - Facilità di override dei template
   - Migliore gestione delle traduzioni

4. **Manutenibilità**
   - Codice più pulito e leggibile
   - Riduzione della complessità
   - Migliore testabilità

## Svantaggi

1. **Complessità Aggiuntiva**
   - Nuovo campo da gestire
   - Necessità di migrazione dei dati esistenti
   - Possibili conflitti di slug

2. **Overhead Database**
   - Indice aggiuntivo sulla tabella
   - Leggero aumento della dimensione dei record

3. **Compatibilità**
   - Necessità di aggiornare il codice esistente
   - Possibili problemi di backward compatibility

## Implementazione Proposta

### 1. Migration

```php
public function up()
{
    Schema::table('mail_templates', function (Blueprint $table) {
        $table->string('slug')->unique()->after('mailable');
    });

    // Popolamento slug per record esistenti
    DB::table('mail_templates')->get()->each(function ($template) {
        DB::table('mail_templates')
            ->where('id', $template->id)
            ->update(['slug' => Str::slug($template->subject)]);
    });
}
```

### 2. Aggiornamento Controller

```php
class MailTemplateController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mailable' => 'required',
            'slug' => 'required|unique:mail_templates',
            'subject' => 'required',
            // ... altri campi
        ]);

        return MailTemplate::create($validated);
    }
}
```

### 3. Esempio di Utilizzo

```php
// Invio email con slug specifico
Mail::to($user)->send(new SpatieEmail($user, 'welcome-email'));

// Invio email con slug generato automaticamente
Mail::to($user)->send(new SpatieEmail($user));
```

## Best Practices

1. **Naming Convention**
   - Utilizzare slug descrittivi e consistenti
   - Seguire il pattern `feature-name`
   - Evitare slug generici o ambigui

2. **Gestione Versioni**
   - Includere la versione nello slug se necessario
   - Mantenere uno storico delle versioni
   - Documentare i cambiamenti

3. **Validazione**
   - Verificare l'unicità dello slug
   - Sanitizzare lo slug prima del salvataggio
   - Gestire i casi di collisione

## Considerazioni sulla Migrazione

1. **Strategia**
   - Migrazione graduale
   - Supporto per entrambi i metodi di identificazione
   - Periodo di transizione

2. **Testing**
   - Test unitari per il nuovo campo
   - Test di integrazione
   - Test di performance

3. **Documentazione**
   - Aggiornamento della documentazione esistente
   - Esempi di utilizzo
   - Guida alla migrazione

## Conclusioni

L'aggiunta del parametro `slug` rappresenta un miglioramento significativo per:
- Identificazione univoca dei template
- Gestione più flessibile
- Migliore manutenibilità
- Facilità di migrazione

Nonostante i potenziali svantaggi, i benefici superano i costi di implementazione, rendendo questa modifica un'aggiunta valida al sistema.

## Collegamenti Correlati

- [Documentazione Spatie Mail Templates](https://github.com/spatie/laravel-database-mail-templates)
- [Sistema di Template Email](./EMAIL_TEMPLATES.md)
- [Email per i Dottori](./DOCTOR_EMAILS.md)
- [Filament Resources](./filament-resources.md)
- [Sistema di Template Email](../../email_templates.md)
- [Email per i Dottori](../../doctor_emails.md)
- [Filament Resources](../../filament-resources.md)

## Implementazione Migrazione

### File: `2018_10_10_000002_create_mail_templates_table.php`

```php
$this->tableUpdate(
    function (Blueprint $table): void {
        if (!$this->hasColumn('slug')) {
            $table->string('slug')->unique()->after('mailable');
        }
        // ... altri aggiornamenti
    }
);
```

### Motivazioni della Scelta
1. **Struttura Standard**
   - Utilizzo di `XotBaseMigration`
   - Implementazione nella sezione `tableUpdate`
   - Verifica esistenza colonna

2. **Compatibilità**
   - Nessun impatto su dati esistenti
   - Mantenuta retrocompatibilità
   - Rollback supportato

3. **Manutenibilità**
   - Codice pulito e documentato
   - Facile da testare
   - Facile da estendere

// ... existing code ... 

---

## spatie_email_usage_guide

*Consolidated from: `spatie_email_usage_guide.md`*


## Introduzione

Questa guida illustra come utilizzare la classe `SpatieEmail` per inviare email personalizzate nel sistema, basandosi sul pacchetto `spatie/laravel-database-mail-templates`.

## Collegamenti correlati

- [README del modulo Notify](./README.md)
- [Documentazione Email Templates](./EMAIL_TEMPLATES.md)
- [Email Specifiche per Dottori](./DOCTOR_EMAILS.md)
- [Implementazione Database Mail](./database-mail.md)
- [Documentazione Centrale](../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../Xot/docs/README.md)
- [Documentazione Email Templates](../../email_templates.md)
- [Email Specifiche per Dottori](../../doctor_emails.md)
- [Implementazione Database Mail](../../database-mail.md)
- [Documentazione Centrale](../../../../docs/collegamenti-documentazione.md)
- [Modulo Xot](../../../../Xot/docs/README.md)

## Implementazione attuale

il sistema utilizza il pacchetto `spatie/laravel-database-mail-templates` per gestire i template delle email nel database. L'implementazione attuale include:

1. **MailTemplate Model**: Estende `SpatieMailTemplate` e implementa `HasTranslations` per supportare traduzioni multilingua
2. **Migration**: Tabella `mail_templates` con colonne JSON per contenuti traducibili
3. **MailTemplateResource**: Resource Filament per gestire i template nel pannello amministrativo
4. **SpatieEmail**: Classe base che utilizza `TemplateMailable` per inviare email basate su template

## Come funziona SpatieEmail

La classe `SpatieEmail` è progettata come un componente riutilizzabile per inviare diversi tipi di email utilizzando template memorizzati nel database. La classe:

```php
<?php
namespace Modules\Notify\Emails;

use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Models\MailTemplate;
use Spatie\MailTemplates\TemplateMailable;

class SpatieEmail extends TemplateMailable
{
    protected static $templateModelClass = MailTemplate::class;

    public function __construct(Model $record)
    {
        $data = $record->toArray();
        $this->setAdditionalData($data);
    }
    
    public function getHtmlLayout(): string
    {
        return '<header>Site name!</header>{{{ body }}}<footer>Copyright 2018</footer>';
    }
}
```

## Come utilizzare SpatieEmail per diversi tipi di email

### 1. Creare il template nel database

Prima di tutto, è necessario creare un template per ogni tipo di email nel database:

```php
use Modules\Notify\Models\MailTemplate;

// Email di benvenuto
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Benvenuto nella piattaforma, {{ first_name }}',
        'en' => 'Welcome to the application, {{ first_name }}'
    ],
    'html_template' => [
        'it' => '<p>Ciao {{ first_name }},</p><p>Grazie per esserti registrato nella piattaforma!</p>',
        'en' => '<p>Hello {{ first_name }},</p><p>Thank you for registering with the application!</p>'
    ],
    'text_template' => [
        'it' => 'Ciao {{ first_name }}, Grazie per esserti registrato nella piattaforma!',
        'en' => 'Hello {{ first_name }}, Thank you for registering with the application!'
    ]
]);

// Email per dottori (ripresa registrazione)
MailTemplate::create([
    'mailable' => \Modules\Notify\Emails\SpatieEmail::class,
    'subject' => [
        'it' => 'Completa la tua registrazione, Dottor {{ last_name }}',
        'en' => 'Complete your registration, Dr. {{ last_name }}'
    ],
    'html_template' => [
        'it' => '<p>Gentile Dottor {{ last_name }},</p><p>La invitiamo a completare la sua registrazione sulla piattaforma cliccando sul seguente link: <a href="{{ registration_url }}">Completa Registrazione</a></p>',
        'en' => '<p>Dear Dr. {{ last_name }},</p><p>We invite you to complete your registration on the application by clicking the following link: <a href="{{ registration_url }}">Complete Registration</a></p>'
    ],
    'text_template' => [
        'it' => 'Gentile Dottor {{ last_name }}, La invitiamo a completare la sua registrazione sulla piattaforma: {{ registration_url }}',
        'en' => 'Dear Dr. {{ last_name }}, We invite you to complete your registration on the application: {{ registration_url }}'
    ]
]);
```

### 2. Inviare email specifiche

#### Email di benvenuto per nuovi utenti

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;

// In un controller o action
public function sendWelcomeEmail(User $user): void
{
    // Il sistema selezionerà automaticamente il template corretto basato sulla classe mailable
    Mail::to($user->email)
        ->locale(app()->getLocale()) // Importante: usa sempre LaravelLocalization::getCurrentLocale() in produzione
        ->send(new SpatieEmail($user));
}
```

#### Email di promemoria per i dottori

```php
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Doctor\Models\Doctor;

// In una Queueable Action (approccio raccomandato)
public function handle(Doctor $doctor, string $registrationUrl): void
{
    // Arricchiamo il model con dati aggiuntivi per il template
    $doctor->setAttribute('registration_url', $registrationUrl);
    
    Mail::to($doctor->email)
        ->locale(LaravelLocalization::getCurrentLocale())
        ->send(new SpatieEmail($doctor));
}
```

## Best practices

1. **Utilizzo di Queueable Actions**: Seguendo le linee guida del progetto, implementare le logiche di invio email come azioni queueable:

```php
namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Emails\SpatieEmail;
use Spatie\QueueableAction\QueueableAction;

class SendTemplatedEmailAction
{
    use QueueableAction;

    public function execute(Model $record, string $email, string $locale = null): void
    {
        Mail::to($email)
            ->locale($locale ?? LaravelLocalization::getCurrentLocale())
            ->send(new SpatieEmail($record));
    }
}
```

2. **Layout HTML personalizzato**: Sovrascrivere il metodo `getHtmlLayout()` per utilizzare un layout HTML più sofisticato:

```php
public function getHtmlLayout(): string
{
    return view('notify::emails.layouts.main')->render();
}
```

3. **Differenziazione dei template**: Creare template specifici per ogni tipo di email, utilizzando il campo `mailable` per distinguerli.

## Esempi pratici di utilizzo

### Email di benvenuto post-registrazione

```php
namespace Modules\User\Actions;

use Modules\User\Models\User;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendWelcomeEmailAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(User $user): void
    {
        $this->sendTemplatedEmailAction->execute($user, $user->email);
    }
}
```

### Email di promemoria per completamento registrazione dottore

```php
namespace Modules\Doctor\Actions;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Actions\SendTemplatedEmailAction;
use Spatie\QueueableAction\QueueableAction;

class SendRegistrationReminderAction
{
    use QueueableAction;

    public function __construct(
        protected SendTemplatedEmailAction $sendTemplatedEmailAction
    ) {}

    public function execute(Doctor $doctor): void
    {
        // Generare URL sicuro per completamento registrazione
        $registrationUrl = route(
            'doctor.registration.continue', 
            ['token' => $doctor->registration_token]
        );
        
        // Aggiungi dati temporanei al modello
        $doctor->setAttribute('registration_url', $registrationUrl);
        
        $this->sendTemplatedEmailAction->execute($doctor, $doctor->email);
    }
}
```

## Personalizzazione avanzata della classe SpatieEmail

Per necessità più complesse, è possibile estendere `SpatieEmail` per specifici casi d'uso:

```php
namespace Modules\Doctor\Emails;

use Modules\Doctor\Models\Doctor;
use Modules\Notify\Emails\SpatieEmail;

class DoctorRegistrationEmail extends SpatieEmail
{
    protected static string $templateName = 'doctor-registration';
    
    public function __construct(Doctor $doctor, string $registrationUrl)
    {
        $doctor->setAttribute('registration_url', $registrationUrl);
        parent::__construct($doctor);
    }
    
    // Override del layout per questo tipo specifico di email
    public function getHtmlLayout(): string
    {
        return view('doctor::emails.layouts.medical')->render();
    }
}
```

## Risoluzione problemi comuni

1. **Template non trovato**: Verificare che il template sia stato correttamente registrato nel database con il nome della classe mailable corretto.

2. **Variabili non disponibili nel template**: Assicurarsi che tutti i dati necessari siano presenti nel modello passato al costruttore o aggiunti tramite `setAdditionalData()`.

3. **Layout HTML non corretto**: Controllare che `{{{ body }}}` sia presente nel layout, altrimenti il contenuto dell'email non verrà inserito.

## Conclusione

L'utilizzo di `SpatieEmail` nel sistema permette di gestire in modo flessibile e centralizzato i template delle email, con supporto multilingua e personalizzazione avanzata. Seguendo le best practices e utilizzando le Queueable Actions, è possibile implementare un sistema di notifiche email robusto e manutenibile.

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
