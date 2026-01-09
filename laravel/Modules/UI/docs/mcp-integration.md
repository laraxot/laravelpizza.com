# Integrazione dei Server MCP con il Modulo UI

## Panoramica

Questo documento fornisce linee guida per l'integrazione dei server MCP (Model Context Protocol) con il modulo UI, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila3_mono.

## Server MCP Consigliati

Per il modulo UI, si consigliano i seguenti server MCP:

### 1. Puppeteer

**Scopo**: Automazione del browser per testing, screenshot e interazioni con l'interfaccia utente.

**Casi d'uso**:
- Generazione automatica di screenshot per documentazione
- Testing automatico dell'interfaccia utente
- Estrazione di contenuti da pagine web
- Verifica della compatibilità cross-browser

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GenerateUIScreenshotsAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Genera screenshot delle interfacce UI.
     *
     * @param array<string> $routes Percorsi delle route da catturare
     * @param string $outputDir Directory di output per gli screenshot
     * @param array<string, mixed> $options Opzioni aggiuntive per Puppeteer
     *
     * @return array<string, string> Mappa di route => percorso screenshot
     */
    public function execute(array $routes, string $outputDir, array $options = []): array
    {
        $results = [];

        // Assicurati che la directory di output esista
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        foreach ($routes as $route) {
            try {
                $url = route($route);
                $fileName = Str::slug($route) . '.png';
                $outputPath = $outputDir . '/' . $fileName;

                Log::info("Generating screenshot for route: {$route}", [
                    'url' => $url,
                    'output_path' => $outputPath
                ]);

                $screenshotPath = $this->mcpService->puppeteer()->captureScreenshot(
                    $url,
                    $outputPath,
                    array_merge([
                        'fullPage' => true,
                        'type' => 'png',
                        'omitBackground' => false
                    ], $options)
                );

                if ($screenshotPath) {
                    $results[$route] = $screenshotPath;
                    Log::info("Screenshot generated successfully", [
                        'route' => $route,
                        'path' => $screenshotPath
                    ]);
                } else {
                    Log::error("Failed to generate screenshot", [
                        'route' => $route
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("Exception while generating screenshot", [
                    'route' => $route,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return $results;
    }
}
```

### 2. Filesystem

**Scopo**: Gestione dei file per asset UI, temi e configurazioni.

**Casi d'uso**:
- Gestione dei file di tema
- Lettura e scrittura di file di configurazione UI
- Gestione degli asset (CSS, JS, immagini)
- Backup e ripristino delle configurazioni UI

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;

class ThemeFileService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Legge un file di tema.
     *
     * @param string $themeName Nome del tema
     * @param string $filePath Percorso relativo del file all'interno del tema
     *
     * @return string|null Contenuto del file o null se non trovato
     */
    public function readThemeFile(string $themeName, string $filePath): ?string
    {
        $fullPath = $this->getThemePath($themeName) . '/' . $filePath;

        try {
            $content = $this->mcpService->filesystem()->readFile($fullPath);

            return $content ?: null;
        } catch (\Exception $e) {
            Log::error("Failed to read theme file", [
                'theme' => $themeName,
                'file' => $filePath,
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Scrive un file di tema.
     *
     * @param string $themeName Nome del tema
     * @param string $filePath Percorso relativo del file all'interno del tema
     * @param string $content Contenuto da scrivere
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function writeThemeFile(string $themeName, string $filePath, string $content): bool
    {
        $fullPath = $this->getThemePath($themeName) . '/' . $filePath;

        try {
            // Assicurati che la directory esista
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            return $this->mcpService->filesystem()->writeFile($fullPath, $content);
        } catch (\Exception $e) {
            Log::error("Failed to write theme file", [
                'theme' => $themeName,
                'file' => $filePath,
                'message' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Elenca i file di un tema.
     *
     * @param string $themeName Nome del tema
     * @param string $directory Directory relativa all'interno del tema
     *
     * @return array<int, array<string, mixed>> Lista dei file
     */
    public function listThemeFiles(string $themeName, string $directory = ''): array
    {
        $fullPath = $this->getThemePath($themeName);

        if ($directory) {
            $fullPath .= '/' . $directory;
        }

        try {
            return $this->mcpService->filesystem()->listDirectory($fullPath);
        } catch (\Exception $e) {
            Log::error("Failed to list theme files", [
                'theme' => $themeName,
                'directory' => $directory,
                'message' => $e->getMessage()
            ]);

            return [];
        }
    }

    /**
     * Ottiene il percorso completo di un tema.
     *
     * @param string $themeName Nome del tema
     *
     * @return string Percorso completo del tema
     */
    private function getThemePath(string $themeName): string
    {
        return base_path('Themes/' . $themeName);
    }
}
```

### 3. Redis

**Scopo**: Caching di componenti UI e configurazioni.

**Casi d'uso**:
- Caching di componenti UI renderizzati
- Memorizzazione di configurazioni UI
- Gestione dello stato dell'interfaccia utente
- Throttling delle richieste di rendering

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;

class UICacheService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Memorizza un componente UI renderizzato in cache.
     *
     * @param string $componentName Nome del componente
     * @param array<string, mixed> $props Proprietà del componente
     * @param string $renderedHtml HTML renderizzato
     * @param int $ttl Tempo di vita in secondi
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function cacheComponent(string $componentName, array $props, string $renderedHtml, int $ttl = 3600): bool
    {
        $cacheKey = $this->generateComponentCacheKey($componentName, $props);

        try {
            return $this->mcpService->redis()->set(
                $cacheKey,
                [
                    'html' => $renderedHtml,
                    'cached_at' => now()->toIso8601String()
                ],
                $ttl
            );
        } catch (\Exception $e) {
            Log::error("Failed to cache UI component", [
                'component' => $componentName,
                'message' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Recupera un componente UI renderizzato dalla cache.
     *
     * @param string $componentName Nome del componente
     * @param array<string, mixed> $props Proprietà del componente
     *
     * @return string|null HTML renderizzato o null se non trovato
     */
    public function getCachedComponent(string $componentName, array $props): ?string
    {
        $cacheKey = $this->generateComponentCacheKey($componentName, $props);

        try {
            $cached = $this->mcpService->redis()->get($cacheKey);

            if ($cached && isset($cached['html'])) {
                return $cached['html'];
            }

            return null;
        } catch (\Exception $e) {
            Log::error("Failed to get cached UI component", [
                'component' => $componentName,
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Invalida la cache di un componente UI.
     *
     * @param string $componentName Nome del componente
     * @param array<string, mixed> $props Proprietà del componente
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function invalidateComponentCache(string $componentName, array $props = []): bool
    {
        if (empty($props)) {
            // Invalida tutti i componenti con questo nome
            $pattern = "ui_component_{$componentName}_*";

            try {
                $keys = $this->mcpService->redis()->keys($pattern);

                foreach ($keys as $key) {
                    $this->mcpService->redis()->delete($key);
                }

                return true;
            } catch (\Exception $e) {
                Log::error("Failed to invalidate UI component cache", [
                    'component' => $componentName,
                    'message' => $e->getMessage()
                ]);

                return false;
            }
        } else {
            // Invalida un componente specifico
            $cacheKey = $this->generateComponentCacheKey($componentName, $props);

            try {
                return $this->mcpService->redis()->delete($cacheKey);
            } catch (\Exception $e) {
                Log::error("Failed to invalidate UI component cache", [
                    'component' => $componentName,
                    'message' => $e->getMessage()
                ]);

                return false;
            }
        }
    }

    /**
     * Genera una chiave di cache per un componente UI.
     *
     * @param string $componentName Nome del componente
     * @param array<string, mixed> $props Proprietà del componente
     *
     * @return string Chiave di cache
     */
    private function generateComponentCacheKey(string $componentName, array $props): string
    {
        $propsHash = md5(json_encode($props));

        return "ui_component_{$componentName}_{$propsHash}";
    }
}
```

### 4. Sequential Thinking

**Scopo**: Analisi e ottimizzazione dell'interfaccia utente.

**Casi d'uso**:
- Analisi dell'accessibilità dell'interfaccia utente
- Generazione di suggerimenti per migliorare l'UX
- Analisi delle performance dell'interfaccia utente
- Ottimizzazione dei componenti UI

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;
use Modules\UI\DataObjects\UIAnalysisData;

class AnalyzeUIAccessibilityAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Analizza l'accessibilità di una pagina UI.
     *
     * @param string $url URL della pagina da analizzare
     *
     * @return UIAnalysisData I dati dell'analisi
     */
    public function execute(string $url): UIAnalysisData
    {
        try {
            // Estrai il contenuto HTML della pagina
            $html = $this->mcpService->puppeteer()->extractContent($url, 'html');

            if (!$html) {
                Log::error("Failed to extract HTML content", [
                    'url' => $url
                ]);

                return new UIAnalysisData(
                    score: 0,
                    issues: ['Failed to extract HTML content'],
                    suggestions: ['Check if the URL is accessible']
                );
            }

            // Analizza l'accessibilità con sequential-thinking
            $analysis = $this->mcpService->sequentialThinking()->analyze(
                $html,
                ['accessibility', 'usability', 'performance']
            );

            $accessibilityScore = $analysis['accessibility']['score'] ?? 0;
            $accessibilityIssues = $analysis['accessibility']['issues'] ?? [];
            $suggestions = $analysis['accessibility']['suggestions'] ?? [];

            return new UIAnalysisData(
                score: $accessibilityScore,
                issues: $accessibilityIssues,
                suggestions: $suggestions
            );
        } catch (\Exception $e) {
            Log::error("Exception during UI accessibility analysis", [
                'url' => $url,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return new UIAnalysisData(
                score: 0,
                issues: ['Analysis failed: ' . $e->getMessage()],
                suggestions: ['Try again later or contact support']
            );
        }
    }
}
```

## Integrazione con Livewire e Volt

Per integrare i server MCP con Livewire e Volt nel modulo UI, è possibile creare componenti che utilizzano i server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Http\Livewire;

use Livewire\Component;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\UI\Services\UICacheService;

class CachedUIComponent extends Component
{
    /**
     * @var string
     */
    public string $componentName;

    /**
     * @var array<string, mixed>
     */
    public array $componentProps = [];

    /**
     * @var int
     */
    public int $cacheTtl = 3600;

    /**
     * @var bool
     */
    public bool $forceRefresh = false;

    /**
     * Monta il componente.
     *
     * @param string $componentName
     * @param array<string, mixed> $componentProps
     * @param int $cacheTtl
     *
     * @return void
     */
    public function mount(string $componentName, array $componentProps = [], int $cacheTtl = 3600): void
    {
        $this->componentName = $componentName;
        $this->componentProps = $componentProps;
        $this->cacheTtl = $cacheTtl;
    }

    /**
     * Forza l'aggiornamento del componente.
     *
     * @return void
     */
    public function refresh(): void
    {
        $this->forceRefresh = true;
    }

    /**
     * Renderizza il componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        /** @var MCPServiceContract $mcpService */
        $mcpService = app(MCPServiceContract::class);

        /** @var UICacheService $uiCacheService */
        $uiCacheService = app(UICacheService::class);

        $html = null;

        if (!$this->forceRefresh) {
            $html = $uiCacheService->getCachedComponent($this->componentName, $this->componentProps);
        }

        if ($html === null) {
            // Renderizza il componente
            $html = view("ui::components.{$this->componentName}", $this->componentProps)->render();

            // Memorizza in cache
            $uiCacheService->cacheComponent($this->componentName, $this->componentProps, $html, $this->cacheTtl);
        }

        return view('ui::livewire.cached-ui-component', [
            'html' => $html
        ]);
    }
}
```

```php
<?php

declare(strict_types=1);

use function Livewire\Volt\{state, computed, mount};
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\UI\Actions\AnalyzeUIAccessibilityAction;

state([
    'url' => '',
    'isAnalyzing' => false,
    'analysisResult' => null
]);

$mount = function (string $url = '') {
    $this->url = $url;
};

$analyze = function () {
    $this->isAnalyzing = true;

    try {
        /** @var AnalyzeUIAccessibilityAction $analyzeAction */
        $analyzeAction = app(AnalyzeUIAccessibilityAction::class);

        $this->analysisResult = $analyzeAction->execute($this->url);
    } catch (\Exception $e) {
        $this->addError('analysis', $e->getMessage());
    } finally {
        $this->isAnalyzing = false;
    }
};

?>

<div>
    <div class="mb-4">
        <label for="url" class="block text-sm font-medium text-gray-700">URL da analizzare</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <input type="text" wire:model="url" id="url" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="https://example.com">
            <button wire:click="analyze" wire:loading.attr="disabled" class="ml-3 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <span wire:loading.remove wire:target="analyze">Analizza</span>
                <span wire:loading wire:target="analyze">Analisi in corso...</span>
            </button>
        </div>
        @error('analysis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    @if($analysisResult)
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Risultati dell'analisi di accessibilità</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">URL: {{ $url }}</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Punteggio di accessibilità</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $analysisResult->score }}/100</span>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $analysisResult->score }}%"></div>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Problemi rilevati</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if(count($analysisResult->issues) > 0)
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    @foreach($analysisResult->issues as $issue)
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <svg class="flex-shrink-0 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate">{{ $issue }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-green-500">Nessun problema rilevato</span>
                            @endif
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Suggerimenti</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if(count($analysisResult->suggestions) > 0)
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    @foreach($analysisResult->suggestions as $suggestion)
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate">{{ $suggestion }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-500">Nessun suggerimento disponibile</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    @endif
</div>
```

## Conclusione

L'integrazione dei server MCP con il modulo UI consente di migliorare significativamente le funzionalità del modulo, fornendo automazione del browser per testing e screenshot, gestione efficiente dei file per asset UI, caching di componenti UI e analisi dell'interfaccia utente. Seguendo le linee guida e gli esempi forniti in questo documento, è possibile implementare queste funzionalità in modo conforme alle regole di sviluppo stabilite per i progetti base_predict_fila3_mono.
# Integrazione dei Server MCP con il Modulo UI

## Panoramica

Questo documento fornisce linee guida per l'integrazione dei server MCP (Model Context Protocol) con il modulo UI, seguendo le regole di sviluppo e le convenzioni di codice stabilite per i progetti base_predict_fila3_mono.

## Server MCP Consigliati

Per il modulo UI, si consigliano i seguenti server MCP:

### 1. Puppeteer

**Scopo**: Automazione del browser per testing, screenshot e interazioni con l'interfaccia utente.

**Casi d'uso**:
- Generazione automatica di screenshot per documentazione
- Testing automatico dell'interfaccia utente
- Estrazione di contenuti da pagine web
- Verifica della compatibilità cross-browser

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GenerateUIScreenshotsAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Genera screenshot delle interfacce UI.
     *
     * @param array<string> $routes Percorsi delle route da catturare
     * @param string $outputDir Directory di output per gli screenshot
     * @param array<string, mixed> $options Opzioni aggiuntive per Puppeteer
     *
     * @return array<string, string> Mappa di route => percorso screenshot
     */
    public function execute(array $routes, string $outputDir, array $options = []): array
    {
        $results = [];

        // Assicurati che la directory di output esista
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        foreach ($routes as $route) {
            try {
                $url = route($route);
                $fileName = Str::slug($route) . '.png';
                $outputPath = $outputDir . '/' . $fileName;

                Log::info("Generating screenshot for route: {$route}", [
                    'url' => $url,
                    'output_path' => $outputPath
                ]);

                $screenshotPath = $this->mcpService->puppeteer()->captureScreenshot(
                    $url,
                    $outputPath,
                    array_merge([
                        'fullPage' => true,
                        'type' => 'png',
                        'omitBackground' => false
                    ], $options)
                );

                if ($screenshotPath) {
                    $results[$route] = $screenshotPath;
                    Log::info("Screenshot generated successfully", [
                        'route' => $route,
                        'path' => $screenshotPath
                    ]);
                } else {
                    Log::error("Failed to generate screenshot", [
                        'route' => $route
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("Exception while generating screenshot", [
                    'route' => $route,
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return $results;
    }
}
```

### 2. Filesystem

**Scopo**: Gestione dei file per asset UI, temi e configurazioni.

**Casi d'uso**:
- Gestione dei file di tema
- Lettura e scrittura di file di configurazione UI
- Gestione degli asset (CSS, JS, immagini)
- Backup e ripristino delle configurazioni UI

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;

class ThemeFileService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Legge un file di tema.
     *
     * @param string $themeName Nome del tema
     * @param string $filePath Percorso relativo del file all'interno del tema
     *
     * @return string|null Contenuto del file o null se non trovato
     */
    public function readThemeFile(string $themeName, string $filePath): ?string
    {
        $fullPath = $this->getThemePath($themeName) . '/' . $filePath;

        try {
            $content = $this->mcpService->filesystem()->readFile($fullPath);

            return $content ?: null;
        } catch (\Exception $e) {
            Log::error("Failed to read theme file", [
                'theme' => $themeName,
                'file' => $filePath,
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Scrive un file di tema.
     *
     * @param string $themeName Nome del tema
     * @param string $filePath Percorso relativo del file all'interno del tema
     * @param string $content Contenuto da scrivere
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function writeThemeFile(string $themeName, string $filePath, string $content): bool
    {
        $fullPath = $this->getThemePath($themeName) . '/' . $filePath;

        try {
            // Assicurati che la directory esista
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            return $this->mcpService->filesystem()->writeFile($fullPath, $content);
        } catch (\Exception $e) {
            Log::error("Failed to write theme file", [
                'theme' => $themeName,
                'file' => $filePath,
                'message' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Elenca i file di un tema.
     *
     * @param string $themeName Nome del tema
     * @param string $directory Directory relativa all'interno del tema
     *
     * @return array<int, array<string, mixed>> Lista dei file
     */
    public function listThemeFiles(string $themeName, string $directory = ''): array
    {
        $fullPath = $this->getThemePath($themeName);

        if ($directory) {
            $fullPath .= '/' . $directory;
        }

        try {
            return $this->mcpService->filesystem()->listDirectory($fullPath);
        } catch (\Exception $e) {
            Log::error("Failed to list theme files", [
                'theme' => $themeName,
                'directory' => $directory,
                'message' => $e->getMessage()
            ]);

            return [];
        }
    }

    /**
     * Ottiene il percorso completo di un tema.
     *
     * @param string $themeName Nome del tema
     *
     * @return string Percorso completo del tema
     */
    private function getThemePath(string $themeName): string
    {
        return base_path('Themes/' . $themeName);
    }
}
```

### 3. Redis

**Scopo**: Caching di componenti UI e configurazioni.

**Casi d'uso**:
- Caching di componenti UI renderizzati
- Memorizzazione di configurazioni UI
- Gestione dello stato dell'interfaccia utente
- Throttling delle richieste di rendering

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Services;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;

class UICacheService
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Memorizza un componente UI renderizzato in cache.
     *
     * @param string $componentName Nome del componente
     * @param array<string, mixed> $props Proprietà del componente
     * @param string $renderedHtml HTML renderizzato
     * @param int $ttl Tempo di vita in secondi
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function cacheComponent(string $componentName, array $props, string $renderedHtml, int $ttl = 3600): bool
    {
        $cacheKey = $this->generateComponentCacheKey($componentName, $props);

        try {
            return $this->mcpService->redis()->set(
                $cacheKey,
                [
                    'html' => $renderedHtml,
                    'cached_at' => now()->toIso8601String()
                ],
                $ttl
            );
        } catch (\Exception $e) {
            Log::error("Failed to cache UI component", [
                'component' => $componentName,
                'message' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Recupera un componente UI renderizzato dalla cache.
     *
     * @param string $componentName Nome del componente
     * @param array<string, mixed> $props Proprietà del componente
     *
     * @return string|null HTML renderizzato o null se non trovato
     */
    public function getCachedComponent(string $componentName, array $props): ?string
    {
        $cacheKey = $this->generateComponentCacheKey($componentName, $props);

        try {
            $cached = $this->mcpService->redis()->get($cacheKey);

            if ($cached && isset($cached['html'])) {
                return $cached['html'];
            }

            return null;
        } catch (\Exception $e) {
            Log::error("Failed to get cached UI component", [
                'component' => $componentName,
                'message' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Invalida la cache di un componente UI.
     *
     * @param string $componentName Nome del componente
     * @param array<string, mixed> $props Proprietà del componente
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function invalidateComponentCache(string $componentName, array $props = []): bool
    {
        if (empty($props)) {
            // Invalida tutti i componenti con questo nome
            $pattern = "ui_component_{$componentName}_*";

            try {
                $keys = $this->mcpService->redis()->keys($pattern);

                foreach ($keys as $key) {
                    $this->mcpService->redis()->delete($key);
                }

                return true;
            } catch (\Exception $e) {
                Log::error("Failed to invalidate UI component cache", [
                    'component' => $componentName,
                    'message' => $e->getMessage()
                ]);

                return false;
            }
        } else {
            // Invalida un componente specifico
            $cacheKey = $this->generateComponentCacheKey($componentName, $props);

            try {
                return $this->mcpService->redis()->delete($cacheKey);
            } catch (\Exception $e) {
                Log::error("Failed to invalidate UI component cache", [
                    'component' => $componentName,
                    'message' => $e->getMessage()
                ]);

                return false;
            }
        }
    }

    /**
     * Genera una chiave di cache per un componente UI.
     *
     * @param string $componentName Nome del componente
     * @param array<string, mixed> $props Proprietà del componente
     *
     * @return string Chiave di cache
     */
    private function generateComponentCacheKey(string $componentName, array $props): string
    {
        $propsHash = md5(json_encode($props));

        return "ui_component_{$componentName}_{$propsHash}";
    }
}
```

### 4. Sequential Thinking

**Scopo**: Analisi e ottimizzazione dell'interfaccia utente.

**Casi d'uso**:
- Analisi dell'accessibilità dell'interfaccia utente
- Generazione di suggerimenti per migliorare l'UX
- Analisi delle performance dell'interfaccia utente
- Ottimizzazione dei componenti UI

**Esempio di implementazione**:
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Illuminate\Support\Facades\Log;
use Modules\UI\DataObjects\UIAnalysisData;

class AnalyzeUIAccessibilityAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Analizza l'accessibilità di una pagina UI.
     *
     * @param string $url URL della pagina da analizzare
     *
     * @return UIAnalysisData I dati dell'analisi
     */
    public function execute(string $url): UIAnalysisData
    {
        try {
            // Estrai il contenuto HTML della pagina
            $html = $this->mcpService->puppeteer()->extractContent($url, 'html');

            if (!$html) {
                Log::error("Failed to extract HTML content", [
                    'url' => $url
                ]);

                return new UIAnalysisData(
                    score: 0,
                    issues: ['Failed to extract HTML content'],
                    suggestions: ['Check if the URL is accessible']
                );
            }

            // Analizza l'accessibilità con sequential-thinking
            $analysis = $this->mcpService->sequentialThinking()->analyze(
                $html,
                ['accessibility', 'usability', 'performance']
            );

            $accessibilityScore = $analysis['accessibility']['score'] ?? 0;
            $accessibilityIssues = $analysis['accessibility']['issues'] ?? [];
            $suggestions = $analysis['accessibility']['suggestions'] ?? [];

            return new UIAnalysisData(
                score: $accessibilityScore,
                issues: $accessibilityIssues,
                suggestions: $suggestions
            );
        } catch (\Exception $e) {
            Log::error("Exception during UI accessibility analysis", [
                'url' => $url,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return new UIAnalysisData(
                score: 0,
                issues: ['Analysis failed: ' . $e->getMessage()],
                suggestions: ['Try again later or contact support']
            );
        }
    }
}
```

## Integrazione con Livewire e Volt

Per integrare i server MCP con Livewire e Volt nel modulo UI, è possibile creare componenti che utilizzano i server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Http\Livewire;

use Livewire\Component;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\UI\Services\UICacheService;

class CachedUIComponent extends Component
{
    /**
     * @var string
     */
    public string $componentName;

    /**
     * @var array<string, mixed>
     */
    public array $componentProps = [];

    /**
     * @var int
     */
    public int $cacheTtl = 3600;

    /**
     * @var bool
     */
    public bool $forceRefresh = false;

    /**
     * Monta il componente.
     *
     * @param string $componentName
     * @param array<string, mixed> $componentProps
     * @param int $cacheTtl
     *
     * @return void
     */
    public function mount(string $componentName, array $componentProps = [], int $cacheTtl = 3600): void
    {
        $this->componentName = $componentName;
        $this->componentProps = $componentProps;
        $this->cacheTtl = $cacheTtl;
    }

    /**
     * Forza l'aggiornamento del componente.
     *
     * @return void
     */
    public function refresh(): void
    {
        $this->forceRefresh = true;
    }

    /**
     * Renderizza il componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        /** @var MCPServiceContract $mcpService */
        $mcpService = app(MCPServiceContract::class);

        /** @var UICacheService $uiCacheService */
        $uiCacheService = app(UICacheService::class);

        $html = null;

        if (!$this->forceRefresh) {
            $html = $uiCacheService->getCachedComponent($this->componentName, $this->componentProps);
        }

        if ($html === null) {
            // Renderizza il componente
            $html = view("ui::components.{$this->componentName}", $this->componentProps)->render();

            // Memorizza in cache
            $uiCacheService->cacheComponent($this->componentName, $this->componentProps, $html, $this->cacheTtl);
        }

        return view('ui::livewire.cached-ui-component', [
            'html' => $html
        ]);
    }
}
```

```php
<?php

declare(strict_types=1);

use function Livewire\Volt\{state, computed, mount};
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\UI\Actions\AnalyzeUIAccessibilityAction;

state([
    'url' => '',
    'isAnalyzing' => false,
    'analysisResult' => null
]);

$mount = function (string $url = '') {
    $this->url = $url;
};

$analyze = function () {
    $this->isAnalyzing = true;

    try {
        /** @var AnalyzeUIAccessibilityAction $analyzeAction */
        $analyzeAction = app(AnalyzeUIAccessibilityAction::class);

        $this->analysisResult = $analyzeAction->execute($this->url);
    } catch (\Exception $e) {
        $this->addError('analysis', $e->getMessage());
    } finally {
        $this->isAnalyzing = false;
    }
};

?>

<div>
    <div class="mb-4">
        <label for="url" class="block text-sm font-medium text-gray-700">URL da analizzare</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <input type="text" wire:model="url" id="url" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="https://example.com">
            <button wire:click="analyze" wire:loading.attr="disabled" class="ml-3 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <span wire:loading.remove wire:target="analyze">Analizza</span>
                <span wire:loading wire:target="analyze">Analisi in corso...</span>
            </button>
        </div>
        @error('analysis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>

    @if($analysisResult)
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Risultati dell'analisi di accessibilità</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">URL: {{ $url }}</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Punteggio di accessibilità</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <span class="mr-2">{{ $analysisResult->score }}/100</span>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $analysisResult->score }}%"></div>
                                </div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Problemi rilevati</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if(count($analysisResult->issues) > 0)
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    @foreach($analysisResult->issues as $issue)
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <svg class="flex-shrink-0 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate">{{ $issue }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-green-500">Nessun problema rilevato</span>
                            @endif
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Suggerimenti</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if(count($analysisResult->suggestions) > 0)
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    @foreach($analysisResult->suggestions as $suggestion)
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 flex-1 w-0 truncate">{{ $suggestion }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-500">Nessun suggerimento disponibile</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    @endif
</div>
```

## Conclusione

L'integrazione dei server MCP con il modulo UI consente di migliorare significativamente le funzionalità del modulo, fornendo automazione del browser per testing e screenshot, gestione efficiente dei file per asset UI, caching di componenti UI e analisi dell'interfaccia utente. Seguendo le linee guida e gli esempi forniti in questo documento, è possibile implementare queste funzionalità in modo conforme alle regole di sviluppo stabilite per i progetti base_predict_fila3_mono.
