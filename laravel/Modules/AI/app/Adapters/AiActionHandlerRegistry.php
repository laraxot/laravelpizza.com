<?php

declare(strict_types=1);

namespace Modules\AI\Adapters;

use Modules\AI\Contracts\AiActionHandlerContract;

/**
 * Singleton registry mapping AiActionProposal::type → AiActionHandlerContract.
 * Adapter (ex app/Support / faux Action): multi-metodo di binding, non use-case.
 */
final class AiActionHandlerRegistry
{
    /**
     * @var array<string, AiActionHandlerContract>
     */
    protected array $handlers = [];

    public function register(AiActionHandlerContract $handler): static
    {
        $this->handlers[$handler->type()] = $handler;

        return $this;
    }

    public function has(string $type): bool
    {
        return isset($this->handlers[$type]);
    }

    public function get(string $type): ?AiActionHandlerContract
    {
        return $this->handlers[$type] ?? null;
    }

    /**
     * @return array<string, AiActionHandlerContract>
     */
    public function all(): array
    {
        return $this->handlers;
    }
}
