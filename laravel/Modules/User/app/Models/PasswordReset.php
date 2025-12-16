<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\PasswordResetFactory;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modules\User\Models\PasswordReset.
 *
 * @property int         $id
 * @property string      $email
 * @property string      $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $user_id
 * @property string|null $updated_by
 * @property string|null $created_by
 *
 * @method static PasswordResetFactory  factory($count = null, $state = [])
 * @method static Builder|PasswordReset newModelQuery()
 * @method static Builder|PasswordReset newQuery()
 * @method static Builder|PasswordReset query()
 * @method static Builder|PasswordReset whereCreatedAt($value)
 * @method static Builder|PasswordReset whereCreatedBy($value)
 * @method static Builder|PasswordReset whereEmail($value)
 * @method static Builder|PasswordReset whereId($value)
 * @method static Builder|PasswordReset whereToken($value)
 * @method static Builder|PasswordReset whereUpdatedAt($value)
 * @method static Builder|PasswordReset whereUpdatedBy($value)
 * @method static Builder|PasswordReset whereUserId($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string|null          $uuid
 *
 * @method static Builder<static>|PasswordReset whereUuid($value)
 *
 * @mixin IdeHelperPasswordReset
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class PasswordReset extends BaseModel
{
    /**
     * @var list<string>
     *
     * @psalm-var list{'email', 'token', 'created_at', 'updated_at', 'created_by', 'updated_by'}
     */
    protected $fillable = ['email', 'token', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_resets';
}

// end class PasswordReset
