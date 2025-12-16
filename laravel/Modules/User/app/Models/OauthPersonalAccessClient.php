<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Laravel\Passport\PersonalAccessClient as PassportPersonalAccessClient;

/**
 * Modules\User\Models\OauthPersonalAccessClient.
 *
 * @property string $uuid
 * @property string $client_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property OauthClient|null $client
 *
 * @method static Builder|OauthPersonalAccessClient newModelQuery()
 * @method static Builder|OauthPersonalAccessClient newQuery()
 * @method static Builder|OauthPersonalAccessClient query()
 * @method static Builder|OauthPersonalAccessClient whereClientId($value)
 * @method static Builder|OauthPersonalAccessClient whereCreatedAt($value)
 * @method static Builder|OauthPersonalAccessClient whereUpdatedAt($value)
 * @method static Builder|OauthPersonalAccessClient whereUuid($value)
 *
 * @property int $id
 *
 * @method static Builder|OauthPersonalAccessClient whereId($value)
 *
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static Builder|OauthPersonalAccessClient whereCreatedBy($value)
 * @method static Builder|OauthPersonalAccessClient whereUpdatedBy($value)
 *
 * @mixin IdeHelperOauthPersonalAccessClient
 * @mixin \Eloquent
 */
class OauthPersonalAccessClient extends PassportPersonalAccessClient
{
    /** @var string */
    protected $connection = 'user';

    // protected $primaryKey = 'uuid';
    /** @var string */
    protected $keyType = 'string';

    // protected $fillable = ['id', 'client_id'];
}
