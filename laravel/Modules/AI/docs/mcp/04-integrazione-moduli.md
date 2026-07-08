# Integrazione dei Server MCP con i Moduli Laravel

## Panoramica

Questa guida fornisce istruzioni dettagliate per l'integrazione dei server MCP (Model Context Protocol) con i moduli Laravel nel progetto base_predict_fila5_mono, seguendo le regole di sviluppo e le convenzioni di codice stabilite.

## Principi di Integrazione

L'integrazione dei server MCP con i moduli Laravel segue questi principi fondamentali:

1. **Rispetto della Struttura Modulare**: Ogni integrazione deve rispettare la separazione delle responsabilità tra i moduli.
2. **Tipizzazione Completa**: Tutte le interazioni con i server MCP devono essere completamente tipizzate.
3. **Utilizzo di Contratti**: Preferire l'uso di interfacce/contratti per il disaccoppiamento.
4. **Documentazione Completa**: Ogni integrazione deve essere adeguatamente documentata.
5. **Conformità a PHPStan**: Il codice deve rispettare almeno il livello 5 di PHPStan, con l'obiettivo di raggiungere il livello 9.

## Struttura dei Moduli

Prima di procedere con l'integrazione, è importante comprendere la struttura dei moduli nel progetto base_predict_fila5_mono:

```
/path/to/your/project/laravel/Modules/
├── AI/
│   ├── Config/
│   ├── Console/
│   ├── Contracts/
│   ├── DataObjects/
│   ├── Http/
│   ├── Providers/
│   ├── Resources/
│   ├── Services/
│   │   ├── Contracts/
│   │   └── Servers/
│   └── ...
├── Blog/
├── UI/
├── User/
├── Xot/
└── ...
```

## Integrazione con il Modulo AI

Il modulo AI è il punto centrale per l'integrazione dei server MCP. Ecco come strutturare l'integrazione:

### Service Provider

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\AI\Services\MCPService;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Xot\Providers\XotBaseServiceProvider;

class MCPServiceProvider extends XotBaseServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton(MCPServiceContract::class, function ($app) {
            return new MCPService(
                config('ai.mcp.servers')
            );
        });
        
        $this->app->alias(MCPServiceContract::class, 'mcp');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../Config/mcp.php' => config_path('ai/mcp.php'),
        ], 'config');
    }
}
```

### Configurazione

```php
<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | MCP Servers Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the configuration for the MCP servers.
    |
    */

    'servers' => [
        'sequential-thinking' => [
            'enabled' => true,
            'timeout' => 30,
        ],
        'memory' => [
            'enabled' => true,
            'timeout' => 30,
        ],
        'fetch' => [
            'enabled' => true,
            'timeout' => 30,
        ],
        'filesystem' => [
            'enabled' => true,
            'timeout' => 30,
        ],
        'mysql' => [
            'enabled' => true,
            'timeout' => 30,
        ],
        'postgres' => [
            'enabled' => true,
            'timeout' => 30,
        ],
        'redis' => [
            'enabled' => true,
            'timeout' => 30,
        ],
        'puppeteer' => [
            'enabled' => true,
            'timeout' => 30,
        ],
    ],
];
```

### Contratti dei Server

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Contracts;

interface SequentialThinkingServerContract
{
    /**
     * Genera un pensiero sequenziale.
     *
     * @param string $thought Il pensiero corrente
     * @param int $thoughtNumber Il numero del pensiero
     * @param int $totalThoughts Il numero totale di pensieri
     * @param bool $nextThoughtNeeded Se è necessario un altro pensiero
     *
     * @return array<string, mixed> I dati del pensiero generato
     */
    public function generateThought(
        string $thought,
        int $thoughtNumber,
        int $totalThoughts,
        bool $nextThoughtNeeded
    ): array;

    /**
     * Analizza un testo utilizzando il pensiero sequenziale.
     *
     * @param string $text Il testo da analizzare
     * @param array<string> $aspects Gli aspetti da analizzare
     *
     * @return array<string, mixed> I risultati dell'analisi
     */
    public function analyze(string $text, array $aspects): array;
}
```

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Contracts;

interface MemoryServerContract
{
    /**
     * Memorizza un'informazione.
     *
     * @param string $key La chiave dell'informazione
     * @param mixed $value Il valore dell'informazione
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function store(string $key, mixed $value): bool;

    /**
     * Recupera un'informazione.
     *
     * @param string $key La chiave dell'informazione
     *
     * @return mixed Il valore dell'informazione
     */
    public function retrieve(string $key): mixed;

    /**
     * Elimina un'informazione.
     *
     * @param string $key La chiave dell'informazione
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function delete(string $key): bool;
}
```

### Implementazioni dei Server

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\SequentialThinkingServerContract;
use Symfony\Component\Process\Process;

class SequentialThinkingServer implements SequentialThinkingServerContract
{
    /**
     * @var array<string, mixed>
     */
    private array $config;
    
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * {@inheritdoc}
     */
    public function generateThought(
        string $thought,
        int $thoughtNumber,
        int $totalThoughts,
        bool $nextThoughtNeeded
    ): array {
        // Implementazione della generazione del pensiero
        // ...
        
        return [
            'thought' => $thought,
            'thoughtNumber' => $thoughtNumber,
            'totalThoughts' => $totalThoughts,
            'nextThoughtNeeded' => $nextThoughtNeeded
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function analyze(string $text, array $aspects): array {
        // Implementazione dell'analisi
        // ...
        
        return [
            'readability' => [
                'score' => 85,
                'level' => 'advanced',
            ],
            'seo' => [
                'score' => 78,
                'suggestions' => [
                    'Aggiungere più parole chiave',
                    'Migliorare i meta tag',
                ],
            ],
            // Altri risultati...
        ];
    }
}
```

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Services\Servers;

use Modules\AI\Services\Contracts\MemoryServerContract;
use Symfony\Component\Process\Process;

class MemoryServer implements MemoryServerContract
{
    /**
     * @var array<string, mixed>
     */
    private array $config;
    
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    /**
     * {@inheritdoc}
     */
    public function store(string $key, mixed $value): bool {
        // Implementazione della memorizzazione
        // ...
        
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function retrieve(string $key): mixed {
        // Implementazione del recupero
        // ...
        
        return [
            'theme' => 'dark',
            'language' => 'it',
            'notifications' => true
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function delete(string $key): bool {
        // Implementazione dell'eliminazione
        // ...
        
        return true;
    }
}
```

## Integrazione con il Modulo User

Il modulo User può utilizzare i server MCP per memorizzare le preferenze degli utenti e verificare le informazioni degli utenti tramite API esterne.

### Actions

```php
<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Modules\Xot\Contracts\UserContract;
use Modules\AI\Services\Contracts\MCPServiceContract;

class StoreUserPreferencesAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Memorizza le preferenze dell'utente tramite il server MCP memory.
     *
     * @param UserContract $user L'utente
     * @param array<string, mixed> $preferences Le preferenze dell'utente
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function execute(UserContract $user, array $preferences): bool
    {
        return $this->mcpService->memory()->store(
            "user_preferences_{$user->id}",
            $preferences
        );
    }
}
```

```php
<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Modules\Xot\Contracts\UserContract;
use Modules\AI\Services\Contracts\MCPServiceContract;

class VerifyUserEmailAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Verifica l'email dell'utente tramite il server MCP fetch.
     *
     * @param UserContract $user L'utente
     *
     * @return bool True se l'email è valida, false altrimenti
     */
    public function execute(UserContract $user): bool
    {
        $response = $this->mcpService->fetch()->get(
            "https://api.email-validator.net/api/verify?EmailAddress={$user->email}"
        );
        
        $data = json_decode($response, true);
        
        return $data['status'] === 'valid';
    }
}
```

## Integrazione con il Modulo Blog

Il modulo Blog può utilizzare i server MCP per analizzare i contenuti dei post e memorizzare i metadati.

### Actions

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Actions;

use Modules\Blog\Models\Post;
use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Blog\DataObjects\ContentAnalysisData;

class AnalyzePostContentAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Analizza il contenuto di un post utilizzando sequential-thinking.
     *
     * @param Post $post Il post da analizzare
     *
     * @return ContentAnalysisData I dati dell'analisi
     */
    public function execute(Post $post): ContentAnalysisData
    {
        $analysis = $this->mcpService->sequentialThinking()->analyze(
            $post->content,
            [
                'readability',
                'seo',
                'sentiment',
                'keywords'
            ]
        );
        
        // Memorizza l'analisi per riferimento futuro
        $this->mcpService->memory()->store(
            "post_analysis_{$post->id}",
            $analysis
        );
        
        return new ContentAnalysisData(
            readabilityScore: $analysis['readability']['score'],
            seoScore: $analysis['seo']['score'],
            sentiment: $analysis['sentiment']['value'],
            keywords: $analysis['keywords']
        );
    }
}
```

### Data Objects

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\DataObjects;

use Spatie\LaravelData\Data;

class ContentAnalysisData extends Data
{
    /**
     * @param int $readabilityScore
     * @param int $seoScore
     * @param string $sentiment
     * @param array<string> $keywords
     */
    public function __construct(
        public readonly int $readabilityScore,
        public readonly int $seoScore,
        public readonly string $sentiment,
        public readonly array $keywords
    ) {
    }
}
```

## Integrazione con il Modulo UI

Il modulo UI può utilizzare i server MCP per testare automaticamente le interfacce e gestire gli asset UI.

### Actions

```php
<?php

declare(strict_types=1);

namespace Modules\UI\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;

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
     * Genera screenshot delle interfacce UI tramite puppeteer.
     *
     * @param array<string> $routes Percorsi delle route da catturare
     * @param string $outputDir Directory di output per gli screenshot
     *
     * @return array<string, string> Mappa di route => percorso screenshot
     */
    public function execute(array $routes, string $outputDir): array
    {
        $results = [];
        
        foreach ($routes as $route) {
            $screenshotPath = $this->mcpService->puppeteer()->captureScreenshot(
                route($route),
                $outputDir . '/' . str_replace('.', '_', $route) . '.png'
            );
            
            $results[$route] = $screenshotPath;
        }
        
        return $results;
    }
}
```

## Integrazione con il Modulo Xot

Il modulo Xot può utilizzare i server MCP per ottimizzare le query database e gestire la cache.

### Actions

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;
use Modules\Xot\DataObjects\QueryAnalysisData;

class OptimizeDatabaseQueryAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Analizza e ottimizza una query SQL utilizzando il server MCP postgres.
     *
     * @param string $query La query da analizzare
     *
     * @return QueryAnalysisData I dati dell'analisi
     */
    public function execute(string $query): QueryAnalysisData
    {
        $analysis = $this->mcpService->postgres()->analyzeQuery($query);
        
        return new QueryAnalysisData(
            originalQuery: $query,
            optimizedQuery: $analysis['optimized_query'],
            estimatedCost: $analysis['estimated_cost'],
            recommendations: $analysis['recommendations']
        );
    }
}
```

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Modules\AI\Services\Contracts\MCPServiceContract;

class CacheManagementAction
{
    /**
     * @param MCPServiceContract $mcpService
     */
    public function __construct(
        private readonly MCPServiceContract $mcpService
    ) {
    }

    /**
     * Gestisce la cache utilizzando il server MCP redis.
     *
     * @param string $key La chiave della cache
     * @param mixed $value Il valore da memorizzare
     * @param int $ttl Tempo di vita in secondi
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function store(string $key, mixed $value, int $ttl = 3600): bool
    {
        return $this->mcpService->redis()->set($key, $value, $ttl);
    }

    /**
     * Recupera un valore dalla cache.
     *
     * @param string $key La chiave della cache
     *
     * @return mixed Il valore memorizzato
     */
    public function retrieve(string $key): mixed
    {
        return $this->mcpService->redis()->get($key);
    }

    /**
     * Elimina un valore dalla cache.
     *
     * @param string $key La chiave della cache
     *
     * @return bool True se l'operazione è riuscita, false altrimenti
     */
    public function delete(string $key): bool
    {
        return $this->mcpService->redis()->delete($key);
    }
}
```

### Data Objects

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\DataObjects;

use Spatie\LaravelData\Data;

class QueryAnalysisData extends Data
{
    /**
     * @param string $originalQuery
     * @param string $optimizedQuery
     * @param float $estimatedCost
     * @param array<string> $recommendations
     */
    public function __construct(
        public readonly string $originalQuery,
        public readonly string $optimizedQuery,
        public readonly float $estimatedCost,
        public readonly array $recommendations
    ) {
    }
}
```

## Integrazione con Filament

Per integrare i server MCP con Filament, è possibile creare risorse Filament che utilizzano i server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Modules\AI\Models\Analysis;
use Modules\AI\Filament\Resources\AnalysisResource\Pages;
use Modules\AI\Services\Contracts\MCPServiceContract;

class AnalysisResource extends Resource
{
    protected static ?string $model = Analysis::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->required(),
                Forms\Components\CheckboxList::make('aspects')
                    ->options([
                        'readability' => 'Readability',
                        'seo' => 'SEO',
                        'sentiment' => 'Sentiment',
                        'keywords' => 'Keywords',
                    ])
                    ->required(),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('analyze')
                    ->action(function (Analysis $record, MCPServiceContract $mcpService) {
                        $analysis = $mcpService->sequentialThinking()->analyze(
                            $record->content,
                            $record->aspects
                        );
                        
                        $record->update([
                            'results' => $analysis,
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnalyses::route('/'),
            'create' => Pages\CreateAnalysis::route('/create'),
            'edit' => Pages\EditAnalysis::route('/{record}/edit'),
        ];
    }
}
```

## Integrazione con Livewire e Volt

Per integrare i server MCP con Livewire e Volt, è possibile creare componenti Livewire che utilizzano i server MCP:

```php
<?php

declare(strict_types=1);

namespace Modules\AI\Http\Livewire;

use Livewire\Component;
use Modules\AI\Services\Contracts\MCPServiceContract;

class ContentAnalyzer extends Component
{
    public string $content = '';
    public array $aspects = ['readability', 'seo', 'sentiment', 'keywords'];
    public ?array $analysis = null;
    
    public function analyze(MCPServiceContract $mcpService): void
    {
        $this->validate([
            'content' => 'required|min:10',
            'aspects' => 'required|array|min:1',
        ]);
        
        $this->analysis = $mcpService->sequentialThinking()->analyze(
            $this->content,
            $this->aspects
        );
    }
    
    public function render(): \Illuminate\View\View
    {
        return view('ai::livewire.content-analyzer');
    }
}
```

```php
<?php

declare(strict_types=1);

use function Livewire\Volt\{state, rules, computed, mount, on};
use Modules\AI\Services\Contracts\MCPServiceContract;

state([
    'content' => '',
    'aspects' => ['readability', 'seo', 'sentiment', 'keywords'],
    'analysis' => null,
]);

rules([
    'content' => 'required|min:10',
    'aspects' => 'required|array|min:1',
]);

$analyze = function (MCPServiceContract $mcpService) {
    $this->analysis = $mcpService->sequentialThinking()->analyze(
        $this->content,
        $this->aspects
    );
};

?>

<div>
    <div class="mb-4">
        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
        <textarea id="content" wire:model="content" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Aspects</label>
        <div class="mt-2 space-y-2">
            @foreach(['readability', 'seo', 'sentiment', 'keywords'] as $aspect)
                <div class="flex items-center">
                    <input id="{{ $aspect }}" wire:model="aspects" value="{{ $aspect }}" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="{{ $aspect }}" class="ml-2 text-sm text-gray-700">{{ ucfirst($aspect) }}</label>
                </div>
            @endforeach
        </div>
        @error('aspects') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
    </div>
    
    <button wire:click="analyze" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        Analyze
    </button>
    
    @if($analysis)
        <div class="mt-4">
            <h3 class="text-lg font-medium text-gray-900">Analysis Results</h3>
            <div class="mt-2">
                @if(isset($analysis['readability']))
                    <div class="mb-2">
                        <h4 class="text-sm font-medium text-gray-700">Readability</h4>
                        <p class="text-sm text-gray-500">Score: {{ $analysis['readability']['score'] }}</p>
                        <p class="text-sm text-gray-500">Level: {{ $analysis['readability']['level'] }}</p>
                    </div>
                @endif
                
                @if(isset($analysis['seo']))
                    <div class="mb-2">
                        <h4 class="text-sm font-medium text-gray-700">SEO</h4>
                        <p class="text-sm text-gray-500">Score: {{ $analysis['seo']['score'] }}</p>
                        @if(isset($analysis['seo']['suggestions']))
                            <ul class="mt-1 list-disc list-inside text-sm text-gray-500">
                                @foreach($analysis['seo']['suggestions'] as $suggestion)
                                    <li>{{ $suggestion }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
                
                @if(isset($analysis['sentiment']))
                    <div class="mb-2">
                        <h4 class="text-sm font-medium text-gray-700">Sentiment</h4>
                        <p class="text-sm text-gray-500">{{ $analysis['sentiment']['value'] }}</p>
                    </div>
                @endif
                
                @if(isset($analysis['keywords']))
                    <div class="mb-2">
                        <h4 class="text-sm font-medium text-gray-700">Keywords</h4>
                        <div class="mt-1 flex flex-wrap gap-2">
                            @foreach($analysis['keywords'] as $keyword)
                                <span class="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800">
                                    {{ $keyword }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
```

## PHPStan Configuration

Per garantire la conformità a PHPStan, è necessario configurare PHPStan per ogni modulo:

```neon
# /path/to/your/project/laravel/Modules/AI/phpstan.neon
parameters:
    level: 5
    paths:
        - ./
    excludePaths:
        - vendor
        - node_modules
    checkMissingIterableValueType: false
    checkGenericClassInNonGenericObjectType: false
    ignoreErrors:
        # Aggiungi qui gli errori da ignorare
```

## Conclusione

Hai imparato come integrare i server MCP con i moduli Laravel nel progetto base_predict_fila5_mono. Questa integrazione consente di estendere le capacità dei moduli con funzionalità avanzate come l'analisi del contenuto, la memorizzazione di informazioni e l'interazione con sistemi esterni.

Seguendo le regole di sviluppo e le convenzioni di codice stabilite, è possibile creare integrazioni robuste e tipizzate che migliorano significativamente le funzionalità del sistema.

---

Continua con la sezione [Implementazione Pratica](./05_IMPLEMENTAZIONE_PRATICA.md) per vedere esempi concreti di implementazione dei server MCP in progetti Laravel.
