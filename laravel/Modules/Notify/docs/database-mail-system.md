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
- [Email Templates](email-templates.md)
- [Mail Queue](mail-queue.md)

## Vedi Anche
- [Laravel Mail](https://laravel.com/docs/mail)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Spatie Packages](https://spatie.be/open-source)
