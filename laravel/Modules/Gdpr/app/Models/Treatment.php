<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Carbon;
use Modules\Gdpr\Database\Factories\TreatmentFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\Gdpr\Models\Treatment.
 *
 * @property string               $id
 * @property int                  $active
 * @property int                  $required
 * @property string               $name
 * @property string               $description
 * @property string|null          $documentVersion
 * @property string|null          $documentUrl
 * @property int                  $weight
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static TreatmentFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Treatment newModelQuery()
 * @method static Builder<static>|Treatment newQuery()
 * @method static Builder<static>|Treatment query()
 * @method static Builder<static>|Treatment whereActive($value)
 * @method static Builder<static>|Treatment whereCreatedAt($value)
 * @method static Builder<static>|Treatment whereCreatedBy($value)
 * @method static Builder<static>|Treatment whereDeletedAt($value)
 * @method static Builder<static>|Treatment whereDeletedBy($value)
 * @method static Builder<static>|Treatment whereDescription($value)
 * @method static Builder<static>|Treatment whereDocumentUrl($value)
 * @method static Builder<static>|Treatment whereDocumentVersion($value)
 * @method static Builder<static>|Treatment whereId($value)
 * @method static Builder<static>|Treatment whereName($value)
 * @method static Builder<static>|Treatment whereRequired($value)
 * @method static Builder<static>|Treatment whereUpdatedAt($value)
 * @method static Builder<static>|Treatment whereUpdatedBy($value)
 * @method static Builder<static>|Treatment whereWeight($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class Treatment extends BaseModel
{
    use HasUuids;

    // protected $table = 'treatment';
    public $incrementing = false;

    protected $fillable = [''];
}
