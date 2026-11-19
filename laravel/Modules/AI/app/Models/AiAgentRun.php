<?php

declare(strict_types=1);

namespace Modules\AI\Models;

use Modules\Xot\Models\XotBaseModel;

/**
 * Run in pausa di un agente neuron-ai (vedi NeuronAI\Workflow\Persistence\EloquentPersistence).
 * Niente cast e niente soft delete: neuron salva stringhe base64 e cancella fisicamente.
 *
 * @property int $id
 * @property string $partition
 * @property string $key
 * @property string $value
 */
class AiAgentRun extends XotBaseModel
{
    /** @var list<string> */
    protected $fillable = ['partition', 'key', 'value'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [];
    }
}
