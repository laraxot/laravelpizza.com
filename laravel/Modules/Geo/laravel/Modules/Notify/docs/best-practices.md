# Best Practices e Raccomandazioni

## 1. Design e Layout

### 1.1 Responsive Design
```php
// resources/views/notify/layouts/responsive.blade.php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                padding: 10px !important;
            }
            .header img {
                width: 120px !important;
            }
            .content {
                padding: 10px 0 !important;
            }
            .footer {
                font-size: 10px !important;
            }
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

### 1.2 Compatibilità
```php
namespace Modules\Notify\Services;

class CompatibilityService
{
    protected $supportedClients = [
        'gmail' => ['version' => 'latest'],
        'outlook' => ['version' => '2016+'],
        'apple-mail' => ['version' => 'latest'],
        'yahoo' => ['version' => 'latest']
    ];

    public function validate($template)
    {
        $issues = [];

        foreach ($this->supportedClients as $client => $requirements) {
            $clientIssues = $this->checkClientCompatibility($template, $client);
            if (!empty($clientIssues)) {
                $issues[$client] = $clientIssues;
            }
        }

        return $issues;
    }

    protected function checkClientCompatibility($template, $client)
    {
        $issues = [];

        // Verifica CSS supportato
        if (!$this->isCssSupported($template->styles, $client)) {
            $issues[] = "CSS non supportato per {$client}";
        }

        // Verifica HTML supportato
        if (!$this->isHtmlSupported($template->content, $client)) {
            $issues[] = "HTML non supportato per {$client}";
        }

        return $issues;
    }
}
```

### 1.3 Performance
```php
namespace Modules\Notify\Services;

class PerformanceOptimizer
{
    protected $cache;
    protected $imageOptimizer;

    public function __construct()
    {
        $this->cache = app('cache');
        $this->imageOptimizer = new ImageOptimizer();
    }

    public function optimize($template)
    {
        // Ottimizza immagini
        $template->content = $this->optimizeImages($template->content);

        // Minifica CSS
        $template->styles = $this->minifyCss($template->styles);

        // Inline critical CSS
        $template->content = $this->inlineCriticalCss($template->content, $template->styles);

        return $template;
    }

    protected function optimizeImages($content)
    {
        preg_match_all('/<img[^>]+>/', $content, $matches);

        foreach ($matches[0] as $img) {
            $optimized = $this->imageOptimizer->optimize($img);
            $content = str_replace($img, $optimized, $content);
        }

        return $content;
    }

    protected function minifyCss($css)
    {
        // Rimuovi commenti
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

        // Rimuovi spazi
        $css = str_replace(["\r\n", "\r", "\n", "\t"], '', $css);
        $css = preg_replace('/\s+/', ' ', $css);

        return trim($css);
    }
}
```

## 2. Struttura del Codice

### 2.1 Organizzazione
```php
namespace Modules\Notify;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TemplateService::class);
        $this->app->singleton(MjmlService::class);
        $this->app->singleton(MailgunService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'notify');
    }
}
```

### 2.2 Convenzioni di Naming
```php
namespace Modules\Notify\Services;

class TemplateService
{
    // Nomi metodi chiari e descrittivi
    public function createTemplate(array $data)
    {
        return $this->template->create($data);
    }

    public function updateTemplate(Template $template, array $data)
    {
        return $this->template->update($data);
    }

    public function deleteTemplate(Template $template)
    {
        return $this->template->delete();
    }

    // Nomi variabili significativi
    protected function processTemplateContent($rawContent)
    {
        $processedContent = $this->sanitizeContent($rawContent);
        $validatedContent = $this->validateContent($processedContent);
        return $validatedContent;
    }
}
```

### 2.3 Documentazione
```php
namespace Modules\Notify\Services;

/**
 * Servizio per la gestione dei template email
 *
 * @package Modules\Notify\Services
 */
class TemplateService
{
    /**
     * Crea un nuovo template
     *
     * @param array $data Dati del template
     * @return Template
     * @throws TemplateException
     */
    public function create(array $data)
    {
        // Implementazione
    }

    /**
     * Aggiorna un template esistente
     *
     * @param Template $template Template da aggiornare
     * @param array $data Dati di aggiornamento
     * @return Template
     * @throws TemplateException
     */
    public function update(Template $template, array $data)
    {
        // Implementazione
    }
}
```

## 3. Sicurezza

### 3.1 Sanitizzazione
```php
namespace Modules\Notify\Services;

class TemplateSanitizer
{
    protected $allowedTags = [
        'p', 'br', 'strong', 'em', 'a', 'img',
        'table', 'tr', 'td', 'th', 'thead', 'tbody'
    ];

    protected $allowedAttributes = [
        'src', 'alt', 'href', 'class', 'style'
    ];

    public function sanitize($content)
    {
        // Sanitizza HTML
        $content = strip_tags($content, $this->allowedTags);

        // Sanitizza attributi
        $content = $this->sanitizeAttributes($content);

        // Sanitizza CSS
        $content = $this->sanitizeCss($content);

        return $content;
    }

    protected function sanitizeAttributes($content)
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach ($dom->getElementsByTagName('*') as $element) {
            $attributes = $element->attributes;
            for ($i = $attributes->length - 1; $i >= 0; $i--) {
                $attribute = $attributes->item($i);
                if (!in_array($attribute->name, $this->allowedAttributes)) {
                    $element->removeAttributeNode($attribute);
                }
            }
        }

        return $dom->saveHTML();
    }
}
```

### 3.2 Validazione
```php
namespace Modules\Notify\Rules;

class TemplateRule implements Rule
{
    public function passes($attribute, $value)
    {
        return $this->validateStructure($value) &&
               $this->validateVariables($value) &&
               $this->validateContent($value);
    }

    protected function validateStructure($template)
    {
        // Validazione struttura HTML
        if (!$this->isValidHtml($template)) {
            return false;
        }

        // Validazione tag consentiti
        if (!$this->hasValidTags($template)) {
            return false;
        }

        return true;
    }

    protected function validateVariables($template)
    {
        // Validazione variabili template
        $variables = $this->extractVariables($template);
        foreach ($variables as $variable) {
            if (!$this->isValidVariable($variable)) {
                return false;
            }
        }

        return true;
    }
}
```

## 4. Caching

### 4.1 Strategie di Cache
```php
namespace Modules\Notify\Services;

class TemplateCache
{
    protected $cache;
    protected $ttl;

    public function __construct()
    {
        $this->cache = app('cache');
        $this->ttl = config('mail-templates.cache.ttl', 3600);
    }

    public function remember($key, $callback)
    {
        return $this->cache->remember(
            "template.{$key}",
            $this->ttl,
            $callback
        );
    }

    public function tags($tags)
    {
        return $this->cache->tags($tags);
    }

    public function flush()
    {
        return $this->cache->tags(['templates'])->flush();
    }
}
```

### 4.2 Invalidation
```php
namespace Modules\Notify\Services;

class CacheInvalidator
{
    protected $cache;

    public function __construct()
    {
        $this->cache = app('cache');
    }

    public function invalidate($template)
    {
        // Invalida cache template
        $this->cache->forget("template.{$template->id}");

        // Invalida cache traduzioni
        $this->cache->forget("template.{$template->id}.translations");

        // Invalida cache versioni
        $this->cache->forget("template.{$template->id}.versions");

        // Invalida cache analytics
        $this->cache->forget("template.{$template->id}.analytics");
    }
}
```

## 5. Testing

### 5.1 Unit Tests
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\TemplateService;
use Modules\Notify\Services\MjmlService;
use Modules\Notify\Services\MailgunService;

class TemplateServiceTest extends TestCase
{
    protected $templateService;
    protected $mjmlService;
    protected $mailgunService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->templateService = app(TemplateService::class);
        $this->mjmlService = app(MjmlService::class);
        $this->mailgunService = app(MailgunService::class);
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

    public function test_can_compile_mjml()
    {
        $mjml = '<mjml><mj-body><mj-section><mj-column><mj-text>Hello World</mj-text></mj-column></mj-section></mj-body></mjml>';

        $result = $this->mjmlService->compile($mjml);

        $this->assertArrayHasKey('html', $result);
        $this->assertArrayHasKey('errors', $result);
        $this->assertEmpty($result['errors']);
    }
}
```

### 5.2 Feature Tests
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

## 6. Monitoraggio

### 6.1 Logging
```php
namespace Modules\Notify\Services;

class TemplateLogger
{
    protected $logger;

    public function __construct()
    {
        $this->logger = Log::channel('templates');
    }

    public function log($event, $data)
    {
        $this->logger->info($event, [
            'timestamp' => now(),
            'user_id' => auth()->id(),
            'data' => $data
        ]);
    }

    public function error($event, $data)
    {
        $this->logger->error($event, [
            'timestamp' => now(),
            'user_id' => auth()->id(),
            'data' => $data
        ]);
    }
}
```

### 6.2 Analytics
```php
namespace Modules\Notify\Services;

class TemplateAnalytics
{
    protected $metrics;

    public function __construct()
    {
        $this->metrics = new MetricsCollector();
    }

    public function track($template, $event)
    {
        return $this->metrics->record([
            'template_id' => $template->id,
            'event' => $event,
            'timestamp' => now(),
            'user_id' => auth()->id(),
            'metadata' => [
                'user_agent' => request()->userAgent(),
                'ip' => request()->ip()
            ]
        ]);
    }

    public function getMetrics($template, $period = 'daily')
    {
        return $this->metrics->get($template, $period);
    }
}
```

## 7. Manutenzione

### 7.1 Versioning
```php
namespace Modules\Notify\Services;

class VersionManager
{
    protected $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function createVersion($content)
    {
        $version = $this->template->versions()->count() + 1;

        return $this->template->versions()->create([
            'version' => $version,
            'content' => $content,
            'created_by' => auth()->id(),
            'changes' => $this->getChanges($content)
        ]);
    }

    public function rollback($version)
    {
        $oldVersion = $this->template->versions()
            ->where('version', $version)
            ->first();

        if (!$oldVersion) {
            throw new VersionNotFoundException("Version {$version} not found");
        }

        $this->template->update([
            'content' => $oldVersion->content
        ]);

        return $this->createVersion($oldVersion->content);
    }

    protected function getChanges($content)
    {
        $previousVersion = $this->template->versions()->latest()->first();

        if (!$previousVersion) {
            return null;
        }

        return [
            'added' => $this->getAddedLines($previousVersion->content, $content),
            'removed' => $this->getRemovedLines($previousVersion->content, $content),
            'modified' => $this->getModifiedLines($previousVersion->content, $content)
        ];
    }
}
```

### 7.2 Backup
```php
namespace Modules\Notify\Console\Commands;

class BackupTemplates extends Command
{
    protected $signature = 'notify:backup-templates';
    protected $description = 'Backup all email templates';

    public function handle()
    {
        $templates = Template::with(['translations', 'versions'])->get();

        $backup = [
            'timestamp' => now(),
            'templates' => $templates->toArray()
        ];

        $filename = 'templates-' . now()->format('Y-m-d-His') . '.json';

        Storage::put(
            "backups/{$filename}",
            json_encode($backup, JSON_PRETTY_PRINT)
        );

        $this->info("Backup created: {$filename}");
    }
}
```

## 8. Note Finali

1. **Documentazione**
   - Mantenere documentazione aggiornata
   - Documentare tutte le API
   - Mantenere changelog

2. **Logging**
   - Implementare logging dettagliato
   - Monitorare errori
   - Tracciare performance

3. **Testing**
   - Eseguire test regolarmente
   - Testare su vari client
   - Verificare performance

4. **Performance**
   - Monitorare metriche
   - Ottimizzare query
   - Implementare caching

5. **Backup**
   - Eseguire backup regolari
   - Verificare backup
   - Testare ripristino

6. **Code Review**
   - Revisionare codice
   - Verificare standard
   - Controllare sicurezza

7. **Sicurezza**
   - Aggiornare dipendenze
   - Scansionare vulnerabilità
   - Implementare best practices 
