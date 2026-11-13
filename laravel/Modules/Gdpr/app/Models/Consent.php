<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Datas\XotData;

/**
 * Modules\Gdpr\Models\Consent.
 *
 * @property string $id
 * @property string|null $treatment_id
 * @property string|null $subject_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property string $user_type
 * @property string|null $user_id
 * @property string|null $type
 * @property string|null $accepted_at
 * @property string|null $revoked_at
 * @property string|null $ip_address
 * @property string|null $revoked_ip_address
 * @property string|null $user_agent
 * @property array<string, mixed>|null $metadata
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 * @property Treatment|null $treatment
 *
 * @method static Builder<static>|Consent newModelQuery()
 * @method static Builder<static>|Consent newQuery()
 * @method static Builder<static>|Consent query()
 * @method static Builder<static>|Consent whereAcceptedAt($value)
 * @method static Builder<static>|Consent whereCreatedAt($value)
 * @method static Builder<static>|Consent whereCreatedBy($value)
 * @method static Builder<static>|Consent whereDeletedAt($value)
 * @method static Builder<static>|Consent whereDeletedBy($value)
 * @method static Builder<static>|Consent whereId($value)
 * @method static Builder<static>|Consent whereSubjectId($value)
 * @method static Builder<static>|Consent whereTreatmentId($value)
 * @method static Builder<static>|Consent whereType($value)
 * @method static Builder<static>|Consent whereUpdatedAt($value)
 * @method static Builder<static>|Consent whereUpdatedBy($value)
 * @method static Builder<static>|Consent whereUserId($value)
 * @method static Builder<static>|Consent whereUserType($value)
 * @method static Builder<static>|Consent whereIpAddress($value)
 * @method static Builder<static>|Consent whereUserAgent($value)
 *
 * @method static \Modules\Gdpr\Database\Factories\ConsentFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Consent extends BaseModel
{
    use HasUuids;

    public $incrementing = false;

    protected static function booted(): void
    {
        static::creating(function (Consent $consent): void {
            if (blank($consent->user_type)) {
                $consent->user_type = XotData::make()->getUserClass();
            }
        });
    }

    public $fillable = [
        'id',
        'subject_id',
        'treatment_id',
        'user_id',
        'user_type',
        'type',
        'accepted_at',
        'created_by',
        'updated_by',
        'ip_address',
        'user_agent',
<<<<<<< .merge_file_g81dI9
        // Revoca e richiesta di cancellazione (migrazione 2026_11_12_000002): senza, updateOrCreate le scartava in silenzio.
        'revoked_at',
        'revoked_ip_address',
        'metadata',
    ];

    /**
=======
        'metadata',
        'revoked_at',
        'revoked_ip_address',
    ];

    /**
     * `metadata` conserva la prova di cosa e' stato accettato (versione e URL del documento, lingua): senza cast ad array
     * e senza fillable veniva scartato in silenzio (regressione del mirror becb0d58bd, ripristinata il 2026-11-11).
     *
>>>>>>> .merge_file_147EoW
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
<<<<<<< .merge_file_g81dI9
            'accepted_at' => 'datetime',
            'revoked_at' => 'datetime',
            'metadata' => 'array',
=======
            'metadata' => 'array',
            'accepted_at' => 'datetime',
            'revoked_at' => 'datetime',
>>>>>>> .merge_file_147EoW
        ]);
    }

    /**
     * @return BelongsTo<Treatment, $this>
     */
    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }
}
