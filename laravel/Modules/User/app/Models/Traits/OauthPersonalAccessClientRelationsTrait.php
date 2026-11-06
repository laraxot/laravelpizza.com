<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\OauthClient;

/**
 * Eloquent relationships for OauthPersonalAccessClient.
 */
trait OauthPersonalAccessClientRelationsTrait
{
    /**
     * @return BelongsTo<OauthClient, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(OauthClient::class, 'client_id');
    }
}
