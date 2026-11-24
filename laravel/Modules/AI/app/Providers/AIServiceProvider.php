<?php

declare(strict_types=1);

namespace Modules\AI\Providers;

// ---- bases --
use Modules\AI\Adapters\AiActionHandlerRegistry;
use Modules\AI\Adapters\AssistantHandoffHandler;
use Modules\AI\Models\AiAgentMessage;
use Modules\AI\Models\AiAgentRun;
<<<<<<< HEAD
use Modules\AI\Neuron\Persistence\StrictModeEloquentPersistence;
use Modules\Xot\Providers\XotBaseServiceProvider;
use NeuronAI\Chat\History\EloquentMessageStore;
use NeuronAI\Chat\History\MessageStoreInterface;
=======
use Modules\Xot\Providers\XotBaseServiceProvider;
use NeuronAI\Chat\History\EloquentMessageStore;
use NeuronAI\Chat\History\MessageStoreInterface;
use NeuronAI\Workflow\Persistence\EloquentPersistence;
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))
use NeuronAI\Workflow\Persistence\PersistenceInterface;

/** @see Modules/AI/docs/agents.md#binding-e-strict-mode-mysql */
class AIServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'AI'; // lower del nome

    /** @see Modules/AI/docs/agents.md#binding-e-strict-mode-mysql */
    public function register(): void
    {
        parent::register();

        // Agenti neuron-ai: conversazioni e run in pausa nel database del modulo, cosi' un'approvazione
<<<<<<< HEAD
        // riprende il run in una richiesta successiva (XotBaseAgent). Strict mode solo durante le scritture
        // dei run: neuron lo esige e le connessioni del tenant hanno strict => false.
        $this->app->bind(MessageStoreInterface::class, static fn (): EloquentMessageStore => new EloquentMessageStore(AiAgentMessage::class));
        $this->app->bind(PersistenceInterface::class, static fn (): StrictModeEloquentPersistence => new StrictModeEloquentPersistence(AiAgentRun::class));
=======
        // riprende il run in una richiesta successiva (XotBaseAgent).
        $this->app->bind(MessageStoreInterface::class, static fn (): EloquentMessageStore => new EloquentMessageStore(AiAgentMessage::class));
        $this->app->bind(PersistenceInterface::class, static fn (): EloquentPersistence => new EloquentPersistence(AiAgentRun::class));
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))

        // Handler di base del modulo; i moduli di dominio registrano i propri (e possono
        // sovrascrivere questi registrando lo stesso tipo).
        $this->app->singleton(
            AiActionHandlerRegistry::class,
            static fn (): AiActionHandlerRegistry => (new AiActionHandlerRegistry)
                ->register(new AssistantHandoffHandler),
        );
    }
}
