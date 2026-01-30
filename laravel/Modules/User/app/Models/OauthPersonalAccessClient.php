<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * OAuth Personal Access Client model.
 *
 * @property string           $uuid
 * @property string           $client_id
 * @property Carbon|null      $created_at
 * @property Carbon|null      $updated_at
 * @property string|null      $updated_by
 * @property string|null      $created_by
 * @property int              $id
 * @property OauthClient|null $client
 *
 * @method static Builder|OauthPersonalAccessClient newModelQuery()
 * @method static Builder|OauthPersonalAccessClient newQuery()
 * @method static Builder|OauthPersonalAccessClient query()
 * @method static Builder|OauthPersonalAccessClient whereClientId($value)
 * @method static Builder|OauthPersonalAccessClient whereUpdatedAt($value)
 * @method static Builder|OauthPersonalAccessClient whereUuid($value)
 * @method static Builder|OauthPersonalAccessClient whereId($value)
 * @method static Builder|OauthPersonalAccessClient whereCreatedBy($value)
 * @method static Builder|OauthPersonalAccessClient whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class OauthPersonalAccessClient extends BaseModel
{
    use HasXotFactory;

    /** @var string */
    protected $table = 'oauth_personal_access_clients';

    /**
     * Get the OAuth client that this personal access client belongs to.
     *
     * @return BelongsTo<OauthClient, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(OauthClient::class, 'client_id');
    }
}
