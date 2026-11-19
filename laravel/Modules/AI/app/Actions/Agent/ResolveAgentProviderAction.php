<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Agent;

use Modules\AI\Datas\AIConfigData;
use Modules\AI\Enums\AiProviderEnum;
use Modules\AI\Exceptions\AiRequestException;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\OpenAILike;
use Spatie\QueueableAction\QueueableAction;

/**
 * Fornitore del modello per gli agenti neuron-ai: il primo con la chiave, nell'ordine dell'assistente
 * (AIConfigData::assistant_providers, di default Groq poi OpenRouter). Tutti compatibili con
 * `/chat/completions` di OpenAI, quindi OpenAILike di neuron. Stessi modelli dell'assistente.
 */
final class ResolveAgentProviderAction
{
    use QueueableAction;

    public function execute(): AIProviderInterface
    {
        $settings = AIConfigData::make();

        foreach ($settings->assistant_providers as $name) {
            $provider = AiProviderEnum::tryFrom($name);
            $model = $settings->assistant_models[$name] ?? null;
            $key = $provider === null ? null : config($provider->keyConfig());

            if ($provider !== null && is_string($model) && is_string($key) && $key !== '') {
                return new OpenAILike($provider->baseUrl(), $key, $model, ['temperature' => 0.2]);
            }
        }

        throw new AiRequestException('Nessun fornitore AI configurato per gli agenti: imposta GROQ_API_KEY o OPENROUTER_API_KEY.');
    }
}
