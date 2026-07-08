# Building a Laravel Portfolio API with MCP

## Introduzione

Questo tutorial esplora l'implementazione di un'API portfolio in Laravel utilizzando il Model Context Protocol (MCP), consentendo agli agenti AI di interagire con i dati del portfolio in modo strutturato e sicuro.

## Prerequisiti

- PHP 8.0 o superiore
- Laravel 8.x o superiore
- Composer
- Conoscenza base di Laravel e API REST
- Un server MCP configurato

## Indice

1. [Panoramica del Progetto](#panoramica-del-progetto)
2. [Configurazione dell'Ambiente](#configurazione-dellambiente)
3. [Creazione del Modello Portfolio](#creazione-del-modello-portfolio)
4. [Implementazione dell'API REST](#implementazione-dellapi-rest)
5. [Integrazione con MCP](#integrazione-con-mcp)
6. [Testing dell'Integrazione](#testing-dellintegrazione)
7. [Casi d'Uso Avanzati](#casi-duso-avanzati)
8. [Sicurezza e Best Practices](#sicurezza-e-best-practices)

## Panoramica del Progetto

In questo tutorial, creeremo un'API portfolio in Laravel che espone dati relativi a progetti, competenze e informazioni personali. Successivamente, integreremo questa API con MCP per consentire agli agenti AI di interagire con i dati del portfolio.

L'architettura del progetto sarà la seguente:

```
Modules/
└── AI/
    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   └── PortfolioController.php
    │   │   └── Resources/
    │   │       └── PortfolioResource.php
    │   ├── Models/
    │   │   ├── Portfolio.php
    │   │   ├── Project.php
    │   │   └── Skill.php
    │   └── MCP/
    │       └── Tools/
    │           ├── GetPortfolioTool.php
    │           ├── GetProjectsTool.php
    │           └── GetSkillsTool.php
    ├── database/
    │   └── migrations/
    │       ├── create_portfolios_table.php
    │       ├── create_projects_table.php
    │       └── create_skills_table.php
    └── routes/
        └── api.php
```

## Configurazione dell'Ambiente

1. Creare un nuovo modulo Laravel o utilizzare un modulo esistente:

```bash
php artisan module:make Portfolio
```

2. Configurare le migrazioni del database per le tabelle necessarie:

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfoliosTable extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->text('bio');
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
}
```

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('live_url')->nullable();
            $table->json('technologies');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
}
```

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('category', ['frontend', 'backend', 'database', 'devops', 'other']);
            $table->integer('proficiency')->comment('1-5 scale');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
}
```

3. Eseguire le migrazioni:

```bash
php artisan migrate
```

## Creazione del Modello Portfolio

Implementare i modelli Eloquent per rappresentare i dati del portfolio:

```php
<?php
declare(strict_types=1);

namespace Modules\Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'bio',
        'email',
        'website',
        'github',
        'linkedin',
    ];

    /**
     * @return HasMany<Project>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * @return HasMany<Skill>
     */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }
}
```

```php
<?php
declare(strict_types=1);

namespace Modules\Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_id',
        'title',
        'description',
        'image_url',
        'github_url',
        'live_url',
        'technologies',
        'start_date',
        'end_date',
    ];

    /**
     * @var array<int, string>
     */
    protected $casts = [
        'technologies' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * @return BelongsTo<Portfolio, Project>
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
```

```php
<?php
declare(strict_types=1);

namespace Modules\Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_id',
        'name',
        'category',
        'proficiency',
    ];

    /**
     * @return BelongsTo<Portfolio, Skill>
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
```

## Implementazione dell'API REST

1. Creare i controller per l'API:

```php
<?php
declare(strict_types=1);

namespace Modules\Portfolio\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Portfolio\Models\Portfolio;
use Modules\Portfolio\Http\Resources\PortfolioResource;
use Modules\Portfolio\Http\Resources\ProjectResource;
use Modules\Portfolio\Http\Resources\SkillResource;

class PortfolioController extends Controller
{
    /**
     * Restituisce i dati del portfolio.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $portfolio = Portfolio::with(['projects', 'skills'])->findOrFail($id);
        
        return response()->json([
            'data' => new PortfolioResource($portfolio),
        ]);
    }

    /**
     * Restituisce i progetti del portfolio.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function projects(int $id): JsonResponse
    {
        $portfolio = Portfolio::findOrFail($id);
        $projects = $portfolio->projects;
        
        return response()->json([
            'data' => ProjectResource::collection($projects),
        ]);
    }

    /**
     * Restituisce le competenze del portfolio.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function skills(int $id): JsonResponse
    {
        $portfolio = Portfolio::findOrFail($id);
        $skills = $portfolio->skills;
        
        return response()->json([
            'data' => SkillResource::collection($skills),
        ]);
    }
}
```

2. Definire le risorse API:

```php
<?php
declare(strict_types=1);

namespace Modules\Portfolio\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'bio' => $this->bio,
            'email' => $this->email,
            'website' => $this->website,
            'github' => $this->github,
            'linkedin' => $this->linkedin,
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
        ];
    }
}
```

3. Configurare le rotte API:

```php
<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Portfolio\Http\Controllers\PortfolioController;

Route::prefix('api/portfolio')->group(function () {
    Route::get('/{id}', [PortfolioController::class, 'show']);
    Route::get('/{id}/projects', [PortfolioController::class, 'projects']);
    Route::get('/{id}/skills', [PortfolioController::class, 'skills']);
});
```

## Integrazione con MCP

1. Installare il pacchetto Laravel MCP:

```bash
composer require jsonallen/laravel-mcp
```

2. Implementare gli strumenti MCP per il portfolio:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Modules\Portfolio\Models\Portfolio;
use Modules\Portfolio\Http\Resources\PortfolioResource;

class GetPortfolioTool extends Tool
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'get_portfolio';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Recupera i dati completi di un portfolio, inclusi progetti e competenze.';
    }

    /**
     * @return array<int, ToolProperty>
     */
    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'portfolio_id',
                type: 'integer',
                description: 'ID del portfolio da recuperare',
                required: true
            ),
        ];
    }

    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public function handle(array $parameters): array
    {
        $portfolioId = (int) $parameters['portfolio_id'];
        $portfolio = Portfolio::with(['projects', 'skills'])->findOrFail($portfolioId);
        
        return (new PortfolioResource($portfolio))->toArray(request());
    }
}
```

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Modules\Portfolio\Models\Portfolio;
use Modules\Portfolio\Http\Resources\ProjectResource;

class GetProjectsTool extends Tool
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'get_portfolio_projects';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Recupera i progetti associati a un portfolio.';
    }

    /**
     * @return array<int, ToolProperty>
     */
    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'portfolio_id',
                type: 'integer',
                description: 'ID del portfolio',
                required: true
            ),
            new ToolProperty(
                name: 'technology_filter',
                type: 'string',
                description: 'Filtra i progetti per tecnologia',
                required: false
            ),
        ];
    }

    /**
     * @param array<string, mixed> $parameters
     * @return array<int, array<string, mixed>>
     */
    public function handle(array $parameters): array
    {
        $portfolioId = (int) $parameters['portfolio_id'];
        $technologyFilter = $parameters['technology_filter'] ?? null;
        
        $portfolio = Portfolio::findOrFail($portfolioId);
        $projects = $portfolio->projects;
        
        if ($technologyFilter) {
            $projects = $projects->filter(function ($project) use ($technologyFilter) {
                return in_array($technologyFilter, $project->technologies);
            });
        }
        
        return ProjectResource::collection($projects)->toArray(request());
    }
}
```

3. Registrare gli strumenti MCP nel service provider:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\Providers;

use Illuminate\Support\ServiceProvider;
use JsonAllen\LaravelMCP\MCPServer;
use Modules\AI\MCP\Tools\GetPortfolioTool;
use Modules\AI\MCP\Tools\GetProjectsTool;
use Modules\AI\MCP\Tools\GetSkillsTool;

class MCPServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(MCPServer::class, function ($app) {
            $server = new MCPServer();
            
            // Registra gli strumenti MCP
            $server->registerTool(new GetPortfolioTool());
            $server->registerTool(new GetProjectsTool());
            $server->registerTool(new GetSkillsTool());
            
            return $server;
        });
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        // Configurazione aggiuntiva
    }
}
```

4. Configurare il server MCP nel file `.env`:

```
MCP_SERVER_ENABLED=true
MCP_SERVER_PATH=/mcp
MCP_SERVER_AUTH_ENABLED=true
MCP_SERVER_AUTH_TOKEN=your_secure_token_here
```

## Testing dell'Integrazione

1. Avviare il server MCP:

```bash
php artisan mcp:serve
```

2. Testare l'integrazione con MCP Inspector:

```bash
npx @modelcontextprotocol/inspector
```

3. Connettere un agente AI al server MCP:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\Services;

use NeuronAI\Agent;
use NeuronAI\MCP\MCPConnector;

class PortfolioAIService
{
    protected Agent $agent;
    protected MCPConnector $connector;
    
    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
        $this->connector = new MCPConnector($agent);
    }
    
    public function getPortfolioInsights(int $portfolioId): string
    {
        // Connessione al server MCP locale
        $this->connector->connect('localhost');
        
        // Prompt per l'agente AI
        $prompt = "Analizza il portfolio con ID {$portfolioId} e fornisci insights sulle competenze e i progetti.";
        
        // L'agente utilizzerà automaticamente gli strumenti MCP disponibili
        return $this->agent->chat($prompt);
    }
}
```

## Casi d'Uso Avanzati

### 1. Generazione di CV Personalizzati

Utilizzando i dati del portfolio e le capacità dell'LLM, è possibile generare CV personalizzati per diverse posizioni lavorative:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Modules\Portfolio\Models\Portfolio;

class GenerateResumeForJobTool extends Tool
{
    public function getName(): string
    {
        return 'generate_resume_for_job';
    }

    public function getDescription(): string
    {
        return 'Genera un CV personalizzato basato sul portfolio per una specifica posizione lavorativa.';
    }

    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'portfolio_id',
                type: 'integer',
                description: 'ID del portfolio',
                required: true
            ),
            new ToolProperty(
                name: 'job_title',
                type: 'string',
                description: 'Titolo della posizione lavorativa',
                required: true
            ),
            new ToolProperty(
                name: 'job_description',
                type: 'string',
                description: 'Descrizione della posizione lavorativa',
                required: true
            ),
            new ToolProperty(
                name: 'format',
                type: 'string',
                description: 'Formato del CV (markdown, html, pdf)',
                required: false
            ),
        ];
    }

    public function handle(array $parameters): array
    {
        $portfolioId = (int) $parameters['portfolio_id'];
        $jobTitle = $parameters['job_title'];
        $jobDescription = $parameters['job_description'];
        $format = $parameters['format'] ?? 'markdown';
        
        $portfolio = Portfolio::with(['projects', 'skills'])->findOrFail($portfolioId);
        
        // Qui si utilizzerebbe l'LLM per generare il CV personalizzato
        // basato sui dati del portfolio e sulla descrizione del lavoro
        
        return [
            'resume' => $generatedResume,
            'format' => $format,
            'job_title' => $jobTitle,
        ];
    }
}
```

### 2. Analisi delle Competenze e Suggerimenti

Implementare uno strumento che analizza le competenze attuali e suggerisce miglioramenti:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Modules\Portfolio\Models\Portfolio;

class AnalyzeSkillsAndSuggestTool extends Tool
{
    public function getName(): string
    {
        return 'analyze_skills_and_suggest';
    }

    public function getDescription(): string
    {
        return 'Analizza le competenze attuali e suggerisce miglioramenti o nuove competenze da acquisire.';
    }

    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'portfolio_id',
                type: 'integer',
                description: 'ID del portfolio',
                required: true
            ),
            new ToolProperty(
                name: 'career_goal',
                type: 'string',
                description: 'Obiettivo di carriera',
                required: false
            ),
        ];
    }

    public function handle(array $parameters): array
    {
        $portfolioId = (int) $parameters['portfolio_id'];
        $careerGoal = $parameters['career_goal'] ?? null;
        
        $portfolio = Portfolio::with(['skills', 'projects'])->findOrFail($portfolioId);
        
        // Qui si utilizzerebbe l'LLM per analizzare le competenze
        // e suggerire miglioramenti basati sull'obiettivo di carriera
        
        return [
            'current_skills' => $portfolio->skills->pluck('name')->toArray(),
            'suggested_skills' => $suggestedSkills,
            'improvement_plan' => $improvementPlan,
        ];
    }
}
```

### 3. Generazione di Contenuti per il Portfolio

Creare uno strumento che genera descrizioni ottimizzate per i progetti:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\MCP\Tools;

use JsonAllen\LaravelMCP\Tool;
use JsonAllen\LaravelMCP\ToolProperty;
use Modules\Portfolio\Models\Project;

class OptimizeProjectDescriptionTool extends Tool
{
    public function getName(): string
    {
        return 'optimize_project_description';
    }

    public function getDescription(): string
    {
        return 'Ottimizza la descrizione di un progetto per renderla più professionale e coinvolgente.';
    }

    public function getProperties(): array
    {
        return [
            new ToolProperty(
                name: 'project_id',
                type: 'integer',
                description: 'ID del progetto',
                required: true
            ),
            new ToolProperty(
                name: 'target_audience',
                type: 'string',
                description: 'Pubblico target (es. recruiter, clienti)',
                required: false
            ),
            new ToolProperty(
                name: 'tone',
                type: 'string',
                description: 'Tono della descrizione (formale, informale, tecnico)',
                required: false
            ),
        ];
    }

    public function handle(array $parameters): array
    {
        $projectId = (int) $parameters['project_id'];
        $targetAudience = $parameters['target_audience'] ?? 'recruiter';
        $tone = $parameters['tone'] ?? 'professionale';
        
        $project = Project::findOrFail($projectId);
        
        // Qui si utilizzerebbe l'LLM per ottimizzare la descrizione del progetto
        
        return [
            'original_description' => $project->description,
            'optimized_description' => $optimizedDescription,
            'target_audience' => $targetAudience,
            'tone' => $tone,
        ];
    }
}
```

## Sicurezza e Best Practices

1. **Autenticazione e Autorizzazione**:
   - Implementare autenticazione per il server MCP
   - Utilizzare token di accesso per limitare l'accesso agli strumenti MCP
   - Applicare policy di autorizzazione per controllare quali utenti possono accedere a quali dati

2. **Validazione e Sanitizzazione**:
   - Validare rigorosamente tutti gli input provenienti dagli LLM
   - Sanitizzare i dati sensibili prima di inviarli agli LLM
   - Implementare rate limiting per prevenire abusi

3. **Logging e Monitoraggio**:
   - Registrare tutte le interazioni con il server MCP
   - Monitorare le performance e l'utilizzo degli strumenti
   - Implementare alert per comportamenti anomali

4. **Conformità con PHPStan Livello 9**:
   - Utilizzare tipizzazione rigorosa per tutti i metodi e le proprietà
   - Documentare correttamente i tipi di ritorno e i parametri
   - Seguire le best practices per la gestione dei valori mixed

---

*Ultimo aggiornamento: Maggio 2025*
