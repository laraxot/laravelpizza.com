# Sistema Template Email

## Architettura

### 1. Struttura Directory
```
resources/
├── views/
│   ├── vendor/
│   │   └── notifications/
│   │       └── email/
│   │           ├── base.blade.php
│   │           ├── layouts/
│   │           │   ├── default.blade.php
│   │           │   └── custom.blade.php
│   │           └── templates/
│   │               ├── welcome.blade.php
│   │               ├── appointment.blade.php
│   │               └── notification.blade.php
│   └── components/
│       └── email/
│           ├── header.blade.php
│           ├── footer.blade.php
│           └── button.blade.php
```

### 2. Sistema di Cache
```php
// app/Services/TemplateCacheService.php
class TemplateCacheService
{
    private $cache;
    private $ttl = 3600; // 1 ora

    public function get($key)
    {
        return $this->cache->remember("template:{$key}", $this->ttl, function () use ($key) {
            return $this->loadTemplate($key);
        });
    }

    public function invalidate($key)
    {
        $this->cache->forget("template:{$key}");
        $this->logInvalidation($key);
    }

    private function loadTemplate($key)
    {
        // 1. Carica template da storage
        // 2. Valida struttura
        // 3. Compila assets
        // 4. Cache risultato
    }
}
```

### 3. Versioning
```php
// app/Services/TemplateVersionService.php
class TemplateVersionService
{
    public function createVersion($template)
    {
        $version = [
            'id' => Str::uuid(),
            'template' => $template,
            'created_at' => now(),
            'created_by' => auth()->id(),
            'changes' => $this->getChanges($template),
        ];

        $this->storeVersion($version);
        $this->updateCurrentVersion($template, $version['id']);
        
        return $version;
    }

    public function rollback($templateId, $versionId)
    {
        $version = $this->getVersion($versionId);
        $this->validateRollback($version);
        $this->applyVersion($templateId, $version);
        $this->logRollback($templateId, $versionId);
    }
}
```

## Gestione Template

### 1. Validazione
```php
// app/Services/TemplateValidationService.php
class TemplateValidationService
{
    public function validate($template)
    {
        $rules = [
            'structure' => $this->validateStructure(),
            'variables' => $this->validateVariables(),
            'styles' => $this->validateStyles(),
            'accessibility' => $this->validateAccessibility(),
        ];

        return $this->applyRules($template, $rules);
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

### 2. Compilazione
```php
// app/Services/TemplateCompilationService.php
class TemplateCompilationService
{
    public function compile($template, $data)
    {
        // 1. Pre-processo
        $preprocessed = $this->preprocess($template);
        
        // 2. Sostituzione variabili
        $withVariables = $this->replaceVariables($preprocessed, $data);
        
        // 3. Compilazione assets
        $withAssets = $this->compileAssets($withVariables);
        
        // 4. Post-processo
        return $this->postprocess($withAssets);
    }

    private function preprocess($template)
    {
        // 1. Validazione sintassi
        // 2. Normalizzazione
        // 3. Ottimizzazione
        // 4. Cache intermedia
    }
}
```

## Ottimizzazione

### 1. Performance
```php
// app/Services/TemplateOptimizationService.php
class TemplateOptimizationService
{
    public function optimize($template)
    {
        return $this->pipeline()
            ->send($template)
            ->through([
                'minifyHtml',
                'optimizeImages',
                'inlineStyles',
                'compressAssets',
            ])
            ->thenReturn();
    }

    private function minifyHtml($template)
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
// app/Services/TemplateCacheStrategy.php
class TemplateCacheStrategy
{
    public function getCacheKey($template, $data)
    {
        return md5(json_encode([
            'template' => $template,
            'data' => $this->normalizeData($data),
            'locale' => app()->getLocale(),
            'version' => $this->getVersion(),
        ]));
    }

    public function shouldCache($template)
    {
        return $this->isCacheable($template) &&
               $this->isNotExpired($template) &&
               $this->isNotDynamic($template);
    }
}
```

## Testing

### 1. Unit Test
```php
// tests/Unit/TemplateTest.php
class TemplateTest extends TestCase
{
    public function test_template_compilation()
    {
        $template = $this->getTestTemplate();
        $data = $this->getTestData();
        
        $result = $this->compilationService->compile($template, $data);
        
        $this->assertValidHtml($result);
        $this->assertVariablesReplaced($result, $data);
        $this->assertAssetsCompiled($result);
    }
}
```

### 2. Integration Test
```php
// tests/Integration/TemplateSystemTest.php
class TemplateSystemTest extends TestCase
{
    public function test_full_template_lifecycle()
    {
        // 1. Creazione template
        $template = $this->createTemplate();
        
        // 2. Versioning
        $version = $this->versionService->createVersion($template);
        
        // 3. Compilazione
        $compiled = $this->compilationService->compile($template, $this->getTestData());
        
        // 4. Cache
        $cached = $this->cacheService->get($template->id);
        
        // 5. Validazione
        $this->assertValidTemplate($cached);
    }
}
```

## Monitoraggio

### 1. Metrics
```php
// app/Services/TemplateMetricsService.php
class TemplateMetricsService
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
            'compilation_time' => $this->getCompilationTime(),
            'cache_hit_rate' => $this->getCacheHitRate(),
            'memory_usage' => $this->getMemoryUsage(),
            'template_size' => $this->getTemplateSize(),
        ];
    }
}
```

### 2. Logging
```php
// app/Services/TemplateLoggingService.php
class TemplateLoggingService
{
    public function log($action, $template, $data = [])
    {
        $log = [
            'action' => $action,
            'template_id' => $template->id,
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
