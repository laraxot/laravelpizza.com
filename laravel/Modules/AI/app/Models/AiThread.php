<?php

declare(strict_types=1);

namespace Modules\AI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\XotBaseModel;

/**
 * Persisted conversation thread owned by the AI module.
 *
 * @property-read ProfileContract|null $creator
 * @property-read Collection<int, AiMessage> $messages
 * @property-read Collection<int, AiActionProposal> $proposals
 * @property-read Collection<int, AiToolLog> $toolLogs
 * @method static Builder<static> query()
 */
class AiThread extends XotBaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'public_id', 'created_by_user_id', 'panel_id', 'last_message_at', 'meta',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'public_id' => 'string',
            'last_message_at' => 'datetime',
            'meta' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /** @return HasMany<AiMessage, $this> */
    public function messages(): HasMany
    {
        return $this->hasMany(AiMessage::class);
    }

    /** @return HasMany<AiActionProposal, $this> */
    public function proposals(): HasMany
    {
        return $this->hasMany(AiActionProposal::class);
    }

    /** @return HasMany<AiToolLog, $this> */
    public function toolLogs(): HasMany
    {
        return $this->hasMany(AiToolLog::class);
    }
}
