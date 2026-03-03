# Guida all'Implementazione dei Template Email

## Setup Iniziale

### 1. Installazione Dipendenze
```bash
composer require spatie/laravel-database-mail-templates
php artisan vendor:publish --provider="Spatie\MailTemplates\MailTemplatesServiceProvider"
php artisan migrate
```

### 2. Configurazione Base
```php
// config/mail-templates.php
return [
    'table_name' => 'mail_templates',
    'model' => \Modules\Notify\Models\MailTemplate::class,
    'default_locale' => 'it',
];
```

## Struttura del Modulo

### 1. Models
```php
namespace Modules\Notify\Models;

use Spatie\MailTemplates\Models\MailTemplate;

class Template extends MailTemplate
{
    protected $fillable = [
        'name',
        'subject',
        'html_template',
        'text_template',
        'locale',
    ];
}
```

### 2. Controllers
```php
namespace Modules\Notify\Http\Controllers;

use Modules\Notify\Models\Template;
use Modules\Notify\Services\TemplateService;

class TemplateController extends Controller
{
    protected $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function preview($id)
    {
        $template = Template::findOrFail($id);
        return view('notify::preview', compact('template'));
    }
}
```

### 3. Services
```php
namespace Modules\Notify\Services;

use Modules\Notify\Models\Template;

class TemplateService
{
    public function render(Template $template, array $data)
    {
        return view()->make('notify::emails.template', [
            'template' => $template,
            'data' => $data
        ])->render();
    }
}
```

## Integrazione con Filament

### 1. Resource
```php
namespace Modules\Notify\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms;
use Modules\Notify\Models\Template;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->translateLabel(),
            Forms\Components\TextInput::make('subject')
                ->required()
                ->translateLabel(),
            Forms\Components\RichEditor::make('html_template')
                ->required()
                ->translateLabel(),
            Forms\Components\Textarea::make('text_template')
                ->translateLabel(),
        ]);
    }
}
```

### 2. Actions
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\Actions;

use Filament\Tables\Actions\Action;

class PreviewAction extends Action
{
    public static function make(): static
    {
        return parent::make()
            ->icon('heroicon-o-eye')
            ->url(fn (Template $record): string => route('notify.templates.preview', $record))
            ->openUrlInNewTab();
    }
}
```

## Template Base

### 1. Layout
```php
// resources/views/vendor/notify/emails/layouts/main.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
```

### 2. Componenti
```php
// resources/views/vendor/notify/emails/components/header.blade.php
<div class="header">
    <img src="{{ asset('images/logo.png') }}" alt="Logo">
</div>

// resources/views/vendor/notify/emails/components/footer.blade.php
<div class="footer">
    <p>{{ config('app.name') }} &copy; {{ date('Y') }}</p>
</div>
```

## Utilizzo

### 1. Creazione Template
```php
use Modules\Notify\Models\Template;

$template = Template::create([
    'name' => 'welcome',
    'subject' => 'Benvenuto in {{ app_name }}',
    'html_template' => view('notify::emails.welcome')->render(),
    'locale' => 'it'
]);
```

### 2. Invio Email
```php
use Modules\Notify\Mail\TemplateMailable;

Mail::to($user->email)->send(new TemplateMailable('welcome', [
    'user' => $user,
    'app_name' => config('app.name')
]));
```

## Testing

### 1. Unit Tests
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Models\Template;

class TemplateTest extends TestCase
{
    public function test_template_rendering()
    {
        $template = Template::factory()->create();
        $rendered = $template->render(['name' => 'Test']);
        $this->assertStringContainsString('Test', $rendered);
    }
}
```

### 2. Feature Tests
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\Template;

class TemplateControllerTest extends TestCase
{
    public function test_preview_page()
    {
        $template = Template::factory()->create();
        $response = $this->get(route('notify.templates.preview', $template));
        $response->assertStatus(200);
    }
}
```

## Note Importanti
- Mantenere i template versionati
- Implementare caching appropriato
- Testare su diversi client email
- Monitorare le performance
- Documentare le variabili disponibili 
