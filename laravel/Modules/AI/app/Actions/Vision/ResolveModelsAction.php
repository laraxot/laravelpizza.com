<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Vision;

use Modules\AI\Enums\AiProviderEnum;
use Spatie\QueueableAction\QueueableAction;

/**
 * Normalizza i modelli configurati per un fornitore (stringa o lista) e, con "solo gratuiti",
 * toglie quelli a pagamento prima di qualunque chiamata.
 */
class ResolveModelsAction
{
    use QueueableAction;

    /**
     * @return list<string>
     */
    public function execute(AiProviderEnum $provider, mixed $configured, bool $freeOnly): array
    {
        // Stringa con piu' modelli separati da virgola (pagina impostazioni) oppure lista.
        $models = \is_string($configured) ? explode(',', $configured) : (\is_array($configured) ? $configured : []);
        $models = array_values(array_filter(
            array_map(static fn (mixed $model): string => \is_string($model) ? trim($model) : '', $models),
            static fn (string $model): bool => $model !== '',
        ));

        if ($freeOnly) {
            $models = array_values(array_filter($models, $provider->isFreeModel(...)));
        }

        return $models;
    }
}
