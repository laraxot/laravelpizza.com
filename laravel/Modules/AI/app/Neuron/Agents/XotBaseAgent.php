<?php

declare(strict_types=1);

namespace Modules\AI\Neuron\Agents;

use Modules\AI\Actions\Agent\ResolveAgentProviderAction;
use NeuronAI\Agent\Agent;
use NeuronAI\Chat\History\MessageStoreInterface;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Workflow\Persistence\PersistenceInterface;
use Throwable;

/**
 * Base degli agenti neuron-ai dei progetti Laraxot. Il progetto scrive solo istruzioni e tool
 * (di solito tool MCP avvolti da McpToolAdapter); qui fornitore, memoria e run in pausa:
 *
 * - fornitore: ResolveAgentProviderAction (Groq, poi OpenRouter);
 * - conversazione: tabella ai_agent_messages; run in pausa per le approvazioni: ai_agent_runs
 *   (binding in AIServiceProvider);
 * - un tool che fallisce risponde al modello con l'errore invece di interrompere il run.
 */
abstract class XotBaseAgent extends Agent
{
    public function __construct(
        protected MessageStoreInterface $conversations,
        protected PersistenceInterface $runs,
    ) {
        parent::__construct();
    }

    protected function provider(): AIProviderInterface
    {
        return app(ResolveAgentProviderAction::class)->execute();
    }

    protected function messageStore(): MessageStoreInterface
    {
        return $this->conversations;
    }

    protected function persistence(): PersistenceInterface
    {
        return $this->runs;
    }

    protected function resolveToolErrorHandler(): callable
    {
        return static fn (Throwable $exception): string => 'Errore: '.$exception->getMessage();
    }
}
