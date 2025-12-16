<?php

declare(strict_types=1);

/**
 * @see https://github.com/rappasoft/laravel-authentication-log/blob/main/src/Models/AuthenticationLog.php
 */

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\AuthenticationLogFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property int                  $id
 * @property string               $authenticatable_type
 * @property int                  $authenticatable_id
 * @property string|null          $ip_address
 * @property string|null          $user_agent
 * @property Carbon|null          $login_at
 * @property bool                 $login_successful
 * @property Carbon|null          $logout_at
 * @property bool                 $cleared_by_user
 * @property array|null           $location
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Model|\Eloquent      $authenticatable
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static AuthenticationLogFactory  factory($count = null, $state = [])
 * @method static Builder|AuthenticationLog newModelQuery()
 * @method static Builder|AuthenticationLog newQuery()
 * @method static Builder|AuthenticationLog query()
 * @method static Builder|AuthenticationLog whereAuthenticatableId($value)
 * @method static Builder|AuthenticationLog whereAuthenticatableType($value)
 * @method static Builder|AuthenticationLog whereClearedByUser($value)
 * @method static Builder|AuthenticationLog whereCreatedAt($value)
 * @method static Builder|AuthenticationLog whereCreatedBy($value)
 * @method static Builder|AuthenticationLog whereId($value)
 * @method static Builder|AuthenticationLog whereIpAddress($value)
 * @method static Builder|AuthenticationLog whereLocation($value)
 * @method static Builder|AuthenticationLog whereLoginAt($value)
 * @method static Builder|AuthenticationLog whereLoginSuccessful($value)
 * @method static Builder|AuthenticationLog whereLogoutAt($value)
 * @method static Builder|AuthenticationLog whereUpdatedAt($value)
 * @method static Builder|AuthenticationLog whereUpdatedBy($value)
 * @method static Builder|AuthenticationLog whereUserAgent($value)
 *
 * @mixin IdeHelperAuthenticationLog
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class AuthenticationLog extends BaseModel
{
    // public $timestamps = false;

    // protected $table = 'authentication_log';

    protected $fillable = [
        'ip_address',
        'user_agent',
        'login_at',
        'login_successful',
        'logout_at',
        'cleared_by_user',
        'location',
    ];

    // public function __construct(array $attributes = [])
    // {
    // if (! isset($this->connection)) {
    //    $this->setConnection(config('authentication-log.db_connection'));
    // }

    //    parent::__construct($attributes);
    // }

    // public function getTable()
    // {
    //    return config('authentication-log.table_name', parent::getTable());
    // }

    public function authenticatable(): MorphTo
    {
        return $this->morphTo();
    }

    /** @return array<string, string> */
    #[\Override]
    protected function casts(): array
    {
        return [
            'cleared_by_user' => 'boolean',
            'location' => 'array',
            'login_successful' => 'boolean',
            'login_at' => 'datetime',
            'logout_at' => 'datetime',
        ];
    }
}
