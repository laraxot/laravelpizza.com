# Implementazione Pratica del Modulo Notify

## 1. Setup Iniziale

### 1.1 Installazione Dipendenze
```bash
composer require spatie/laravel-mail-templates
composer require mjml/mjml-php
composer require mailgun/mailgun-php
```

### 1.2 Configurazione Base
```php
// config/mail-templates.php
return [
    'default_layout' => 'notify::layouts.default',
    'cache' => [
        'enabled' => true,
        'ttl' => 3600
    ],
    'mjml' => [
        'app_id' => env('MJML_APP_ID'),
        'secret_key' => env('MJML_SECRET_KEY')
    ],
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET')
    ]
];
```

## 2. Struttura del Modulo

### 2.1 Models
```php
namespace Modules\Notify\Models;

class Template extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'content',
        'layout',
        'is_active',
        'version'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'version' => 'integer'
    ];

    public function versions()
    {
        return $this->hasMany(TemplateVersion::class);
    }

    public function translations()
    {
        return $this->hasMany(TemplateTranslation::class);
    }

    public function analytics()
    {
        return $this->hasMany(TemplateAnalytics::class);
    }
}

class TemplateVersion extends Model
{
    protected $fillable = [
        'template_id',
        'version',
        'content',
        'created_by',
        'changes'
    ];

    protected $casts = [
        'changes' => 'array'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}

class TemplateTranslation extends Model
{
    protected $fillable = [
        'template_id',
        'locale',
        'content',
        'subject'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
```

### 2.2 Controllers
```php
namespace Modules\Notify\Http\Controllers;

class TemplateController extends Controller
{
    protected $templateService;
    protected $mjmlService;
    protected $mailgunService;

    public function __construct(
        TemplateService $templateService,
        MjmlService $mjmlService,
        MailgunService $mailgunService
    ) {
        $this->templateService = $templateService;
        $this->mjmlService = $mjmlService;
        $this->mailgunService = $mailgunService;
    }

    public function index()
    {
        $templates = Template::with(['translations', 'versions'])
            ->latest()
            ->paginate();

        return view('notify::templates.index', compact('templates'));
    }

    public function create()
    {
        return view('notify::templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'layout' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $template = $this->templateService->create($validated);

        return redirect()
            ->route('notify.templates.show', $template)
            ->with('success', 'Template created successfully.');
    }

    public function show(Template $template)
    {
        $template->load(['translations', 'versions', 'analytics']);

        return view('notify::templates.show', compact('template'));
    }

    public function edit(Template $template)
    {
        return view('notify::templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'layout' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $template = $this->templateService->update($template, $validated);

        return redirect()
            ->route('notify.templates.show', $template)
            ->with('success', 'Template updated successfully.');
    }

    public function destroy(Template $template)
    {
        $this->templateService->delete($template);

        return redirect()
            ->route('notify.templates.index')
            ->with('success', 'Template deleted successfully.');
    }

    public function preview(Template $template)
    {
        $preview = $this->templateService->preview($template);

        return view('notify::templates.preview', compact('preview'));
    }

    public function send(Request $request, Template $template)
    {
        $validated = $request->validate([
            'to' => 'required|email',
            'data' => 'array'
        ]);

        $this->mailgunService->send($template, $validated);

        return redirect()
            ->route('notify.templates.show', $template)
            ->with('success', 'Email sent successfully.');
    }
}
```

### 2.3 Services
```php
namespace Modules\Notify\Services;

class TemplateService
{
    protected $mjmlService;
    protected $cache;

    public function __construct(MjmlService $mjmlService)
    {
        $this->mjmlService = $mjmlService;
        $this->cache = app('cache');
    }

    public function create(array $data)
    {
        $template = Template::create($data);

        $this->createVersion($template, $data['content']);

        return $template;
    }

    public function update(Template $template, array $data)
    {
        $template->update($data);

        if (isset($data['content'])) {
            $this->createVersion($template, $data['content']);
        }

        $this->cache->forget("template.{$template->id}");

        return $template;
    }

    public function delete(Template $template)
    {
        $template->delete();
        $this->cache->forget("template.{$template->id}");
    }

    public function preview(Template $template)
    {
        return $this->mjmlService->compile($template->content);
    }

    protected function createVersion(Template $template, string $content)
    {
        $version = $template->versions()->count() + 1;

        $changes = $template->versions()->latest()->first()
            ? $this->getChanges($template->versions()->latest()->first()->content, $content)
            : null;

        return $template->versions()->create([
            'version' => $version,
            'content' => $content,
            'created_by' => auth()->id(),
            'changes' => $changes
        ]);
    }

    protected function getChanges(string $old, string $new)
    {
        // Implementazione diff
        return [
            'added' => $this->getAddedLines($old, $new),
            'removed' => $this->getRemovedLines($old, $new),
            'modified' => $this->getModifiedLines($old, $new)
        ];
    }
}

class MjmlService
{
    protected $mjml;
    protected $options;

    public function __construct()
    {
        $this->mjml = new \Mjml\Mjml();
        $this->options = [
            'minify' => true,
            'beautify' => false,
            'validationLevel' => 'strict'
        ];
    }

    public function compile($template)
    {
        try {
            $mjml = $this->convertToMjml($template);
            $result = $this->mjml->render($mjml, $this->options);
            
            return [
                'html' => $result->html,
                'errors' => $result->errors
            ];
        } catch (\Exception $e) {
            Log::error('MJML compilation failed', [
                'error' => $e->getMessage(),
                'template' => $template
            ]);
            throw $e;
        }
    }

    protected function convertToMjml($template)
    {
        return view('notify::mjml.wrapper', [
            'content' => $template,
            'styles' => $this->extractStyles($template),
            'components' => $this->extractComponents($template)
        ])->render();
    }
}

class MailgunService
{
    protected $mailgun;
    protected $domain;
    protected $analytics;

    public function __construct()
    {
        $this->mailgun = new \Mailgun\Mailgun(config('services.mailgun.secret'));
        $this->domain = config('services.mailgun.domain');
        $this->analytics = new MailgunAnalytics();
    }

    public function send($template, $data)
    {
        try {
            $result = $this->mailgun->messages()->send($this->domain, [
                'from' => $template->from,
                'to' => $data['to'],
                'subject' => $template->subject,
                'template' => $template->mailgun_template,
                'h:X-Mailgun-Variables' => json_encode($data),
                'o:tracking' => true,
                'o:tracking-clicks' => true,
                'o:tracking-opens' => true
            ]);

            $this->analytics->track($template, $result);

            return $result;
        } catch (\Exception $e) {
            Log::error('Mailgun send failed', [
                'error' => $e->getMessage(),
                'template' => $template,
                'data' => $data
            ]);
            throw $e;
        }
    }
}
```

## 3. Integrazione con Filament

### 3.1 Resources
```php
namespace Modules\Notify\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;

class TemplateResource extends Resource
{
    protected static ?string $model = Template::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Template')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Content')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('subject')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Builder::make('content')
                                ->blocks([
                                    Builder\Block::make('text')
                                        ->schema([
                                            Forms\Components\RichEditor::make('content')
                                                ->required()
                                                ->toolbarButtons([
                                                    'bold',
                                                    'italic',
                                                    'link',
                                                    'bulletList',
                                                    'orderedList'
                                                ])
                                        ]),
                                    Builder\Block::make('image')
                                        ->schema([
                                            Forms\Components\FileUpload::make('image')
                                                ->required()
                                                ->image()
                                                ->imageResizeMode('cover')
                                                ->imageCropAspectRatio('16:9')
                                                ->imageResizeTargetWidth('1920')
                                                ->imageResizeTargetHeight('1080')
                                        ])
                                ])
                        ]),
                    Forms\Components\Tabs\Tab::make('Preview')
                        ->schema([
                            Forms\Components\View::make('notify::preview')
                                ->livewire(TemplatePreview::class)
                        ]),
                    Forms\Components\Tabs\Tab::make('Settings')
                        ->schema([
                            Forms\Components\Select::make('layout')
                                ->options([
                                    'default' => 'Default',
                                    'custom' => 'Custom'
                                ])
                                ->required(),
                            Forms\Components\Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                        ])
                ])
        ]);
    }

    public static function table(Tables $table): Tables
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('subject')
                ->searchable()
                ->sortable(),
            Tables\Columns\IconColumn::make('is_active')
                ->boolean()
                ->sortable(),
            Tables\Columns\TextColumn::make('version')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('layout')
                ->options([
                    'default' => 'Default',
                    'custom' => 'Custom'
                ]),
            Tables\Filters\TernaryFilter::make('is_active')
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\Action::make('preview')
                ->url(fn (Template $record): string => route('notify.templates.preview', $record))
                ->openUrlInNewTab()
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\VersionsRelationManager::class,
            RelationManagers\TranslationsRelationManager::class,
            RelationManagers\AnalyticsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplate::route('/create'),
            'edit' => Pages\EditTemplate::route('/{record}/edit'),
        ];
    }
}
```

### 3.2 Actions
```php
namespace Modules\Notify\Filament\Resources\TemplateResource\Actions;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class PreviewAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-eye')
            ->label('Preview')
            ->url(fn (Model $record): string => route('notify.templates.preview', $record))
            ->openUrlInNewTab();
    }
}

class SendAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-paper-airplane')
            ->label('Send')
            ->form([
                Forms\Components\TextInput::make('to')
                    ->email()
                    ->required(),
                Forms\Components\KeyValue::make('data')
                    ->label('Template Variables')
            ])
            ->action(function (Model $record, array $data): void {
                $record->send($data['to'], $data['data']);
            });
    }
}
```

## 4. Template Base

### 4.1 Layout
```php
// resources/views/notify/layouts/default.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Base styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .content {
            padding: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        @include('notify::partials.header')
        
        <div class="content">
            {{ $slot }}
        </div>
        
        @include('notify::partials.footer')
    </div>
</body>
</html>
```

### 4.2 Components
```php
// resources/views/notify/partials/header.blade.php
<div class="header">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="150">
</div>

// resources/views/notify/partials/footer.blade.php
<div class="footer">
    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    <p>
        <a href="{{ config('app.url') }}/unsubscribe">Unsubscribe</a> |
        <a href="{{ config('app.url') }}/preferences">Email Preferences</a>
    </p>
</div>
```

## 5. Utilizzo

### 5.1 Creazione Template
```php
$template = Template::create([
    'name' => 'Welcome Email',
    'subject' => 'Welcome to {{ app_name }}',
    'content' => view('notify::templates.welcome')->render(),
    'layout' => 'default',
    'is_active' => true
]);
```

### 5.2 Invio Email
```php
$template->send('user@example.com', [
    'app_name' => config('app.name'),
    'user_name' => 'John Doe'
]);
```

## 6. Testing

### 6.1 Unit Tests
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Models\Template;
use Modules\Notify\Services\TemplateService;

class TemplateTest extends TestCase
{
    protected $templateService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->templateService = app(TemplateService::class);
    }

    public function test_can_create_template()
    {
        $data = [
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'content' => 'Test Content',
            'layout' => 'default',
            'is_active' => true
        ];

        $template = $this->templateService->create($data);

        $this->assertInstanceOf(Template::class, $template);
        $this->assertEquals($data['name'], $template->name);
        $this->assertEquals($data['subject'], $template->subject);
        $this->assertEquals($data['content'], $template->content);
    }

    public function test_can_update_template()
    {
        $template = Template::factory()->create();

        $data = [
            'name' => 'Updated Template',
            'subject' => 'Updated Subject',
            'content' => 'Updated Content',
            'layout' => 'default',
            'is_active' => true
        ];

        $updated = $this->templateService->update($template, $data);

        $this->assertEquals($data['name'], $updated->name);
        $this->assertEquals($data['subject'], $updated->subject);
        $this->assertEquals($data['content'], $updated->content);
    }
}
```

### 6.2 Feature Tests
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\Template;

class TemplateControllerTest extends TestCase
{
    public function test_can_view_templates_index()
    {
        $response = $this->get(route('notify.templates.index'));

        $response->assertStatus(200);
        $response->assertViewIs('notify::templates.index');
    }

    public function test_can_create_template()
    {
        $data = [
            'name' => 'Test Template',
            'subject' => 'Test Subject',
            'content' => 'Test Content',
            'layout' => 'default',
            'is_active' => true
        ];

        $response = $this->post(route('notify.templates.store'), $data);

        $response->assertRedirect(route('notify.templates.show', Template::first()));
        $this->assertDatabaseHas('templates', $data);
    }

    public function test_can_preview_template()
    {
        $template = Template::factory()->create();

        $response = $this->get(route('notify.templates.preview', $template));

        $response->assertStatus(200);
        $response->assertViewIs('notify::templates.preview');
    }
}
```

## 7. Note Importanti

1. **Versioning**
   - Mantenere versioni dei template
   - Implementare diff tra versioni
   - Permettere rollback

2. **Caching**
   - Cache template compilati
   - Cache query frequenti
   - Implementare cache tags

3. **Testing**
   - Test su vari client email
   - Test responsive design
   - Test performance

4. **Documentazione**
   - Documentare variabili disponibili
   - Mantenere changelog
   - Documentare API

## 8. Collegamenti Utili

- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [MJML Documentation](https://mjml.io/documentation/)
- [Mailgun API](https://documentation.mailgun.com/en/latest/api_reference.html)
- [Filament Documentation](https://filamentphp.com/docs) 
