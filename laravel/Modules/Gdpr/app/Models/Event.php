<?php

/**
 * @see https://github.com/foothing/laravel-gdpr-consent
 */

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Modules\Gdpr\Database\Factories\EventFactory;
use Modules\Xot\Contracts\ProfileContract;

use function Safe\json_encode;

/**
 * Modules\Gdpr\Models\Event.
 *
 * @property string               $id
 * @property string|null          $treatment_id
 * @property string|null          $consent_id
 * @property string               $subject_id
 * @property string               $ip
 * @property string               $action
 * @property string               $payload
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 * @property Consent|null         $consent
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static EventFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Event newModelQuery()
 * @method static Builder<static>|Event newQuery()
 * @method static Builder<static>|Event query()
 * @method static Builder<static>|Event whereAction($value)
 * @method static Builder<static>|Event whereConsentId($value)
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereCreatedBy($value)
 * @method static Builder<static>|Event whereDeletedAt($value)
 * @method static Builder<static>|Event whereDeletedBy($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereIp($value)
 * @method static Builder<static>|Event wherePayload($value)
 * @method static Builder<static>|Event whereSubjectId($value)
 * @method static Builder<static>|Event whereTreatmentId($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @method static Builder<static>|Event whereUpdatedBy($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class Event extends BaseModel
{
    use HasUuids;

    // protected $table = 'event';

    public $fillable = [
        'id',
        'action',
        'treatment_id',
        'consent_id',
        'subject_id',
        'payload',
    ];

    public function consent(): BelongsTo
    {
        return $this->belongsTo(Consent::class);
    }

    public function setPayloadAttribute(?string $value): void
    {
        $this->attributes['payload'] = Crypt::encrypt(json_encode($value, JSON_THROW_ON_ERROR));
    }

    public function setIpAttribute(?string $value): void
    {
        $this->attributes['ip'] = Crypt::encrypt($value);
    }
}
