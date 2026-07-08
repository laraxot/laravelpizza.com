# Spatie Laravel Database Mail Templates - Guida Completa

## Introduzione

**Spatie Laravel Database Mail Templates** è un package per Laravel che permette di gestire template email direttamente nel database invece che nei file Blade. Questo offre maggiore flessibilità per la gestione dei template email in produzione.

## Installazione

```bash
composer require spatie/laravel-database-mail-templates
php artisan vendor:publish --provider="Spatie\MailTemplates\MailTemplatesServiceProvider"
php artisan migrate
```

## Configurazione

### File di Configurazione

```php
// config/mail-templates.php
return [
    'table_names' => [
        'mail_templates' => 'mail_templates',
    ],

    'models' => [
        'mail_template' => Spatie\MailTemplates\Models\MailTemplate::class,
    ],
];
```

### Migrazione Database

```php
Schema::create('mail_templates', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('subject');
    $table->text('html_template');
    $table->text('text_template')->nullable();
    $table->json('variables')->nullable();
    $table->timestamps();
});
```

## Utilizzo Base

### Creazione Template

```php
use Spatie\MailTemplates\Models\MailTemplate;

$template = MailTemplate::create([
    'name' => 'welcome-email',
    'subject' => 'Benvenuto {{name}}!',
    'html_template' => '
        <h1>Benvenuto {{name}}!</h1>
        <p>Grazie per esserti registrato.</p>
        <a href="{{url}}">Clicca qui per confermare</a>
    ',
    'text_template' => 'Benvenuto {{name}}! Grazie per esserti registrato.',
    'variables' => ['name', 'url']
]);
```

### Invio Email con Template

```php
use Spatie\MailTemplates\TemplateMailable;

class WelcomeMail extends TemplateMailable
{
    public function __construct(
        public string $name,
        public string $url
    ) {}

    public function getTemplate(): MailTemplate
    {
        return MailTemplate::where('name', 'welcome-email')->first();
    }
}

// Utilizzo
WelcomeMail::create($user->name, $url)->send();
```

## Integrazione con Filament

### Resource per Gestione Template

```php
<?php

namespace Modules\Notify\Filament\Resources;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Notify\Models\MailTemplate;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MailTemplateResource extends XotBaseResource
{
    protected static ?string $model = MailTemplate::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            TextInput::make('subject')
                ->required()
                ->maxLength(255),

            Textarea::make('html_template')
                ->required()
                ->rows(10),

            Textarea::make('text_template')
                ->rows(10),

            TextInput::make('variables')
                ->helperText('Variabili separate da virgola: name,email,url'),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable(),

            TextColumn::make('subject')
                ->limit(50),

            TextColumn::make('updated_at')
                ->dateTime(),
        ];
    }
}
```

### Action per Test Email

```php
<?php

namespace Modules\Notify\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Models\MailTemplate;
use Modules\Xot\Filament\Actions\XotBaseAction;

class TestMailTemplateAction extends XotBaseAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('notify::actions.test_mail_template.label'))
            ->icon('heroicon-o-envelope')
            ->color('primary')
            ->form([
                TextInput::make('email')
                    ->label(__('notify::fields.email.label'))
                    ->email()
                    ->required(),
            ])
            ->action(function (array $data, MailTemplate $record): void {
                try {
                    // Crea istanza mailable di test
                    $mailable = new class($data['email']) {
                        public function __construct(public string $email) {}

                        public function build(): void
                        {
                            // Logica per creare mailable di test
                        }
                    };

                    // Invia email di test
                    Mail::to($data['email'])->send($mailable);

                    Notification::make()
                        ->success()
                        ->title(__('notify::notifications.test_email_sent'))
                        ->send();

                } catch (\Exception $e) {
                    Notification::make()
                        ->danger()
                        ->title(__('notify::notifications.test_email_failed'))
                        ->body($e->getMessage())
                        ->send();
                }
            });
    }
}
```

## Variabili e Placeholder

### Definizione Variabili

```php
// Nel modello MailTemplate
$template = MailTemplate::create([
    'name' => 'order-confirmation',
    'variables' => ['customer_name', 'order_number', 'total', 'items']
]);
```

### Utilizzo nelle Email

```php
// In Mailable
class OrderConfirmationMail extends TemplateMailable
{
    public function __construct(
        public string $customerName,
        public string $orderNumber,
        public float $total,
        public array $items
    ) {}

    public function getTemplate(): MailTemplate
    {
        return MailTemplate::where('name', 'order-confirmation')->first();
    }
}
```

### Rendering Template

```php
// Template HTML
'
<h1>Ordine #{{order_number}}</h1>
<p>Ciao {{customer_name}},</p>
<p>Totale: €{{total}}</p>
<ul>
@foreach($items as $item)
<li>{{item.name}} - €{{item.price}}</li>
@endforeach
</ul>
'
```

## Gestione Template Multilingua

### Template per Lingua

```php
// Template italiano
$templateIt = MailTemplate::create([
    'name' => 'welcome-email',
    'locale' => 'it',
    'subject' => 'Benvenuto {{name}}!',
    // ...
]);

// Template inglese
$templateEn = MailTemplate::create([
    'name' => 'welcome-email',
    'locale' => 'en',
    'subject' => 'Welcome {{name}}!',
    // ...
]);
```

### Selezione Automatica Lingua

```php
class WelcomeMail extends TemplateMailable
{
    public function getTemplate(): MailTemplate
    {
        return MailTemplate::where('name', 'welcome-email')
            ->where('locale', app()->getLocale())
            ->first() ?? MailTemplate::where('name', 'welcome-email')
            ->first();
    }
}
```

## Validazione Template

### Validazione Variabili

```php
class MailTemplateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'html_template' => 'required|string',
            'text_template' => 'nullable|string',
            'variables' => 'nullable|array',
            'variables.*' => 'string',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $template = $this->route('template');

            // Verifica che tutte le variabili nel template esistano
            $definedVariables = $this->input('variables', []);
            $usedVariables = $this->extractVariablesFromTemplate($this->input('html_template'));

            $missingVariables = array_diff($usedVariables, $definedVariables);

            if (!empty($missingVariables)) {
                $validator->errors()->add('variables', 'Variabili mancanti: ' . implode(', ', $missingVariables));
            }
        });
    }

    private function extractVariablesFromTemplate(string $template): array
    {
        preg_match_all('/\{\{(\w+)\}\}/', $template, $matches);
        return $matches[1] ?? [];
    }
}
```

## Performance e Caching

### Caching Template

```php
use Illuminate\Support\Facades\Cache;

$template = Cache::remember(
    "mail_template.{$name}.{$locale}",
    now()->addHours(24),
    fn() => MailTemplate::where('name', $name)
        ->where('locale', $locale)
        ->first()
);
```

### Ottimizzazione Query

```php
// Caricamento eager delle relazioni
$templates = MailTemplate::with('category')
    ->where('active', true)
    ->get();

// Query ottimizzata
$template = MailTemplate::where('name', $name)
    ->where('locale', $locale)
    ->where('active', true)
    ->first();
```

## Testing

### Test Base

```php
<?php

use Modules\Notify\Models\MailTemplate;
use Tests\TestCase;

class MailTemplateTest extends TestCase
{
    public function test_can_create_template(): void
    {
        $template = MailTemplate::factory()->create([
            'name' => 'test-template',
            'subject' => 'Test Subject {{name}}',
            'html_template' => '<h1>Hello {{name}}</h1>',
            'variables' => ['name']
        ]);

        $this->assertEquals('test-template', $template->name);
        $this->assertEquals(['name'], $template->variables);
    }

    public function test_can_render_template(): void
    {
        $template = MailTemplate::factory()->create([
            'html_template' => '<h1>Hello {{name}}</h1><p>Total: {{total}}</p>'
        ]);

        $rendered = $template->render(['name' => 'John', 'total' => '100']);

        $this->assertStringContains('Hello John', $rendered);
        $this->assertStringContains('Total: 100', $rendered);
    }
}
```

### Test Integrazione Filament

```php
public function test_can_create_template_via_filament(): void
{
    $user = User::factory()->create();

    livewire(CreateMailTemplate::class)
        ->actingAs($user)
        ->fillForm([
            'name' => 'test-template',
            'subject' => 'Test Subject',
            'html_template' => '<h1>Test</h1>',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('mail_templates', [
        'name' => 'test-template',
    ]);
}
```

## Troubleshooting

### Errore: Template non trovato

**Causa**: Template con nome/locale non esistente.

**Soluzione**:
```php
// Verifica template esiste
$template = MailTemplate::where('name', 'welcome-email')
    ->where('locale', 'it')
    ->first();

if (!$template) {
    throw new \Exception('Template non trovato');
}
```

### Errore: Variabile mancante nel template

**Causa**: Template usa variabile non definita.

**Soluzione**:
```php
// Verifica tutte le variabili siano definite
$usedVariables = $this->extractVariablesFromTemplate($template->html_template);
$missingVariables = array_diff($usedVariables, $template->variables ?? []);

if (!empty($missingVariables)) {
    throw new \Exception('Variabili mancanti: ' . implode(', ', $missingVariables));
}
```

### Errore: Email non inviata

**Causa**: Configurazione mail non corretta o template malformato.

**Soluzione**:
```php
try {
    Mail::to('test@example.com')->send($mailable);
} catch (\Exception $e) {
    \Log::error('Email non inviata: ' . $e->getMessage());
    throw $e;
}
```

## Best Practices

### 1. Validazione Template

```php
// Validare sempre template prima del salvataggio
$validator = Validator::make($data, [
    'html_template' => 'required|string',
    'variables' => 'required|array',
]);

$validator->after(function ($validator) use ($data) {
    $usedVars = $this->extractVariablesFromTemplate($data['html_template']);
    $missingVars = array_diff($usedVars, $data['variables']);

    if (!empty($missingVars)) {
        $validator->errors()->add('variables', 'Variabili mancanti: ' . implode(', ', $missingVars));
    }
});
```

### 2. Gestione Errori

```php
// Gestire sempre errori nel rendering
try {
    $rendered = $template->render($variables);
} catch (\Exception $e) {
    // Fallback a template di default o errore specifico
    throw new \Exception('Errore nel rendering del template: ' . $e->getMessage());
}
```

### 3. Performance

```php
// Cache template frequenti
$template = Cache::remember(
    "mail_template.{$name}.{$locale}",
    now()->addHours(24),
    fn() => MailTemplate::where('name', $name)->where('locale', $locale)->first()
);
```

### 4. Sicurezza

```php
// Sanitizzare input per prevenire XSS
$sanitizedData = [
    'name' => strip_tags($data['name']),
    'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
];
```

## Configurazione Avanzata

### Eventi

```php
// Ascoltare eventi del package
Event::listen('Spatie\MailTemplates\Events\MailTemplateSent', function ($event) {
    \Log::info('Template email inviato', [
        'template' => $event->mailTemplate->name,
        'to' => $event->to,
    ]);
});
```

### Middleware

```php
// Middleware per logging email
class LogMailTemplates
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('post') && $request->routeIs('mail-templates.*')) {
            \Log::info('Mail template modificato', [
                'user' => auth()->id(),
                'ip' => $request->ip(),
            ]);
        }

        return $next($request);
    }
}
```

## Integrazione con Altri Package

### Spatie Laravel Permission

```php
class MailTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view mail templates');
    }

    public function create(User $user): bool
    {
        return $user->can('create mail templates');
    }
}
```

### Spatie Laravel Activity Log

```php
class MailTemplate extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['name', 'subject', 'html_template'];

    protected static $logName = 'mail_template';
}
```

## Migration da File a Database

### Script di Migrazione

```php
<?php

// Script per migrare template da file a database
$templates = [
    'welcome' => [
        'subject' => 'Benvenuto!',
        'html' => 'resources/views/emails/welcome.blade.php',
        'text' => 'resources/views/emails/welcome-text.blade.php',
    ],
];

foreach ($templates as $name => $template) {
    $htmlContent = file_get_contents(base_path($template['html']));
    $textContent = file_exists(base_path($template['text']))
        ? file_get_contents(base_path($template['text']))
        : null;

    MailTemplate::create([
        'name' => $name,
        'subject' => $template['subject'],
        'html_template' => $htmlContent,
        'text_template' => $textContent,
    ]);
}
```

## Deployment

### Ottimizzazioni Produzione

```php
// Cache template in produzione
if (app()->environment('production')) {
    $templates = MailTemplate::all();
    Cache::put('mail_templates', $templates, now()->addDay());
}
```

### Backup Template

```php
// Backup automatico template
$templates = MailTemplate::all();

foreach ($templates as $template) {
    Storage::disk('backups')->put(
        "mail_templates/{$template->name}.json",
        $template->toJson()
    );
}
```

## Monitoraggio

### Metriche Email

```php
// Tracciare metriche email
Event::listen('Spatie\MailTemplates\Events\MailTemplateSent', function ($event) {
    // Incrementa contatore
    \DB::table('mail_metrics')->insert([
        'template_name' => $event->mailTemplate->name,
        'sent_at' => now(),
        'recipient' => $event->to[0] ?? null,
    ]);
});
```

## Risorse Esterne

- [Documentazione Ufficiale](https://spatie.be/docs/laravel-database-mail-templates)
- [Repository GitHub](https://github.com/spatie/laravel-database-mail-templates)
- [Plugin Filament](https://filamentphp.com/plugins/spatie-database-mail-templates)

---

*Ultimo aggiornamento: Sistema di documentazione automatica*
