# Editor Visuale Template

## Architettura

### 1. Componenti
```php
// app/Filament/Resources/EmailTemplateResource.php
class EmailTemplateResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Builder::make('content')
                ->blocks([
                    Builder\Block::make('text')
                        ->schema([
                            Forms\Components\RichEditor::make('content')
                                ->required()
                                ->rules(['required', 'string', 'max:10000'])
                                ->columnSpanFull(),
                        ]),
                    Builder\Block::make('image')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->required()
                                ->image()
                                ->maxSize(5120)
                                ->columnSpanFull(),
                        ]),
                    Builder\Block::make('button')
                        ->schema([
                            Forms\Components\TextInput::make('text')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('url')
                                ->required()
                                ->url()
                                ->maxLength(255),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }
}
```

### 2. Editor GrapesJS
```php
// app/Services/EditorService.php
class EditorService
{
    public function initializeEditor($container)
    {
        return $this->editor = grapesjs.init({
            container: $container,
            plugins: [
                'gjs-preset-webpage',
                'gjs-blocks-basic',
                'gjs-plugin-forms',
                'gjs-custom-code',
            ],
            pluginsOpts: {
                'gjs-preset-webpage': {},
                'gjs-blocks-basic': {},
                'gjs-plugin-forms': {},
                'gjs-custom-code': {},
            },
            storageManager: {
                type: 'remote',
                autosave: true,
                stepsBeforeSave: 1,
                urlStore: '/api/templates/store',
                urlLoad: '/api/templates/load',
                params: {
                    _token: document.querySelector('meta[name="csrf-token"]').content
                },
            },
        });
    }
}
```

## Funzionalità

### 1. Preview
```php
// app/Services/PreviewService.php
class PreviewService
{
    public function generatePreview($template, $data = [])
    {
        // 1. Compila template
        $compiled = $this->compileTemplate($template);
        
        // 2. Sostituisci variabili
        $withVariables = $this->replaceVariables($compiled, $data);
        
        // 3. Applica stili
        $withStyles = $this->applyStyles($withVariables);
        
        // 4. Genera preview
        return $this->renderPreview($withStyles);
    }

    private function compileTemplate($template)
    {
        // 1. Validazione
        // 2. Compilazione
        // 3. Ottimizzazione
        // 4. Cache
    }
}
```

### 2. Validazione
```php
// app/Services/EditorValidationService.php
class EditorValidationService
{
    public function validate($content)
    {
        $rules = [
            'structure' => $this->validateStructure(),
            'content' => $this->validateContent(),
            'styles' => $this->validateStyles(),
            'accessibility' => $this->validateAccessibility(),
        ];

        return $this->applyRules($content, $rules);
    }

    private function validateStructure()
    {
        return [
            'required' => ['header', 'content', 'footer'],
            'max_length' => 10000,
            'allowed_tags' => ['div', 'p', 'a', 'img', 'table'],
            'required_attributes' => ['alt' => 'img'],
        ];
    }
}
```

## Integrazione

### 1. Filament
```php
// app/Filament/Resources/EmailTemplateResource/Actions/PreviewAction.php
class PreviewAction extends Action
{
    public function handle()
    {
        $template = $this->getTemplate();
        $data = $this->getTestData();
        
        $preview = $this->previewService->generatePreview($template, $data);
        
        return $this->response()
            ->success()
            ->html($preview);
    }
}
```

### 2. API
```php
// app/Http/Controllers/Api/TemplateController.php
class TemplateController extends Controller
{
    public function store(Request $request)
    {
        $template = $request->validate([
            'content' => 'required|string',
            'styles' => 'array',
            'assets' => 'array',
        ]);

        $saved = $this->templateService->save($template);
        
        return response()->json([
            'success' => true,
            'template' => $saved,
        ]);
    }
}
```

## Ottimizzazione

### 1. Performance
```php
// app/Services/EditorOptimizationService.php
class EditorOptimizationService
{
    public function optimize($content)
    {
        return $this->pipeline()
            ->send($content)
            ->through([
                'minifyHtml',
                'optimizeImages',
                'inlineStyles',
                'compressAssets',
            ])
            ->thenReturn();
    }

    private function minifyHtml($content)
    {
        // 1. Rimuovi spazi
        // 2. Rimuovi commenti
        // 3. Ottimizza tag
        // 4. Valida output
    }
}
```

### 2. Caching
```php
// app/Services/EditorCacheService.php
class EditorCacheService
{
    public function get($key)
    {
        return $this->cache->remember("editor:{$key}", 3600, function () use ($key) {
            return $this->loadContent($key);
        });
    }

    public function invalidate($key)
    {
        $this->cache->forget("editor:{$key}");
        $this->logInvalidation($key);
    }
}
```

## Testing

### 1. Unit Test
```php
// tests/Unit/EditorTest.php
class EditorTest extends TestCase
{
    public function test_editor_initialization()
    {
        $editor = $this->editorService->initializeEditor('#editor');
        
        $this->assertInstanceOf(GrapesJS::class, $editor);
        $this->assertTrue($editor->isReady());
    }
}
```

### 2. Integration Test
```php
// tests/Integration/EditorSystemTest.php
class EditorSystemTest extends TestCase
{
    public function test_full_editor_workflow()
    {
        // 1. Inizializzazione
        $editor = $this->initializeEditor();
        
        // 2. Modifica contenuto
        $this->editContent($editor);
        
        // 3. Preview
        $preview = $this->generatePreview($editor);
        
        // 4. Salvataggio
        $saved = $this->saveContent($editor);
        
        // 5. Validazione
        $this->assertValidContent($saved);
    }
}
```

## Monitoraggio

### 1. Metrics
```php
// app/Services/EditorMetricsService.php
class EditorMetricsService
{
    public function collectMetrics()
    {
        return [
            'performance' => $this->getPerformanceMetrics(),
            'usage' => $this->getUsageMetrics(),
            'errors' => $this->getErrorMetrics(),
            'cache' => $this->getCacheMetrics(),
        ];
    }

    private function getPerformanceMetrics()
    {
        return [
            'load_time' => $this->getLoadTime(),
            'save_time' => $this->getSaveTime(),
            'preview_time' => $this->getPreviewTime(),
            'memory_usage' => $this->getMemoryUsage(),
        ];
    }
}
```

### 2. Logging
```php
// app/Services/EditorLoggingService.php
class EditorLoggingService
{
    public function log($action, $data = [])
    {
        $log = [
            'action' => $action,
            'user_id' => auth()->id(),
            'timestamp' => now(),
            'data' => $data,
        ];

        $this->storeLog($log);
        $this->notifyIfNeeded($log);
    }
}
```

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md). 
