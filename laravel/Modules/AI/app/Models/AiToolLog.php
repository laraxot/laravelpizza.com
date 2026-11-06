<?php

declare(strict_types=1);

namespace Modules\AI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\AI\Enums\AiToolLogStatusEnum;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class AiToolLog.
 *
 * Audit trail of tool calls performed by the AI assistant.
 *
 * @property AiToolLogStatusEnum $status
 * @property-read ProfileContract|null $creator
 * @property-read AiActionProposal|null $proposal
 * @property-read AiThread|null $thread
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|AiToolLog newModelQuery()
 * @method static Builder<static>|AiToolLog newQuery()
 * @method static Builder<static>|AiToolLog query()
 *
 */
class AiToolLog extends XotBaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'ai_thread_id',
        'ai_action_proposal_id',
        'user_id',
        'tool_name',
        'arguments',
        'response',
        'status',
        'error',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'arguments' => 'array',
            'response' => 'array',
            'status' => AiToolLogStatusEnum::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<AiThread, $this>
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(AiThread::class, 'ai_thread_id');
    }

    /**
     * @return BelongsTo<AiActionProposal, $this>
     */
    public function proposal(): BelongsTo
    {
        return $this->belongsTo(AiActionProposal::class, 'ai_action_proposal_id');
    }
}
