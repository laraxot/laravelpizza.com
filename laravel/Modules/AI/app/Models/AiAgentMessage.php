<?php

declare(strict_types=1);

namespace Modules\AI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Xot\Models\XotBaseModel;

/**
 * Messaggio di un agente neuron-ai (vedi NeuronAI\Chat\History\EloquentMessageStore).
 *
 * @property int $id
 * @property string $thread_id
 * @property string $message_id
 * @property string $role
 * @property array<int|string, mixed>|null $content
 * @property array<string, mixed>|null $meta
 * @property Carbon|null $archived_at
 *
 * @method static Builder<static>|AiAgentMessage query()
 */
class AiAgentMessage extends XotBaseModel
{
    /** @var list<string> */
    protected $fillable = ['thread_id', 'message_id', 'role', 'content', 'meta', 'archived_at'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'content' => 'array',
            'meta' => 'array',
            'archived_at' => 'datetime',
        ];
    }
}
