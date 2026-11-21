<?php

/**
 * @see https://github.com/foothing/laravel-gdpr-consent
 */

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Modules\Xot\Contracts\ProfileContract;
use Safe\Exceptions\JsonException;

use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Modules\Gdpr\Models\Event.
 *
 * @property string $id
 * @property string|null $treatment_id
 * @property string|null $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Consent|null $consent
 * @property string $id
 * @property string|null $treatment_id
 * @property string|null $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Consent|null $consent
 * @property string $id
 * @property string|null $treatment_id
 * @property string|null $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Consent|null $consent
 * @property string $id
 * @property string|null $treatment_id
 * @property string|null $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Consent|null $consent
 * @property string $id
 * @property string|null $treatment_id
 * @property string|null $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Consent|null $consent
 * @property string $id
 * @property string|null $treatment_id
 * @property string|null $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Consent|null $consent
 * @property string $id
 * @property string|null $treatment_id
 * @property string|null $consent_id
 * @property string $subject_id
 * @property string $ip
 * @property string $action
 * @property string $payload
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Consent|null $consent
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
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
 * @method static \Modules\Gdpr\Database\Factories\EventFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Event extends BaseModel
{
    use HasUuids;

    public $fillable = [
        'id',
        'action',
        'treatment_id',
        'consent_id',
        'subject_id',
        'payload',
        // Senza 'ip' l'indirizzo passato a create() (anche dal form del pannello, dove e' obbligatorio) veniva
        // scartato e l'insert falliva: la colonna e' NOT NULL. Si salva cifrato (setIpAttribute).
        'ip',
    ];

    protected $table = 'gdpr_events';

    /**
     * @return BelongsTo<Consent, $this>
     */
    public function consent(): BelongsTo
    {
        return $this->belongsTo(Consent::class);
    }

    public function setPayloadAttribute(?string $value): void
    {
        $this->attributes['payload'] = Crypt::encrypt(json_encode($value, JSON_THROW_ON_ERROR));
    }

    /** Inverso di setPayloadAttribute: decifra e restituisce il testo salvato (di solito JSON). */
    public function getPayloadAttribute(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        try {
            $decrypted = Crypt::decrypt($value);
        } catch (DecryptException) {
            return $value;
        }
        if (! is_string($decrypted)) {
            return null;
        }
        try {
            $decoded = json_decode($decrypted, true);
        } catch (JsonException) {
            return $decrypted;
        }

        return is_string($decoded) ? $decoded : $decrypted;
    }

    public function setIpAttribute(?string $value): void
    {
        $this->attributes['ip'] = Crypt::encrypt($value);
    }

    /**
     * L'indirizzo si salva cifrato: senza questo accessor il pannello (elenco e dettaglio eventi) mostrava il testo
     * cifrato. Un valore non decifrabile (chiave cambiata, riga vecchia in chiaro) si mostra com'e'.
     */
    public function getIpAttribute(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        try {
            $decrypted = Crypt::decrypt($value);
        } catch (DecryptException) {
            return $value;
        }

        return is_string($decrypted) ? $decrypted : null;
    }
}
