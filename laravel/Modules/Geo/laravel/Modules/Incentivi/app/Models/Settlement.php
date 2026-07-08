<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\Incentivi\Database\Factories\SettlementFactory;
use Modules\Ptv\Models\Profile;

/**
 * @property int $id
 * @property string $denominazione
 * @property string $tipologia
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $project_id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property string $importo
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read Profile|null $creator
 * @property-read Model|\Eloquent|null $linkable
 * @property-read Project|null $project
 * @property-read Profile|null $updater
 * @method static SettlementFactory factory($count = null, $state = [])
 * @method static Builder<static>|Settlement newModelQuery()
 * @method static Builder<static>|Settlement newQuery()
 * @method static Builder<static>|Settlement query()
 * @method static Builder<static>|Settlement whereCreatedAt($value)
 * @method static Builder<static>|Settlement whereCreatedBy($value)
 * @method static Builder<static>|Settlement whereDenominazione($value)
 * @method static Builder<static>|Settlement whereId($value)
 * @method static Builder<static>|Settlement whereImporto($value)
 * @method static Builder<static>|Settlement whereModelId($value)
 * @method static Builder<static>|Settlement whereModelType($value)
 * @method static Builder<static>|Settlement whereProjectId($value)
 * @method static Builder<static>|Settlement whereTipologia($value)
 * @method static Builder<static>|Settlement whereUpdatedAt($value)
 * @method static Builder<static>|Settlement whereUpdatedBy($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class Settlement extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'denominazione',
        'tipologia',
        'importo',
        'model_id',
        'model_type',
        'project_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function linkable(): MorphTo
    {
        return $this->morphTo('model');
    }
}
