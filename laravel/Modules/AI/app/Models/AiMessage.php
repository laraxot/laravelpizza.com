<?php

declare(strict_types=1);

namespace Modules\AI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\AI\Enums\AiMessageRoleEnum;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class AiMessage.
 *
 * A single message (user|assistant|tool|system) within an AiThread.
 *
 * @property int $id
 * @property int $ai_thread_id
 * @property string|null $user_id
 * @property AiMessageRoleEnum $role
 * @property string|null $content
 * @property array<string, mixed>|null $payload
 * @property-read ProfileContract|null $creator
 * @property-read AiThread|null $thread
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static> newModelQuery()
 * @method static Builder<static> newQuery()
 * @method static Builder<static> query()
 */
class AiMessage extends XotBaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'ai_thread_id',
        'user_id',
        'role',
        'content',
        'payload',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => AiMessageRoleEnum::class,
            'payload' => 'array',
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
}
