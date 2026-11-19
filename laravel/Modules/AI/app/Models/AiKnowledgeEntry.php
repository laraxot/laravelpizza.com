<?php

declare(strict_types=1);

namespace Modules\AI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\XotBaseModel;

/**
 * Voce della base di conoscenza dell'assistente (domanda tipo + risposta ufficiale).
 *
 * L'assistente risponde SOLO usando queste voci: la qualita' delle risposte dipende dalla
 * qualita' di questi dati, non dal modello.
 *
 * @property int $id
 * @property string $collection
 * @property string $question
 * @property string $answer
 * @property list<string>|null $tags
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static> newModelQuery()
 * @method static Builder<static> newQuery()
 * @method static Builder<static> query()
 */
class AiKnowledgeEntry extends XotBaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'collection',
        'question',
        'answer',
        'tags',
        'is_active',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
