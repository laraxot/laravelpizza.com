# AI Agents in PHP with MCP

## Introduzione

Questo tutorial esplora l'implementazione di agenti AI in PHP utilizzando il Model Context Protocol (MCP), con particolare attenzione all'integrazione con Laravel e all'utilizzo del framework Neuron AI.

## Prerequisiti

- PHP 8.0 o superiore
- Laravel 8.x o superiore
- Composer
- Un account con un provider di LLM (OpenAI, Anthropic, ecc.)
- Conoscenza base di Laravel e PHP

## Indice

1. [Comprensione degli Agenti AI](#comprensione-degli-agenti-ai)
2. [Il Model Context Protocol (MCP)](#il-model-context-protocol-mcp)
3. [Installazione di Neuron AI](#installazione-di-neuron-ai)
4. [Creazione di un Agente Base](#creazione-di-un-agente-base)
5. [Implementazione di Strumenti](#implementazione-di-strumenti)
6. [Connessione a Server MCP](#connessione-a-server-mcp)
7. [Testing e Debugging](#testing-e-debugging)
8. [Casi d'Uso Pratici](#casi-duso-pratici)

## Comprensione degli Agenti AI

Gli agenti AI sono programmi che possono eseguire compiti in risposta a un prompt. A differenza dei semplici LLM, che principalmente forniscono informazioni e rispondono a domande all'interno di una conversazione, gli agenti AI possono intraprendere azioni indipendenti per completare attività.

Un agente AI può:
- Ricercare informazioni su più siti web e compilarle
- Gestire email rispondendo a messaggi semplici
- Monitorare dati e inviare avvisi quando accade qualcosa di importante

## Il Model Context Protocol (MCP)

MCP è un layer tra l'LLM e gli strumenti che si desidera connettere. Consente agli LLM di accedere a funzionalità esterne in modo standardizzato.

Vantaggi di MCP:
- Standardizzazione della comunicazione tra LLM e strumenti
- Facilità di implementazione di nuove funzionalità
- Maggiore sicurezza e controllo
- Manutenzione semplificata

## Installazione di Neuron AI

Neuron AI è un framework PHP open source che semplifica lo sviluppo di agenti AI. Per installarlo:

```bash
composer require inspector-apm/neuron-ai
```

## Creazione di un Agente Base

Per creare un agente base con Neuron AI:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\Agents;

use NeuronAI\Agent;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\Anthropic\Anthropic;

class MyAgent extends Agent
{
    public function provider(): AIProviderInterface
    {
        return new Anthropic(
            key: env('ANTHROPIC_API_KEY'),
            model: env('ANTHROPIC_MODEL', 'claude-3-opus-20240229'),
        );
    }
    
    public function instructions(): string
    {
        return "Sei un assistente AI specializzato in Laravel. Il tuo compito è aiutare gli utenti a risolvere problemi di sviluppo, rispondere a domande tecniche e fornire consigli sulle best practices.";
    }
}
```

## Implementazione di Strumenti

Gli strumenti consentono all'agente di interagire con l'ambiente e eseguire azioni specifiche:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\Agents;

use NeuronAI\Agent;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\Anthropic\Anthropic;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolProperty;

class MyAgent extends Agent
{
    // ... codice precedente ...
    
    public function tools(): array
    {
        return [
            Tool::make(
                "search_documentation",
                "Cerca nella documentazione di Laravel."
            )->addProperty(
                new ToolProperty(
                    name: 'query',
                    type: 'string',
                    description: 'La query di ricerca',
                    required: true
                )
            )->setCallable(function (string $query) {
                // Implementazione della ricerca nella documentazione
                return "Risultati della ricerca per: " . $query;
            }),
            
            Tool::make(
                "run_artisan_command",
                "Esegue un comando Artisan."
            )->addProperty(
                new ToolProperty(
                    name: 'command',
                    type: 'string',
                    description: 'Il comando Artisan da eseguire',
                    required: true
                )
            )->setCallable(function (string $command) {
                // Implementazione dell'esecuzione del comando Artisan
                return "Output del comando: " . $command;
            })
        ];
    }
}
```

## Connessione a Server MCP

Per connettere l'agente a un server MCP:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\Services;

use Modules\AI\Agents\MyAgent;
use NeuronAI\MCP\MCPConnector;

class MCPService
{
    protected MyAgent $agent;
    protected MCPConnector $connector;
    
    public function __construct(MyAgent $agent)
    {
        $this->agent = $agent;
        $this->connector = new MCPConnector($agent);
    }
    
    public function connect(string $serverName): void
    {
        $this->connector->connect($serverName);
    }
    
    public function listResources(string $serverName): array
    {
        return $this->connector->listResources($serverName);
    }
    
    public function readResource(string $serverName, string $uri): mixed
    {
        return $this->connector->readResource($serverName, $uri);
    }
}
```

## Testing e Debugging

Per testare l'agente e il server MCP:

```php
<?php
declare(strict_types=1);

namespace Modules\AI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AI\Agents\MyAgent;
use Modules\AI\Services\MCPService;

class MCPController extends Controller
{
    protected MyAgent $agent;
    protected MCPService $mcpService;
    
    public function __construct(MyAgent $agent, MCPService $mcpService)
    {
        $this->agent = $agent;
        $this->mcpService = $mcpService;
    }
    
    public function chat(Request $request)
    {
        $message = $request->input('message');
        $response = $this->agent->chat($message);
        
        return response()->json([
            'response' => $response
        ]);
    }
    
    public function listResources(Request $request)
    {
        $serverName = $request->input('server_name');
        $resources = $this->mcpService->listResources($serverName);
        
        return response()->json([
            'resources' => $resources
        ]);
    }
}
```

## Casi d'Uso Pratici

Alcuni casi d'uso pratici per gli agenti AI con MCP in Laravel:

1. **Assistente per Sviluppatori**:
   - Rispondere a domande sulla documentazione di Laravel
   - Generare snippet di codice
   - Suggerire soluzioni a problemi comuni

2. **Chatbot di Supporto**:
   - Rispondere a domande frequenti
   - Guidare gli utenti attraverso processi complessi
   - Raccogliere feedback e segnalazioni di bug

3. **Automazione dei Workflow**:
   - Generare report
   - Inviare notifiche
   - Eseguire attività di manutenzione

Per ulteriori informazioni sui casi d'uso di MCP in Laravel, consulta il documento [MCP_CASI_USO.md](../MCP_CASI_USO.md).

---

*Ultimo aggiornamento: Maggio 2025*
