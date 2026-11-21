<?php

declare(strict_types=1);

namespace Modules\AI\Neuron\Tools;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\ResponseFactory;
use Laravel\Mcp\Server\Tool as McpServerTool;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolOutput;
use NeuronAI\Tools\ToolPropertyFactory;

use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Espone a un agente neuron-ai un tool di un server laravel/mcp, eseguito nel processo (senza HTTP):
 * stesso nome, descrizione, schema e handle(). I tool si scrivono una volta sola e servono sia ai client
 * MCP esterni sia all'agente in chat. Pattern da datomatic/laravelday-2026 (MIT), riscritto per Laraxot.
 *
 * L'utente del tool e' quello autenticato nella richiesta corrente (Laravel\Mcp\Request::user()).
 */
class McpToolAdapter extends Tool
{
    public function __construct(private readonly McpServerTool $tool)
    {
        /** @var array{name: string, description: string, inputSchema: array<string, mixed>} $definition */
        $definition = json_decode(json_encode($tool->toArray()), true);

        $this->name = $definition['name'];
        $this->description = $definition['description'];
        $this->properties = ToolPropertyFactory::fromSchema($definition['inputSchema']);
    }

    public function __invoke(mixed ...$arguments): ToolOutput
    {
        // handle() riceve gli argomenti dal Request che il container inietta.
        // Solo argomenti con nome (quelli dello schema); i null sono "non indicato".
        $named = [];
        foreach ($arguments as $key => $value) {
            if (is_string($key) && $value !== null) {
                $named[$key] = $value;
            }
        }
        app()->instance(Request::class, new Request($named));

        try {
            $handle = [$this->tool, 'handle'];
            if (! is_callable($handle)) {
                return ToolOutput::error('Il tool '.$this->name.' non ha un metodo handle()');
            }
            $response = app()->call($handle);
        } catch (ValidationException|AuthorizationException $exception) {
            return ToolOutput::error($exception->getMessage());
        } finally {
            app()->forgetInstance(Request::class);
        }

        if ($response instanceof ResponseFactory) {
            return ToolOutput::text(json_encode($response->getStructuredContent(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }

        if (! $response instanceof Response) {
            return ToolOutput::error('Risposta non valida dal tool '.$this->name);
        }

        return $response->isError()
            ? ToolOutput::error((string) $response->content())
            : ToolOutput::text((string) $response->content());
    }
}
