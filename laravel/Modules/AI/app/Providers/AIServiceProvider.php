<?php

declare(strict_types=1);

namespace Modules\AI\Providers;

// ---- bases --
use Modules\AI\Adapters\AiActionHandlerRegistry;
use Modules\AI\Adapters\AssistantHandoffHandler;
use Modules\AI\Models\AiAgentMessage;
use Modules\AI\Models\AiAgentRun;
use Modules\Xot\Providers\XotBaseServiceProvider;
use NeuronAI\Chat\History\EloquentMessageStore;
use NeuronAI\Chat\History\MessageStoreInterface;
use NeuronAI\Workflow\Persistence\EloquentPersistence;
use NeuronAI\Workflow\Persistence\PersistenceInterface;

class AIServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'AI'; // lower del nome

    public function register(): void
    {
        parent::register();

        // Agenti neuron-ai: conversazioni e run in pausa nel database del modulo, cosi' un'approvazione
        // riprende il run in una richiesta successiva (XotBaseAgent).
        $this->app->bind(MessageStoreInterface::class, static fn (): EloquentMessageStore => new EloquentMessageStore(AiAgentMessage::class));
        $this->app->bind(PersistenceInterface::class, static fn (): EloquentPersistence => new EloquentPersistence(AiAgentRun::class));

        // Handler di base del modulo; i moduli di dominio registrano i propri (e possono
        // sovrascrivere questi registrando lo stesso tipo).
        $this->app->singleton(
            AiActionHandlerRegistry::class,
            static fn (): AiActionHandlerRegistry => (new AiActionHandlerRegistry)
                ->register(new AssistantHandoffHandler),
        );
    }
}
